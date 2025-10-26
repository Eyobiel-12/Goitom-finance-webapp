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
    
    public $items = [];
    public $newItem = [
        'description' => '',
        'qty' => 1,
        'unit_price' => 0,
        'vat_rate' => 21,
    ];

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'nullable|exists:projects,id',
        'number' => 'required|string|max:255',
        'issue_date' => 'required|date',
        'due_date' => 'nullable|date|after:issue_date',
        'currency' => 'required|string|max:3',
        'status' => 'required|in:draft,sent,paid,overdue,cancelled',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.description' => 'required|string',
        'items.*.qty' => 'required|numeric|min:0.01',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.vat_rate' => 'required|numeric|min:0|max:100',
    ];

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
            $this->due_date = now()->addDays(30)->format('Y-m-d');
            $this->number = app(InvoiceService::class)->generateInvoiceNumber(auth()->user()->organization_id);
        }
    }

    public function addItem()
    {
        $this->validate([
            'newItem.description' => 'required|string',
            'newItem.qty' => 'required|numeric|min:0.01',
            'newItem.unit_price' => 'required|numeric|min:0',
            'newItem.vat_rate' => 'required|numeric|min:0|max:100',
        ]);

        $this->items[] = $this->newItem;
        $this->newItem = [
            'description' => '',
            'qty' => 1,
            'unit_price' => 0,
            'vat_rate' => 21,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
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
        }

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
        if ($this->invoice) {
            app(InvoiceService::class)->sendInvoice($this->invoice);
            $this->status = 'sent';
            session()->flash('message', 'Factuur verzonden!');
        }
    }

    public function getClientsProperty()
    {
        return Client::forOrganization(auth()->user()->organization_id)->get();
    }

    public function getProjectsProperty()
    {
        return Project::forOrganization(auth()->user()->organization_id)->get();
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

    public function getTotalProperty()
    {
        return $this->subtotal + $this->vatTotal;
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }
}
