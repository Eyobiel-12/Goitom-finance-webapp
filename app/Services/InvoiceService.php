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
    public function createInvoice(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $invoice = Invoice::create([
                'organization_id' => $data['organization_id'],
                'client_id' => $data['client_id'],
                'project_id' => $data['project_id'] ?? null,
                'number' => $data['number'],
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'] ?? null,
                'currency' => $data['currency'] ?? 'EUR',
                'status' => $data['status'] ?? 'draft',
                'notes' => $data['notes'] ?? null,
            ]);

            // Create invoice items
            if (isset($data['items']) && is_array($data['items'])) {
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
            }

            return $invoice->fresh(['items']);
        });
    }

    /**
     * Update an existing invoice
     */
    public function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $invoice->update([
                'client_id' => $data['client_id'] ?? $invoice->client_id,
                'project_id' => $data['project_id'] ?? $invoice->project_id,
                'issue_date' => $data['issue_date'] ?? $invoice->issue_date,
                'due_date' => $data['due_date'] ?? $invoice->due_date,
                'currency' => $data['currency'] ?? $invoice->currency,
                'status' => $data['status'] ?? $invoice->status,
                'notes' => $data['notes'] ?? $invoice->notes,
            ]);

            // Update items if provided
            if (isset($data['items']) && is_array($data['items'])) {
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
            }

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
            $this->generatePdf($invoice);
        }

        // Update status and sent timestamp
        $invoice->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // TODO: Implement email sending
        // Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));
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
