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
        'bedrag_excl_btw' => 'required|numeric|min:0',
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
        if (in_array($propertyName, ['bedrag_excl_btw', 'btw_percentage'])) {
            $this->validateOnly($propertyName);
        }
    }

    public function nextStep(): void
    {
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
        return $this->bedrag_excl_btw * ($this->btw_percentage / 100);
    }

    public function getCalculatedTotalProperty(): float
    {
        return $this->bedrag_excl_btw + $this->calculatedBtw;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'organization_id' => auth()->user()->organization_id,
            'naam' => $this->naam,
            'beschrijving' => $this->beschrijving ?: null,
            'bedrag_excl_btw' => $this->bedrag_excl_btw,
            'btw_percentage' => $this->btw_percentage,
            'btw_bedrag' => $this->calculatedBtw,
            'totaal_bedrag' => $this->calculatedTotal,
            'categorie' => $this->categorie ?: null,
            'datum' => $this->datum,
        ];

        if ($this->btwAftrek) {
            $this->btwAftrek->update($data);
            session()->flash('message', 'BTW aftrek bijgewerkt!');
        } else {
            BtwAftrek::create($data);
            session()->flash('message', 'BTW aftrek toegevoegd!');
        }

        $this->redirect(route('app.btw-aftrek.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.btw-aftrek-form');
    }
}

