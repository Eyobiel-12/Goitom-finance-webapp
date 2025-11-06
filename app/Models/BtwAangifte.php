<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        // New fields
        'deadline',
        'is_overdue',
        'late_filing_penalty',
        'correction_of_id',
        'correction_reason',
        'correction_discovered_date',
        'filed_within_8_weeks',
        'filed_via',
        'belastingdienst_reference',
        'ontvangen_btw_0',
        'ontvangen_btw_9',
        'ontvangen_btw_21',
        'betaalde_btw_0',
        'betaalde_btw_9',
        'betaalde_btw_21',
        'validation_errors',
        'is_validated',
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
            'deadline' => 'date',
            'is_overdue' => 'boolean',
            'late_filing_penalty' => 'decimal:2',
            'correction_of_id' => 'integer',
            'correction_discovered_date' => 'date',
            'filed_within_8_weeks' => 'boolean',
            'ontvangen_btw_0' => 'decimal:2',
            'ontvangen_btw_9' => 'decimal:2',
            'ontvangen_btw_21' => 'decimal:2',
            'betaalde_btw_0' => 'decimal:2',
            'betaalde_btw_9' => 'decimal:2',
            'betaalde_btw_21' => 'decimal:2',
            'validation_errors' => 'array',
            'is_validated' => 'boolean',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function correctionOf(): BelongsTo
    {
        return $this->belongsTo(BtwAangifte::class, 'correction_of_id');
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(BtwAangifte::class, 'correction_of_id');
    }

    /**
     * Calculate deadline based on quarter
     */
    public function calculateDeadline(): Carbon
    {
        if ($this->kwartaal) {
            // Quarterly: Last day of month following quarter
            $quarterEndMonth = $this->kwartaal * 3;
            $deadlineMonth = $quarterEndMonth + 1;
            $deadlineYear = $this->jaar;
            
            if ($deadlineMonth > 12) {
                $deadlineMonth = 1;
                $deadlineYear++;
            }
            
            return Carbon::create($deadlineYear, $deadlineMonth, 1)->endOfMonth();
        } else {
            // Annual: March 31 of next year
            return Carbon::create($this->jaar + 1, 3, 31);
        }
    }

    /**
     * Update deadline and overdue status
     */
    public function updateDeadlineStatus(): void
    {
        if (!$this->deadline) {
            $this->deadline = $this->calculateDeadline();
        }
        
        $this->is_overdue = $this->deadline < now() && $this->status !== 'ingediend';
        
        if ($this->is_overdue && $this->late_filing_penalty === 0) {
            $this->calculateLatePenalty();
        }
    }

    /**
     * Calculate late filing penalty (simplified - actual calculation is more complex)
     */
    public function calculateLatePenalty(): void
    {
        $daysOverdue = now()->diffInDays($this->deadline);
        $baseAmount = $this->btw_afdracht > 0 ? $this->btw_afdracht : $this->btw_terug;
        
        // Simplified: 5% base penalty + interest (actual rates vary)
        $penaltyRate = min(0.05 + ($daysOverdue / 365 * 0.04), 0.20); // Max 20%
        $this->late_filing_penalty = $baseAmount * $penaltyRate;
    }

    /**
     * Enhanced BTW calculation with proper date logic and percentage breakdown
     */
    public function calculate(): void
    {
        $settings = \App\Models\BtwSettings::forOrganization($this->organization_id);
        $isCashBasis = $settings->btw_stelsel === 'kassa';
        
        // Get invoices based on stelsel
        if ($isCashBasis) {
            // Cash basis: Use payment date from payments table
            $query = $this->organization->invoices()
                ->where('status', 'paid')
                ->whereHas('payments', function ($q) {
                    $q->whereYear('date', $this->jaar);
                    if ($this->kwartaal) {
                        $quarterStart = Carbon::create($this->jaar, ($this->kwartaal - 1) * 3 + 1, 1);
                        $quarterEnd = $quarterStart->copy()->endOfQuarter();
                        $q->whereBetween('date', [$quarterStart, $quarterEnd]);
                    }
                });
        } else {
            // Invoice basis: Use invoice issue_date
            $query = $this->organization->invoices()
                ->whereYear('issue_date', $this->jaar);
                
            if ($this->kwartaal) {
                $quarterStart = Carbon::create($this->jaar, ($this->kwartaal - 1) * 3 + 1, 1);
                $quarterEnd = $quarterStart->copy()->endOfQuarter();
                $query->whereBetween('issue_date', [$quarterStart, $quarterEnd]);
            }
        }
        
        $invoices = $query->with('items', 'payments')->get();
        
        // For cash basis: Filter invoices by actual payment dates
        if ($isCashBasis) {
            $invoices = $invoices->filter(function ($invoice) {
                $paymentDates = $invoice->payments->pluck('date');
                if ($paymentDates->isEmpty()) {
                    return false;
                }
                
                if ($this->kwartaal) {
                    $quarterStart = Carbon::create($this->jaar, ($this->kwartaal - 1) * 3 + 1, 1);
                    $quarterEnd = $quarterStart->copy()->endOfQuarter();
                    return $paymentDates->some(function ($date) use ($quarterStart, $quarterEnd) {
                        return $date >= $quarterStart && $date <= $quarterEnd;
                    });
                }
                
                return $paymentDates->some(function ($date) {
                    return Carbon::parse($date)->year == $this->jaar;
                });
            });
        }
        
        // Calculate omzet and BTW with percentage breakdown
        $this->omzet_excl_btw = 0;
        $this->ontvangen_btw = 0;
        $this->ontvangen_btw_0 = 0;
        $this->ontvangen_btw_9 = 0;
        $this->ontvangen_btw_21 = 0;
        
        foreach ($invoices as $invoice) {
            foreach ($invoice->items as $item) {
                $netAmount = (float) $item->net_amount;
                $vatAmount = (float) $item->vat_amount;
                $vatRate = (float) $item->vat_rate;
                
                $this->omzet_excl_btw += $netAmount;
                $this->ontvangen_btw += $vatAmount;
                
                // Breakdown by rate
                if ($vatRate == 0) {
                    $this->ontvangen_btw_0 += $vatAmount;
                } elseif ($vatRate == 9 || $vatRate == 6) { // 6% was historical low rate
                    $this->ontvangen_btw_9 += $vatAmount;
                } else {
                    $this->ontvangen_btw_21 += $vatAmount;
                }
            }
        }
        
        // BTW paid (from BTW aftrek)
        $aftrekQuery = $this->organization->btwAftrek()
            ->whereYear('datum', $this->jaar);
            
        if ($this->kwartaal) {
            $quarterStart = Carbon::create($this->jaar, ($this->kwartaal - 1) * 3 + 1, 1);
            $quarterEnd = $quarterStart->copy()->endOfQuarter();
            $aftrekQuery->whereBetween('datum', [$quarterStart, $quarterEnd]);
        }
        
        $aftrekken = $aftrekQuery->get();
        
        $this->uitgaven_excl_btw = 0;
        $this->betaalde_btw = 0;
        $this->betaalde_btw_0 = 0;
        $this->betaalde_btw_9 = 0;
        $this->betaalde_btw_21 = 0;
        
        foreach ($aftrekken as $aftrek) {
            $bedragExcl = (float) $aftrek->bedrag_excl_btw;
            $btwBedrag = (float) $aftrek->btw_bedrag;
            $btwPercentage = (float) $aftrek->btw_percentage;
            
            $this->uitgaven_excl_btw += $bedragExcl;
            $this->betaalde_btw += $btwBedrag;
            
            // Breakdown by rate
            if ($btwPercentage == 0) {
                $this->betaalde_btw_0 += $btwBedrag;
            } elseif ($btwPercentage == 9 || $btwPercentage == 6) {
                $this->betaalde_btw_9 += $btwBedrag;
            } else {
                $this->betaalde_btw_21 += $btwBedrag;
            }
        }
        
        // Calculate difference
        $verschil = $this->ontvangen_btw - $this->betaalde_btw;
        
        if ($verschil > 0) {
            $this->btw_afdracht = $verschil;
            $this->btw_terug = 0;
        } else {
            $this->btw_terug = abs($verschil);
            $this->btw_afdracht = 0;
        }
        
        // Update deadline
        $this->updateDeadlineStatus();
        
        // Validate
        $this->validate();
    }

    /**
     * Validate aangifte before submission
     */
    public function validate(): array
    {
        $errors = [];
        
        // Check required fields
        if ($this->omzet_excl_btw === null) {
            $errors[] = 'Omzet excl. BTW is required';
        }
        
        if ($this->ontvangen_btw === null) {
            $errors[] = 'Ontvangen BTW is required';
        }
        
        // Check BTW number format (NLXXXXXXXXB01)
        if ($this->organization->vat_number) {
            $vatNumber = $this->organization->vat_number;
            if (!preg_match('/^NL\d{9}B\d{2}$/', $vatNumber)) {
                $errors[] = 'Invalid BTW number format';
            }
        }
        
        // Check for duplicate filing
        $existing = self::where('organization_id', $this->organization_id)
            ->where('jaar', $this->jaar)
            ->where('kwartaal', $this->kwartaal)
            ->where('status', 'ingediend')
            ->where('id', '!=', $this->id)
            ->first();
            
        if ($existing) {
            $errors[] = 'Aangifte already filed for this period';
        }
        
        // Check 8-week rule for corrections
        if ($this->correction_of_id && $this->correction_discovered_date) {
            $weeksSinceDiscovery = now()->diffInWeeks($this->correction_discovered_date);
            if ($weeksSinceDiscovery > 8) {
                $errors[] = 'Correction must be filed within 8 weeks of discovery';
                $this->filed_within_8_weeks = false;
            } else {
                $this->filed_within_8_weeks = true;
            }
        }
        
        $this->validation_errors = $errors;
        $this->is_validated = empty($errors);
        
        return $errors;
    }

    /**
     * Scope voor organization
     */
    public function scopeForOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }
}
