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

final class InvoiceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public bool $withAttachment = true
    ) {}

    public function envelope(): Envelope
    {
        $daysOverdue = 0;
        if ($this->invoice->due_date && $this->invoice->due_date->isPast()) {
            $daysOverdue = now()->diffInDays($this->invoice->due_date);
        }
        
        $subject = $daysOverdue > 0 
            ? sprintf('Herinnering: Openstaande factuur %s van %s (%d dag(en) achterstallig)', $this->invoice->number, $this->invoice->organization->name, $daysOverdue)
            : sprintf('Herinnering: Openstaande factuur %s van %s', $this->invoice->number, $this->invoice->organization->name);
        
        return new Envelope(
            subject: $subject,
            from: config('mail.from.address'),
            replyTo: $this->invoice->organization->owner->email ?? config('mail.from.address'),
        );
    }

    public function content(): Content
    {
        $daysOverdue = 0;
        if ($this->invoice->due_date && $this->invoice->due_date->isPast()) {
            $daysOverdue = now()->diffInDays($this->invoice->due_date);
        }
        
        // Gebruik platte tekst voor maximale deliverability (geen links)
        return new Content(
            text: 'emails.invoice-reminder-plain',
            with: [
                'invoice' => $this->invoice,
                'organization' => $this->invoice->organization,
                'daysOverdue' => $daysOverdue,
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->withAttachment) {
            \Illuminate\Support\Facades\Log::info("Sending reminder email without PDF attachment (disabled)");
            return [];
        }

        if (!$this->invoice->pdf_path) {
            \Illuminate\Support\Facades\Log::info("No PDF path for invoice {$this->invoice->number}, sending email without attachment");
            return [];
        }

        $fullPath = storage_path('app/public/' . $this->invoice->pdf_path);
        
        if (!file_exists($fullPath)) {
            \Illuminate\Support\Facades\Log::warning("PDF file not found: {$fullPath} - sending email without attachment");
            return [];
        }

        $fileSize = filesize($fullPath);
        \Illuminate\Support\Facades\Log::info("Attaching PDF to reminder email", [
            'path' => $fullPath,
            'size' => $fileSize,
            'invoice' => $this->invoice->number,
        ]);

        return [
            Attachment::fromPath($fullPath)
                ->as('Factuur-' . $this->invoice->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
