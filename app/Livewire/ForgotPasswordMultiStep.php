<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\OtpVerificationMail;
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

        // Send email
        Mail::to($this->email)->send(new OtpVerificationMail($otpCode));

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

        // Redirect to reset password page with email in query string
        $this->redirect(route('password.reset', ['email' => $this->email]), navigate: true);
    }

    public function render()
    {
        return view('livewire.forgot-password-multi-step');
    }
}

