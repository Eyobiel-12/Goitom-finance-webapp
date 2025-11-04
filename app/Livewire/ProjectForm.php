<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;

final class ProjectForm extends Component
{
    public $project = null;
    public $client_id = '';
    public $name = '';
    public $description = '';
    public $status = 'active';
    public $rate = '';
    public $hours = 0;
    
    public $current_step = 1;
    public $total_steps = 3;

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:active,completed,paused,cancelled',
        'rate' => 'nullable|numeric|min:0',
        'hours' => 'nullable|numeric|min:0',
    ];
    
    protected function getCurrentStepRules(): array
    {
        return match($this->current_step) {
            1 => [
                'client_id' => 'required|exists:clients,id',
            ],
            2 => [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ],
            3 => [
                'status' => 'required|in:active,completed,paused,cancelled',
                'rate' => 'nullable|numeric|min:0',
                'hours' => 'nullable|numeric|min:0',
            ],
            default => [],
        };
    }
    
    public function nextStep()
    {
        $this->validate($this->getCurrentStepRules());
        if ($this->current_step < $this->total_steps) {
            $this->current_step++;
        }
    }
    
    public function previousStep()
    {
        if ($this->current_step > 1) {
            $this->current_step--;
        }
    }
    
    public function goToStep($step)
    {
        $this->current_step = $step;
    }

    public function mount($project = null)
    {
        if ($project) {
            $this->project = $project;
            $this->client_id = $project->client_id;
            $this->name = $project->name;
            $this->description = $project->description ?? '';
            $this->status = $project->status;
            $this->rate = $project->rate ?? '';
            $this->hours = $project->hours ?? 0;
        }
    }

    public function save()
    {
        // Check limits before creating new project
        if (!$this->project && !auth()->user()->organization->canCreateProject()) {
            session()->flash('error', 'Je hebt je limiet bereikt (' . auth()->user()->organization->limit_active_projects . ' actieve projecten). Upgrade naar Pro voor onbeperkt projecten.');
            return redirect()->route('app.projects.index');
        }

        $this->validate();

        $data = [
            'organization_id' => auth()->user()->organization_id,
            'client_id' => $this->client_id,
            'name' => $this->name,
            'description' => $this->description ?: null,
            'status' => $this->status,
            'rate' => $this->rate ?: null,
            'hours' => $this->hours,
        ];

        if ($this->project) {
            $this->project->update($data);
            session()->flash('message', 'Project bijgewerkt!');
        } else {
            $project = Project::create($data);
            session()->flash('message', 'Project aangemaakt!');
            return redirect()->route('app.projects.index');
        }

        return redirect()->route('app.projects.index');
    }

    public function getClientsProperty()
    {
        return Client::forOrganization(auth()->user()->organization_id)->get();
    }

    public function render()
    {
        return view('livewire.project-form');
    }
}
