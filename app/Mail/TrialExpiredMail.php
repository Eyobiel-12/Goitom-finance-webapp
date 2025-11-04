<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TrialExpiredMail extends BaseMail
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
            subject: 'Je trial is verlopen – rond je betaling af',
            from: config('mail.from.address'),
            replyTo: config('mail.from.address'),
            tags: ['trial', 'expired', 'payment'],
            metadata: [
                'organization_id' => (string) $this->organization->id,
                'type' => 'trial_expired',
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trial-expired',
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
