<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\PasswordResetOtpMail;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ForgotPasswordMultiStep extends Component
{
    public int $currentStep = 1;
    public string $email = '';
    public string $otp_code = '';

    protected array $rules = [
        'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
        'otp_code' => ['required', 'string', 'size:6'],
    ];

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function nextStep(): void
    {
        $this->validateOnly('email');
        $this->sendOtp();
        $this->currentStep++;
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function sendOtp(): void
    {
        $this->validateOnly('email');

        // Generate OTP
        $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP
        EmailVerification::create([
            'email' => $this->email,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Log OTP for diagnostics and show in local env
        \Illuminate\Support\Facades\Log::info('Password reset OTP generated', [
            'email' => $this->email,
            'otp' => $otpCode,
        ]);
        if (app()->environment('local')) {
            session()->flash('debug_otp', $otpCode);
        }

        // Send email (sync) met BCC naar afzender voor audit
        try {
            Mail::to($this->email)
                ->bcc(config('mail.from.address'))
                ->send(new PasswordResetOtpMail($otpCode));
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            // Toon nette melding en log
            \Illuminate\Support\Facades\Log::error('OTP mail transport error', [
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);
            session()->flash('error', 'Kon de verificatiecode niet versturen. Probeer opnieuw of controleer je spam.');
            return;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP mail error', [
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);
            session()->flash('error', 'Kon de verificatiecode niet versturen. Probeer opnieuw.');
            return;
        }

        session()->flash('message', 'Een 6-cijferige verificatiecode is naar je e-mailadres gestuurd.');
    }

    public function verifyOtp(): void
    {
        $this->validateOnly('otp_code');

        $verification = EmailVerification::where('email', $this->email)
            ->where('otp_code', $this->otp_code)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            $this->addError('otp_code', 'Ongeldige of verlopen OTP-code.');
            return;
        }

        // Mark as used
        $verification->markAsUsed();

        // Store email in session for password reset
        session(['password_reset_email' => $this->email]);

        // Redirect to reset password page (full page to avoid Alpine.navigate dependency)
        $this->redirect(route('password.reset', ['email' => $this->email]), navigate: false);
    }

    public function render()
    {
        return view('livewire.forgot-password-multi-step');
    }
}

