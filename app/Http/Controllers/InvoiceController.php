<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ) {}

    public function index(Request $request): View
    {
        $invoices = Invoice::forOrganization(auth()->user()->organization_id)
            ->with(['client', 'project'])
            ->latest()
            ->paginate(12);

        return view('app.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $clients = Client::forOrganization(auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        $projects = Project::forOrganization(auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        return view('app.invoices.create', compact('clients', 'projects'));
    }

    public function store(InvoiceRequest $request): RedirectResponse
    {
        $invoice = $this->invoiceService->create(
            auth()->user()->organization_id,
            $request->validated()
        );

        return redirect()->route('app.invoices.show', $invoice)
            ->with('success', 'Factuur aangemaakt.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['client', 'project', 'items', 'payments']);
        return view('app.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice): View
    {
        $invoice->load('items');
        
        $clients = Client::forOrganization(auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        $projects = Project::forOrganization(auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        return view('app.invoices.edit', compact('invoice', 'clients', 'projects'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice = $this->invoiceService->update($invoice, $request->validated());

        return redirect()->route('app.invoices.show', $invoice)
            ->with('success', 'Factuur bijgewerkt.');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()->route('app.invoices.index')
            ->with('success', 'Factuur verwijderd.');
    }
}
