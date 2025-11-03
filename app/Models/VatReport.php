<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class VatReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'start_date',
        'end_date',
        'taxable_base',
        'vat_collected',
        'vat_paid',
        'net_due',
        'export_path',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'taxable_base' => 'decimal:2',
            'vat_collected' => 'decimal:2',
            'vat_paid' => 'decimal:2',
            'net_due' => 'decimal:2',
        ];
    }

    /**
     * Get the organization that owns this VAT report.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Scope to filter by organization.
     */
    public function scopeForOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
                    ->whereBetween('end_date', [$startDate, $endDate]);
    }
}
