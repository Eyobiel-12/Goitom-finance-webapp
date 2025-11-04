<x-layouts.app>
    <div class="py-8 bg-gray-100">
        <div class="max-w-5xl mx-auto px-4">
            <!-- Back Button -->
            <a href="{{ route('app.invoices.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Terug naar facturen
            </a>

            <!-- Invoice Document -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $invoice->organization->name ?? 'Goitom Finance BV' }}</h1>
                    </div>
                    <div class="text-right">
                        <h2 class="text-3xl font-bold text-blue-600 mb-1">Factuur</h2>
                        <p class="text-gray-600 mb-2">#{{ $invoice->number }}</p>
                        @if($invoice->status === 'paid')
                        <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded">Betaald</span>
                        @elseif($invoice->status === 'sent')
                        <span class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded">Verzonden</span>
                        @elseif($invoice->status === 'overdue')
                        <span class="inline-block px-3 py-1 bg-red-600 text-white text-sm font-semibold rounded">Achterstallig</span>
                        @else
                        <span class="inline-block px-3 py-1 bg-gray-500 text-white text-sm font-semibold rounded">Concept</span>
                        @endif
                    </div>
                </div>

                <!-- Blue Separator Line -->
                <div class="h-1 bg-blue-600 mb-8"></div>

                <!-- VAN / AAN / FACTUURGEGEVENS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- VAN -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase">Van</h3>
                        <p class="font-semibold text-gray-900">{{ $invoice->organization->name ?? 'Goitom Finance BV' }}</p>
                        @if($invoice->organization && $invoice->organization->vat_number)
                        <p class="text-sm text-gray-600 mt-1">BTW: {{ $invoice->organization->vat_number }}</p>
                        @endif
                        @if(auth()->user()->email)
                        <p class="text-sm text-gray-600 mt-1">{{ auth()->user()->email }}</p>
                        @endif
                    </div>

                    <!-- AAN -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase">Aan</h3>
                        <p class="font-semibold text-gray-900">{{ $invoice->client->name }}</p>
                        @if($invoice->client->email)
                        <p class="text-sm text-gray-600 mt-1">{{ $invoice->client->email }}</p>
                        @endif
                        @if($invoice->client->phone)
                        <p class="text-sm text-gray-600 mt-1">{{ $invoice->client->phone }}</p>
                        @endif
                    </div>

                    <!-- FACTUURGEGEVENS -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase">Factuurgegevens</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Factuurdatum:</span> {{ $invoice->issue_date->format('d-m-Y') }}
                        </p>
                        @if($invoice->due_date)
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Vervaldatum:</span> {{ $invoice->due_date->format('d-m-Y') }}
                        </p>
                        @endif
                        @if($invoice->project)
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold">Project:</span> {{ $invoice->project->name }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Invoice Items Table -->
                <div class="mb-8">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-600 text-white">
                                <th class="px-4 py-3 text-left text-sm font-bold uppercase">Omschrijving</th>
                                <th class="px-4 py-3 text-right text-sm font-bold uppercase">Aantal</th>
                                <th class="px-4 py-3 text-right text-sm font-bold uppercase">Stukprijs</th>
                                <th class="px-4 py-3 text-right text-sm font-bold uppercase">Bedrag</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($invoice->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 text-gray-900 font-medium">{{ $item->description }}</td>
                                <td class="px-4 py-4 text-right text-gray-900">{{ number_format($item->qty, 2, ',', '.') }}</td>
                                <td class="px-4 py-4 text-right text-gray-900">€{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                <td class="px-4 py-4 text-right text-gray-900 font-semibold">€{{ number_format($item->line_total, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">Geen factuurregels</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="flex justify-end mb-8">
                    <div class="w-full md:w-80">
                        <div class="space-y-3 bg-gray-50 rounded-lg p-6">
                            <div class="flex justify-between text-gray-700">
                                <span class="font-medium">Subtotaal</span>
                                <span class="font-semibold">€{{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
                            </div>
                            @php
                                $vatPercentage = $invoice->items->first()->vat_rate ?? 21;
                            @endphp
                            <div class="flex justify-between text-gray-700">
                                <span class="font-medium">BTW ({{ number_format($vatPercentage, 0) }}%)</span>
                                <span class="font-semibold">€{{ number_format($invoice->vat_total, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t-2 border-gray-300">
                                <span class="text-2xl font-bold text-gray-900">TOTAAL</span>
                                <span class="text-2xl font-bold text-gray-900">€{{ number_format($invoice->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-between items-end pt-8 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        <p class="font-semibold">{{ $invoice->organization->name ?? 'Goitom Finance BV' }}</p>
                    </div>
                    <div class="text-sm italic text-gray-500">
                        Bedankt voor uw vertrouwen
                    </div>
                </div>

                <!-- Notes -->
                @if($invoice->notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 mb-2">Opmerkingen</h3>
                    <p class="text-gray-600 text-sm whitespace-pre-line">{{ $invoice->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('app.invoices.edit', $invoice) }}" class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-all font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Bewerken
                    </a>
                    <a href="{{ route('app.invoices.pdf', $invoice) }}" target="_blank" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF Downloaden
                    </a>
                    <button onclick="showEmailPreview()" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg font-semibold text-white hover:shadow-lg transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        E-mail Verzenden
                    </button>
                    @if($invoice->status !== 'paid')
                    <form action="{{ route('app.invoices.markPaid', $invoice) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-lg font-semibold text-white hover:shadow-lg transition-all flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Markeer als Betaald
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if(session('success'))
            <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
        </div>
    </div>

    <!-- Email Preview Modal -->
    <div id="emailPreviewModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-4xl w-full max-h-[95vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6 pb-4 border-b">
                <h3 class="text-2xl font-bold text-gray-900">E-mail Preview</h3>
                <button onclick="closeEmailPreview()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-600">Naar:</p>
                        <p class="font-semibold text-gray-900">{{ $invoice->client->name }} &lt;{{ $invoice->client->email }}&gt;</p>
                    </div>
                </div>
            </div>
            
            <div class="border-2 border-gray-300 rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-2 border-b border-gray-300">
                    <p class="text-xs text-gray-600 text-center">E-mail Preview</p>
                </div>
                <div class="p-6 bg-white">
                    @include('emails.invoice-sent', ['invoice' => $invoice, 'organization' => $invoice->organization])
                </div>
            </div>
            
            <div class="mt-8 flex space-x-3">
                <form action="{{ route('app.invoices.send', $invoice) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg font-bold text-gray-900 hover:shadow-lg transition-all">
                        Versturen
                    </button>
                </form>
                <button onclick="closeEmailPreview()" class="px-6 py-4 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                    Annuleren
                </button>
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
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEmailPreview();
            }
        });
    </script>
</x-layouts.app>
