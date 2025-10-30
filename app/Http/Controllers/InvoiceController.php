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
        $organizationId = auth()->user()->organization_id;
        
        // Calculate statistics efficiently in controller
        $stats = [
            'total' => Invoice::forOrganization($organizationId)->count(),
            'paid' => Invoice::forOrganization($organizationId)->where('status', 'paid')->count(),
            'sent' => Invoice::forOrganization($organizationId)->where('status', 'sent')->count(),
            'overdue' => Invoice::forOrganization($organizationId)->where('status', 'overdue')->count(),
        ];
        
        // Build query with filters
        $query = Invoice::forOrganization($organizationId)
            ->with(['client', 'project']);
        
        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $invoices = $query->latest()->paginate(12)->withQueryString();

        return view('app.invoices.index', compact('invoices', 'stats'));
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
        $invoice->load(['client', 'project', 'items', 'payments', 'organization']);
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
