<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

final class PdfSettings extends Component
{
    use WithFileUploads;

    public $template = 'classic';
    public $primary_color = '#10b981';
    public $logo;
    public $show_logo = true;
    public $company_name = '';
    public $tagline = '';
    public $footer_message = 'Bedankt voor je vertrouwen!';

    // Extra bedrijfsinformatie
    public $kvk = '';
    public $iban = '';
    public $phone = '';
    public $website = '';
    public $address_line1 = '';
    public $address_line2 = '';
    public $postal_code = '';
    public $city = '';
    public $country = '';
    
    // Wizard state
    public $current_step = 1;
    public $total_steps = 4;

    public function mount()
    {
        // Load organization altijd fresh uit database
        $user = auth()->user();
        if ($user->organization_id) {
            $organization = \App\Models\Organization::find($user->organization_id);
        } else {
            $organization = $user->organization;
            if ($organization) {
                $organization->refresh();
            }
        }
        
        if (!$organization) {
            abort(404, 'Organization not found');
        }
        
        $settings = $organization->settings ?? [];
        
        $this->template = $settings['pdf_template'] ?? 'classic';
        $this->primary_color = $settings['pdf_primary_color'] ?? '#10b981';
        $this->show_logo = $settings['pdf_show_logo'] ?? true;
        $this->company_name = $organization->name;
        $this->tagline = $organization->tagline ?? 'Professionele Financiële Diensten';
        $this->footer_message = $settings['pdf_footer_message'] ?? 'Bedankt voor je vertrouwen!';
        
        // Herstel laatste stap uit settings
        $this->current_step = $settings['pdf_settings_step'] ?? 1;

        // Load extended fields
        $this->kvk = $settings['kvk'] ?? '';
        $this->iban = $settings['iban'] ?? '';
        $this->phone = $settings['phone'] ?? '';
        $this->website = $settings['website'] ?? '';
        $this->address_line1 = $settings['address_line1'] ?? '';
        $this->address_line2 = $settings['address_line2'] ?? '';
        $this->postal_code = $settings['postal_code'] ?? '';
        $this->city = $settings['city'] ?? '';
        $this->country = $settings['country'] ?? '';
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

    public function updatedCompanyName()
    {
        $organization = auth()->user()->organization;
        $organization->update(['name' => $this->company_name]);
    }

    public function nextStep()
    {
        // Auto-save instellingen bij stap overgang
        $this->saveSettings();
        
        if ($this->current_step < $this->total_steps) {
            $this->current_step++;
            // Sla huidige stap op
            $this->saveCurrentStep();
        }
    }

    public function previousStep()
    {
        if ($this->current_step > 1) {
            $this->current_step--;
            // Sla huidige stap op
            $this->saveCurrentStep();
        }
    }

    public function goToStep($step)
    {
        // Auto-save voor je naar een andere stap gaat
        $this->saveSettings();
        
        if ($step >= 1 && $step <= $this->total_steps) {
            $this->current_step = $step;
            // Sla huidige stap op
            $this->saveCurrentStep();
        }
    }

    public function updatedPrimaryColor()
    {
        $this->saveSettings();
    }

    public function updatedKvk()
    {
        $this->saveSettings();
    }

    public function updatedIban()
    {
        $this->saveSettings();
    }

    public function updatedPhone()
    {
        $this->saveSettings();
    }

    public function updatedWebsite()
    {
        $this->saveSettings();
    }

    public function updatedAddressLine1()
    {
        $this->saveSettings();
    }

    public function updatedAddressLine2()
    {
        $this->saveSettings();
    }

    public function updatedPostalCode()
    {
        $this->saveSettings();
    }

    public function updatedCity()
    {
        $this->saveSettings();
    }

    public function updatedCountry()
    {
        $this->saveSettings();
    }

    public function updatedShowLogo()
    {
        $this->saveSettings();
    }

    public function updatedFooterMessage()
    {
        $this->saveSettings();
    }

    public function updatedLogo()
    {
        \Log::info('updatedLogo called', [
            'has_logo' => $this->logo !== null,
            'logo_type' => $this->logo ? get_class($this->logo) : 'null'
        ]);
        
        // Livewire file uploads zijn asynchroon - probeer direct op te slaan
        if ($this->logo) {
            try {
                // Validate eerst
                $this->validateOnly('logo', [
                    'logo' => 'required|image|max:2048',
                ]);
                
                \Log::info('Logo is valid, saving immediately...');
                $this->saveLogo();
            } catch (\Exception $e) {
                \Log::error('Error in updatedLogo', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                session()->flash('error', 'Fout bij logo upload: ' . $e->getMessage());
            }
        }
    }
    
    public function saveUploadedLogo()
    {
        \Log::info('saveUploadedLogo called', [
            'has_logo' => $this->logo !== null,
            'logo_type' => $this->logo ? get_class($this->logo) : 'null'
        ]);
        
        if (!$this->logo) {
            session()->flash('error', 'Geen logo bestand gevonden. Selecteer eerst een bestand.');
            \Log::warning('saveUploadedLogo called but $this->logo is null');
            return;
        }
        
        // Validate logo
        try {
            $this->validate([
                'logo' => 'required|image|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Logo validation failed', ['errors' => $e->errors()]);
            session()->flash('error', 'Logo validatie mislukt: ' . implode(', ', $e->errors()['logo'] ?? []));
            return;
        }
        
        // Check of logo geldig is
        if (method_exists($this->logo, 'isValid') && !$this->logo->isValid()) {
            \Log::error('Logo is not valid', ['error' => $this->logo->getError()]);
            session()->flash('error', 'Logo bestand is ongeldig: ' . $this->logo->getError());
            return;
        }
        
        try {
            \Log::info('Logo is valid, saving...');
            $this->saveLogo();
        } catch (\Exception $e) {
            \Log::error('Error in saveUploadedLogo', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Fout bij logo upload: ' . $e->getMessage());
        }
    }

    public function save()
    {
        // Alle instellingen opslaan
        $this->saveSettings();
        
        session()->flash('message', 'PDF-instellingen opgeslagen!');
    }

    private function saveLogo(): void
    {
        if (!$this->logo) {
            \Log::warning('saveLogo called without $this->logo');
            return;
        }

        // Check of logo geldig is
        if (!$this->logo->isValid()) {
            session()->flash('error', 'Logo bestand is ongeldig: ' . $this->logo->getError());
            \Log::error('Logo is not valid', ['error' => $this->logo->getError()]);
            return;
        }

        $organization = auth()->user()->organization;
        
        // Verwijder oude logo als die bestaat
        if ($organization->logo_path && Storage::disk('public')->exists($organization->logo_path)) {
            try {
                Storage::disk('public')->delete($organization->logo_path);
                \Log::info('Old logo deleted', ['old_path' => $organization->logo_path]);
            } catch (\Exception $e) {
                \Log::warning('Failed to delete old logo', ['error' => $e->getMessage()]);
            }
        }
        
        // Upload nieuw logo naar public disk
        try {
            // Upload logo
            $path = $this->logo->store('logos', 'public');
            \Log::info('Logo stored to path', ['path' => $path, 'org_id' => $organization->id]);
            
            // Verifieer dat bestand bestaat
            if (!Storage::disk('public')->exists($path)) {
                session()->flash('error', 'Logo upload mislukt. Bestand niet gevonden na upload.');
                \Log::error('Stored logo not found on disk', ['path' => $path]);
                return;
            }
            
            // Check bestandsgrootte
            $fileSize = Storage::disk('public')->size($path);
            \Log::info('Logo file size', ['path' => $path, 'size' => $fileSize]);
            
            // Update organization met logo_path - gebruik direct update() voor betrouwbaarheid
            $organization->logo_path = $path;
            $organization->save();
            
            // Forceer fresh load van organization
            $organization->refresh();
            
            // Verifieer dat logo_path is opgeslagen
            if ($organization->logo_path !== $path) {
                session()->flash('error', 'Logo pad niet correct opgeslagen in database.');
                \Log::error('Logo path not saved correctly', ['expected' => $path, 'actual' => $organization->logo_path]);
                return;
            }
            
            \Log::info('Organization logo_path updated successfully', ['org_id' => $organization->id, 'path' => $path]);
            
            // Reset logo property NA succesvol opslaan
            $this->logo = null;
            
            // Flash success message
            session()->flash('message', 'Logo succesvol geüpload!');
            
            // Forceer re-render van de component
            $this->dispatch('logo-uploaded');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Logo upload mislukt: ' . $e->getMessage());
            \Log::error('Logo upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function saveCurrentStep()
    {
        $organization = auth()->user()->organization;
        $settings = $organization->settings ?? [];
        $settings['pdf_settings_step'] = $this->current_step;
        $organization->update(['settings' => $settings]);
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
        $settings['pdf_settings_step'] = $this->current_step; // Sla ook stap op

        // Extended fields
        $settings['kvk'] = $this->kvk;
        $settings['iban'] = $this->iban;
        $settings['phone'] = $this->phone;
        $settings['website'] = $this->website;
        $settings['address_line1'] = $this->address_line1;
        $settings['address_line2'] = $this->address_line2;
        $settings['postal_code'] = $this->postal_code;
        $settings['city'] = $this->city;
        $settings['country'] = $this->country;
        
        $organization->update(['settings' => $settings]);
    }

    public function render()
    {
        // Forceer altijd verse organization data zodat logo_path meteen zichtbaar is
        // Dit zorgt ervoor dat na refresh het logo altijd correct wordt geladen
        $user = auth()->user();
        
        // Load organization direct uit database - altijd fresh!
        if ($user->organization_id) {
            $organization = \App\Models\Organization::find($user->organization_id);
        } else {
            // Fallback: load via relation en refresh
            $organization = $user->organization;
            if ($organization) {
                $organization->refresh();
            }
        }
        
        // Als er geen organization is, return null
        if (!$organization) {
            abort(404, 'Organization not found');
        }
        
        return view('livewire.pdf-settings', [
            'organization' => $organization,
        ]);
    }
}
