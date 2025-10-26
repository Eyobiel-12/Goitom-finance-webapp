<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <a href="{{ route('app.invoices.index') }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Factuur Details</h1>
                    </div>
                    <p class="text-gray-400 text-lg ml-12">{{ $invoice->number }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('app.invoices.edit', $invoice) }}" class="px-6 py-3 bg-gray-800 border border-gray-700 rounded-xl font-semibold text-white hover:bg-gray-700 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Bewerken
                    </a>
                    @if($invoice->pdf_path)
                    <a href="{{ route('app.invoices.pdf', $invoice) }}" target="_blank" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF Downloaden
                    </a>
                    @endif
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-xl">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-400 font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Invoice Card -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Invoice Information -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-white">Factuur Informatie</h2>
                            @if($invoice->status === 'paid')
                            <span class="px-4 py-2 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-sm font-semibold">Betaald</span>
                            @elseif($invoice->status === 'sent')
                            <span class="px-4 py-2 bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 rounded-full text-sm font-semibold">Verzonden</span>
                            @elseif($invoice->status === 'overdue')
                            <span class="px-4 py-2 bg-red-500/20 text-red-400 border border-red-500/30 rounded-full text-sm font-semibold">Achterstallig</span>
                            @else
                            <span class="px-4 py-2 bg-gray-500/20 text-gray-400 border border-gray-500/30 rounded-full text-sm font-semibold">Concept</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Factuurnummer</p>
                                <p class="text-lg font-semibold text-white">{{ $invoice->number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Klant</p>
                                <p class="text-lg font-semibold text-white">{{ $invoice->client->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Factuurdatum</p>
                                <p class="text-lg font-semibold text-white">{{ $invoice->issue_date->format('d M Y') }}</p>
                            </div>
                            @if($invoice->due_date)
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Vervaldatum</p>
                                <p class="text-lg font-semibold text-white">{{ $invoice->due_date->format('d M Y') }}</p>
                            </div>
                            @endif
                        </div>

                        @if($invoice->notes)
                        <div class="mt-6 pt-6 border-t border-gray-800">
                            <p class="text-sm text-gray-500 mb-2">Opmerkingen</p>
                            <p class="text-gray-400">{{ $invoice->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Invoice Items -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-6">Factuurregels</h2>
                        
                        <div class="space-y-3">
                            @forelse($invoice->items as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-gray-700/50">
                                <div class="flex-1">
                                    <p class="font-semibold text-white">{{ $item->description }}</p>
                                    <p class="text-sm text-gray-400">{{ $item->qty }} x €{{ number_format($item->unit_price, 2) }} ({{ $item->vat_rate }}% BTW)</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-yellow-400">€{{ number_format($item->line_total, 2) }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-400 text-center py-4">Geen factuurregels</p>
                            @endforelse
                        </div>

                        <!-- Totals -->
                        <div class="mt-6 pt-6 border-t border-gray-800">
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-400">
                                    <span>Subtotaal</span>
                                    <span>€{{ number_format($invoice->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-400">
                                    <span>BTW ({{ number_format($invoice->items->first()->vat_rate ?? 21, 2) }}%)</span>
                                    <span>€{{ number_format($invoice->vat_total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-2xl font-bold pt-3 border-t border-gray-800">
                                    <span class="text-white">Totaal</span>
                                    <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">€{{ number_format($invoice->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Actions Card -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Acties</h3>
                        <div class="space-y-3">
                            <button onclick="showEmailPreview()" class="w-full px-4 py-3 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all text-sm font-semibold text-left flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                E-mail Verzenden
                            </button>
                            
                            <!-- Email Preview Modal -->
                            <div id="emailPreviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                <div class="bg-gray-900 rounded-xl border border-yellow-400 p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-xl font-bold text-yellow-400">E-mail Preview</h3>
                                        <button onclick="closeEmailPreview()" class="text-gray-400 hover:text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Email Preview Content -->
                                    <div class="border border-gray-700 rounded-lg p-4 bg-white">
                                        @include('emails.invoice-sent', ['invoice' => $invoice, 'organization' => $invoice->organization])
                                    </div>
                                    
                                    <div class="mt-4 flex space-x-3">
                                        <form action="{{ route('app.invoices.send', $invoice) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg font-semibold text-gray-900 hover:shadow-lg shadow-yellow-400/30 transition-all">
                                                Versturen
                                            </button>
                                        </form>
                                        <button onclick="closeEmailPreview()" class="px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg font-semibold text-white hover:bg-gray-700 transition-all">
                                            Annuleren
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('app.invoices.pdf', $invoice) }}" target="_blank" class="w-full block">
                                <button class="w-full px-4 py-3 bg-gradient-to-r from-blue-500/10 to-blue-600/10 text-blue-400 border border-blue-500/30 rounded-lg hover:bg-blue-500/20 transition-all text-sm font-semibold text-left flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    PDF Downloaden
                                </button>
                            </a>
                            <form action="{{ route('app.invoices.markPaid', $invoice) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-green-500/10 to-green-600/10 text-green-400 border border-green-500/30 rounded-lg hover:bg-green-500/20 transition-all text-sm font-semibold text-left flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Markeer als Betaald
                                </button>
                            </form>
                            <form action="{{ route('app.invoices.destroy', $invoice) }}" method="POST" class="w-full" onsubmit="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-red-500/10 to-red-600/10 text-red-400 border border-red-500/30 rounded-lg hover:bg-red-500/20 transition-all text-sm font-semibold text-left flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Verwijderen
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Client Info -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Klant</h3>
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center text-2xl font-bold text-gray-900 mb-4">
                            {{ strtoupper(substr($invoice->client->name, 0, 1)) }}
                        </div>
                        <p class="font-bold text-white text-lg mb-1">{{ $invoice->client->name }}</p>
                        @if($invoice->client->email)
                        <p class="text-gray-400 text-sm mb-1">{{ $invoice->client->email }}</p>
                        @endif
                        @if($invoice->client->phone)
                        <p class="text-gray-400 text-sm">{{ $invoice->client->phone }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showEmailPreview() {
            document.getElementById('emailPreviewModal').classList.remove('hidden');
        }
        
        function closeEmailPreview() {
            document.getElementById('emailPreviewModal').classList.add('hidden');
        }
        
        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEmailPreview();
            }
        });
    </script>
</x-layouts.app>