<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

final class PdfSettings extends Component
{
    use WithFileUploads;

    public $template = 'modern';
    public $primary_color = '#10b981';
    public $logo;
    public $show_logo = true;
    public $company_name = '';
    public $tagline = '';
    public $footer_message = 'Bedankt voor je vertrouwen!';

    public function mount()
    {
        $organization = auth()->user()->organization;
        $settings = $organization->settings ?? [];
        
        $this->template = $settings['pdf_template'] ?? 'modern';
        $this->primary_color = $settings['pdf_primary_color'] ?? '#10b981';
        $this->show_logo = $settings['pdf_show_logo'] ?? true;
        $this->company_name = $organization->name;
        $this->tagline = $organization->tagline ?? 'Professionele Financiële Diensten';
        $this->footer_message = $settings['pdf_footer_message'] ?? 'Bedankt voor je vertrouwen!';
    }

    public function updatedTemplate()
    {
        $this->saveSettings();
    }

    public function updatedTagline()
    {
        $organization = auth()->user()->organization;
        $organization->update(['tagline' => $this->tagline]);
    }

    public function updatedPrimaryColor()
    {
        $this->saveSettings();
    }

    public function save()
    {
        $organization = auth()->user()->organization;
        
        // Upload logo if provided
        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            $organization->update(['logo_path' => $path]);
        }
        
        $this->saveSettings();
        
        session()->flash('message', 'PDF-instellingen opgeslagen!');
    }

    private function saveSettings()
    {
        $organization = auth()->user()->organization;
        
        // Update settings
        $settings = $organization->settings ?? [];
        $settings['pdf_template'] = $this->template;
        $settings['pdf_primary_color'] = $this->primary_color;
        $settings['pdf_show_logo'] = $this->show_logo;
        $settings['pdf_footer_message'] = $this->footer_message;
        $settings['tagline'] = $this->tagline;
        
        $organization->update(['settings' => $settings]);
    }

    public function render()
    {
        $organization = auth()->user()->organization;
        return view('livewire.pdf-settings', [
            'organization' => $organization,
        ]);
    }
}
