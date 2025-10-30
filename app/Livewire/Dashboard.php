<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use Livewire\Component;

final class Dashboard extends Component
{
    public function render()
    {
        $organizationId = auth()->user()->organization_id;
        
        $stats = [
            'total_clients' => Client::forOrganization($organizationId)->count(),
            'active_projects' => Project::forOrganization($organizationId)->byStatus('active')->count(),
            'total_invoices' => Invoice::forOrganization($organizationId)->count(),
            'pending_invoices' => Invoice::forOrganization($organizationId)->byStatus('sent')->count(),
            'overdue_invoices' => Invoice::forOrganization($organizationId)->overdue()->count(),
            'total_revenue' => Invoice::forOrganization($organizationId)->byStatus('paid')->sum('total'),
        ];
        
        // Revenue trends - laatste 6 maanden
        $months = collect();
        $revenueData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            
            // Gebruik payments voor accurate revenue timing
            $revenue = \App\Models\Payment::whereHas('invoice', function($q) use ($organizationId) {
                $q->forOrganization($organizationId);
            })
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('amount');
            
            $revenue = is_numeric($revenue) ? (float) $revenue : 0.0;
            
            // Fallback naar invoices met status paid als er geen payments zijn
            if ($revenue == 0) {
                $revenue = Invoice::forOrganization($organizationId)
                    ->byStatus('paid')
                    ->whereBetween('issue_date', [$monthStart, $monthEnd])
                    ->sum('total');
                
                $revenue = is_numeric($revenue) ? (float) $revenue : 0.0;
            }
            
            $months->push($monthStart->format('M Y'));
            $revenueData->push(round($revenue, 2));
        }
        
        // Invoice status breakdown
        $invoiceStatuses = [
            'draft' => Invoice::forOrganization($organizationId)->byStatus('draft')->count(),
            'sent' => Invoice::forOrganization($organizationId)->byStatus('sent')->count(),
            'paid' => Invoice::forOrganization($organizationId)->byStatus('paid')->count(),
            'overdue' => Invoice::forOrganization($organizationId)->overdue()->count(),
        ];
        
        // Top clients by revenue
        $topClients = Invoice::forOrganization($organizationId)
            ->byStatus('paid')
            ->selectRaw('client_id, SUM(total) as total_revenue')
            ->groupBy('client_id')
            ->with('client')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get()
            ->map(function ($invoice) {
                $revenue = is_numeric($invoice->total_revenue) ? (float) $invoice->total_revenue : 0.0;
                return [
                    'name' => $invoice->client->name ?? 'Unknown',
                    'revenue' => round($revenue, 2),
                ];
            });
        
        $recentInvoices = Invoice::forOrganization($organizationId)
            ->with(['client', 'items'])
            ->latest()
            ->limit(5)
            ->get();
            
        $recentClients = Client::forOrganization($organizationId)
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard', compact(
            'stats', 
            'recentInvoices', 
            'recentClients',
            'months',
            'revenueData',
            'invoiceStatuses',
            'topClients'
        ));
    }
}
