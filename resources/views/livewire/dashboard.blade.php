<div>
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Date Range Filter Bar -->
            <div class="mb-6 bg-gradient-to-r from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl p-4 border border-yellow-400/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-300">Periode:</span>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-2">
                        <button wire:click="$set('dateRange', 'today'); updateDateRange()" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $dateRange === 'today' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                            Vandaag
                        </button>
                        <button wire:click="$set('dateRange', 'week'); updateDateRange()" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $dateRange === 'week' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                            Week
                        </button>
                        <button wire:click="$set('dateRange', 'month'); updateDateRange()" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $dateRange === 'month' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                            Maand
                        </button>
                        <button wire:click="$set('dateRange', 'quarter'); updateDateRange()" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $dateRange === 'quarter' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                            Kwartaal
                        </button>
                        <button wire:click="$set('dateRange', 'year'); updateDateRange()" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $dateRange === 'year' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                            Jaar
                        </button>
                        <button wire:click="$set('dateRange', 'all'); updateDateRange()" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $dateRange === 'all' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                            Alles
                        </button>
                        
                        @if($startDate && $endDate)
                            <div class="flex items-center px-3 py-2 bg-gray-800/50 rounded-lg border border-gray-700">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <button onclick="toggleKeyboardShortcuts()" 
                            class="flex items-center px-3 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-xs font-medium text-gray-400 hover:text-yellow-400 transition-all">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Shortcuts (?)
                    </button>
                </div>
            </div>

            <!-- Trial Banner -->
            @if(auth()->user()->organization->onTrial())
            <div class="mb-6 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-blue-500/10 rounded-xl border border-blue-500/30 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">🎁 Je trial loopt over {{ auth()->user()->organization->trialDaysRemaining() }} dagen af</h3>
                            <p class="text-sm text-gray-400">Upgrade nu en behoud toegang tot al je gegevens zonder onderbreking</p>
                        </div>
                    </div>
                    <a href="{{ route('app.subscription.index') }}" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all whitespace-nowrap">
                        Upgrade Nu
                    </a>
                </div>
            </div>
            @endif

            <!-- Header with Quick Actions -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-yellow-200 to-yellow-400 bg-clip-text text-transparent animate-gradient">
                        Dashboard
                    </h1>
                    <p class="mt-2 text-gray-400 text-lg flex items-center">
                        <span class="mr-2">👋</span>
                        Welkom terug, <span class="text-yellow-400 ml-1 font-semibold">{{ auth()->user()->name }}</span>!
                    </p>
                </div>
                
                <!-- Quick Actions -->
                <div class="mt-4 lg:mt-0 flex flex-wrap gap-3">
                    <a href="{{ route('app.invoices.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900 rounded-xl font-semibold text-sm shadow-lg hover:shadow-yellow-400/50 transform hover:scale-105 transition-all duration-300 {{ !auth()->user()->organization->canCreateInvoice() ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nieuwe Factuur
                        @if(!auth()->user()->organization->isPro())
                        <span class="ml-2 text-xs opacity-70">({{ auth()->user()->organization->getInvoicesRemaining() > 0 ? auth()->user()->organization->getInvoicesRemaining() : 0 }}/{{ auth()->user()->organization->limit_invoices_per_month }})</span>
                        @endif
                    </a>
                    <a href="{{ route('app.clients.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-800 text-yellow-400 border border-yellow-400/30 rounded-xl font-semibold text-sm hover:bg-gray-700 transform hover:scale-105 transition-all duration-300 {{ !auth()->user()->organization->canCreateClient() ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Nieuwe Klant
                        @if(!auth()->user()->organization->isPro())
                        <span class="ml-2 text-xs opacity-70">({{ auth()->user()->organization->getClientsRemaining() > 0 ? auth()->user()->organization->getClientsRemaining() : 0 }}/{{ auth()->user()->organization->limit_clients }})</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- BTW Deadline Alerts -->
            @if(isset($btwDeadlines) && count($btwDeadlines) > 0)
            @php
                $urgentDeadlines = collect($btwDeadlines)->filter(fn($d) => $d['is_urgent'] || $d['is_overdue']);
            @endphp
            @if($urgentDeadlines->count() > 0)
            <div class="mb-8 bg-gradient-to-r from-red-500/10 via-orange-500/10 to-red-500/10 rounded-xl border border-red-500/30 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        BTW Deadline Waarschuwing
                    </h3>
                    <a href="{{ route('app.btw.index') }}" class="text-sm text-yellow-400 hover:text-yellow-300 font-semibold">
                        Ga naar BTW →
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-{{ min($urgentDeadlines->count(), 4) }} gap-3">
                    @foreach($urgentDeadlines->take(4) as $deadline)
                    <div class="bg-gray-900/50 rounded-lg p-4 border {{ $deadline['is_overdue'] ? 'border-red-500/50' : 'border-orange-500/50' }}">
                        <p class="text-sm font-bold text-white mb-1">{{ $deadline['period'] }}</p>
                        <p class="text-xs text-gray-400 mb-2">{{ $deadline['deadline']->format('d M Y') }}</p>
                        @if($deadline['is_overdue'])
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-500/20 text-red-400">
                                Achterstallig!
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-orange-500/20 text-orange-400">
                                Over {{ $deadline['days_until'] }} dagen
                            </span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <!-- Usage Limits (Starter only) -->
            @if(!auth()->user()->organization->isPro())
            <div class="mb-6 bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Gebruik dit maand</h3>
                    <a href="{{ route('app.subscription.index') }}" class="text-sm text-yellow-400 hover:text-yellow-300 font-semibold">Upgrade voor unlimited →</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Invoices -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-400">Facturen</span>
                            <span class="text-white font-semibold">{{ auth()->user()->organization->usage_invoices_this_month }}/{{ auth()->user()->organization->limit_invoices_per_month }}</span>
                        </div>
                        <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-600 transition-all" style="width: {{ min(100, auth()->user()->organization->getUsagePercentage('invoices')) }}%"></div>
                        </div>
                        @if(auth()->user()->organization->getInvoicesRemaining() <= 3)
                        <p class="text-xs text-orange-400 mt-1">Nog {{ auth()->user()->organization->getInvoicesRemaining() }} over</p>
                        @endif
                    </div>
                    <!-- Clients -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-400">Klanten</span>
                            <span class="text-white font-semibold">{{ auth()->user()->organization->clients()->count() }}/{{ auth()->user()->organization->limit_clients }}</span>
                        </div>
                        <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 transition-all" style="width: {{ min(100, auth()->user()->organization->getUsagePercentage('clients')) }}%"></div>
                        </div>
                        @if(auth()->user()->organization->getClientsRemaining() <= 5)
                        <p class="text-xs text-orange-400 mt-1">Nog {{ auth()->user()->organization->getClientsRemaining() }} over</p>
                        @endif
                    </div>
                    <!-- Projects -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-400">Actieve Projecten</span>
                            <span class="text-white font-semibold">{{ auth()->user()->organization->projects()->where('status', 'active')->count() }}/{{ auth()->user()->organization->limit_active_projects }}</span>
                        </div>
                        <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 transition-all" style="width: {{ min(100, auth()->user()->organization->getUsagePercentage('projects')) }}%"></div>
                        </div>
                        @if(auth()->user()->organization->getProjectsRemaining() <= 2)
                        <p class="text-xs text-orange-400 mt-1">Nog {{ auth()->user()->organization->getProjectsRemaining() }} over</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Stats Grid with Growth Indicators -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <!-- Total Clients -->
                <div class="group relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl p-4 border border-yellow-400/20 hover:border-yellow-400/40 transition-all duration-300 hover:shadow-lg hover:shadow-yellow-400/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400/20 to-yellow-600/10 rounded-lg flex items-center justify-center border border-yellow-400/30 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            @if($growth['clients'] != 0)
                                <div class="flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $growth['clients'] > 0 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                    {{ $growth['clients'] > 0 ? '↑' : '↓' }} {{ number_format(abs($growth['clients']), 0) }}%
                                </div>
                            @endif
                        </div>
                        
                        <p class="text-xs font-medium text-gray-400 mb-1">Totaal Klanten</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent counting-number" data-target="{{ $stats['total_clients'] }}">
                            0
                        </p>
                    </div>
                </div>

                <!-- Active Projects -->
                <div class="group relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl p-4 border border-blue-400/20 hover:border-blue-400/40 transition-all duration-300 hover:shadow-lg hover:shadow-blue-400/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-600/10 rounded-lg flex items-center justify-center border border-blue-400/30 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <p class="text-xs font-medium text-gray-400 mb-1">Actieve Projecten</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent counting-number" data-target="{{ $stats['active_projects'] }}">
                            0
                        </p>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="group relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl p-4 border border-emerald-400/20 hover:border-emerald-400/40 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-400/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400/20 to-emerald-600/10 rounded-lg flex items-center justify-center border border-emerald-400/30 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            @if($growth['revenue'] != 0)
                                <div class="flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $growth['revenue'] > 0 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                    {{ $growth['revenue'] > 0 ? '↑' : '↓' }} {{ number_format(abs($growth['revenue']), 0) }}%
                                </div>
                            @endif
                        </div>
                        
                        <p class="text-xs font-medium text-gray-400 mb-1">Totale Omzet</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">
                            €<span class="counting-number" data-target="{{ $stats['total_revenue'] }}">0</span>
                        </p>
                    </div>
                </div>

                <!-- Outstanding Balance -->
                <div class="group relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl p-4 border border-orange-400/20 hover:border-orange-400/40 transition-all duration-300 hover:shadow-lg hover:shadow-orange-400/10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-400/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400/20 to-orange-600/10 rounded-lg flex items-center justify-center border border-orange-400/30 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <p class="text-xs font-medium text-gray-400 mb-1">Openstaand Saldo</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                            €<span class="counting-number" data-target="{{ $insights['outstanding_balance'] }}">0</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['pending_invoices'] + $stats['overdue_invoices'] }} openstaand</p>
                    </div>
                </div>
            </div>

            <!-- Smart Alerts & Top Performers Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Smart Alerts Card -->
                <div class="bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl border border-red-400/20 overflow-hidden shadow-xl">
                    <div class="px-5 py-3 border-b border-red-400/10 bg-gradient-to-r from-red-400/5 to-transparent">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-white">Slimme Alerts</h3>
                            </div>
                            @if($upcomingDue->count() + $overdueInvoices->count() > 0)
                                <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-bold animate-pulse">
                                    {{ $upcomingDue->count() + $overdueInvoices->count() }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-5 max-h-[400px] overflow-y-auto custom-scrollbar">
                        @if($overdueInvoices->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-xs font-bold text-red-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-.834-1.964-.834-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Achterstallig ({{ $overdueInvoices->count() }})
                                </h4>
                                @foreach($overdueInvoices as $invoice)
                                    <div class="flex items-center justify-between p-3 bg-red-500/5 border border-red-500/20 rounded-lg mb-2 hover:bg-red-500/10 transition-all">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-white">#{{ $invoice->number }}</p>
                                            <p class="text-xs text-gray-500">{{ $invoice->client->name }}</p>
                                            <p class="text-xs text-red-400 mt-1">{{ $invoice->due_date->diffForHumans() }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-red-400">€{{ number_format($invoice->total, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        @if($upcomingDue->count() > 0)
                            <div>
                                <h4 class="text-xs font-bold text-orange-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Vervalt Binnenkort ({{ $upcomingDue->count() }})
                                </h4>
                                @foreach($upcomingDue as $invoice)
                                    <div class="flex items-center justify-between p-3 bg-orange-500/5 border border-orange-500/20 rounded-lg mb-2 hover:bg-orange-500/10 transition-all">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-white">#{{ $invoice->number }}</p>
                                            <p class="text-xs text-gray-500">{{ $invoice->client->name }}</p>
                                            <p class="text-xs text-orange-400 mt-1">Vervalt {{ $invoice->due_date->diffForHumans() }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-orange-400">€{{ number_format($invoice->total, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        @if($upcomingDue->count() === 0 && $overdueInvoices->count() === 0)
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-emerald-400 font-semibold">Alles up-to-date!</p>
                                <p class="text-gray-500 text-xs mt-1">Geen openstaande of achterstallige facturen</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Top Performers Widget -->
                <div class="bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-xl border border-yellow-400/20 overflow-hidden shadow-xl">
                    <div class="px-5 py-3 border-b border-yellow-400/10 bg-gradient-to-r from-yellow-400/5 to-transparent">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">Top Performers</h3>
                        </div>
                    </div>
                    <div class="p-5 max-h-[400px] overflow-y-auto custom-scrollbar">
                        @if($topClients->count() > 0)
                            <div class="space-y-2">
                                @foreach($topClients as $index => $client)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-800/30 rounded-lg border border-gray-700/50 hover:border-yellow-400/30 transition-all group">
                                        <div class="flex-shrink-0">
                                            @php
                                                $medalClass = match($index) {
                                                    0 => 'bg-gradient-to-br from-yellow-400 to-yellow-600 text-gray-900',
                                                    1 => 'bg-gradient-to-br from-gray-300 to-gray-400 text-gray-900',
                                                    2 => 'bg-gradient-to-br from-orange-400 to-orange-600 text-gray-900',
                                                    default => 'bg-gray-700 text-gray-400'
                                                };
                                            @endphp
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm {{ $medalClass }}">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-white truncate">{{ $client->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $client->invoices_count }} facturen</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-yellow-400">€{{ number_format($client->invoices_sum_total, 0) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                <p class="text-gray-400 text-sm">Nog geen data</p>
                                <p class="text-gray-600 text-xs mt-1">Start met facturen maken</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-yellow-400/20 overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-yellow-400/10 bg-gradient-to-r from-yellow-400/5 to-transparent">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Omzet Ontwikkeling</h3>
                            </div>
                            <span class="text-xs text-gray-400">Laatste 6 maanden</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="revenueChart" class="w-full" height="250"></canvas>
                    </div>
                </div>

                <!-- Invoice Status Chart -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-yellow-400/20 overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-yellow-400/10 bg-gradient-to-r from-yellow-400/5 to-transparent">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Factuur Status</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 flex items-center justify-center">
                        <canvas id="invoiceStatusChart" class="max-w-xs" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Activity and Recent Data -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity Timeline -->
                <div class="lg:col-span-2 bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-yellow-400/20 overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-yellow-400/10 bg-gradient-to-r from-yellow-400/5 to-transparent">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Recente Activiteit</h3>
                        </div>
                    </div>
                    <div class="p-6 max-h-[500px] overflow-y-auto custom-scrollbar">
                        @if($recentActivities->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-4 p-4 bg-gray-800/30 rounded-xl border border-gray-700/50 hover:border-yellow-400/30 hover:bg-gray-800/50 transition-all group">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                @if($activity['icon'] === 'invoice') bg-yellow-400/10 border border-yellow-400/30
                                                @else bg-blue-400/10 border border-blue-400/30
                                                @endif">
                                                @if($activity['icon'] === 'invoice')
                                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-white">{{ $activity['title'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $activity['description'] }}</p>
                                            @if(isset($activity['amount']))
                                                <p class="text-xs font-bold text-yellow-400 mt-1">€{{ number_format($activity['amount'], 2) }}</p>
                                            @endif
                                            <p class="text-xs text-gray-600 mt-2">{{ $activity['created_at']->diffForHumans() }}</p>
                                        </div>
                                        @if(isset($activity['status']))
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium
                                                    @if($activity['status'] === 'paid') bg-emerald-500/10 text-emerald-400 border border-emerald-500/30
                                                    @elseif($activity['status'] === 'sent') bg-orange-500/10 text-orange-400 border border-orange-500/30
                                                    @else bg-gray-500/10 text-gray-400 border border-gray-500/30
                                                    @endif">
                                                    {{ ucfirst($activity['status']) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-400">Geen recente activiteit</p>
                                <p class="text-gray-600 text-sm mt-2">Begin met het toevoegen van klanten en facturen</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Clients Card -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-yellow-400/20 overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-yellow-400/10 bg-gradient-to-r from-yellow-400/5 to-transparent">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Nieuwste Klanten</h3>
                            </div>
                            <a href="{{ route('app.clients.index') }}" class="text-xs text-yellow-400 hover:text-yellow-300 font-medium">
                                Alles →
                            </a>
                        </div>
                    </div>
                    <div class="p-6 max-h-[500px] overflow-y-auto custom-scrollbar">
                        @if($recentClients->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentClients as $client)
                                    <a href="{{ route('app.clients.show', $client) }}" 
                                       class="block p-4 bg-gray-800/30 rounded-xl border border-gray-700/50 hover:border-yellow-400/30 hover:bg-gray-800/50 transition-all group">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400/20 to-yellow-600/10 rounded-full flex items-center justify-center border border-yellow-400/30">
                                                <span class="text-sm font-bold text-yellow-400">
                                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-white truncate">{{ $client->name }}</p>
                                                @if($client->email)
                                                    <p class="text-xs text-gray-500 truncate">{{ $client->email }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-400 text-sm">Nog geen klanten</p>
                                <a href="{{ route('app.clients.create') }}" class="text-yellow-400 text-xs hover:text-yellow-300 mt-2 inline-block">
                                    Voeg eerste klant toe →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button (FAB) -->
    <div class="fixed bottom-8 right-8 z-50" x-data="{ open: false }">
        <!-- Quick Actions Menu -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             @click.away="open = false"
             class="absolute bottom-20 right-0 w-64 bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-yellow-400/30 shadow-2xl overflow-hidden">
            <div class="p-2">
                <a href="{{ route('app.invoices.create') }}" 
                   class="flex items-center px-4 py-3 hover:bg-yellow-400/10 rounded-xl transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400/20 to-yellow-600/10 rounded-lg flex items-center justify-center border border-yellow-400/30 mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Nieuwe Factuur</p>
                        <p class="text-xs text-gray-500">Ctrl + I</p>
                    </div>
                </a>
                
                <a href="{{ route('app.clients.create') }}" 
                   class="flex items-center px-4 py-3 hover:bg-blue-400/10 rounded-xl transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-600/10 rounded-lg flex items-center justify-center border border-blue-400/30 mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Nieuwe Klant</p>
                        <p class="text-xs text-gray-500">Ctrl + K</p>
                    </div>
                </a>
                
                <a href="{{ route('app.projects.create') }}" 
                   class="flex items-center px-4 py-3 hover:bg-purple-400/10 rounded-xl transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400/20 to-purple-600/10 rounded-lg flex items-center justify-center border border-purple-400/30 mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Nieuw Project</p>
                        <p class="text-xs text-gray-500">Ctrl + P</p>
                    </div>
                </a>
                
                <a href="{{ route('app.invoices.index') }}" 
                   class="flex items-center px-4 py-3 hover:bg-green-400/10 rounded-xl transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-400/20 to-green-600/10 rounded-lg flex items-center justify-center border border-green-400/30 mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Facturen Bekijken</p>
                        <p class="text-xs text-gray-500">Ctrl + F</p>
                    </div>
                </a>
                
                <button onclick="window.location.reload()" 
                        class="w-full flex items-center px-4 py-3 hover:bg-gray-400/10 rounded-xl transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-400/20 to-gray-600/10 rounded-lg flex items-center justify-center border border-gray-400/30 mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Vernieuwen</p>
                        <p class="text-xs text-gray-500">Ctrl + R</p>
                    </div>
                </button>
            </div>
        </div>
        
        <!-- Main FAB Button -->
        <button @click="open = !open" 
                class="group relative w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full shadow-2xl hover:shadow-yellow-400/50 transition-all duration-300 hover:scale-110 flex items-center justify-center">
            <svg x-show="!open" class="w-8 h-8 text-gray-900 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <svg x-show="open" class="w-8 h-8 text-gray-900 transition-transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            
            <!-- Pulse animation -->
            <span class="absolute inset-0 rounded-full bg-yellow-400 animate-ping opacity-20"></span>
        </button>
    </div>

    <!-- Keyboard Shortcuts Overlay -->
    <div id="keyboardShortcuts" 
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[100] hidden items-center justify-center p-4"
         onclick="toggleKeyboardShortcuts()">
        <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border-2 border-yellow-400/30 shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto"
             onclick="event.stopPropagation()">
            <div class="sticky top-0 bg-gradient-to-r from-yellow-400/10 to-transparent border-b border-yellow-400/20 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Keyboard Shortcuts
                    </h3>
                    <button onclick="toggleKeyboardShortcuts()" 
                            class="w-8 h-8 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Navigation -->
                <div>
                    <h4 class="text-sm font-bold text-yellow-400 uppercase tracking-wider mb-3">Navigatie</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Dashboard</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + D</kbd>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Facturen</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + F</kbd>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Klanten</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + L</kbd>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div>
                    <h4 class="text-sm font-bold text-yellow-400 uppercase tracking-wider mb-3">Snelle Acties</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Nieuwe Factuur</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + I</kbd>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Nieuwe Klant</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + K</kbd>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Nieuw Project</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + P</kbd>
                        </div>
                    </div>
                </div>
                
                <!-- General -->
                <div>
                    <h4 class="text-sm font-bold text-yellow-400 uppercase tracking-wider mb-3">Algemeen</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Zoeken</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + /</kbd>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Vernieuwen</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">Ctrl + R</kbd>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-lg">
                            <span class="text-gray-300">Shortcuts Tonen</span>
                            <kbd class="px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg text-sm font-mono text-yellow-400">?</kbd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animations & Chart Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counting Number Animation
            const countingNumbers = document.querySelectorAll('.counting-number');
            countingNumbers.forEach(el => {
                const target = parseInt(el.getAttribute('data-target'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        el.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        el.textContent = Math.floor(current).toLocaleString();
                    }
                }, 16);
            });

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                const revenueData = @json($revenueByMonth);
                const labels = Object.keys(revenueData).map(month => {
                    const date = new Date(month + '-01');
                    return date.toLocaleDateString('nl-NL', { month: 'short', year: '2-digit' });
                });
                const data = Object.values(revenueData);

                // gradient fill
                const ctx = revenueCtx.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 260);
                gradient.addColorStop(0, 'rgba(212, 175, 55, 0.35)');
                gradient.addColorStop(1, 'rgba(212, 175, 55, 0.02)');

                // average line plugin
                const avg = data.length ? data.reduce((a,b)=>a+b,0) / data.length : 0;
                const avgLine = {
                    id: 'avgLine',
                    afterDatasetsDraw(chart, args, pluginOptions) {
                        const {ctx, chartArea:{left, right}, scales:{y}} = chart;
                        const yPos = y.getPixelForValue(avg);
                        ctx.save();
                        ctx.strokeStyle = 'rgba(212, 175, 55, 0.35)';
                        ctx.setLineDash([6,6]);
                        ctx.beginPath();
                        ctx.moveTo(left, yPos);
                        ctx.lineTo(right, yPos);
                        ctx.stroke();
                        ctx.setLineDash([]);
                        ctx.fillStyle = '#9ca3af';
                        ctx.font = '12px Inter, ui-sans-serif';
                        ctx.fillText('Gemiddelde: ' + avg.toLocaleString('nl-NL', { style:'currency', currency:'EUR', maximumFractionDigits:0 }).replace('EUR', '€'), left + 8, yPos - 6);
                        ctx.restore();
                    }
                };

                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Omzet (€)',
                            data: data,
                            borderColor: 'rgb(212, 175, 55)',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(212, 175, 55)',
                            pointBorderColor: '#1a1a1a',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1a1a1a',
                                titleColor: '#d4af37',
                                bodyColor: '#ffffff',
                                borderColor: '#d4af37',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return '€' + context.parsed.y.toLocaleString('nl-NL', {minimumFractionDigits: 2});
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(212, 175, 55, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    callback: function(value) {
                                        return '€' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#9ca3af'
                                }
                            }
                        }
                    },
                    plugins: [avgLine]
                });
            }

            // Invoice Status Chart
            const statusCtx = document.getElementById('invoiceStatusChart');
            if (statusCtx) {
                const statusData = @json($invoiceStatusBreakdown);
                
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(statusData).map(key => {
                            const labels = {
                                'draft': 'Concept',
                                'sent': 'Verzonden',
                                'paid': 'Betaald',
                                'overdue': 'Achterstallig'
                            };
                            return labels[key] || key;
                        }),
                        datasets: [{
                            data: Object.values(statusData),
                            backgroundColor: [
                                'rgba(156, 163, 175, 0.8)',
                                'rgba(251, 146, 60, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(239, 68, 68, 0.8)'
                            ],
                            borderColor: [
                                'rgb(156, 163, 175)',
                                'rgb(251, 146, 60)',
                                'rgb(16, 185, 129)',
                                'rgb(239, 68, 68)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#9ca3af',
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1a1a1a',
                                titleColor: '#d4af37',
                                bodyColor: '#ffffff',
                                borderColor: '#d4af37',
                                borderWidth: 1,
                                padding: 12
                            }
                        }
                    }
                });
            }
            
            // Keyboard Shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + I - New Invoice
                if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
                    e.preventDefault();
                    window.location.href = '{{ route('app.invoices.create') }}';
                }
                
                // Ctrl/Cmd + K - New Client
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    window.location.href = '{{ route('app.clients.create') }}';
                }
                
                // Ctrl/Cmd + P - New Project
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.location.href = '{{ route('app.projects.create') }}';
                }
                
                // Ctrl/Cmd + F - View Invoices
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    window.location.href = '{{ route('app.invoices.index') }}';
                }
                
                // Ctrl/Cmd + L - View Clients
                if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
                    e.preventDefault();
                    window.location.href = '{{ route('app.clients.index') }}';
                }
                
                // Ctrl/Cmd + D - Dashboard
                if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                    e.preventDefault();
                    window.location.href = '{{ route('app.dashboard') }}';
                }
                
                // ? - Show keyboard shortcuts
                if (e.key === '?' && !e.ctrlKey && !e.metaKey) {
                    e.preventDefault();
                    toggleKeyboardShortcuts();
                }
                
                // Escape - Close shortcuts overlay
                if (e.key === 'Escape') {
                    const shortcuts = document.getElementById('keyboardShortcuts');
                    if (shortcuts && shortcuts.classList.contains('flex')) {
                        toggleKeyboardShortcuts();
                    }
                }
            });
        });
        
        // Toggle keyboard shortcuts overlay
        function toggleKeyboardShortcuts() {
            const overlay = document.getElementById('keyboardShortcuts');
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                document.body.style.overflow = 'hidden';
            } else {
                overlay.classList.remove('flex');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    </script>

    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-gradient {
            background-size: 200% auto;
            animation: gradient 3s ease infinite;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(26, 26, 26, 0.5);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.3);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 175, 55, 0.5);
        }
    </style>
</div>
