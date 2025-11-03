<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

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
            // Generate HTML for the invoice
            $html = $this->generateInvoiceHtml();
            
            // Generate PDF using Browsershot
            $pdfContent = Browsershot::html($html)
                ->format('A4')
                ->margins(10, 10, 10, 10)
                ->showBackground()
                ->pdf();
            
            // Store PDF in storage
            $filename = "invoices/invoice-{$this->invoice->number}.pdf";
            Storage::disk('public')->put($filename, $pdfContent);
            
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
        
        return view('invoices.pdf', compact('invoice'))->render();
    }
}
