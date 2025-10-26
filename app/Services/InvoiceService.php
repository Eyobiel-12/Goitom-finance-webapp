<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\GenerateInvoicePdf;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

final class InvoiceService
{
    /**
     * Create a new invoice with items
     */
    public function create(int $organizationId, array $data): Invoice
    {
        return DB::transaction(function () use ($organizationId, $data) {
            $invoice = Invoice::create([
                'organization_id' => $organizationId,
                'client_id' => $data['client_id'],
                'project_id' => $data['project_id'] ?? null,
                'number' => $this->generateInvoiceNumber($organizationId),
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'] ?? null,
                'currency' => 'EUR',
                'status' => 'draft',
                'notes' => $data['notes'] ?? null,
            ]);

            // Create invoice items
            $subtotal = 0;
            $vatTotal = 0;

            foreach ($data['items'] as $itemData) {
                $netAmount = $itemData['qty'] * $itemData['unit_price'];
                $vatAmount = $netAmount * ($itemData['vat_rate'] / 100);
                $lineTotal = $netAmount + $vatAmount;

                $invoice->items()->create([
                    'description' => $itemData['description'],
                    'qty' => $itemData['qty'],
                    'unit_price' => $itemData['unit_price'],
                    'vat_rate' => $itemData['vat_rate'],
                    'net_amount' => $netAmount,
                    'vat_amount' => $vatAmount,
                    'line_total' => $lineTotal,
                ]);

                $subtotal += $netAmount;
                $vatTotal += $vatAmount;
            }

            // Update invoice totals
            $invoice->update([
                'subtotal' => $subtotal,
                'vat_total' => $vatTotal,
                'total' => $subtotal + $vatTotal,
            ]);

            return $invoice->fresh(['items']);
        });
    }

    /**
     * Update an existing invoice
     */
    public function update(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $invoice->update([
                'client_id' => $data['client_id'],
                'project_id' => $data['project_id'] ?? null,
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Delete old items and create new ones
            $invoice->items()->delete();

            $subtotal = 0;
            $vatTotal = 0;

            foreach ($data['items'] as $itemData) {
                $netAmount = $itemData['qty'] * $itemData['unit_price'];
                $vatAmount = $netAmount * ($itemData['vat_rate'] / 100);
                $lineTotal = $netAmount + $vatAmount;

                $invoice->items()->create([
                    'description' => $itemData['description'],
                    'qty' => $itemData['qty'],
                    'unit_price' => $itemData['unit_price'],
                    'vat_rate' => $itemData['vat_rate'],
                    'net_amount' => $netAmount,
                    'vat_amount' => $vatAmount,
                    'line_total' => $lineTotal,
                ]);

                $subtotal += $netAmount;
                $vatTotal += $vatAmount;
            }

            // Update invoice totals
            $invoice->update([
                'subtotal' => $subtotal,
                'vat_total' => $vatTotal,
                'total' => $subtotal + $vatTotal,
            ]);

            return $invoice->fresh(['items']);
        });
    }

    /**
     * Generate PDF for an invoice
     */
    public function generatePdf(Invoice $invoice): void
    {
        GenerateInvoicePdf::dispatch($invoice);
    }

    /**
     * Send invoice to client
     */
    public function sendInvoice(Invoice $invoice): void
    {
        // Generate PDF if not exists
        if (!$invoice->pdf_path) {
            // Generate PDF synchronously
            $pdf = $this->generatePdfSync($invoice);
            $invoice->update(['pdf_path' => $pdf]);
        }

        // Update status and sent timestamp
        $invoice->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Send email with PDF attachment
        try {
            \Illuminate\Support\Facades\Mail::to($invoice->client->email)
                ->send(new \App\Mail\InvoiceSentMail($invoice));
            
            \Illuminate\Support\Facades\Log::info("Invoice email sent to {$invoice->client->email} for invoice {$invoice->number}");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send invoice email to {$invoice->client->email}: " . $e->getMessage());
            throw $e;
        }
    }

    private function generatePdfSync(Invoice $invoice): string
    {
        // Generate HTML for the invoice
        $template = $invoice->organization->settings['pdf_template'] ?? 'classic';
        $viewName = "invoices.pdf-{$template}";
        $html = view($viewName, compact('invoice'))->render();
        
        // Generate PDF using DomPDF
        $pdf = \PDF::loadHtml($html)
            ->setPaper('a4', 'portrait')
            ->setOption('enable-local-file-access', true);
        
        // Store PDF in storage
        $filename = "invoices/invoice-{$invoice->number}.pdf";
        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $pdf->output());
        
        return $filename;
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(Invoice $invoice, array $paymentData = []): void
    {
        $invoice->update([
            'status' => 'paid',
        ]);

        // Create payment record if provided
        if (!empty($paymentData)) {
            $invoice->payments()->create([
                'amount' => $paymentData['amount'] ?? $invoice->total,
                'method' => $paymentData['method'] ?? 'bank_transfer',
                'date' => $paymentData['date'] ?? now(),
                'txn_reference' => $paymentData['txn_reference'] ?? null,
                'notes' => $paymentData['notes'] ?? null,
            ]);
        }
    }

    /**
     * Create a new invoice (alias for create)
     */
    public function createInvoice(array $data): Invoice
    {
        return $this->create($data['organization_id'], $data);
    }

    /**
     * Update an existing invoice (alias for update)
     */
    public function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return $this->update($invoice, $data);
    }

    /**
     * Generate next invoice number
     */
    public function generateInvoiceNumber(int $organizationId): string
    {
        $year = now()->year;
        $prefix = "INV-{$year}-";
        
        $lastInvoice = Invoice::where('organization_id', $organizationId)
            ->where('number', 'like', $prefix . '%')
            ->orderBy('number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) str_replace($prefix, '', $lastInvoice->number);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
