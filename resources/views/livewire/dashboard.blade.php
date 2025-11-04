<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Dashboard</h1>
                <p class="mt-2 text-gray-400 text-lg">Welkom terug, {{ auth()->user()->name }}!</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Clients -->
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-6 border border-yellow-400/20 hover:border-yellow-400/50 transition-all duration-300 hover:shadow-2xl hover:shadow-yellow-400/10 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400/20 to-yellow-600/10 rounded-xl flex items-center justify-center border border-yellow-400/30 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-gray-400 transition-colors">Totaal Klanten</p>
                            <p class="text-3xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">{{ $stats['total_clients'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Projects -->
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-6 border border-yellow-400/20 hover:border-yellow-400/50 transition-all duration-300 hover:shadow-2xl hover:shadow-yellow-400/10 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400/20 to-yellow-600/10 rounded-xl flex items-center justify-center border border-yellow-400/30 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-gray-400 transition-colors">Actieve Projecten</p>
                            <p class="text-3xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">{{ $stats['active_projects'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Invoices -->
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-6 border border-yellow-400/20 hover:border-yellow-400/50 transition-all duration-300 hover:shadow-2xl hover:shadow-yellow-400/10 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400/20 to-yellow-600/10 rounded-xl flex items-center justify-center border border-yellow-400/30 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-gray-400 transition-colors">Totaal Facturen</p>
                            <p class="text-3xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">{{ $stats['total_invoices'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Invoices -->
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-6 border border-orange-500/20 hover:border-orange-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500/20 to-orange-600/10 rounded-xl flex items-center justify-center border border-orange-500/30 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-gray-400 transition-colors">Openstaande Facturen</p>
                            <p class="text-3xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">{{ $stats['pending_invoices'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Overdue Invoices -->
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-6 border border-red-500/20 hover:border-red-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-red-500/10 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-500/20 to-red-600/10 rounded-xl flex items-center justify-center border border-red-500/30 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-gray-400 transition-colors">Achterstallige Facturen</p>
                            <p class="text-3xl font-bold bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">{{ $stats['overdue_invoices'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-6 border border-emerald-500/20 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 rounded-xl flex items-center justify-center border border-emerald-500/30 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-gray-400 transition-colors">Totale Omzet</p>
                            <p class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">€{{ number_format($stats['total_revenue'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Invoices -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-yellow-400/20 overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-yellow-400/20 bg-gradient-to-r from-yellow-400/10 to-transparent">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Recente Facturen</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($recentInvoices->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentInvoices as $invoice)
                                    <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-gray-700/50 hover:border-yellow-400/30 hover:bg-gray-800/50 transition-all group">
                                        <div>
                                            <p class="text-sm font-semibold text-white">#{{ $invoice->number }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $invoice->client->name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">€{{ number_format($invoice->total, 2) }}</p>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-1
                                                @if($invoice->status === 'paid') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                                @elseif($invoice->status === 'sent') bg-yellow-400/20 text-yellow-400 border border-yellow-400/30
                                                @elseif($invoice->status === 'overdue') bg-red-500/20 text-red-400 border border-red-500/30
                                                @else bg-gray-500/20 text-gray-400 border border-gray-500/30
                                                @endif">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-center py-8">Nog geen facturen aangemaakt</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Clients -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-yellow-400/20 overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-yellow-400/20 bg-gradient-to-r from-yellow-400/10 to-transparent">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Recente Klanten</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($recentClients->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentClients as $client)
                                    <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-gray-700/50 hover:border-yellow-400/30 hover:bg-gray-800/50 transition-all group">
                                        <div>
                                            <p class="text-sm font-semibold text-white">{{ $client->name }}</p>
                                            @if($client->email)
                                                <p class="text-xs text-gray-500 mt-1">{{ $client->email }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500">{{ $client->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-center py-8">Nog geen klanten toegevoegd</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>