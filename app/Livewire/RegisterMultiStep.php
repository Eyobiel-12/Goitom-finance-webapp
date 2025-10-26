<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\OtpVerificationMail;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RegisterMultiStep extends Component
{
    public int $currentStep = 1;
    public int $totalSteps = 3;

    // Step 1: Basic Info
    public string $name = '';
    public string $email = '';

    // Step 2: Password
    public string $password = '';
    public string $password_confirmation = '';

    // Step 3: OTP Verification
    public string $otp_code = '';
    public bool $otp_sent = false;
    public ?EmailVerification $emailVerification = null;

    public function mount(): void
    {
        // Check if already verified in session
        if (session()->has('registration_verified')) {
            $this->currentStep = 3;
            $this->otp_sent = true;
        }
    }

    public function step1(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email',
        ], [
            'name.required' => 'Naam is verplicht.',
            'name.min' => 'Naam moet minimaal 3 karakters bevatten.',
            'email.required' => 'E-mail is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al geregistreerd.',
        ]);

        $this->currentStep = 2;
    }

    public function sendOtp(): void
    {
        $this->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Wachtwoord is verplicht.',
            'password.min' => 'Wachtwoord moet minimaal 8 karakters bevatten.',
            'password.confirmed' => 'Wachtwoorden komen niet overeen.',
        ]);

        // Generate and send OTP
        $this->emailVerification = EmailVerification::generateForEmail($this->email);

        try {
            Mail::to($this->email)->send(new OtpVerificationMail($this->emailVerification->otp_code));
            $this->otp_sent = true;
        } catch (\Exception $e) {
            $this->addError('otp', 'Er is een fout opgetreden bij het versturen van de e-mail. Probeer het opnieuw.');
            return;
        }

        $this->currentStep = 3;
    }

    public function verifyOtp(): void
    {
        $this->validate([
            'otp_code' => 'required|string|size:6',
        ], [
            'otp_code.required' => 'OTP-code is verplicht.',
            'otp_code.size' => 'OTP-code moet 6 cijfers bevatten.',
        ]);

        // Find valid verification
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

        // Create user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'ondernemer',
        ]);

        // Log user in
        auth()->login($user);

        // Redirect to organization setup or dashboard
        return redirect()->route('app.dashboard')->with('success', 'Account succesvol aangemaakt!');
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function render()
    {
        return view('livewire.register-multi-step');
    }
}
