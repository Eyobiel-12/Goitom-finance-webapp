<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BtwSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'btw_stelsel',
        'kor_eligible',
        'kor_turnover_limit',
        'kor_exemption',
        'filing_frequency',
        'reminder_days_before_deadline',
        'auto_submit',
    ];

    protected function casts(): array
    {
        return [
            'kor_eligible' => 'boolean',
            'kor_turnover_limit' => 'decimal:2',
            'kor_exemption' => 'boolean',
            'reminder_days_before_deadline' => 'integer',
            'auto_submit' => 'boolean',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get settings for organization or create default
     */
    public static function forOrganization(int $organizationId): self
    {
        return self::firstOrCreate(
            ['organization_id' => $organizationId],
            [
                'btw_stelsel' => 'factuur',
                'kor_eligible' => false,
                'kor_turnover_limit' => 20000.00,
                'kor_exemption' => false,
                'filing_frequency' => 'quarterly',
                'reminder_days_before_deadline' => 7,
                'auto_submit' => false,
            ]
        );
    }
}

