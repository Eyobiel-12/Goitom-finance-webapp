<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

final class ClientForm extends Component
{
    public $client = null;
    public $name = '';
    public $contact_name = '';
    public $email = '';
    public $phone = '';
    public $street = '';
    public $city = '';
    public $postal_code = '';
    public $country = 'NL';
    public $tax_id = '';
    public $kvk_number = '';
    
    public $current_step = 1;
    public $total_steps = 3;

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_name' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:255',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:2',
        'tax_id' => 'nullable|string|max:255',
        'kvk_number' => 'nullable|string|max:255',
    ];
    
    protected function getCurrentStepRules(): array
    {
        return match($this->current_step) {
            1 => [
                'name' => 'required|string|max:255',
                'contact_name' => 'nullable|string|max:255',
            ],
            2 => [
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:255',
            ],
            3 => [
                'street' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:2',
                'tax_id' => 'nullable|string|max:255',
                'kvk_number' => 'nullable|string|max:255',
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

    public function mount($client = null)
    {
        if ($client) {
            $this->client = $client;
            $this->name = $client->name;
            $this->contact_name = $client->contact_name ?? '';
            $this->email = $client->email ?? '';
            $this->phone = $client->phone ?? '';
            $this->tax_id = $client->tax_id ?? '';
            $this->kvk_number = $client->kvk_number ?? '';
            $this->country = $client->country ?? 'NL';
            
            $address = $client->address ?? [];
            $this->street = $address['street'] ?? '';
            $this->city = $address['city'] ?? '';
            $this->postal_code = $address['postal_code'] ?? '';
        }
    }

    public function save()
    {
        // Validate only required fields for all steps
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $address = [
            'street' => $this->street,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
        ];

        $data = [
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->name,
            'contact_name' => $this->contact_name ?: null,
            'email' => $this->email ?: null,
            'phone' => $this->phone ?: null,
            'address' => $address,
            'tax_id' => $this->tax_id ?: null,
            'kvk_number' => $this->kvk_number ?: null,
        ];

        if ($this->client) {
            $this->client->update($data);
            session()->flash('message', 'Klant bijgewerkt!');
        } else {
            $client = Client::create($data);
            session()->flash('message', 'Klant aangemaakt!');
            return redirect()->route('app.clients.index');
        }

        return redirect()->route('app.clients.index');
    }

    public function render()
    {
        return view('livewire.client-form');
    }
}
