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

        // Generate OTP record
        $this->emailVerification = EmailVerification::generateForEmail($this->email);

        try {
            // Probeer async (queue); val terug op sync als queue niet beschikbaar is
            Mail::to($this->email)->queue(new OtpVerificationMail($this->emailVerification->otp_code));
            $this->otp_sent = true;
        } catch (\Throwable $e) {
            \Log::warning('Queue mail failed, falling back to sync send for OTP', [
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);
            try {
                Mail::to($this->email)->send(new OtpVerificationMail($this->emailVerification->otp_code));
                $this->otp_sent = true;
            } catch (\Throwable $e2) {
                \Log::error('OTP mail send failed', [
                    'email' => $this->email,
                    'error' => $e2->getMessage(),
                ]);
                $this->addError('otp', 'Verzenden van OTP mislukt. Controleer e-mailconfiguratie en probeer opnieuw.');
                return;
            }
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

        // Create organization for the user
        $baseSlug = \Illuminate\Support\Str::slug($user->name . '-business');
        $slug = $baseSlug;
        $counter = 1;
        
        // Ensure unique slug
        while (\App\Models\Organization::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $organization = \App\Models\Organization::create([
            'owner_user_id' => $user->id,
            'name' => $user->name . ' Business',
            'slug' => $slug,
            'country' => 'NL',
            'currency' => 'EUR',
            'default_vat_rate' => 21.00,
            'branding_color' => '#d4af37',
            'status' => 'active',
        ]);

        // Update user with organization
        $user->update(['organization_id' => $organization->id]);

        // Log user in FIRST (before any async operations)
        auth()->login($user);

        // Send welcome email asynchronously (after login, non-blocking)
        \Illuminate\Support\Facades\Mail::to($user->email)->queue(new \App\Mail\WelcomeMail($user));

        // Set flag to show onboarding tour
        session(['show_onboarding_tour' => true]);

        // Redirect to organization setup or dashboard
        $this->redirect(route('app.dashboard'), navigate: true);
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function render()
    {
        return view('livewire.register-multi-step')->layout('layouts.guest');
    }
}
