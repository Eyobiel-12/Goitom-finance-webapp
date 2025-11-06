<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\OtpVerificationMail;
use App\Mail\WelcomeMail;
use App\Models\EmailVerification;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

final class TestUserRegistration extends Command
{
    protected $signature = 'user:register-test 
                            {name : User name} 
                            {email : User email}
                            {--skip-email : Skip sending actual emails}';

    protected $description = 'Test user registration flow with OTP verification';

    public function handle(): int
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $skipEmail = $this->option('skip-email');

        $this->info('🚀 Starting registration flow for: ' . $name);
        $this->newLine();

        // Step 1: Validate email uniqueness
        if (User::where('email', $email)->exists()) {
            $this->error('❌ Email already registered!');
            return self::FAILURE;
        }
        $this->info('✅ Step 1: Email validation passed');

        // Step 2: Generate OTP
        $verification = EmailVerification::generateForEmail($email);
        $this->info('✅ Step 2: OTP generated: ' . $verification->otp_code);
        $this->info('   Expires at: ' . $verification->expires_at->format('Y-m-d H:i:s'));

        // Step 3: Send OTP email (if not skipped)
        if (!$skipEmail) {
            try {
                Mail::to($email)->send(new OtpVerificationMail($verification->otp_code));
                $this->info('✅ Step 3: OTP email sent to ' . $email);
            } catch (\Exception $e) {
                $this->error('❌ Failed to send OTP email: ' . $e->getMessage());
                return self::FAILURE;
            }
        } else {
            $this->warn('⚠️  Step 3: Skipping email send (--skip-email flag)');
        }
        $this->newLine();

        // Ask for OTP code
        $otpCode = $this->ask('Enter the 6-digit OTP code (or press Enter to use: ' . $verification->otp_code . ')');
        if (empty($otpCode)) {
            $otpCode = $verification->otp_code;
        }

        // Step 4: Verify OTP
        $validVerification = EmailVerification::where('email', $email)
            ->where('otp_code', $otpCode)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$validVerification) {
            $this->error('❌ Invalid or expired OTP code!');
            return self::FAILURE;
        }

        $validVerification->markAsUsed();
        $this->info('✅ Step 4: OTP verified successfully');

        // Step 5: Create user
        $password = 'password123'; // Default test password
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'ondernemer',
            'email_verified_at' => now(),
        ]);
        $this->info('✅ Step 5: User created (ID: ' . $user->id . ')');

        // Step 6: Create organization
        $baseSlug = \Illuminate\Support\Str::slug($user->name . '-business');
        $slug = $baseSlug;
        $counter = 1;

        while (Organization::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $organization = Organization::create([
            'owner_user_id' => $user->id,
            'name' => $user->name . ' Business',
            'slug' => $slug,
            'country' => 'NL',
            'currency' => 'EUR',
            'default_vat_rate' => 21.00,
            'branding_color' => '#d4af37',
            'status' => 'active',
        ]);

        $user->update(['organization_id' => $organization->id]);
        $this->info('✅ Step 6: Organization created: ' . $organization->name);

        // Step 7: Send welcome email
        if (!$skipEmail) {
            try {
                Mail::to($user->email)->send(new WelcomeMail($user));
                $this->info('✅ Step 7: Welcome email sent');
            } catch (\Exception $e) {
                $this->warn('⚠️  Failed to send welcome email: ' . $e->getMessage());
            }
        } else {
            $this->warn('⚠️  Step 7: Skipping welcome email (--skip-email flag)');
        }

        $this->newLine();
        $this->info('🎉 Registration complete!');
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['User ID', $user->id],
                ['Name', $user->name],
                ['Email', $user->email],
                ['Password', $password],
                ['Role', $user->role],
                ['Organization', $organization->name],
                ['Organization Slug', $organization->slug],
            ]
        );

        return self::SUCCESS;
    }
}

