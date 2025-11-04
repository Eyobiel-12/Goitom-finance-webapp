<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Organization;
use Illuminate\Console\Command;

final class CheckExpiredTrials extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Check for expired trials and update subscription status';

    public function handle(): int
    {
        $now = now();

        // Find organizations with expired trials
        $expiredTrials = Organization::where('subscription_status', 'trial')
            ->where('trial_ends_at', '<', $now)
            ->get();

        foreach ($expiredTrials as $org) {
            // Set to past_due status (grace period)
            $org->update([
                'subscription_status' => 'past_due',
                'subscription_ends_at' => $now->copy()->addDays(7), // 7-day grace period
            ]);

            // Send reminder email to owner
            try {
                if ($org->owner && $org->owner->email) {
                    \Mail::to($org->owner->email)->send(new \App\Mail\TrialExpiredMail($org));
                }
                $this->info("Sent trial expired email to {$org->owner->email}");
            } catch (\Exception $e) {
                $this->error("Failed to send email to {$org->owner->email}: {$e->getMessage()}");
            }
        }

        // Find organizations past grace period
        $suspended = Organization::where('subscription_status', 'past_due')
            ->where('subscription_ends_at', '<', $now)
            ->get();

        foreach ($suspended as $org) {
            // Last warning email just before suspension (if not already suspended earlier today)
            try {
                if ($org->owner && $org->owner->email) {
                    \Mail::to($org->owner->email)->send(new \App\Mail\PaymentLastWarningMail($org));
                }
            } catch (\Exception) {
                // ignore mailing failures
            }

            $org->update(['subscription_status' => 'suspended']);
            $this->info("Suspended organization: {$org->name}");
        }

        $this->info("Processed {$expiredTrials->count()} expired trials, {$suspended->count()} suspensions");
        return self::SUCCESS;
    }
}
