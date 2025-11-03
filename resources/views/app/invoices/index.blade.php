<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-5xl font-bold bg-gradient-to-r from-white via-yellow-200 to-yellow-400 bg-clip-text text-transparent mb-2 tracking-tight drop-shadow-lg">Facturen</h1>
                        <p class="text-gray-400 text-lg font-sans opacity-90">Beheer je facturen en betalingen</p>
                    </div>
                    <a href="{{ route('app.invoices.create') }}" 
                       class="group relative px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-2xl shadow-yellow-400/40 hover:shadow-yellow-400/60 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 flex items-center gap-3 ring-2 ring-yellow-400/20 hover:ring-yellow-400/40">
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Nieuwe Factuur</span>
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Totaal Card -->
                <div class="relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-2xl border border-yellow-400/30 p-6 hover:border-yellow-400/60 hover:shadow-2xl hover:shadow-yellow-400/20 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 group">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-800/60 rounded-xl flex items-center justify-center border border-yellow-400/40 flex-shrink-0 group-hover:border-yellow-400/60 group-hover:bg-yellow-400/10 transition-all duration-300 group-hover:scale-110">
                            <svg class="w-8 h-8 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-1 opacity-80 group-hover:opacity-100 transition-opacity duration-300">Totaal</p>
                            <p class="text-3xl font-bold text-yellow-400 group-hover:text-yellow-300 transition-colors duration-300">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Betaald Card -->
                <div class="relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-2xl border border-green-500/30 p-6 hover:border-green-500/60 hover:shadow-2xl hover:shadow-green-500/20 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 group">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-800/60 rounded-xl flex items-center justify-center border border-green-500/40 flex-shrink-0 group-hover:border-green-500/60 group-hover:bg-green-500/10 transition-all duration-300 group-hover:scale-110">
                            <svg class="w-8 h-8 text-green-400 group-hover:text-green-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-1 opacity-80 group-hover:opacity-100 transition-opacity duration-300">Betaald</p>
                            <p class="text-3xl font-bold text-green-400 group-hover:text-green-300 transition-colors duration-300">{{ $stats['paid'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Openstaand Card -->
                <div class="relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-2xl border border-yellow-400/30 p-6 hover:border-yellow-400/60 hover:shadow-2xl hover:shadow-yellow-400/20 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 group">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-800/60 rounded-xl flex items-center justify-center border border-yellow-400/40 flex-shrink-0 group-hover:border-yellow-400/60 group-hover:bg-yellow-400/10 transition-all duration-300 group-hover:scale-110">
                            <svg class="w-8 h-8 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-1 opacity-80 group-hover:opacity-100 transition-opacity duration-300">Openstaand</p>
                            <p class="text-3xl font-bold text-yellow-400 group-hover:text-yellow-300 transition-colors duration-300">{{ $stats['sent'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Achterstallig Card -->
                <div class="relative bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-2xl border border-red-500/30 p-6 hover:border-red-500/60 hover:shadow-2xl hover:shadow-red-500/20 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 group">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-800/60 rounded-xl flex items-center justify-center border border-red-500/40 flex-shrink-0 group-hover:border-red-500/60 group-hover:bg-red-500/10 transition-all duration-300 group-hover:scale-110">
                            <svg class="w-8 h-8 text-red-400 group-hover:text-red-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-1 opacity-80 group-hover:opacity-100 transition-opacity duration-300">Achterstallig</p>
                            <p class="text-3xl font-bold text-red-400 group-hover:text-red-300 transition-colors duration-300">{{ $stats['overdue'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search Card -->
            <div class="bg-gradient-to-br from-gray-900/70 to-gray-950/70 backdrop-blur-sm rounded-2xl border border-gray-800/30 p-6 mb-6 hover:border-gray-700/50 transition-all duration-300">
                <form method="GET" action="{{ route('app.invoices.index') }}" class="flex flex-col sm:flex-row gap-4 items-center">
                    <select name="status" onchange="this.form.submit()" class="flex-1 sm:flex-none w-full sm:w-auto px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all duration-150">
                        <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>Alle statussen</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Concept</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Verzonden</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Betaald</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Achterstallig</option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoek facturen..." 
                           class="flex-1 w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all duration-150">
                    <button type="submit" class="px-6 py-3 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-xl hover:bg-yellow-400/20 transition-all duration-150 font-semibold">
                        Zoeken
                    </button>
                    @if(request('status') || request('search'))
                    <a href="{{ route('app.invoices.index') }}" class="px-6 py-3 bg-gray-800/50 text-gray-300 border border-gray-700 rounded-xl hover:bg-gray-800 transition-all duration-150 font-semibold">
                        Reset
                    </a>
                    @endif
                    <div class="flex items-center bg-gray-800/50 rounded-xl p-1 border border-gray-700">
                        <button type="button" onclick="showTableView()" id="tableViewBtn" class="px-4 py-2 bg-gray-900/50 text-yellow-400 rounded-lg transition-all duration-150 hover:bg-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="showCardView()" id="cardViewBtn" class="px-4 py-2 text-gray-500 rounded-lg hover:bg-gray-900 transition-all duration-150">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Invoices Table Card -->
            <div id="tableView" class="bg-gradient-to-br from-gray-900/70 to-gray-950/70 backdrop-blur-sm rounded-2xl border border-gray-800/30 overflow-hidden shadow-2xl hover:border-gray-700/50 transition-all duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/20 border-b border-gray-800/30 backdrop-blur-sm">
                            <tr>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Factuur</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Klant</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Datum</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Bedrag</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/30">
                            @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-800/30 hover:bg-gradient-to-r hover:from-yellow-400/5 hover:to-transparent transition-all duration-300 border-l-4 border-transparent hover:border-yellow-400/50 hover:shadow-lg hover:shadow-yellow-400/5">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-gray-900 font-bold text-sm mr-4 shadow-lg shadow-yellow-400/30 group-hover:shadow-yellow-400/50 group-hover:scale-110 transition-all duration-300">
                                            #
                                        </div>
                                        <div>
                                            <p class="font-bold text-white text-base">{{ $invoice->number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-gray-300 font-medium group-hover:text-white transition-colors duration-300">{{ $invoice->client->name ?? 'Onbekend' }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">{{ $invoice->issue_date->format('d M Y') }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-xl font-bold text-yellow-400 group-hover:text-yellow-300 drop-shadow-lg transition-all duration-300">€{{ number_format($invoice->total, 2) }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    @if($invoice->status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1.5 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></span>
                                        Betaald
                                    </span>
                                    @elseif($invoice->status === 'sent')
                                    <span class="inline-flex items-center px-3 py-1.5 bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                        Verzonden
                                    </span>
                                    @elseif($invoice->status === 'overdue')
                                    <span class="inline-flex items-center px-3 py-1.5 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                        Achterstallig
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gray-500/20 text-gray-400 border border-gray-500/30 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                        Concept
                                    </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('app.invoices.pdf', $invoice) }}" 
                                           class="p-2.5 hover:bg-yellow-400/20 hover:scale-110 rounded-lg transition-all duration-300 group opacity-70 hover:opacity-100"
                                           title="Download PDF">
                                            <svg class="w-5 h-5 text-gray-500 group-hover:text-yellow-400 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4M1 20h22"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('app.invoices.show', $invoice) }}" 
                                           class="p-2.5 hover:bg-yellow-400/20 hover:scale-110 rounded-lg transition-all duration-300 group opacity-70 hover:opacity-100"
                                           title="Bekijken">
                                            <svg class="w-5 h-5 text-gray-500 group-hover:text-yellow-400 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('app.invoices.edit', $invoice) }}" 
                                           class="p-2.5 hover:bg-yellow-400/20 hover:scale-110 rounded-lg transition-all duration-300 group opacity-70 hover:opacity-100"
                                           title="Bewerken">
                                            <svg class="w-5 h-5 text-gray-500 group-hover:text-yellow-400 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-gray-800/50 rounded-full flex items-center justify-center mb-6">
                                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-white mb-2">Geen facturen</h3>
                                        <p class="text-gray-400 mb-6">Begin met het aanmaken van je eerste factuur!</p>
                                        <a href="{{ route('app.invoices.create') }}" 
                                           class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                                            Maak je eerste factuur
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($invoices->hasPages())
                <div class="px-8 py-6 border-t border-gray-800/50 bg-gray-800/20">
                    {{ $invoices->links() }}
                </div>
                @endif
            </div>

            <!-- Invoices Cards View -->
            <div id="cardView" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($invoices as $invoice)
                <div class="group bg-gradient-to-br from-gray-900/80 to-gray-950/80 backdrop-blur-sm rounded-2xl border border-gray-800/30 p-6 hover:border-yellow-400/60 hover:shadow-2xl hover:shadow-yellow-400/20 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-gray-900 font-bold text-lg shadow-lg shadow-yellow-400/20">
                            #
                        </div>
                        @if($invoice->status === 'paid')
                        <span class="inline-flex items-center px-3 py-1.5 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-semibold">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></span>
                            Betaald
                        </span>
                        @elseif($invoice->status === 'sent')
                        <span class="inline-flex items-center px-3 py-1.5 bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 rounded-full text-xs font-semibold">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                            Verzonden
                        </span>
                        @elseif($invoice->status === 'overdue')
                        <span class="inline-flex items-center px-3 py-1.5 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-xs font-semibold">
                            <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                            Achterstallig
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1.5 bg-gray-500/20 text-gray-400 border border-gray-500/30 rounded-full text-xs font-semibold">
                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                            Concept
                        </span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">{{ $invoice->number }}</h3>
                    <p class="text-gray-400 mb-6">{{ $invoice->client->name ?? 'Onbekend' }}</p>
                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-800/50">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Datum</p>
                            <p class="text-sm font-medium text-gray-300">{{ $invoice->issue_date->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Bedrag</p>
                            <p class="text-xl font-bold text-yellow-400">€{{ number_format($invoice->total, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('app.invoices.pdf', $invoice) }}" 
                           class="flex-1 px-4 py-2.5 bg-gray-800/50 text-gray-300 rounded-xl hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all duration-150 text-sm font-medium text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            PDF
                        </a>
                        <a href="{{ route('app.invoices.show', $invoice) }}" 
                           class="px-4 py-2.5 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-xl hover:bg-yellow-400/20 transition-all duration-150">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-gray-800/50 p-16 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-gray-800/50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Geen facturen</h3>
                        <p class="text-gray-400 mb-6">Begin met het aanmaken van je eerste factuur!</p>
                        <a href="{{ route('app.invoices.create') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                            Maak je eerste factuur
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function showTableView() {
            document.getElementById('tableView').classList.remove('hidden');
            document.getElementById('cardView').classList.add('hidden');
            document.getElementById('tableViewBtn').classList.add('bg-gray-900/50', 'text-yellow-400');
            document.getElementById('tableViewBtn').classList.remove('text-gray-500');
            document.getElementById('cardViewBtn').classList.remove('bg-gray-900/50', 'text-yellow-400');
            document.getElementById('cardViewBtn').classList.add('text-gray-500');
        }
        
        function showCardView() {
            document.getElementById('tableView').classList.add('hidden');
            document.getElementById('cardView').classList.remove('hidden');
            document.getElementById('cardViewBtn').classList.add('bg-gray-900/50', 'text-yellow-400');
            document.getElementById('cardViewBtn').classList.remove('text-gray-500');
            document.getElementById('tableViewBtn').classList.remove('bg-gray-900/50', 'text-yellow-400');
            document.getElementById('tableViewBtn').classList.add('text-gray-500');
        }
    </script>
</x-layouts.app>
