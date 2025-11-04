<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

abstract class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Get the message envelope with anti-spam headers
     */
    public function envelope(): Envelope
    {
        $envelope = $this->buildEnvelope();
        
        // Add anti-spam headers to prevent emails from going to spam
        $this->withSymfonyMessage(function ($message) {
            // Get domain from app URL
            $domain = parse_url(config('app.url', 'https://goitomfinance.email'), PHP_URL_HOST) ?: 'goitomfinance.email';
            
            // Precedence header (prevents auto-replies)
            $message->getHeaders()->addTextHeader('Precedence', 'bulk');
            
            // List-Unsubscribe header (required for marketing emails - improves deliverability)
            $unsubscribeUrl = config('app.url') . '/unsubscribe';
            $message->getHeaders()->addTextHeader(
                'List-Unsubscribe',
                '<' . $unsubscribeUrl . '>'
            );
            $message->getHeaders()->addTextHeader(
                'List-Unsubscribe-Post',
                'List-Unsubscribe=One-Click'
            );
            
            // X-Priority header (normal priority)
            $message->getHeaders()->addTextHeader('X-Priority', '3');
            
            // Auto-Submitted header (prevents auto-replies)
            $message->getHeaders()->addTextHeader('Auto-Submitted', 'auto-generated');
            
            // Note: Return-Path and Message-ID are automatically set by Symfony/Laravel
            // We don't need to set them manually as they require specific header types
            
            // X-Mailer header (identify application)
            $message->getHeaders()->addTextHeader('X-Mailer', 'Goitom Finance v1.0');
            
            // X-Auto-Response-Suppress header (prevents auto-replies)
            $message->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'All');
            
            // X-Entity-Ref-ID header (for email tracking)
            $message->getHeaders()->addTextHeader('X-Entity-Ref-ID', uniqid('', true));
            
            // MIME-Version header
            $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
        });
        
        return $envelope;
    }

    /**
     * Build the envelope - must be implemented by child classes
     */
    abstract protected function buildEnvelope(): Envelope;
}

