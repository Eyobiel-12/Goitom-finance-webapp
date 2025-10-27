<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\BtwAangifte;
use Carbon\Carbon;
use Livewire\Component;

final class BtwAangifteGenerator extends Component
{
    public $jaar;
    public $kwartaal = null;
    public $btwAangifte = null;
    
    protected array $rules = [
        'jaar' => 'required|integer|min:2020|max:' . (date('Y') + 1),
        'kwartaal' => 'nullable|integer|min:1|max:4',
    ];

    public function mount(): void
    {
        $this->jaar = now()->year;
        $this->kwartaal = $this->getCurrentQuarter();
    }

    private function getCurrentQuarter(): ?int
    {
        $month = now()->month;
        if ($month <= 3) return 1;
        if ($month <= 6) return 2;
        if ($month <= 9) return 3;
        return 4;
    }

    public function generate(): void
    {
        $this->validate();

        // Create or get existing aangifte
        $aangifte = BtwAangifte::updateOrCreate(
            [
                'organization_id' => auth()->user()->organization_id,
                'jaar' => $this->jaar,
                'kwartaal' => $this->kwartaal,
            ],
            [
                'organization_id' => auth()->user()->organization_id,
                'jaar' => $this->jaar,
                'kwartaal' => $this->kwartaal,
                'status' => 'concept',
            ]
        );

        // Calculate BTW
        $aangifte->calculate();
        $aangifte->save();

        $this->btwAangifte = $aangifte;
        session()->flash('message', 'BTW aangifte gegenereerd!');
    }

    public function markAsSubmitted(): void
    {
        if ($this->btwAangifte) {
            $this->btwAangifte->update([
                'status' => 'ingediend',
                'indien_datum' => now(),
            ]);
            session()->flash('message', 'BTW aangifte gemarkeerd als ingediend!');
            $this->btwAangifte = $this->btwAangifte->fresh();
        }
    }

    public function render()
    {
        $aangifteList = BtwAangifte::forOrganization(auth()->user()->organization_id)
            ->orderBy('jaar', 'desc')
            ->orderBy('kwartaal', 'desc')
            ->get();

        return view('livewire.btw-aangifte-generator', compact('aangifteList'));
    }
}

