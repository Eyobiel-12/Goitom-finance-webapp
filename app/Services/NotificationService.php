<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\User;

final class NotificationService
{
    public function createInvoiceOverdueNotification(Invoice $invoice, int $userId): void
    {
        $daysOverdue = now()->diffInDays($invoice->due_date);
        
        Notification::create([
            'organization_id' => $invoice->organization_id,
            'user_id' => $userId,
            'invoice_id' => $invoice->id,
            'type' => 'invoice_overdue',
            'title' => 'Achterstallige factuur',
            'message' => sprintf(
                'Factuur %s van %s is %d dag(en) achterstallig. Totaal: €%s',
                $invoice->number,
                $invoice->client->name ?? 'Onbekend',
                $daysOverdue,
                number_format($invoice->total, 2, ',', '.')
            ),
            'metadata' => [
                'invoice_number' => $invoice->number,
                'days_overdue' => $daysOverdue,
                'amount' => $invoice->total,
            ],
        ]);
    }

    public function createPaymentReminderNotification(Invoice $invoice, int $userId, int $daysUntilDue): void
    {
        Notification::create([
            'organization_id' => $invoice->organization_id,
            'user_id' => $userId,
            'invoice_id' => $invoice->id,
            'type' => 'payment_reminder',
            'title' => 'Betalingsherinnering',
            'message' => sprintf(
                'Factuur %s van %s is over %d dag(en) vervallen. Bedrag: €%s',
                $invoice->number,
                $invoice->client->name ?? 'Onbekend',
                $daysUntilDue,
                number_format($invoice->total, 2, ',', '.')
            ),
            'metadata' => [
                'invoice_number' => $invoice->number,
                'days_until_due' => $daysUntilDue,
                'amount' => $invoice->total,
            ],
        ]);
    }

    public function createInvoiceSentNotification(Invoice $invoice, int $userId): void
    {
        Notification::create([
            'organization_id' => $invoice->organization_id,
            'user_id' => $userId,
            'invoice_id' => $invoice->id,
            'type' => 'invoice_sent',
            'title' => 'Factuur verzonden',
            'message' => sprintf(
                'Factuur %s is verzonden naar %s',
                $invoice->number,
                $invoice->client->name ?? 'Onbekend'
            ),
            'metadata' => [
                'invoice_number' => $invoice->number,
            ],
        ]);
    }

    public function createInvoicePaidNotification(Invoice $invoice, int $userId): void
    {
        Notification::create([
            'organization_id' => $invoice->organization_id,
            'user_id' => $userId,
            'invoice_id' => $invoice->id,
            'type' => 'invoice_paid',
            'title' => 'Factuur betaald',
            'message' => sprintf(
                'Factuur %s van %s is betaald. Bedrag: €%s',
                $invoice->number,
                $invoice->client->name ?? 'Onbekend',
                number_format($invoice->total, 2, ',', '.')
            ),
            'metadata' => [
                'invoice_number' => $invoice->number,
                'amount' => $invoice->total,
            ],
        ]);
    }

    public function notifyAllUsersInOrganization(int $organizationId, string $type, string $title, string $message, ?int $invoiceId = null, ?array $metadata = null): void
    {
        $users = User::forOrganization($organizationId)->get();
        
        foreach ($users as $user) {
            Notification::create([
                'organization_id' => $organizationId,
                'user_id' => $user->id,
                'invoice_id' => $invoiceId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'metadata' => $metadata,
            ]);
        }
    }
}

