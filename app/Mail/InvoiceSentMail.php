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
            from: $this->invoice->organization->owner->email ?? config('mail.from.address'),
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

        return [
            Attachment::fromStorage('public/' . $this->invoice->pdf_path)
                ->as('Factuur-' . $this->invoice->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
