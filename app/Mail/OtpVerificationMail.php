<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OtpVerificationMail extends BaseMail
{
    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $otpCode
    ) {}

    /**
     * Build the message envelope.
     */
    protected function buildEnvelope(): Envelope
    {
        return new Envelope(
            subject: 'E-mail Bevestiging - Goitom Finance',
            from: config('mail.from.address'),
            replyTo: config('mail.from.address'),
            tags: ['otp', 'verification'],
            metadata: [
                'type' => 'otp_verification',
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp-verification',
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
