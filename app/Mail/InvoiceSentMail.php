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
        public Invoice $invoice
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
        if (!$this->invoice->pdf_path) {
            return [];
        }

        // Check if file exists
        $fullPath = storage_path('app/public/' . $this->invoice->pdf_path);
        
        if (!file_exists($fullPath)) {
            \Illuminate\Support\Facades\Log::error("PDF file not found: {$fullPath}");
            return [];
        }

        return [
            Attachment::fromPath($fullPath)
                ->as('Factuur-' . $this->invoice->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
