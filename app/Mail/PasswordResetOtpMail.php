<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otpCode
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Wachtwoord Reset - Goitom Finance',
            from: config('mail.from.address', 'no-reply@goitomfinance.email'),
            replyTo: config('mail.from.address', 'no-reply@goitomfinance.email'),
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.password-reset-otp-plain',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

