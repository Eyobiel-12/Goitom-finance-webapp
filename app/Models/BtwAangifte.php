<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BtwAangifte extends Model
{
    use HasFactory;

    protected $table = 'btw_aangifte';

    protected $fillable = [
        'organization_id',
        'jaar',
        'kwartaal',
        'btw_afdracht',
        'ontvangen_btw',
        'omzet_excl_btw',
        'betaalde_btw',
        'uitgaven_excl_btw',
        'btw_terug',
        'status',
        'indien_datum',
        'opmerkingen',
    ];

    protected function casts(): array
    {
        return [
            'jaar' => 'integer',
            'kwartaal' => 'integer',
            'btw_afdracht' => 'decimal:2',
            'ontvangen_btw' => 'decimal:2',
            'omzet_excl_btw' => 'decimal:2',
            'betaalde_btw' => 'decimal:2',
            'uitgaven_excl_btw' => 'decimal:2',
            'btw_terug' => 'decimal:2',
            'indien_datum' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Bereken automatisch de BTW aangifte
     */
    public function calculate(): void
    {
        // BTW ontvangen van klanten (alleen BETAALDE facturen)
        $invoices = $this->organization
            ->invoices()
            ->where('status', 'paid') // Alleen betaalde facturen tellen
            ->whereYear('issue_date', $this->jaar)
            ->when($this->kwartaal, function ($query) {
                $quarterStart = \Carbon\Carbon::create($this->jaar, ($this->kwartaal - 1) * 3 + 1, 1);
                $quarterEnd = $quarterStart->copy()->endOfQuarter();
                return $query->whereBetween('issue_date', [$quarterStart, $quarterEnd]);
            })
            ->get();

        // Omzet EXCL BTW (net_amount van alle facturen)
        $this->omzet_excl_btw = $invoices->sum(function ($invoice) {
            return $invoice->items->sum('net_amount');
        });

        // BTW ontvangen INCL BTW
        $this->ontvangen_btw = $invoices->sum(function ($invoice) {
            return $invoice->items->sum('vat_amount');
        });

        // BTW betaald (BTW aftrek)
        $aftrekken = $this->organization
            ->btwAftrek()
            ->whereYear('datum', $this->jaar)
            ->when($this->kwartaal, function ($query) {
                $quarterStart = \Carbon\Carbon::create($this->jaar, ($this->kwartaal - 1) * 3 + 1, 1);
                $quarterEnd = $quarterStart->copy()->endOfQuarter();
                return $query->whereBetween('datum', [$quarterStart, $quarterEnd]);
            })
            ->get();

        // Uitgaven EXCL BTW
        $this->uitgaven_excl_btw = $aftrekken->sum('bedrag_excl_btw');

        // BTW betaald
        $this->betaalde_btw = $aftrekken->sum('btw_bedrag');

        // Bereken verschil (BTW te betalen of terug)
        $verschil = $this->ontvangen_btw - $this->betaalde_btw;

        if ($verschil > 0) {
            $this->btw_afdracht = $verschil; // Te betalen aan belastingdienst
            $this->btw_terug = 0;
        } else {
            $this->btw_terug = abs($verschil); // Te ontvangen van belastingdienst
            $this->btw_afdracht = 0;
        }
    }

    /**
     * Scope voor organization
     */
    public function scopeForOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }
}

