<div>
    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @foreach([1, 2, 3] as $step)
            <div class="flex items-center flex-1">
                <div class="flex flex-col items-center flex-1">
                    <div class="w-12 h-12 rounded-full border-2 flex items-center justify-center transition-all duration-300 {{ $current_step >= $step ? 'bg-gradient-to-br from-yellow-400 to-yellow-600 border-yellow-400 text-gray-900 shadow-lg shadow-yellow-400/30' : 'border-gray-600 text-gray-600' }}">
                        @if($current_step > $step)
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        @else
                        <span class="font-bold text-lg">{{ $step }}</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-400 mt-3 text-center font-medium">
                        @if($step === 1) Details
                        @elseif($step === 2) Bedrag
                        @else Review
                        @endif
                    </p>
                </div>
                @if($step < 3)
                <div class="flex-1 h-1 mx-4 rounded-full transition-all duration-300 {{ $current_step > $step ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 'bg-gray-700' }}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Step 1: Basic Info -->
    @if($current_step === 1)
    <div class="space-y-6 animate-fade-in">
        <div class="mb-6">
            <h3 class="text-3xl font-bold text-white mb-2">📝 Basisinformatie</h3>
            <p class="text-gray-400">Voer de basisinformatie van je aftrekpost in</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Naam van de aftrekpost *
                </label>
                <input type="text" wire:model="naam" placeholder="Bijvoorbeeld: Kantoor inrichting" class="w-full px-4 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl text-white placeholder-gray-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all hover:border-gray-600">
                @error('naam') <p class="text-red-400 text-sm mt-1 flex items-center"><svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categorie
                </label>
                <select wire:model="categorie" class="w-full px-4 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all hover:border-gray-600">
                    <option value="Kosten">💰 Kosten</option>
                    <option value="Investering">📈 Investering</option>
                    <option value="Kantoor">🏢 Kantoor</option>
                    <option value="Marketing">📢 Marketing</option>
                    <option value="Reis">✈️ Reis</option>
                    <option value="Anders">🔧 Anders</option>
                </select>
                @error('categorie') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
                Beschrijving (optioneel)
            </label>
            <textarea wire:model="beschrijving" rows="3" placeholder="Geef meer details over deze aftrekpost..." class="w-full px-4 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl text-white placeholder-gray-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all hover:border-gray-600 resize-none"></textarea>
            @error('beschrijving') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Datum *
            </label>
            <input type="date" wire:model="datum" class="w-full px-4 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all hover:border-gray-600 md:max-w-xs">
            @error('datum') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Help Card -->
        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/30 rounded-xl p-4 mt-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-blue-400 font-semibold mb-1">💡 Tip</p>
                    <p class="text-gray-400 text-sm">Denk aan uitgaven zoals: bureaukosten, software abonnementen, kantoorbenodigdheden, reiskosten, of andere zakelijke uitgaven.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Step 2: Amount -->
    @if($current_step === 2)
    <div class="space-y-6 animate-fade-in">
        <div class="mb-6">
            <h3 class="text-3xl font-bold text-white mb-2">💶 Bedrag & BTW</h3>
            <p class="text-gray-400">Voer het bedrag en BTW percentage in</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Bedrag excl. BTW *
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-xl font-semibold">€</span>
                    <input type="number" step="0.01" wire:model.live="bedrag_excl_btw" placeholder="0,00" class="w-full pl-10 pr-4 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl text-white placeholder-gray-500 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all hover:border-gray-600 text-lg font-semibold">
                </div>
                @error('bedrag_excl_btw') <p class="text-red-400 text-sm mt-1 flex items-center"><svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
                <p class="text-xs text-gray-500 mt-1">Voer het bedrag in zonder BTW</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    BTW Percentage *
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" wire:click="$set('btw_percentage', 0)" class="px-4 py-4 text-center border-2 rounded-xl transition-all font-semibold {{ $btw_percentage == 0 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-gray-800 border-gray-700 text-white hover:border-gray-600' }}">
                        0%
                    </button>
                    <button type="button" wire:click="$set('btw_percentage', 9)" class="px-4 py-4 text-center border-2 rounded-xl transition-all font-semibold {{ $btw_percentage == 9 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-gray-800 border-gray-700 text-white hover:border-gray-600' }}">
                        9%
                    </button>
                    <button type="button" wire:click="$set('btw_percentage', 21)" class="px-4 py-4 text-center border-2 rounded-xl transition-all font-semibold {{ $btw_percentage == 21 ? 'bg-yellow-400 text-gray-900 border-yellow-400' : 'bg-gray-800 border-gray-700 text-white hover:border-gray-600' }}">
                        21%
                    </button>
                </div>
                @error('btw_percentage') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-500 mt-2">Selecteer het correcte BTW tarief</p>
            </div>
        </div>

        <!-- Calculation Preview -->
        <div class="bg-gradient-to-br from-yellow-400/10 to-yellow-600/10 border-2 border-yellow-400/30 rounded-2xl p-6 mt-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-yellow-400">Berekening</h4>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-xl">
                    <span class="text-gray-300 font-medium">Bedrag excl. BTW:</span>
                    <span class="text-white font-bold text-lg">€{{ number_format($bedrag_excl_btw, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-xl">
                    <span class="text-gray-300 font-medium">BTW ({{ $btw_percentage }}%):</span>
                    <span class="text-yellow-400 font-bold text-lg">€{{ number_format($this->calculatedBtw, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-yellow-400/20 to-yellow-600/20 rounded-xl border-2 border-yellow-400/30">
                    <span class="text-white font-bold text-xl">Totaal Bedrag:</span>
                    <span class="text-yellow-400 font-bold text-2xl">€{{ number_format($this->calculatedTotal, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- BTW Info Card -->
        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/30 rounded-xl p-4 mt-4">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-purple-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-purple-400 font-semibold mb-1">📋 BTW Tarieven</p>
                    <p class="text-gray-400 text-sm mb-2">Meest voorkomende BTW tarieven in Nederland:</p>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• <strong>0%:</strong> Export, BTW-vrije goederen</li>
                        <li>• <strong>9%:</strong> Basisbehoeften (voeding, medicijnen, boeken)</li>
                        <li>• <strong>21%:</strong> Standaard tarief (meeste producten en diensten)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Step 3: Review -->
    @if($current_step === 3)
    <div class="space-y-6 animate-fade-in">
        <div class="mb-6">
            <h3 class="text-3xl font-bold text-white mb-2">✅ Review</h3>
            <p class="text-gray-400">Controleer alle gegevens voordat je opslaat</p>
        </div>
        
        <div class="bg-gradient-to-br from-green-400/10 to-green-600/10 border-2 border-green-400/30 rounded-2xl p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 class="text-2xl font-bold text-green-400">Aftrekpost Details</h4>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="p-4 bg-gray-900/50 rounded-xl">
                    <p class="text-sm text-gray-400 mb-1">Naam</p>
                    <p class="text-white font-semibold text-lg">{{ $naam }}</p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl">
                    <p class="text-sm text-gray-400 mb-1">Categorie</p>
                    <p class="text-white font-semibold text-lg">{{ $categorie }}</p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl">
                    <p class="text-sm text-gray-400 mb-1">Datum</p>
                    <p class="text-white font-semibold text-lg">{{ \Carbon\Carbon::parse($datum)->format('d-m-Y') }}</p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl">
                    <p class="text-sm text-gray-400 mb-1">BTW Percentage</p>
                    <p class="text-white font-semibold text-lg">{{ $btw_percentage }}%</p>
                </div>
            </div>

            @if($beschrijving)
            <div class="p-4 bg-gray-900/50 rounded-xl mb-6">
                <p class="text-sm text-gray-400 mb-1">Beschrijving</p>
                <p class="text-white font-medium">{{ $beschrijving }}</p>
            </div>
            @endif

            <!-- Financial Summary -->
            <div class="border-t-2 border-green-400/30 pt-6 mt-6">
                <h5 class="text-lg font-bold text-green-400 mb-4">Financieel Overzicht</h5>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-xl">
                        <span class="text-gray-300">Bedrag excl. BTW:</span>
                        <span class="text-white font-bold text-lg">€{{ number_format($bedrag_excl_btw, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-xl">
                        <span class="text-gray-300">BTW Bedrag:</span>
                        <span class="text-green-400 font-bold text-lg">+ €{{ number_format($this->calculatedBtw, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-5 bg-gradient-to-r from-green-400/20 to-green-600/20 rounded-xl border-2 border-green-400/30">
                        <span class="text-white font-bold text-xl">Totaal Aftrek:</span>
                        <span class="text-green-400 font-bold text-3xl">€{{ number_format($this->calculatedTotal, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Note -->
        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/30 rounded-xl p-4">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-blue-400 font-semibold mb-1">✓ Klaar om te versturen!</p>
                    <p class="text-gray-400 text-sm">Je aftrekpost wordt opgeslagen en verschijnt in je BTW-aftrek dashboard.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation Buttons -->
    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-700">
        @if($current_step > 1)
        <button wire:click="previousStep" class="px-8 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl font-semibold text-white hover:bg-gray-700 hover:border-gray-600 transition-all duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Terug</span>
        </button>
        @else
        <a href="{{ route('app.btw-aftrek.index') }}" class="px-8 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl font-semibold text-white hover:bg-gray-700 hover:border-gray-600 transition-all duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span>Annuleren</span>
        </a>
        @endif

        @if($current_step === 3)
        <button wire:click="save" class="px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 rounded-xl font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all duration-200 flex items-center space-x-2 group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Opslaan</span>
        </button>
        @else
        <button wire:click="nextStep" class="px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-200 flex items-center space-x-2 group">
            <span>Volgende</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        @endif
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fade-in 0.4s ease-out;
    }
</style>
