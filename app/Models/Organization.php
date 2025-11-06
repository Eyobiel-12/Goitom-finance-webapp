<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Crypt;

final class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_user_id',
        'name',
        'tagline',
        'slug',
        'vat_number',
        'country',
        'currency',
        'default_vat_rate',
        'logo_path',
        'branding_color',
        'settings',
        'status',
        'btw_stelsel',
        'subscription_plan',
        'subscription_status',
        'trial_ends_at',
        'mollie_customer_id',
        'mollie_subscription_id',
        'subscription_ends_at',
        'limit_invoices_per_month',
        'limit_clients',
        'limit_active_projects',
        'limit_storage_mb',
        'usage_invoices_this_month',
        'usage_month_started',
    ];

    protected function casts(): array
    {
        return [
            'default_vat_rate' => 'decimal:2',
            'settings' => 'array',
            'trial_ends_at' => 'datetime',
            'subscription_ends_at' => 'datetime',
            'usage_month_started' => 'date',
        ];
    }

    /**
     * Get the owner of the organization.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    /**
     * Get all users belonging to this organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all clients for this organization.
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Get all projects for this organization.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get all invoices for this organization.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function subscriptionPayments(): HasMany
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function getCurrentBillingInterval(): int
    {
        // Latest successful payment for the current plan
        $latest = $this->subscriptionPayments()
            ->where('status', 'paid')
            ->where('plan', $this->subscription_plan)
            ->orderByDesc('paid_at')
            ->orderByDesc('created_at')
            ->first();

        return $latest?->interval_months ?? 1;
    }

    /**
     * Get all items for this organization.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get all templates for this organization.
     */
    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    /**
     * Get all VAT reports for this organization.
     */
    public function vatReports(): HasMany
    {
        return $this->hasMany(VatReport::class);
    }

    /**
     * Get all BTW aftrek for this organization.
     */
    public function btwAftrek(): HasMany
    {
        return $this->hasMany(BtwAftrek::class);
    }

    /**
     * Get all BTW aangifte for this organization.
     */
    public function btwAangifte(): HasMany
    {
        return $this->hasMany(BtwAangifte::class);
    }

    /**
     * Get BTW settings for this organization.
     */
    public function btwSettings(): HasOne
    {
        return $this->hasOne(BtwSettings::class);
    }

    /**
     * Get all audit logs for this organization.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Encrypt VAT number when setting.
     */
    public function setVatNumberAttribute(?string $value): void
    {
        $this->attributes['vat_number'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt VAT number when getting.
     */
    public function getVatNumberAttribute(?string $value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Scope to filter by status.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter by status.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to filter by status.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    // Subscription helpers
    public function onTrial(): bool
    {
        return $this->subscription_status === 'trial' 
            && $this->trial_ends_at 
            && $this->trial_ends_at->isFuture();
    }

    public function hasActiveSubscription(): bool
    {
        return in_array($this->subscription_status, ['trial', 'active']);
    }

    public function isPro(): bool
    {
        return $this->subscription_plan === 'pro' && $this->hasActiveSubscription();
    }

    public function isStarter(): bool
    {
        return $this->subscription_plan === 'starter' && $this->hasActiveSubscription();
    }

    public function canUseFeature(string $feature): bool
    {
        $proFeatures = [
            'email_sending', 
            'reminders', 
            'advanced_btw', 
            'api_access', 
            'priority_support'
        ];
        
        if (!in_array($feature, $proFeatures)) {
            return true; // starter features available to all
        }
        
        return $this->isPro();
    }

    public function trialDaysRemaining(): int
    {
        if (!$this->onTrial()) {
            return 0;
        }
        return (int) max(0, now()->diffInDays($this->trial_ends_at, false));
    }

    // Grace period helpers
    public function isPastDue(): bool
    {
        return $this->subscription_status === 'past_due';
    }

    public function isSuspended(): bool
    {
        return $this->subscription_status === 'suspended';
    }

    public function isReadOnly(): bool
    {
        return $this->isPastDue();
    }

    public function shouldShowPaywallBanner(): bool
    {
        return $this->isPastDue() || $this->isSuspended();
    }

    // Usage tracking and limits
    public function resetMonthlyUsage(): void
    {
        $this->update([
            'usage_invoices_this_month' => 0,
            'usage_month_started' => now()->startOfMonth(),
        ]);
    }

    public function checkAndResetMonthlyUsage(): void
    {
        // Reset if new month or never set
        if (!$this->usage_month_started || $this->usage_month_started->month !== now()->month) {
            $this->resetMonthlyUsage();
        }
    }

    public function incrementInvoiceUsage(): void
    {
        $this->checkAndResetMonthlyUsage();
        $this->increment('usage_invoices_this_month');
    }

    public function canCreateInvoice(): bool
    {
        if ($this->isPro()) {
            return true; // Unlimited for Pro
        }

        $this->checkAndResetMonthlyUsage();
        return $this->usage_invoices_this_month < $this->limit_invoices_per_month;
    }

    public function canCreateClient(): bool
    {
        if ($this->isPro()) {
            return true;
        }

        return $this->clients()->count() < $this->limit_clients;
    }

    public function canCreateProject(): bool
    {
        if ($this->isPro()) {
            return true;
        }

        return $this->projects()->where('status', 'active')->count() < $this->limit_active_projects;
    }

    public function getInvoicesRemaining(): int
    {
        if ($this->isPro()) {
            return -1; // Unlimited
        }

        $this->checkAndResetMonthlyUsage();
        return max(0, $this->limit_invoices_per_month - $this->usage_invoices_this_month);
    }

    public function getClientsRemaining(): int
    {
        if ($this->isPro()) {
            return -1;
        }

        return max(0, $this->limit_clients - $this->clients()->count());
    }

    public function getProjectsRemaining(): int
    {
        if ($this->isPro()) {
            return -1;
        }

        return max(0, $this->limit_active_projects - $this->projects()->where('status', 'active')->count());
    }

    public function getUsagePercentage(string $type): int
    {
        if ($this->isPro()) {
            return 0;
        }

        return match($type) {
            'invoices' => $this->limit_invoices_per_month > 0 
                ? (int) (($this->usage_invoices_this_month / $this->limit_invoices_per_month) * 100) 
                : 0,
            'clients' => $this->limit_clients > 0 
                ? (int) (($this->clients()->count() / $this->limit_clients) * 100) 
                : 0,
            'projects' => $this->limit_active_projects > 0 
                ? (int) (($this->projects()->where('status', 'active')->count() / $this->limit_active_projects) * 100) 
                : 0,
            default => 0,
        };
    }
}
