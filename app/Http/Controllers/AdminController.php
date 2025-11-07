<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Organization;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $stats = $this->getSystemStats();
        $recentOrganizations = Organization::with('owner')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        $recentUsers = User::with('organization')
            ->where('role', '!=', 'admin')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        $recentPayments = SubscriptionPayment::with('organization')
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrganizations' => $recentOrganizations,
            'recentUsers' => $recentUsers,
            'recentPayments' => $recentPayments,
        ]);
    }
    
    public function organizations(Request $request)
    {
        $query = Organization::with('owner', 'users')
            ->withCount(['users', 'clients', 'projects', 'invoices']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%")
                  ->orWhere('vat_number', 'ilike', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by subscription
        if ($request->has('subscription') && $request->subscription) {
            $query->where('subscription_status', $request->subscription);
        }
        
        $organizations = $query->orderByDesc('created_at')->paginate(20);
        
        return view('admin.organizations', [
            'organizations' => $organizations,
        ]);
    }
    
    public function showOrganization(Organization $organization)
    {
        $organization->load([
            'owner',
            'users',
            'clients',
            'projects',
            'invoices' => function ($q) {
                $q->orderByDesc('created_at')->limit(10);
            },
            'subscriptionPayments' => function ($q) {
                $q->orderByDesc('paid_at')->limit(10);
            },
        ]);
        
        $stats = [
            'total_clients' => $organization->clients()->count(),
            'total_projects' => $organization->projects()->count(),
            'total_invoices' => $organization->invoices()->count(),
            'total_revenue' => $organization->invoices()->where('status', 'paid')->sum('total'),
            'subscription_payments' => $organization->subscriptionPayments()->sum('amount'),
        ];
        
        return view('admin.organization-show', [
            'organization' => $organization,
            'stats' => $stats,
        ]);
    }
    
    public function users(Request $request)
    {
        $query = User::with('organization')
            ->where('role', '!=', 'admin');
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderByDesc('created_at')->paginate(20);
        
        return view('admin.users', [
            'users' => $users,
        ]);
    }
    
    public function subscriptions(Request $request)
    {
        $query = Organization::with('owner')
            ->whereNotNull('subscription_plan');
        
        // Filter by plan
        if ($request->has('plan') && $request->plan) {
            $query->where('subscription_plan', $request->plan);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('subscription_status', $request->status);
        }
        
        $organizations = $query->orderByDesc('created_at')->paginate(20);
        
        // Get subscription stats
        $subscriptionStats = [
            'total_starter' => Organization::where('subscription_plan', 'starter')->count(),
            'total_pro' => Organization::where('subscription_plan', 'pro')->count(),
            'total_active' => Organization::where('subscription_status', 'active')->count(),
            'total_trial' => Organization::where('subscription_status', 'trial')->count(),
            'total_past_due' => Organization::where('subscription_status', 'past_due')->count(),
            'total_suspended' => Organization::where('subscription_status', 'suspended')->count(),
            'monthly_revenue' => SubscriptionPayment::whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
        ];
        
        return view('admin.subscriptions', [
            'organizations' => $organizations,
            'stats' => $subscriptionStats,
        ]);
    }
    
    // Organization Management Actions
    public function updateOrganization(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:active,suspended,pending',
            'subscription_status' => 'sometimes|in:trial,active,past_due,suspended,canceled',
            'subscription_plan' => 'sometimes|in:starter,pro',
        ]);
        
        $organization->update($validated);
        
        return back()->with('success', 'Organisatie bijgewerkt!');
    }
    
    public function suspendOrganization(Organization $organization)
    {
        $organization->update(['status' => 'suspended']);
        return back()->with('success', 'Organisatie opgeschort!');
    }
    
    public function activateOrganization(Organization $organization)
    {
        $organization->update(['status' => 'active']);
        return back()->with('success', 'Organisatie geactiveerd!');
    }
    
    public function extendTrial(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);
        
        $newTrialEndsAt = $organization->trial_ends_at 
            ? $organization->trial_ends_at->copy()->addDays($validated['days'])
            : now()->addDays($validated['days']);
        
        $organization->update([
            'trial_ends_at' => $newTrialEndsAt,
            'subscription_status' => 'trial',
        ]);
        
        return back()->with('success', "Trial verlengd met {$validated['days']} dagen!");
    }
    
    public function changeSubscriptionPlan(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'plan' => 'required|in:starter,pro',
            'status' => 'sometimes|in:trial,active,past_due,suspended,canceled',
        ]);
        
        $organization->update([
            'subscription_plan' => $validated['plan'],
            'subscription_status' => $validated['status'] ?? 'active',
        ]);
        
        return back()->with('success', "Abonnement gewijzigd naar {$validated['plan']}!");
    }
    
    // User Management Actions
    public function suspendUser(User $user)
    {
        // For now, we'll just mark them - you might want to add a 'suspended' field
        $user->update(['email' => $user->email . '.suspended']);
        return back()->with('success', 'Gebruiker opgeschort!');
    }
    
    public function activateUser(User $user)
    {
        $user->update(['email' => str_replace('.suspended', '', $user->email)]);
        return back()->with('success', 'Gebruiker geactiveerd!');
    }
    
    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Kan admin gebruiker niet verwijderen!');
        }
        
        $user->delete();
        return back()->with('success', 'Gebruiker verwijderd!');
    }
    
    // Export Actions
    public function exportOrganizations(Request $request)
    {
        $organizations = Organization::with('owner')
            ->withCount(['users', 'clients', 'projects', 'invoices'])
            ->get();
        
        $csv = "ID,Naam,Email,BTW,Eigenaar,Status,Abonnement,Gebruikers,Klanten,Projecten,Facturen,Aangemaakt\n";
        
        foreach ($organizations as $org) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%s,%s,%d,%d,%d,%d,%s\n",
                $org->id,
                '"' . str_replace('"', '""', $org->name) . '"',
                '"' . str_replace('"', '""', $org->email ?? '') . '"',
                '"' . str_replace('"', '""', $org->vat_number ?? '') . '"',
                '"' . str_replace('"', '""', $org->owner->name ?? '') . '"',
                $org->status,
                $org->subscription_plan ?? '—',
                $org->users_count,
                $org->clients_count,
                $org->projects_count,
                $org->invoices_count,
                $org->created_at->format('Y-m-d')
            );
        }
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="organizations-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
    
    public function exportUsers(Request $request)
    {
        $users = User::with('organization')
            ->where('role', '!=', 'admin')
            ->get();
        
        $csv = "ID,Naam,Email,Rol,Organisatie,Aangemaakt\n";
        
        foreach ($users as $user) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%s\n",
                $user->id,
                '"' . str_replace('"', '""', $user->name) . '"',
                '"' . str_replace('"', '""', $user->email) . '"',
                $user->role,
                '"' . str_replace('"', '""', $user->organization->name ?? '') . '"',
                $user->created_at->format('Y-m-d')
            );
        }
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
    
    // System Health
    public function systemHealth()
    {
        $health = [
            'database' => [
                'status' => 'healthy',
                'connections' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
                'size' => $this->getDatabaseSize(),
            ],
            'storage' => [
                'status' => 'healthy',
                'free_space' => disk_free_space(storage_path()),
                'total_space' => disk_total_space(storage_path()),
            ],
            'queue' => [
                'status' => 'healthy',
                'pending_jobs' => DB::table('jobs')->count(),
            ],
            'cache' => [
                'status' => 'healthy',
            ],
        ];
        
        return view('admin.system-health', [
            'health' => $health,
        ]);
    }
    
    private function getDatabaseSize(): string
    {
        try {
            $result = DB::selectOne("SELECT pg_size_pretty(pg_database_size(current_database())) as size");
            return $result->size ?? 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
    
    // Advanced Statistics
    public function statistics()
    {
        $stats = $this->getAdvancedStats();
        return view('admin.statistics', [
            'stats' => $stats,
        ]);
    }
    
    private function getAdvancedStats(): array
    {
        $now = now();
        $last6Months = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i);
        });
        
        $monthlyOrganizations = $last6Months->map(function ($date) {
            return [
                'month' => $date->format('M Y'),
                'count' => Organization::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
            ];
        });
        
        $monthlyRevenue = $last6Months->map(function ($date) {
            return [
                'month' => $date->format('M Y'),
                'revenue' => Invoice::where('status', 'paid')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('total'),
            ];
        });
        
        $subscriptionDistribution = [
            'starter' => Organization::where('subscription_plan', 'starter')->count(),
            'pro' => Organization::where('subscription_plan', 'pro')->count(),
            'trial' => Organization::where('subscription_status', 'trial')->count(),
            'active' => Organization::where('subscription_status', 'active')->count(),
            'past_due' => Organization::where('subscription_status', 'past_due')->count(),
            'suspended' => Organization::where('subscription_status', 'suspended')->count(),
        ];
        
        return [
            'monthly_organizations' => $monthlyOrganizations,
            'monthly_revenue' => $monthlyRevenue,
            'subscription_distribution' => $subscriptionDistribution,
        ];
    }
    
    private function getSystemStats(): array
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();
        
        return [
            'total_organizations' => Organization::count(),
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'total_clients' => DB::table('clients')->count(),
            'total_projects' => DB::table('projects')->count(),
            'total_invoices' => Invoice::count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total'),
            'total_subscription_revenue' => SubscriptionPayment::sum('amount'),
            'active_subscriptions' => Organization::where('subscription_status', 'active')->count(),
            'trial_subscriptions' => Organization::where('subscription_status', 'trial')->count(),
            'organizations_this_month' => Organization::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count(),
            'organizations_last_month' => Organization::whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->count(),
            'users_this_month' => User::where('role', '!=', 'admin')
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count(),
            'users_last_month' => User::where('role', '!=', 'admin')
                ->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->count(),
            'revenue_this_month' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->sum('total'),
            'revenue_last_month' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->sum('total'),
        ];
    }
}

