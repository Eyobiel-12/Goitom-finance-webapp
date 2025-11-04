<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PasswordResetOtpMail extends BaseMail
{
    public function __construct(
        public string $otpCode
    ) {}

    protected function buildEnvelope(): Envelope
    {
        return new Envelope(
            subject: 'Wachtwoord Reset - Goitom Finance',
            from: config('mail.from.address'),
            replyTo: config('mail.from.address'),
            tags: ['password', 'reset', 'otp'],
            metadata: [
                'type' => 'password_reset',
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

