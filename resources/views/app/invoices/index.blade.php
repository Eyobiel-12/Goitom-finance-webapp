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

            <!-- Filters -->
            <div class="mb-6 flex gap-4">
                <select class="px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                    <option>Alle statussen</option>
                    <option>Concept</option>
                    <option>Verzonden</option>
                    <option>Betaald</option>
                    <option>Achterstallig</option>
                </select>
                <input type="text" placeholder="Zoek facturen..." 
                       class="flex-1 px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
            </div>

            <!-- Invoices Table -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 overflow-hidden">
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
                                    <a href="{{ route('app.invoices.show', $invoice) }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('app.invoices.edit', $invoice) }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
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
        </div>
    </div>
</x-layouts.app>