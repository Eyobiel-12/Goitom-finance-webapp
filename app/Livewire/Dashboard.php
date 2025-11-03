<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

final class Dashboard extends Component
{
    public string $dateRange = 'all';
    public ?string $startDate = null;
    public ?string $endDate = null;

    public function mount(): void
    {
        // Set default date range to current month
        $this->dateRange = 'month';
        $this->updateDateRange();
    }

    public function updateDateRange(): void
    {
        match($this->dateRange) {
            'today' => [
                $this->startDate = now()->startOfDay()->toDateString(),
                $this->endDate = now()->endOfDay()->toDateString()
            ],
            'week' => [
                $this->startDate = now()->startOfWeek()->toDateString(),
                $this->endDate = now()->endOfWeek()->toDateString()
            ],
            'month' => [
                $this->startDate = now()->startOfMonth()->toDateString(),
                $this->endDate = now()->endOfMonth()->toDateString()
            ],
            'quarter' => [
                $this->startDate = now()->startOfQuarter()->toDateString(),
                $this->endDate = now()->endOfQuarter()->toDateString()
            ],
            'year' => [
                $this->startDate = now()->startOfYear()->toDateString(),
                $this->endDate = now()->endOfYear()->toDateString()
            ],
            'all' => [
                $this->startDate = null,
                $this->endDate = null
            ],
            default => null
        };
    }

    public function render()
    {
        $organizationId = auth()->user()->organization_id;
        
        // Build queries with optional date filtering
        $clientsQuery = Client::forOrganization($organizationId);
        $projectsQuery = Project::forOrganization($organizationId)->byStatus('active');
        $invoicesQuery = Invoice::forOrganization($organizationId);
        $revenueQuery = Invoice::forOrganization($organizationId)->byStatus('paid');
        
        // Apply date filtering if set
        if ($this->startDate && $this->endDate) {
            $clientsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
            $projectsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
            $invoicesQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
            $revenueQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }
        
        // Current stats
        $stats = [
            'total_clients' => $clientsQuery->count(),
            'active_projects' => $projectsQuery->count(),
            'total_invoices' => $invoicesQuery->count(),
            'pending_invoices' => (clone $invoicesQuery)->byStatus('sent')->count(),
            'overdue_invoices' => (clone $invoicesQuery)->overdue()->count(),
            'total_revenue' => $revenueQuery->sum('total'),
        ];
        
        // Previous period stats for comparison
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        
        $previousStats = [
            'clients' => Client::forOrganization($organizationId)
                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->count(),
            'revenue' => Invoice::forOrganization($organizationId)
                ->byStatus('paid')
                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->sum('total'),
        ];
        
        // Calculate growth percentages
        $growth = [
            'clients' => $previousStats['clients'] > 0 
                ? (($stats['total_clients'] - $previousStats['clients']) / $previousStats['clients']) * 100 
                : 100,
            'revenue' => $previousStats['revenue'] > 0 
                ? (($stats['total_revenue'] - $previousStats['revenue']) / $previousStats['revenue']) * 100 
                : 100,
        ];
        
        // Revenue by month (last 6 months)
        $revenueByMonth = Invoice::forOrganization($organizationId)
            ->byStatus('paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('TO_CHAR(created_at, \'YYYY-MM\') as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month');
        
        // Invoice status breakdown
        $invoiceStatusBreakdown = Invoice::forOrganization($organizationId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        $recentInvoices = Invoice::forOrganization($organizationId)
            ->with(['client', 'items'])
            ->latest()
            ->limit(5)
            ->get();
            
        $recentClients = Client::forOrganization($organizationId)
            ->latest()
            ->limit(5)
            ->get();
            
        // Smart Alerts - Upcoming due dates & overdue
        $upcomingDue = Invoice::forOrganization($organizationId)
            ->byStatus('sent')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->with('client')
            ->orderBy('due_date')
            ->limit(5)
            ->get();
            
        $overdueInvoices = Invoice::forOrganization($organizationId)
            ->overdue()
            ->with('client')
            ->orderBy('due_date')
            ->limit(5)
            ->get();
            
        // Top Performers - Best clients by revenue
        $topClients = Client::forOrganization($organizationId)
            ->withSum(['invoices' => function($query) {
                $query->where('status', 'paid');
            }], 'total')
            ->withCount('invoices')
            ->get()
            ->filter(fn($client) => $client->invoices_sum_total > 0)
            ->sortByDesc('invoices_sum_total')
            ->take(5);
            
        // Top projects by revenue
        $topProjects = Project::forOrganization($organizationId)
            ->withSum(['invoices' => function($query) {
                $query->where('status', 'paid');
            }], 'total')
            ->get()
            ->filter(fn($project) => $project->invoices_sum_total > 0)
            ->sortByDesc('invoices_sum_total')
            ->take(5);
            
        // Financial Insights
        $insights = [
            'avg_invoice_value' => Invoice::forOrganization($organizationId)
                ->where('status', 'paid')
                ->avg('total') ?? 0,
            'avg_payment_days' => $this->calculateAveragePaymentDays($organizationId),
            'outstanding_balance' => Invoice::forOrganization($organizationId)
                ->whereIn('status', ['sent', 'overdue'])
                ->sum('total'),
            'paid_this_month' => Invoice::forOrganization($organizationId)
                ->byStatus('paid')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('total'),
            'invoices_this_month' => Invoice::forOrganization($organizationId)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
        ];
        
        // Recent activities (combining invoices and clients)
        $recentActivities = collect();
        
        // Add recent invoices to activities
        Invoice::forOrganization($organizationId)
            ->with('client')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($invoice) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'invoice',
                    'title' => "Factuur #{$invoice->number} aangemaakt",
                    'description' => "Voor {$invoice->client->name}",
                    'amount' => $invoice->total,
                    'status' => $invoice->status,
                    'created_at' => $invoice->created_at,
                    'icon' => 'invoice',
                ]);
            });
            
        // Add recent clients to activities
        Client::forOrganization($organizationId)
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($client) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'client',
                    'title' => "Nieuwe klant toegevoegd",
                    'description' => $client->name,
                    'created_at' => $client->created_at,
                    'icon' => 'user',
                ]);
            });
            
        // Sort activities by date
        $recentActivities = $recentActivities->sortByDesc('created_at')->take(10);

        return view('livewire.dashboard', compact(
            'stats', 
            'growth',
            'recentInvoices', 
            'recentClients',
            'revenueByMonth',
            'invoiceStatusBreakdown',
            'recentActivities',
            'upcomingDue',
            'overdueInvoices',
            'topClients',
            'topProjects',
            'insights'
        ));
    }
    
    private function calculateAveragePaymentDays(int $organizationId): float
    {
        $paidInvoices = Invoice::forOrganization($organizationId)
            ->byStatus('paid')
            ->whereNotNull('sent_at')
            ->whereNotNull('updated_at')
            ->get();
            
        if ($paidInvoices->isEmpty()) {
            return 0;
        }
        
        $totalDays = 0;
        $count = 0;
        
        foreach ($paidInvoices as $invoice) {
            if ($invoice->sent_at && $invoice->updated_at) {
                $totalDays += $invoice->sent_at->diffInDays($invoice->updated_at);
                $count++;
            }
        }
        
        return $count > 0 ? round($totalDays / $count, 1) : 0;
    }
}
