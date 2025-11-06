<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PaymentLastWarningMail extends BaseMail
{
    /**
     * Create a new message instance.
     */
    public function __construct(public readonly \App\Models\Organization $organization)
    {
    }

    /**
     * Build the message envelope.
     */
    protected function buildEnvelope(): Envelope
    {
        return new Envelope(
            subject: 'Laatste waarschuwing – betaling vereist',
            from: config('mail.from.address'),
            replyTo: config('mail.from.address'),
            tags: ['payment', 'warning'],
            metadata: [
                'organization_id' => (string) $this->organization->id,
                'type' => 'payment_warning',
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-last-warning',
            with: [
                'organization' => $this->organization,
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
        return [];
    }
}
