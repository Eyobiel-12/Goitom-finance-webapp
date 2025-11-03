<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BtwAftrek extends Model
{
    use HasFactory;

    protected $table = 'btw_aftrek';

    protected $fillable = [
        'organization_id',
        'naam',
        'beschrijving',
        'bedrag_excl_btw',
        'btw_percentage',
        'btw_bedrag',
        'totaal_bedrag',
        'categorie',
        'datum',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'bedrag_excl_btw' => 'decimal:2',
            'btw_percentage' => 'decimal:2',
            'btw_bedrag' => 'decimal:2',
            'totaal_bedrag' => 'decimal:2',
            'datum' => 'date',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Bereken BTW bedrag automatisch
     */
    public function calculateBtw(): void
    {
        $this->btw_bedrag = $this->bedrag_excl_btw * ($this->btw_percentage / 100);
        $this->totaal_bedrag = $this->bedrag_excl_btw + $this->btw_bedrag;
    }

    /**
     * Scope voor organization
     */
    public function scopeForOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }
}

