<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Client;
use App\Models\Project;
use App\Services\InvoiceService;
use Livewire\Component;
use Livewire\WithFileUploads;

final class InvoiceForm extends Component
{
    use WithFileUploads;

    public $invoice = null;
    public $client_id = '';
    public $project_id = '';
    public $number = '';
    public $issue_date = '';
    public $due_date = '';
    public $currency = 'EUR';
    public $status = 'draft';
    public $notes = '';
    public $vat_percentage = 21;
    public $payment_terms = 30; // days
    public $clientSearch = '';
    public $showClientModal = false;
    public $newClient = [
        'name' => '',
        'email' => '',
        'phone' => '',
    ];
    
    public $items = [];
    public $newItem = [
        'description' => '',
        'qty' => 1,
        'unit_price' => 0,
        'vat_rate' => 21,
    ];

    protected array $baseRules = [
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'nullable|exists:projects,id',
        'number' => 'required|string|max:255',
        'issue_date' => 'required|date',
        'due_date' => 'nullable|date|after:issue_date',
        'payment_terms' => 'nullable|integer|min:0|max:120',
        'currency' => 'required|string|max:3',
        'status' => 'required|in:draft,sent,paid,overdue,cancelled',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.description' => 'nullable|string',
        'items.*.qty' => 'nullable|numeric|min:0',
        'items.*.unit_price' => 'nullable|numeric|min:0',
        'items.*.vat_rate' => 'nullable|numeric|min:0|max:100',
    ];

    protected function rules(): array
    {
        $rules = $this->baseRules;
        if ($this->showClientModal === true) {
            $rules['newClient.name'] = 'required|string|max:255';
            $rules['newClient.email'] = 'nullable|email|max:255';
            $rules['newClient.phone'] = 'nullable|string|max:50';
        }
        return $rules;
    }

    public function mount($invoice = null)
    {
        if ($invoice) {
            $this->invoice = $invoice;
            $this->client_id = $invoice->client_id;
            $this->project_id = $invoice->project_id;
            $this->number = $invoice->number;
            $this->issue_date = $invoice->issue_date->format('Y-m-d');
            $this->due_date = $invoice->due_date?->format('Y-m-d');
            $this->currency = $invoice->currency;
            $this->status = $invoice->status;
            $this->notes = $invoice->notes;
            
            $this->items = $invoice->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'qty' => $item->qty,
                    'unit_price' => $item->unit_price,
                    'vat_rate' => $item->vat_rate,
                ];
            })->toArray();
        } else {
            $this->issue_date = now()->format('Y-m-d');
            $this->payment_terms = 30;
            $this->due_date = now()->addDays($this->payment_terms)->format('Y-m-d');
            $this->number = app(InvoiceService::class)->generateInvoiceNumber(auth()->user()->organization_id);
        }
    }

    public function updatedPaymentTerms(): void
    {
        if ($this->issue_date && $this->payment_terms !== null) {
            $this->due_date = \Carbon\Carbon::parse($this->issue_date)->addDays((int) $this->payment_terms)->format('Y-m-d');
        }
    }

    public function updatedVatPercentage(): void
    {
        // When global VAT changes, align all line items to this rate
        $rate = (float) $this->vat_percentage;
        foreach ($this->items as $i => $it) {
            $this->items[$i]['vat_rate'] = $rate;
        }
    }

    public function updatedItems($value, $key): void
    {
        // Normalize EU decimals for qty and unit_price as user types
        if (preg_match('/^(\\d+)\\.(qty|unit_price)$/', $key, $m)) {
            $index = (int) $m[1];
            $field = $m[2];
            $raw = $this->items[$index][$field];
            if (is_string($raw)) {
                $this->items[$index][$field] = (float) str_replace([',', ' '], ['.', ''], $raw);
            }
        }
    }

    public function addItem()
    {
        // Add item without validation - user will fill it
        $this->items[] = [
            'description' => '',
            'qty' => 1,
            'unit_price' => 0,
            'vat_rate' => (float) $this->vat_percentage,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function duplicateItem(int $index): void
    {
        if (!isset($this->items[$index])) return;
        $copy = $this->items[$index];
        $this->items = array_values(array_merge(
            array_slice($this->items, 0, $index + 1),
            [$copy],
            array_slice($this->items, $index + 1)
        ));
    }

    private function persistInvoice(): \App\Models\Invoice
    {
        // Check limits before creating new invoice
        if (!$this->invoice && !auth()->user()->organization->canCreateInvoice()) {
            session()->flash('error', 'Je hebt je maandelijkse limiet bereikt (' . auth()->user()->organization->limit_invoices_per_month . ' facturen). Upgrade naar Pro voor onbeperkt facturen.');
            $this->dispatch('show-upgrade-modal');
            throw new \Exception('Invoice limit reached');
        }

        $this->validate();

        $data = [
            'organization_id' => auth()->user()->organization_id,
            'client_id' => $this->client_id,
            'project_id' => $this->project_id ?: null,
            'number' => $this->number,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date ?: null,
            'currency' => $this->currency,
            'status' => $this->status,
            'notes' => $this->notes,
            'items' => $this->items,
        ];

        $invoiceService = app(InvoiceService::class);

        if ($this->invoice) {
            $invoice = $invoiceService->updateInvoice($this->invoice, $data);
            session()->flash('message', 'Factuur bijgewerkt!');
        } else {
            $invoice = $invoiceService->createInvoice($data);
            session()->flash('message', 'Factuur aangemaakt!');
            $this->invoice = $invoice; // keep for follow-up actions
        }

        return $invoice;
    }

    public function save()
    {
        $invoice = $this->persistInvoice();
        return redirect()->route('app.invoices.show', $invoice);
    }

    public function saveDraft()
    {
        $this->status = 'draft';
        return $this->save();
    }

    public function saveAndSend()
    {
        // Check Pro feature
        if (!auth()->user()->organization->canUseFeature('email_sending')) {
            session()->flash('error', 'E-mail verzenden is een Pro feature. Upgrade je plan om door te gaan.');
            $this->dispatch('show-upgrade-modal');
            return;
        }

        $this->status = 'sent';
        $invoice = $this->persistInvoice();
        // send now that we have an invoice
        app(InvoiceService::class)->sendInvoice($invoice);
        session()->flash('message', 'Factuur aangemaakt en verzonden!');
        return redirect()->route('app.invoices.show', $invoice);
    }

    public function generatePdf()
    {
        if ($this->invoice) {
            app(InvoiceService::class)->generatePdf($this->invoice);
            session()->flash('message', 'PDF wordt gegenereerd...');
        }
    }

    public function sendInvoice()
    {
        // Check Pro feature
        if (!auth()->user()->organization->canUseFeature('email_sending')) {
            session()->flash('error', 'E-mail verzenden is een Pro feature. Upgrade je plan om door te gaan.');
            $this->dispatch('show-upgrade-modal');
            return;
        }

        if ($this->invoice) {
            app(InvoiceService::class)->sendInvoice($this->invoice);
            $this->status = 'sent';
            session()->flash('message', 'Factuur verzonden!');
        }
    }

    public function createClient(): void
    {
        // Check client limit
        if (!auth()->user()->organization->canCreateClient()) {
            session()->flash('error', 'Je hebt je limiet bereikt (' . auth()->user()->organization->limit_clients . ' klanten). Upgrade naar Pro.');
            $this->showClientModal = false;
            return;
        }

        $this->validate([ 'newClient.name' => 'required|string|max:255', 'newClient.email' => 'nullable|email|max:255', 'newClient.phone' => 'nullable|string|max:50' ]);

        $client = Client::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->newClient['name'],
            'email' => $this->newClient['email'] ?: null,
            'phone' => $this->newClient['phone'] ?: null,
        ]);

        $this->client_id = (string) $client->id;
        $this->clientSearch = '';
        $this->showClientModal = false;
        $this->newClient = ['name' => '', 'email' => '', 'phone' => ''];
        session()->flash('message', 'Klant toegevoegd.');
    }

    public function getClientsProperty()
    {
        $query = Client::forOrganization(auth()->user()->organization_id);
        if ($this->clientSearch !== '') {
            $query->where('name', 'ilike', '%' . $this->clientSearch . '%');
        }
        return $query->orderBy('name')->get();
    }

    public function getProjectsProperty()
    {
        $query = Project::forOrganization(auth()->user()->organization_id);
        if ($this->client_id) {
            $query->where('client_id', $this->client_id);
        }
        return $query->orderBy('name')->get();
    }

    public function getSubtotalProperty()
    {
        return collect($this->items)->sum(function ($item) {
            return $item['qty'] * $item['unit_price'];
        });
    }

    public function getVatTotalProperty()
    {
        return collect($this->items)->sum(function ($item) {
            return ($item['qty'] * $item['unit_price']) * ($item['vat_rate'] / 100);
        });
    }

    public function getVat0Property()
    {
        return collect($this->items)->where('vat_rate', 0)->sum(fn ($i) => ($i['qty'] * $i['unit_price']) * 0);
    }

    public function getVat9Property()
    {
        return collect($this->items)->where('vat_rate', 9)->sum(fn ($i) => ($i['qty'] * $i['unit_price']) * 0.09);
    }

    public function getVat21Property()
    {
        return collect($this->items)->where('vat_rate', 21)->sum(fn ($i) => ($i['qty'] * $i['unit_price']) * 0.21);
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->vatTotal;
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }
}
