<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\BtwAangifte;
use App\Models\BtwSettings;
use Carbon\Carbon;
use Livewire\Component;

final class BtwAangifteGenerator extends Component
{
    public $jaar;
    public $kwartaal = null;
    public $btwAangifte = null;
    public $showCorrectionForm = false;
    public $correctionReason = '';
    public $correctionDiscoveredDate = '';
    
    protected function rules(): array
    {
        return [
            'jaar' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'kwartaal' => 'nullable|integer|min:1|max:4',
            'correctionReason' => 'required_if:showCorrectionForm,true|string|min:10',
            'correctionDiscoveredDate' => 'required_if:showCorrectionForm,true|date',
        ];
    }

    public function mount(): void
    {
        $this->jaar = now()->year;
        $this->kwartaal = $this->getCurrentQuarter();
        $this->correctionDiscoveredDate = now()->format('Y-m-d');
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
        // Validate using component rules (avoid Livewire array index validation error)
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
            // Validate before submission
            $errors = $this->btwAangifte->validate();
            
            if (!empty($errors)) {
                session()->flash('error', 'Validatiefouten: ' . implode(', ', $errors));
                return;
            }

            $this->btwAangifte->update([
                'status' => 'ingediend',
                'indien_datum' => now(),
            ]);
            session()->flash('message', 'BTW aangifte gemarkeerd als ingediend!');
            $this->btwAangifte = $this->btwAangifte->fresh();
        }
    }

    public function createCorrection(): void
    {
        // Validate using component rules so Livewire maps to real properties
        $this->validate();

        if (!$this->btwAangifte) {
            session()->flash('error', 'Selecteer eerst een aangifte om te corrigeren');
            return;
        }

        // Create correction aangifte
        $correction = BtwAangifte::create([
            'organization_id' => auth()->user()->organization_id,
            'jaar' => $this->btwAangifte->jaar,
            'kwartaal' => $this->btwAangifte->kwartaal,
            'correction_of_id' => $this->btwAangifte->id,
            'correction_reason' => $this->correctionReason,
            'correction_discovered_date' => $this->correctionDiscoveredDate,
            'status' => 'concept',
        ]);

        // Recalculate
        $correction->calculate();
        $correction->save();

        $this->btwAangifte = $correction;
        $this->showCorrectionForm = false;
        $this->correctionReason = '';
        session()->flash('message', 'Correctie aangifte aangemaakt! Controleer de gegevens.');
    }

    public function render()
    {
        $aangifteList = BtwAangifte::forOrganization(auth()->user()->organization_id)
            ->orderBy('jaar', 'desc')
            ->orderBy('kwartaal', 'desc')
            ->get();
            
        $settings = BtwSettings::forOrganization(auth()->user()->organization_id);
        
        // Get upcoming deadlines
        $upcomingDeadlines = $this->getUpcomingDeadlines();

        return view('livewire.btw-aangifte-generator', compact('aangifteList', 'settings', 'upcomingDeadlines'));
    }

    private function getUpcomingDeadlines(): array
    {
        $deadlines = [];
        $currentYear = now()->year;
        $currentQuarter = $this->getCurrentQuarter();
        
        // Next 4 quarters
        for ($i = 0; $i < 4; $i++) {
            $quarter = $currentQuarter + $i;
            $year = $currentYear;
            
            if ($quarter > 4) {
                $quarter = $quarter - 4;
                $year++;
            }
            
            $deadline = Carbon::create($year, ($quarter * 3) + 1, 1)->endOfMonth();
            
            $deadlines[] = [
                'period' => "Q{$quarter} {$year}",
                'deadline' => $deadline,
                'days_until' => now()->diffInDays($deadline, false),
                'is_overdue' => $deadline < now(),
            ];
        }
        
        return $deadlines;
    }
}
