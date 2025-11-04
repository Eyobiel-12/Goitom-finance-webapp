<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class WelcomeMail extends BaseMail
{
    /**
     * Create a new message instance.
     */
    public function __construct(
        public $user
    ) {}

    /**
     * Build the message envelope.
     */
    protected function buildEnvelope(): Envelope
    {
        return new Envelope(
            subject: 'Welkom bij Goitom Finance!',
            from: config('mail.from.address'),
            replyTo: config('mail.from.address'),
            tags: ['welcome', 'onboarding'],
            metadata: [
                'user_id' => (string) $this->user->id,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
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
