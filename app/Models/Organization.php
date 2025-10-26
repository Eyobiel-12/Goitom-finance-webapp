<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    ];

    protected function casts(): array
    {
        return [
            'default_vat_rate' => 'decimal:2',
            'settings' => 'array',
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
}
