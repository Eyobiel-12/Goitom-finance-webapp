<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\InvoiceReminderMail;
use App\Models\Invoice;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

final class SendInvoiceReminders extends Command
{
    protected $signature = 'invoices:send-reminders';

    protected $description = 'Verstuur automatische herinneringen voor achterstallige en bijna vervallen facturen';

    public function handle(): int
    {
        $this->info('Controleren op facturen die herinneringen nodig hebben...');

        $notificationService = new NotificationService();
        $processed = 0;

        // Achterstallige facturen
        $overdueInvoices = Invoice::where('status', '!=', 'paid')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'invoice_overdue')
                    ->where('created_at', '>', now()->subDay());
            })
            ->with(['client', 'organization'])
            ->get();

        foreach ($overdueInvoices as $invoice) {
            // Verstuur reminder email naar klant (als email bestaat en factuur status is 'sent')
            if ($invoice->status === 'sent' && $invoice->client->email) {
                try {
                    // Generate PDF if not exists
                    if (!$invoice->pdf_path) {
                        $invoiceService = app(\App\Services\InvoiceService::class);
                        $pdf = $invoiceService->generatePdfSync($invoice);
                        $invoice->update(['pdf_path' => $pdf]);
                    }
                    
                    Mail::to($invoice->client->email)
                        ->send(new InvoiceReminderMail($invoice));
                    
                    $this->info("Reminder email sent for invoice {$invoice->number}");
                } catch (\Exception $e) {
                    $this->error("Failed to send reminder email for invoice {$invoice->number}: " . $e->getMessage());
                }
            }
            
            // Verstuur notification naar alle users in de organisatie
            $users = $invoice->organization->users;
            if ($users->isEmpty() && $invoice->organization->owner_user_id) {
                $users = collect([$invoice->organization->owner]);
            }
            
            foreach ($users as $user) {
                $notificationService->createInvoiceOverdueNotification($invoice, $user->id);
            }
            $processed++;
        }

        $this->info("Achterstallige facturen: {$overdueInvoices->count()}");

        // Bijna vervallen facturen (3 dagen voor vervaldatum)
        $upcomingInvoices = Invoice::where('status', 'sent')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->addDays(3)->startOfDay(), now()->addDays(3)->endOfDay()])
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'payment_reminder')
                    ->where('created_at', '>', now()->subDay());
            })
            ->with(['client', 'organization'])
            ->get();

        foreach ($upcomingInvoices as $invoice) {
            $daysUntilDue = now()->diffInDays($invoice->due_date);
            $users = $invoice->organization->users;
            if ($users->isEmpty() && $invoice->organization->owner_user_id) {
                $users = collect([$invoice->organization->owner]);
            }
            
            foreach ($users as $user) {
                $notificationService->createPaymentReminderNotification($invoice, $user->id, $daysUntilDue);
            }
            $processed++;
        }

        $this->info("Bijna vervallen facturen: {$upcomingInvoices->count()}");
        $this->info("Totaal verwerkt: {$processed}");

        return self::SUCCESS;
    }
}
