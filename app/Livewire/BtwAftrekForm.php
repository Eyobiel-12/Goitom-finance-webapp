<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\BtwAftrek;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

final class BtwAftrekForm extends Component
{
    public $btwAftrek = null;
    public $naam = '';
    public $beschrijving = '';
    public $bedrag_excl_btw = 0;
    public $btw_percentage = 21;
    public $categorie = 'Kosten';
    public $datum = '';
    
    public $current_step = 1;
    public $total_steps = 3;

    protected array $rules = [
        'naam' => 'required|string|max:255',
        'bedrag_excl_btw' => 'required|numeric|min:0.01',
        'btw_percentage' => 'required|numeric|min:0|max:100',
        'categorie' => 'nullable|string|max:255',
        'datum' => 'required|date',
    ];

    public function mount($btwAftrek = null): void
    {
        if ($btwAftrek) {
            $this->btwAftrek = $btwAftrek;
            $this->naam = $btwAftrek->naam;
            $this->beschrijving = $btwAftrek->beschrijving;
            $this->bedrag_excl_btw = $btwAftrek->bedrag_excl_btw;
            $this->btw_percentage = $btwAftrek->btw_percentage;
            $this->categorie = $btwAftrek->categorie;
            $this->datum = $btwAftrek->datum->format('Y-m-d');
        } else {
            $this->datum = now()->format('Y-m-d');
        }
    }

    public function updated($propertyName): void
    {
        // Normalize bedrag_excl_btw if it's a string with EU format (comma as decimal)
        if ($propertyName === 'bedrag_excl_btw' && is_string($this->bedrag_excl_btw)) {
            $this->bedrag_excl_btw = (float) str_replace([',', ' '], ['.', ''], $this->bedrag_excl_btw);
        }
        
        if (in_array($propertyName, ['bedrag_excl_btw', 'btw_percentage'])) {
            $this->validateOnly($propertyName);
        }
    }

    public function nextStep(): void
    {
        // Validate current step before proceeding
        if ($this->current_step === 1) {
            $this->validate(['naam' => 'required|string|max:255', 'datum' => 'required|date']);
        } elseif ($this->current_step === 2) {
            $this->validate(['bedrag_excl_btw' => 'required|numeric|min:0.01', 'btw_percentage' => 'required|numeric|min:0|max:100']);
        }

        if ($this->current_step < $this->total_steps) {
            $this->current_step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->current_step > 1) {
            $this->current_step--;
        }
    }

    public function calculate(): void
    {
        $this->validateOnly('bedrag_excl_btw');
        $this->validateOnly('btw_percentage');
    }

    public function getCalculatedBtwProperty(): float
    {
        $bedrag = (float)($this->bedrag_excl_btw ?? 0);
        $btwPercentage = (float)($this->btw_percentage ?? 0);
        return $bedrag * ($btwPercentage / 100);
    }

    public function getCalculatedTotalProperty(): float
    {
        $bedrag = (float)($this->bedrag_excl_btw ?? 0);
        return $bedrag + $this->calculatedBtw;
    }

    public function save()
    {
        // Ensure numeric values first
        if (!is_numeric($this->bedrag_excl_btw)) {
            if (is_string($this->bedrag_excl_btw)) {
                $this->bedrag_excl_btw = (float) str_replace([',', ' '], ['.', ''], $this->bedrag_excl_btw);
            } else {
                $this->bedrag_excl_btw = 0;
            }
        } else {
            $this->bedrag_excl_btw = (float) $this->bedrag_excl_btw;
        }
        $this->btw_percentage = (float) $this->btw_percentage;

        \Log::info('BTW Aftrek save method called - after normalization', [
            'naam' => $this->naam,
            'bedrag_excl_btw' => $this->bedrag_excl_btw,
            'bedrag_excl_btw_type' => gettype($this->bedrag_excl_btw),
            'btw_percentage' => $this->btw_percentage,
            'datum' => $this->datum,
            'categorie' => $this->categorie,
            'calculated_btw' => $this->calculatedBtw,
            'calculated_total' => $this->calculatedTotal,
        ]);

        // Normalize date (accept both Y-m-d and d-m-Y)
        if ($this->datum) {
            try {
                $parsed = \Carbon\Carbon::createFromFormat('Y-m-d', $this->datum);
            } catch (\Throwable) {
                try {
                    $parsed = \Carbon\Carbon::createFromFormat('d-m-Y', $this->datum);
                    $this->datum = $parsed->format('Y-m-d');
                } catch (\Throwable) {
                    // leave as-is; validation will catch
                }
            }
        }

        // Validate - Livewire will automatically show errors
        $this->validate();

        $organizationId = auth()->user()->organization_id;
        
        if (!$organizationId) {
            $this->addError('organization', 'Geen organisatie gevonden. Log opnieuw in.');
            return;
        }

        // Check if bedrag_excl_btw is valid
        if ($this->bedrag_excl_btw <= 0) {
            $this->addError('bedrag_excl_btw', 'Bedrag moet groter zijn dan 0');
            return;
        }

        $data = [
            'organization_id' => $organizationId,
            'naam' => $this->naam,
            'beschrijving' => $this->beschrijving ?: null,
            'bedrag_excl_btw' => $this->bedrag_excl_btw,
            'btw_percentage' => $this->btw_percentage,
            'btw_bedrag' => $this->calculatedBtw,
            'totaal_bedrag' => $this->calculatedTotal,
            'categorie' => $this->categorie ?: null,
            'datum' => $this->datum,
            'status' => 'draft',
        ];

        try {
            DB::beginTransaction();
            
            if ($this->btwAftrek) {
                $this->btwAftrek->update($data);
                session()->flash('message', 'BTW aftrek bijgewerkt!');
            } else {
                BtwAftrek::create($data);
                session()->flash('message', 'BTW aftrek toegevoegd!');
            }
            
            DB::commit();
            
            return redirect()->route('app.btw-aftrek.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('BTW Aftrek save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
                'request_data' => [
                    'naam' => $this->naam,
                    'bedrag_excl_btw' => $this->bedrag_excl_btw,
                    'btw_percentage' => $this->btw_percentage,
                    'datum' => $this->datum,
                ]
            ]);
            $this->addError('save', 'Opslaan mislukt: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.btw-aftrek-form');
    }
}

