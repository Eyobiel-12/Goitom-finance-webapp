<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Facturen</h1>
                    <p class="mt-2 text-gray-400 text-lg">Beheer je facturen en betalingen</p>
                </div>
                <a href="{{ route('app.invoices.create') }}" 
                   class="group relative px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300 hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nieuwe Factuur
                </a>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-yellow-400/20 p-4">
                    <p class="text-sm text-gray-500 mb-1">Totaal</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ \App\Models\Invoice::where('organization_id', auth()->user()->organization_id)->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-green-500/20 p-4">
                    <p class="text-sm text-gray-500 mb-1">Betaald</p>
                    <p class="text-2xl font-bold text-green-400">{{ \App\Models\Invoice::where('organization_id', auth()->user()->organization_id)->where('status', 'paid')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-orange-500/20 p-4">
                    <p class="text-sm text-gray-500 mb-1">Openstaand</p>
                    <p class="text-2xl font-bold text-orange-400">{{ \App\Models\Invoice::where('organization_id', auth()->user()->organization_id)->where('status', 'sent')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-red-500/20 p-4">
                    <p class="text-sm text-gray-500 mb-1">Achterstallig</p>
                    <p class="text-2xl font-bold text-red-400">{{ \App\Models\Invoice::where('organization_id', auth()->user()->organization_id)->where('status', 'overdue')->count() }}</p>
                </div>
            </div>

            <!-- Filters and View Toggle -->
            <div class="mb-6 flex gap-4 items-center">
                <select class="px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                    <option>Alle statussen</option>
                    <option>Concept</option>
                    <option>Verzonden</option>
                    <option>Betaald</option>
                    <option>Achterstallig</option>
                </select>
                <input type="text" placeholder="Zoek facturen..." 
                       class="flex-1 px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                <div class="flex items-center bg-gray-900 rounded-xl p-1 border border-gray-700">
                    <button onclick="showTableView()" id="tableViewBtn" class="px-4 py-2 bg-gray-800 text-yellow-400 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                    <button onclick="showCardView()" id="cardViewBtn" class="px-4 py-2 text-gray-400 rounded-lg hover:bg-gray-800 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Invoices Table -->
            <div id="tableView" class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Factuur</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Klant</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Datum</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Bedrag</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse(\App\Models\Invoice::where('organization_id', auth()->user()->organization_id)->with('client')->latest()->get() as $invoice)
                        <tr class="hover:bg-gray-900/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center text-gray-900 font-bold text-xs mr-3">
                                        #
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $invoice->number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-white">{{ $invoice->client->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-400">{{ $invoice->issue_date->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-lg font-bold text-yellow-400">€{{ number_format($invoice->total, 2) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($invoice->status === 'paid')
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-semibold">Betaald</span>
                                @elseif($invoice->status === 'sent')
                                <span class="px-3 py-1 bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 rounded-full text-xs font-semibold">Verzonden</span>
                                @elseif($invoice->status === 'overdue')
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-xs font-semibold">Achterstallig</span>
                                @else
                                <span class="px-3 py-1 bg-gray-500/20 text-gray-400 border border-gray-500/30 rounded-full text-xs font-semibold">Concept</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('app.invoices.pdf', $invoice) }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors" title="Download PDF">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4M1 20h22"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('app.invoices.show', $invoice) }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors" title="Bekijken">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('app.invoices.edit', $invoice) }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors" title="Bewerken">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="text-xl font-bold text-gray-400 mb-2">Geen facturen</h3>
                                <p class="text-gray-600">Begin met het aanmaken van je eerste factuur!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Invoices Cards -->
            <div id="cardView" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse(\App\Models\Invoice::where('organization_id', auth()->user()->organization_id)->with('client')->latest()->get() as $invoice)
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 hover:border-yellow-400/30 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-gray-900 font-bold">
                            #
                        </div>
                        @if($invoice->status === 'paid')
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-semibold">Betaald</span>
                        @elseif($invoice->status === 'sent')
                        <span class="px-3 py-1 bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 rounded-full text-xs font-semibold">Verzonden</span>
                        @elseif($invoice->status === 'overdue')
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-xs font-semibold">Achterstallig</span>
                        @else
                        <span class="px-3 py-1 bg-gray-500/20 text-gray-400 border border-gray-500/30 rounded-full text-xs font-semibold">Concept</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $invoice->number }}</h3>
                    <p class="text-gray-400 text-sm mb-4">{{ $invoice->client->name }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Datum</p>
                            <p class="text-sm text-white">{{ $invoice->issue_date->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Bedrag</p>
                            <p class="text-lg font-bold text-yellow-400">€{{ number_format($invoice->total, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('app.invoices.pdf', $invoice) }}" class="flex-1 px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all text-sm font-medium text-center flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            PDF
                        </a>
                        <a href="{{ route('app.invoices.show', $invoice) }}" class="px-4 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Geen facturen</h3>
                    <p class="text-gray-600">Begin met het aanmaken van je eerste factuur!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function showTableView() {
            document.getElementById('tableView').classList.remove('hidden');
            document.getElementById('cardView').classList.add('hidden');
            document.getElementById('tableViewBtn').classList.add('bg-gray-800', 'text-yellow-400');
            document.getElementById('tableViewBtn').classList.remove('text-gray-400');
            document.getElementById('cardViewBtn').classList.remove('bg-gray-800', 'text-yellow-400');
            document.getElementById('cardViewBtn').classList.add('text-gray-400');
        }
        
        function showCardView() {
            document.getElementById('tableView').classList.add('hidden');
            document.getElementById('cardView').classList.remove('hidden');
            document.getElementById('cardViewBtn').classList.add('bg-gray-800', 'text-yellow-400');
            document.getElementById('cardViewBtn').classList.remove('text-gray-400');
            document.getElementById('tableViewBtn').classList.remove('bg-gray-800', 'text-yellow-400');
            document.getElementById('tableViewBtn').classList.add('text-gray-400');
        }
    </script>
</x-layouts.app>