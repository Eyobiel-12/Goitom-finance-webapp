<div>
    <div>
        <!-- Header -->
        <div class="flex items-center justify-end mb-6">
            @if($invoice)
            <div class="flex space-x-3">
                <a href="{{ route('app.invoices.pdf', $invoice) }}" target="_blank"
                   class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF Downloaden
                </a>
                <button wire:click="sendInvoice" 
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Verzenden
                </button>
            </div>
            @endif
        </div>

        @if (session()->has('message'))
        <div class="mb-6 px-4 py-3 bg-green-500/20 border border-green-500/30 rounded-xl text-green-400">
            {{ session('message') }}
        </div>
        @endif

        <form wire:submit.prevent="save">
            <!-- Invoice Details -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Factuur Gegevens</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Factuurnummer</label>
                        <input type="text" wire:model="number" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        @error('number') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Klant *</label>
                        <select wire:model="client_id" 
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                            <option value="">Selecteer klant</option>
                            @foreach($this->clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Project</label>
                        <select wire:model="project_id" 
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                            <option value="">Geen project</option>
                            @foreach($this->projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Factuurdatum</label>
                        <input type="date" wire:model="issue_date" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                        @error('issue_date') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Vervaldatum</label>
                        <input type="date" wire:model="due_date" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                        <select wire:model="status" 
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                            <option value="draft">Concept</option>
                            <option value="sent">Verzonden</option>
                            <option value="paid">Betaald</option>
                            <option value="overdue">Achterstallig</option>
                            <option value="cancelled">Geannuleerd</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Factuurregels</h3>
                    <button type="button" wire:click="addItem" 
                            class="px-4 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-xl hover:bg-yellow-400/20 transition-all text-sm font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Regel Toevoegen
                    </button>
                </div>

                @if(count($items) > 0)
                <div class="space-y-3">
                    @foreach($items as $index => $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-800/30 rounded-xl border border-gray-700/50">
                        <input type="text" wire:model="items.{{ $index }}.description" 
                               placeholder="Omschrijving" 
                               class="flex-1 px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        <input type="number" step="0.01" wire:model="items.{{ $index }}.qty" 
                               placeholder="Aantal" 
                               class="w-24 px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        <input type="number" step="0.01" wire:model="items.{{ $index }}.unit_price" 
                               placeholder="Prijs" 
                               class="w-32 px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        <input type="number" step="0.01" wire:model="items.{{ $index }}.vat_rate" 
                               placeholder="BTW %" 
                               class="w-24 px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        <div class="w-32 text-right font-bold text-yellow-400">
                            €{{ number_format($item['qty'] * $item['unit_price'] * (1 + $item['vat_rate'] / 100), 2) }}
                        </div>
                        <button type="button" wire:click="removeItem({{ $index }})" 
                                class="p-3 text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-8">Geen factuurregels. Klik op "Regel Toevoegen" om te beginnen.</p>
                @endif
            </div>

            <!-- Totals & Notes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Notes -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Opmerkingen</label>
                    <textarea wire:model="notes" rows="5" 
                              class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                              placeholder="Optionele opmerkingen voor de factuur..."></textarea>
                </div>

                <!-- Totals -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-6">Overzicht</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotaal</span>
                            <span class="font-semibold">€{{ number_format($this->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>BTW</span>
                            <span class="font-semibold">€{{ number_format($this->vatTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-2xl font-bold pt-3 border-t border-gray-800">
                            <span class="text-white">Totaal</span>
                            <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">€{{ number_format($this->total, 2) }}</span>
                        </div>
                    </div>
                </div>
</div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('app.invoices.index') }}" 
                   class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold">
                    Annuleren
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                    {{ $invoice ? 'Bijwerken' : 'Aanmaken' }}
                </button>
            </div>
        </form>
    </div>