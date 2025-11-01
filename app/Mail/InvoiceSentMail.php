<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class InvoiceSentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public bool $withAttachment = true
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uw Factuur van ' . $this->invoice->organization->name,
            from: config('mail.from.address'),
            replyTo: $this->invoice->organization->owner->email ?? config('mail.from.address'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-sent',
            with: [
                'invoice' => $this->invoice,
                'organization' => $this->invoice->organization,
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->withAttachment) {
            \Illuminate\Support\Facades\Log::info("Sending invoice email without PDF attachment (disabled)");
            return [];
        }

        if (!$this->invoice->pdf_path) {
            \Illuminate\Support\Facades\Log::warning("Invoice has no pdf_path", [
                'invoice_id' => $this->invoice->id,
                'invoice_number' => $this->invoice->number,
            ]);
            return [];
        }

        // Check if file exists - try multiple possible paths
        $possiblePaths = [
            storage_path('app/public/' . $this->invoice->pdf_path),
            storage_path('app/' . $this->invoice->pdf_path),
            $this->invoice->pdf_path,
        ];

        $fullPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $fullPath = $path;
                break;
            }
        }
        
        if (!$fullPath || !file_exists($fullPath)) {
            \Illuminate\Support\Facades\Log::error("PDF file not found for invoice", [
                'invoice_id' => $this->invoice->id,
                'invoice_number' => $this->invoice->number,
                'pdf_path' => $this->invoice->pdf_path,
                'tried_paths' => $possiblePaths,
            ]);
            return [];
        }

        $fileSize = filesize($fullPath);
        \Illuminate\Support\Facades\Log::info("Attaching PDF to invoice email", [
            'path' => $fullPath,
            'size' => $fileSize,
            'invoice' => $this->invoice->number,
            'invoice_id' => $this->invoice->id,
        ]);

        return [
            Attachment::fromPath($fullPath)
                ->as('Factuur-' . $this->invoice->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
