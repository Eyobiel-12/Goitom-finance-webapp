<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\SubscriptionPayment;
use App\Services\SubscriptionService;

class SubscriptionPurchasedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly SubscriptionPayment $payment)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bedankt voor je abonnement',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-purchased',
            with: [
                'payment' => $this->payment,
                'organization' => $this->payment->organization,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        try {
            // Generate PDF invoice
            $pdfPath = SubscriptionService::generatePaymentInvoicePdf($this->payment);
            $fullPath = storage_path('app/public/' . $pdfPath);
            
            if (!file_exists($fullPath)) {
                \Illuminate\Support\Facades\Log::error("Subscription invoice PDF not found: {$fullPath}");
                return [];
            }

            return [
                Attachment::fromPath($fullPath)
                    ->as('Factuur-Abonnement-' . str_pad((string)$this->payment->id, 6, '0', STR_PAD_LEFT) . '.pdf')
                    ->withMime('application/pdf'),
            ];
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Failed to generate subscription invoice PDF: " . $e->getMessage());
            return [];
        }
    }
}
