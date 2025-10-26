<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $organizationId = $request->user()->organization_id;
        
        $invoices = Invoice::forOrganization($organizationId)
            ->with(['client', 'project', 'items'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->get('client_id'), function ($query, $clientId) {
                return $query->where('client_id', $clientId);
            })
            ->when($request->get('date_from'), function ($query, $dateFrom) {
                return $query->where('issue_date', '>=', $dateFrom);
            })
            ->when($request->get('date_to'), function ($query, $dateTo) {
                return $query->where('issue_date', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
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
        ]);

        $validated['organization_id'] = $request->user()->organization_id;
        
        $invoice = $this->invoiceService->createInvoice($validated);

        return response()->json($invoice->load(['client', 'project', 'items']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);
        
        return response()->json($invoice->load(['client', 'project', 'items', 'payments']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);
        
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'issue_date' => 'sometimes|date',
            'due_date' => 'nullable|date|after:issue_date',
            'currency' => 'sometimes|string|max:3',
            'status' => 'sometimes|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
            'items' => 'sometimes|array|min:1',
            'items.*.description' => 'required_with:items|string',
            'items.*.qty' => 'required_with:items|numeric|min:0.01',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
            'items.*.vat_rate' => 'required_with:items|numeric|min:0|max:100',
        ]);

        $invoice = $this->invoiceService->updateInvoice($invoice, $validated);

        return response()->json($invoice->load(['client', 'project', 'items']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Invoice $invoice): Response
    {
        $this->authorize('delete', $invoice);
        
        $invoice->delete();

        return response()->noContent();
    }

    /**
     * Send invoice to client
     */
    public function send(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);
        
        $this->invoiceService->sendInvoice($invoice);

        return response()->json([
            'message' => 'Invoice sent successfully',
            'invoice' => $invoice->fresh()
        ]);
    }

    /**
     * Mark invoice as paid
     */
    public function markPaid(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);
        
        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:0',
            'method' => 'nullable|in:bank_transfer,cash,card,paypal,other',
            'date' => 'nullable|date',
            'txn_reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $this->invoiceService->markAsPaid($invoice, $validated);

        return response()->json([
            'message' => 'Invoice marked as paid',
            'invoice' => $invoice->fresh()
        ]);
    }

    /**
     * Generate PDF for invoice
     */
    public function pdf(Request $request, Invoice $invoice): Response
    {
        $this->authorize('view', $invoice);
        
        if (!$invoice->pdf_path) {
            $this->invoiceService->generatePdf($invoice);
            return response()->json(['message' => 'PDF generation started'], 202);
        }

        return response()->file(storage_path('app/public/' . $invoice->pdf_path));
    }

    /**
     * Get payments for invoice
     */
    public function payments(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);
        
        return response()->json($invoice->payments);
    }

    /**
     * Add payment to invoice
     */
    public function addPayment(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:bank_transfer,cash,card,paypal,other',
            'date' => 'required|date',
            'txn_reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $payment = $invoice->payments()->create($validated);

        return response()->json($payment, 201);
    }
}
