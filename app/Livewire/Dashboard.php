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
        
        $recentInvoices = Invoice::forOrganization($organizationId)
            ->with(['client', 'items'])
            ->latest()
            ->limit(5)
            ->get();
            
        $recentClients = Client::forOrganization($organizationId)
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard', compact('stats', 'recentInvoices', 'recentClients'));
    }
}
