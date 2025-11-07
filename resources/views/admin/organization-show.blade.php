@extends('admin.layout')

@section('title', $organization->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-2xl font-bold text-white">{{ $organization->name }}</h2>
                <p class="text-sm text-gray-400 mt-1">{{ $organization->email ?? '—' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm rounded-full {{ $organization->status === 'active' ? 'bg-green-500/20 text-green-400 border border-green-500/40' : 'bg-red-500/20 text-red-400 border border-red-500/40' }}">
                    {{ ucfirst($organization->status) }}
                </span>
                @if($organization->subscription_plan)
                <span class="px-3 py-1 text-sm rounded-full {{ $organization->subscription_plan === 'pro' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40' : 'bg-gray-700 text-gray-300' }}">
                    {{ ucfirst($organization->subscription_plan) }}
                </span>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mt-6 pt-6 border-t border-gray-800">
            <h3 class="text-sm font-semibold text-gray-400 mb-3">Snelle Acties</h3>
            <div class="flex flex-wrap gap-3">
                @if($organization->status === 'active')
                <form method="POST" action="{{ route('admin.organizations.suspend', $organization) }}" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Weet je zeker dat je deze organisatie wilt opschorten?')" 
                            class="px-5 py-2.5 bg-red-500/20 text-red-400 border border-red-500/40 rounded-xl hover:bg-red-500/30 hover:border-red-500/60 hover:shadow-lg hover:shadow-red-500/20 transition-all duration-300 transform hover:scale-105 text-sm font-semibold">
                        Opschorten
                    </button>
                </form>
                @else
                <form method="POST" action="{{ route('admin.organizations.activate', $organization) }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-5 py-2.5 bg-green-500/20 text-green-400 border border-green-500/40 rounded-xl hover:bg-green-500/30 hover:border-green-500/60 hover:shadow-lg hover:shadow-green-500/20 transition-all duration-300 transform hover:scale-105 text-sm font-semibold">
                        Activeren
                    </button>
                </form>
                @endif
                
                @if($organization->onTrial())
                <button onclick="document.getElementById('extend-trial-modal').classList.remove('hidden')" 
                        class="px-5 py-2.5 bg-blue-500/20 text-blue-400 border border-blue-500/40 rounded-xl hover:bg-blue-500/30 hover:border-blue-500/60 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 transform hover:scale-105 text-sm font-semibold">
                    Trial Verlengen
                </button>
                @endif
                
                <button onclick="document.getElementById('change-plan-modal').classList.remove('hidden')" 
                        class="px-5 py-2.5 bg-yellow-500/20 text-yellow-400 border border-yellow-500/40 rounded-xl hover:bg-yellow-500/30 hover:border-yellow-500/60 hover:shadow-lg hover:shadow-yellow-500/20 transition-all duration-300 transform hover:scale-105 text-sm font-semibold">
                    Plan Wijzigen
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <div>
                <p class="text-xs text-gray-400 mb-1">BTW Nummer</p>
                <p class="text-sm font-semibold text-white">{{ $organization->vat_number ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Land</p>
                <p class="text-sm font-semibold text-white">{{ $organization->country ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Valuta</p>
                <p class="text-sm font-semibold text-white">{{ $organization->currency ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Aangemaakt</p>
                <p class="text-sm font-semibold text-white">{{ $organization->created_at->format('d-m-Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 animate-fade-in" style="animation-delay: 0.1s">
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-indigo-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Klanten</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-indigo-400 to-indigo-600 bg-clip-text text-transparent">{{ number_format($stats['total_clients']) }}</p>
        </div>
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-pink-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Projecten</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500/20 to-pink-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">{{ number_format($stats['total_projects']) }}</p>
        </div>
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-cyan-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Facturen</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-cyan-400 to-cyan-600 bg-clip-text text-transparent">{{ number_format($stats['total_invoices']) }}</p>
        </div>
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-lg hover:border-green-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-gray-400 text-sm font-semibold">Omzet</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-green-500/20 to-green-600/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">€{{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
        </div>
    </div>

    <!-- Users -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in" style="animation-delay: 0.2s">
        <h3 class="text-lg font-bold text-white mb-6">Gebruikers</h3>
        <div class="space-y-3">
            @forelse($organization->users as $index => $user)
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 animate-slide-in" style="animation-delay: {{ $index * 0.05 }}s">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-lg flex items-center justify-center">
                        <span class="text-purple-400 font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ ucfirst($user->role) }}</p>
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

    <!-- Recent Invoices -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in" style="animation-delay: 0.3s">
        <h3 class="text-lg font-bold text-white mb-6">Recente Facturen</h3>
        <div class="space-y-3">
            @forelse($organization->invoices as $index => $invoice)
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 animate-slide-in" style="animation-delay: {{ $index * 0.05 }}s">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">{{ $invoice->number }}</p>
                        <p class="text-xs text-gray-400 mt-1">€{{ number_format($invoice->total, 2, ',', '.') }} - {{ ucfirst($invoice->status) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $invoice->created_at->format('d-m-Y') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $invoice->status === 'paid' ? 'bg-green-500/20 text-green-400 border border-green-500/40' : ($invoice->status === 'sent' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/40' : 'bg-gray-700 text-gray-300') }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="p-4 rounded-xl bg-gray-800/30 border border-gray-700/50">
                <p class="text-sm text-gray-500 text-center">Geen facturen gevonden</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Payments -->
    @if($organization->subscriptionPayments->count() > 0)
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in" style="animation-delay: 0.4s">
        <h3 class="text-lg font-bold text-white mb-6">Recente Betalingen</h3>
        <div class="space-y-3">
            @forelse($organization->subscriptionPayments as $index => $payment)
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 animate-slide-in" style="animation-delay: {{ $index * 0.05 }}s">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-semibold text-white">{{ ucfirst($payment->plan) }} - {{ $payment->interval_months }} maanden</p>
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $payment->plan === 'pro' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40' : 'bg-gray-700 text-gray-300' }}">
                        {{ ucfirst($payment->plan) }}
                    </span>
                </div>
                <p class="text-sm font-bold text-green-400">€{{ number_format($payment->amount, 2, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $payment->paid_at?->format('d-m-Y') ?? '—' }}</p>
            </div>
            @empty
            <div class="p-4 rounded-xl bg-gray-800/30 border border-gray-700/50">
                <p class="text-sm text-gray-500 text-center">Geen betalingen gevonden</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif
</div>

<!-- Extend Trial Modal -->
<div id="extend-trial-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center modal-backdrop" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="modal-content bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-2xl border border-gray-800/50 p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-xl font-bold text-white mb-4">Trial Verlengen</h3>
        <form method="POST" action="{{ route('admin.organizations.extend-trial', $organization) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-400 mb-2">Aantal dagen</label>
                <input type="number" name="days" min="1" max="365" value="7" required
                       class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300">
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="document.getElementById('extend-trial-modal').classList.add('hidden')"
                        class="px-5 py-2.5 bg-gray-800 text-gray-300 rounded-xl hover:bg-gray-700 hover:shadow-lg transition-all duration-300 transform hover:scale-105 font-semibold">
                    Annuleren
                </button>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl text-white font-semibold hover:from-blue-600 hover:to-blue-700 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:scale-105">
                    Verlengen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Change Plan Modal -->
<div id="change-plan-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center modal-backdrop" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="modal-content bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-2xl border border-gray-800/50 p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-xl font-bold text-white mb-4">Plan Wijzigen</h3>
        <form method="POST" action="{{ route('admin.organizations.change-plan', $organization) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-400 mb-2">Plan</label>
                <select name="plan" required
                        class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300">
                    <option value="starter" {{ $organization->subscription_plan === 'starter' ? 'selected' : '' }}>Starter</option>
                    <option value="pro" {{ $organization->subscription_plan === 'pro' ? 'selected' : '' }}>Pro</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-400 mb-2">Status</label>
                <select name="status"
                        class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300">
                    <option value="trial" {{ $organization->subscription_status === 'trial' ? 'selected' : '' }}>Trial</option>
                    <option value="active" {{ $organization->subscription_status === 'active' ? 'selected' : '' }}>Actief</option>
                    <option value="past_due" {{ $organization->subscription_status === 'past_due' ? 'selected' : '' }}>Past Due</option>
                    <option value="suspended" {{ $organization->subscription_status === 'suspended' ? 'selected' : '' }}>Geblokkeerd</option>
                </select>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="document.getElementById('change-plan-modal').classList.add('hidden')"
                        class="px-5 py-2.5 bg-gray-800 text-gray-300 rounded-xl hover:bg-gray-700 hover:shadow-lg transition-all duration-300 transform hover:scale-105 font-semibold">
                    Annuleren
                </button>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl text-white font-semibold hover:from-yellow-600 hover:to-yellow-700 hover:shadow-xl hover:shadow-yellow-500/30 transition-all duration-300 transform hover:scale-105">
                    Wijzigen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

