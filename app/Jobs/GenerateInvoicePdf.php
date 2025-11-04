<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class GenerateInvoicePdf implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Invoice $invoice
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Generate HTML for the invoice using the configured template
            $html = $this->generateInvoiceHtml();

            // Generate PDF using the same engine/settings as the synchronous path (DomPDF)
            $pdf = \PDF::loadHtml($html)
                ->setPaper('a4', 'portrait')
                ->setOption('enable-local-file-access', true);

            // Store PDF in storage
            $filename = "invoices/invoice-{$this->invoice->number}.pdf";
            Storage::disk('public')->put($filename, $pdf->output());
            
            // Update invoice with PDF path
            $this->invoice->update([
                'pdf_path' => $filename
            ]);
            
            Log::info("PDF generated for invoice {$this->invoice->number}");
            
        } catch (\Exception $e) {
            Log::error("Failed to generate PDF for invoice {$this->invoice->number}: " . $e->getMessage());
            throw $e;
        }
    }

    private function generateInvoiceHtml(): string
    {
        $invoice = $this->invoice->load(['client', 'organization', 'items']);
        // Select the same Blade view as the synchronous generator
        $template = $invoice->organization->settings['pdf_template'] ?? 'classic';
        $viewName = "invoices.pdf-{$template}";

        return view($viewName, compact('invoice'))->render();
    }
}
