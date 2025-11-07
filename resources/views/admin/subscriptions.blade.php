@extends('admin.layout')

@section('title', 'Abonnementen Beheer')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 animate-fade-in">
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-gray-700 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Starter</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-gray-700/20 to-gray-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['total_starter']) }}</p>
        </div>
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-yellow-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Pro</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-yellow-500/20 to-yellow-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">{{ number_format($stats['total_pro']) }}</p>
        </div>
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-green-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Actief</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-green-500/20 to-green-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">{{ number_format($stats['total_active']) }}</p>
        </div>
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-blue-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Maandelijkse Omzet</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">€{{ number_format($stats['monthly_revenue'], 2, ',', '.') }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in" style="animation-delay: 0.1s">
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Plan</label>
                <select name="plan" class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition-all duration-300">
                    <option value="">Alle</option>
                    <option value="starter" {{ request('plan') === 'starter' ? 'selected' : '' }}>Starter</option>
                    <option value="pro" {{ request('plan') === 'pro' ? 'selected' : '' }}>Pro</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition-all duration-300">
                    <option value="">Alle</option>
                    <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>Trial</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actief</option>
                    <option value="past_due" {{ request('status') === 'past_due' ? 'selected' : '' }}>Past Due</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Geblokkeerd</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 rounded-xl font-semibold text-white hover:from-red-600 hover:to-red-700 hover:shadow-xl hover:shadow-red-500/30 transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.414.586V17l-4 4v-6.586a1 1 0 00-.414-.586L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Subscriptions Table -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 overflow-hidden shadow-xl animate-fade-in" style="animation-delay: 0.2s">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-800/80 to-gray-800/50 backdrop-blur-sm">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Organisatie</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Eigenaar</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Plan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Trial</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Aangemaakt</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($organizations as $org)
                    <tr class="hover:bg-gray-800/30 transition-all duration-200 hover:shadow-lg">
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-white">{{ $org->name }}</p>
                            <p class="text-xs text-gray-500">{{ $org->email ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-300">{{ $org->owner->name ?? '—' }}</p>
                            <p class="text-xs text-gray-500">{{ $org->owner->email ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $org->subscription_plan === 'pro' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40' : 'bg-gray-700 text-gray-300' }}">
                                {{ ucfirst($org->subscription_plan ?? '—') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $org->subscription_status === 'active' ? 'bg-green-500/20 text-green-400 border border-green-500/40' : ($org->subscription_status === 'trial' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/40' : 'bg-red-500/20 text-red-400 border border-red-500/40') }}">
                                {{ ucfirst($org->subscription_status ?? '—') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">
                            @if($org->onTrial())
                            {{ $org->trialDaysRemaining() }} dagen
                            @else
                            —
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $org->created_at->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.organizations.show', $org) }}" 
                               class="px-4 py-2 text-xs font-semibold bg-gradient-to-r from-red-500 to-red-600 rounded-lg text-white hover:from-red-600 hover:to-red-700 hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300 transform hover:scale-105">
                                Bekijken
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Geen abonnementen gevonden</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($organizations->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $organizations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

