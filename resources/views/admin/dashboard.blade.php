@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in">
        <!-- Total Organizations -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-blue-500/30 hover:shadow-blue-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-sm font-semibold mb-2">Totaal Organisaties</h3>
            <p class="text-4xl font-extrabold text-white mb-2 bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">{{ number_format($stats['total_organizations']) }}</p>
            <div class="flex items-center space-x-2 mt-3">
                <span class="text-xs text-gray-500">{{ $stats['organizations_this_month'] }} deze maand</span>
                @if($stats['organizations_last_month'] > 0)
                <span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/40 font-semibold">
                    +{{ round((($stats['organizations_this_month'] - $stats['organizations_last_month']) / $stats['organizations_last_month']) * 100) }}%
                </span>
                @endif
            </div>
        </div>

        <!-- Total Users -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-purple-500/30 hover:shadow-purple-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-sm font-semibold mb-2">Totaal Gebruikers</h3>
            <p class="text-4xl font-extrabold text-white mb-2 bg-gradient-to-r from-purple-400 to-purple-600 bg-clip-text text-transparent">{{ number_format($stats['total_users']) }}</p>
            <div class="flex items-center space-x-2 mt-3">
                <span class="text-xs text-gray-500">{{ $stats['users_this_month'] }} deze maand</span>
                @if($stats['users_last_month'] > 0)
                <span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/40 font-semibold">
                    +{{ round((($stats['users_this_month'] - $stats['users_last_month']) / $stats['users_last_month']) * 100) }}%
                </span>
                @endif
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-green-500/30 hover:shadow-green-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-sm font-semibold mb-2">Totaal Omzet</h3>
            <p class="text-4xl font-extrabold text-white mb-2 bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">€{{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
            <div class="flex items-center space-x-2 mt-3">
                <span class="text-xs text-gray-500">€{{ number_format($stats['revenue_this_month'], 2, ',', '.') }} deze maand</span>
                @if($stats['revenue_last_month'] > 0)
                <span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/40 font-semibold">
                    +{{ round((($stats['revenue_this_month'] - $stats['revenue_last_month']) / $stats['revenue_last_month']) * 100) }}%
                </span>
                @endif
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-yellow-500/30 hover:shadow-yellow-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-sm font-semibold mb-2">Actieve Abonnementen</h3>
            <p class="text-4xl font-extrabold text-white mb-2 bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">{{ number_format($stats['active_subscriptions']) }}</p>
            <div class="flex items-center space-x-2 mt-3">
                <span class="px-2 py-0.5 text-xs rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/40 font-semibold">
                    {{ $stats['trial_subscriptions'] }} in trial
                </span>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.1s">
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-gray-700 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Totaal Klanten</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['total_clients']) }}</p>
        </div>
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-gray-700 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Totaal Projecten</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500/20 to-pink-600/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['total_projects']) }}</p>
        </div>
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-gray-700 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Totaal Facturen</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['total_invoices']) }}</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.2s">
        <!-- Recent Organizations -->
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white">Recente Organisaties</h3>
                <a href="{{ route('admin.organizations.index') }}" class="text-xs text-red-400 hover:text-red-300 font-semibold transition-colors">Bekijk alle →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentOrganizations as $index => $org)
                <a href="{{ route('admin.organizations.show', $org) }}" 
                   class="group block p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 hover:from-gray-800 hover:to-gray-700/50 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 hover:shadow-lg animate-slide-in"
                   style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-white group-hover:text-red-400 transition-colors">{{ $org->name }}</p>
                            <p class="text-xs text-gray-400 mt-1 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $org->created_at->diffForHumans() }}</span>
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-red-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
                @empty
                <div class="p-4 rounded-xl bg-gray-800/30 border border-gray-700/50">
                    <p class="text-sm text-gray-500 text-center">Geen organisaties gevonden</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white">Recente Gebruikers</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-red-400 hover:text-red-300 font-semibold transition-colors">Bekijk alle →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentUsers as $index => $user)
                <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 animate-slide-in"
                     style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-lg flex items-center justify-center">
                            <span class="text-purple-400 font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 rounded-xl bg-gray-800/30 border border-gray-700/50">
                    <p class="text-sm text-gray-500 text-center">Geen gebruikers gevonden</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white">Recente Betalingen</h3>
                <a href="{{ route('admin.subscriptions.index') }}" class="text-xs text-red-400 hover:text-red-300 font-semibold transition-colors">Bekijk alle →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPayments as $index => $payment)
                <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 animate-slide-in"
                     style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-semibold text-white">{{ $payment->organization->name }}</p>
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $payment->plan === 'pro' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40' : 'bg-gray-700 text-gray-300' }}">
                            {{ ucfirst($payment->plan) }}
                        </span>
                    </div>
                    <p class="text-sm font-bold text-green-400">€{{ number_format($payment->amount, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1 flex items-center space-x-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $payment->paid_at?->diffForHumans() ?? 'N/A' }}</span>
                    </p>
                </div>
                @empty
                <div class="p-4 rounded-xl bg-gray-800/30 border border-gray-700/50">
                    <p class="text-sm text-gray-500 text-center">Geen betalingen gevonden</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

