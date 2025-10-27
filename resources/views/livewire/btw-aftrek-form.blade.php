<div>
    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @foreach([1, 2, 3] as $step)
            <div class="flex items-center flex-1">
                <div class="flex flex-col items-center flex-1">
                    <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all {{ $current_step >= $step ? 'bg-yellow-400 border-yellow-400' : 'border-gray-600 text-gray-600' }}">
                        @if($current_step > $step)
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        @else
                        <span class="font-bold">{{ $step }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-center">
                        @if($step === 1) Details
                        @elseif($step === 2) Bedrag
                        @else Review
                        @endif
                    </p>
                </div>
                @if($step < 3)
                <div class="flex-1 h-0.5 mx-2 {{ $current_step > $step ? 'bg-yellow-400' : 'bg-gray-700' }}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Step 1: Basic Info -->
    @if($current_step === 1)
    <div class="space-y-6">
        <h3 class="text-2xl font-bold text-white mb-6">Basisinformatie</h3>
        
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Naam *</label>
            <input type="text" wire:model="naam" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
            @error('naam') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Beschrijving</label>
            <textarea wire:model="beschrijving" rows="3" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all"></textarea>
            @error('beschrijving') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Categorie</label>
            <select wire:model="categorie" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
                <option value="Kosten">Kosten</option>
                <option value="Investering">Investering</option>
                <option value="Kantoor">Kantoor</option>
                <option value="Marketing">Marketing</option>
                <option value="Reis">Reis</option>
                <option value="Anders">Anders</option>
            </select>
            @error('categorie') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Datum *</label>
            <input type="date" wire:model="datum" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
            @error('datum') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
    @endif

    <!-- Step 2: Amount -->
    @if($current_step === 2)
    <div class="space-y-6">
        <h3 class="text-2xl font-bold text-white mb-6">Bedrag & BTW</h3>
        
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Bedrag excl. BTW *</label>
            <input type="number" step="0.01" wire:model.live="bedrag_excl_btw" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
            @error('bedrag_excl_btw') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">BTW Percentage *</label>
            <select wire:model.live="btw_percentage" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
                <option value="0">0%</option>
                <option value="9">9%</option>
                <option value="21">21%</option>
            </select>
            @error('btw_percentage') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Calculation Preview -->
        <div class="bg-gradient-to-br from-yellow-400/10 to-yellow-600/10 border-2 border-yellow-400/30 rounded-xl p-6">
            <h4 class="text-lg font-bold text-yellow-400 mb-4">Berekening</h4>
            <div class="space-y-3">
                <div class="flex justify-between text-white">
                    <span>Bedrag excl. BTW:</span>
                    <span class="font-semibold">€{{ number_format($bedrag_excl_btw, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-white">
                    <span>BTW ({{ $btw_percentage }}%):</span>
                    <span class="font-semibold text-yellow-400">€{{ number_format($this->calculatedBtw, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-white text-xl pt-3 border-t border-yellow-400/30">
                    <span class="font-bold">Totaal:</span>
                    <span class="font-bold text-yellow-400">€{{ number_format($this->calculatedTotal, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Step 3: Review -->
    @if($current_step === 3)
    <div class="space-y-6">
        <h3 class="text-2xl font-bold text-white mb-6">Review</h3>
        
        <div class="bg-gradient-to-br from-green-400/10 to-green-600/10 border-2 border-green-400/30 rounded-xl p-6">
            <h4 class="text-lg font-bold text-green-400 mb-4">Aftrekpost Details</h4>
            <div class="space-y-3 text-white">
                <div class="flex justify-between">
                    <span class="text-gray-400">Naam:</span>
                    <span class="font-semibold">{{ $naam }}</span>
                </div>
                @if($beschrijving)
                <div class="flex justify-between">
                    <span class="text-gray-400">Beschrijving:</span>
                    <span class="font-semibold">{{ $beschrijving }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-400">Categorie:</span>
                    <span class="font-semibold">{{ $categorie }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Datum:</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($datum)->format('d-m-Y') }}</span>
                </div>
                <div class="pt-3 border-t border-green-400/30">
                    <div class="flex justify-between mb-2">
                        <span>Bedrag excl. BTW:</span>
                        <span class="font-bold">€{{ number_format($bedrag_excl_btw, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>BTW ({{ $btw_percentage }}%):</span>
                        <span class="font-bold text-green-400">€{{ number_format($this->calculatedBtw, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xl pt-2">
                        <span class="font-bold">Totaal Aftrek:</span>
                        <span class="font-bold text-green-400">€{{ number_format($this->calculatedTotal, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation Buttons -->
    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-700">
        @if($current_step > 1)
        <button wire:click="previousStep" class="px-6 py-3 bg-gray-800 border border-gray-700 rounded-xl font-semibold text-white hover:bg-gray-700 transition-all">
            Terug
        </button>
        @else
        <a href="{{ route('app.btw-aftrek.index') }}" class="px-6 py-3 bg-gray-800 border border-gray-700 rounded-xl font-semibold text-white hover:bg-gray-700 transition-all">
            Annuleren
        </a>
        @endif

        <button wire:click="nextStep" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
            {{ $current_step === $total_steps ? 'Voltooien' : 'Volgende' }}
        </button>
    </div>
</div>

