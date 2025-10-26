<div class="py-8 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-3 mb-8">
            <a href="{{ route('app.clients.index') }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">
                {{ $client ? 'Klant Bewerken' : 'Nieuwe Klant' }}
            </h2>
        </div>

        @if (session()->has('message'))
        <div class="mb-6 px-4 py-3 bg-green-500/20 border border-green-500/30 rounded-xl text-green-400">
            {{ session('message') }}
        </div>
        @endif

        <!-- Progress Steps -->
        <div class="bg-gray-900 rounded-xl p-6 mb-8">
            <div class="flex items-center">
                @php
                $steps = [
                    1 => 'Basis',
                    2 => 'Contact',
                    3 => 'Adres & Tax'
                ];
                @endphp
                @foreach($steps as $step => $label)
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center">
                        <button 
                            wire:click="goToStep({{ $step }})"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all {{ $current_step >= $step ? 'bg-yellow-400 text-gray-900' : 'bg-gray-700 text-gray-400' }}">
                            {{ $step }}
                        </button>
                        <span class="ml-2 text-sm font-medium {{ $current_step >= $step ? 'text-yellow-400' : 'text-gray-400' }}">{{ $label }}</span>
                    </div>
                    @if($step < $total_steps)
                    <div class="flex-1 h-0.5 mx-2 {{ $current_step > $step ? 'bg-yellow-400' : 'bg-gray-700' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <form wire:submit.prevent="save">
            <!-- Step 1: Basic Info -->
            @if($current_step === 1)
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Basisgegevens</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Bedrijfsnaam *</label>
                        <input type="text" wire:model="name" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="Bijv. Acme Corporation">
                        @error('name') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Contactpersoon</label>
                        <input type="text" wire:model="contact_name" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="Naam van contactpersoon">
                    </div>
                </div>
            </div>
            @endif

            <!-- Step 2: Contact Info -->
            @if($current_step === 2)
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Contactgegevens</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">E-mail</label>
                        <input type="email" wire:model="email" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="contact@bedrijf.nl">
                        @error('email') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Telefoon</label>
                        <input type="text" wire:model="phone" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="+31 6 12345678">
                    </div>
                </div>
            </div>
            @endif

            <!-- Step 3: Address & Tax -->
            @if($current_step === 3)
            <div class="space-y-6">
                <!-- Address -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-6">Adres</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Straat</label>
                            <input type="text" wire:model="street" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                   placeholder="Hoofdstraat 123">
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Postcode</label>
                                <input type="text" wire:model="postal_code" 
                                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                       placeholder="1234 AB">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Plaats</label>
                                <input type="text" wire:model="city" 
                                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                       placeholder="Amsterdam">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Land</label>
                            <input type="text" wire:model="country" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                   placeholder="NL">
                        </div>
                    </div>
                </div>

                <!-- Tax & KVK Info -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-6">Belasting & Registratie</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">KVK-nummer</label>
                            <input type="text" wire:model="kvk_number" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                   placeholder="12345678">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">BTW-nummer / Tax ID</label>
                            <input type="text" wire:model="tax_id" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                   placeholder="NL123456789B01">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex justify-between items-center mt-6">
                <div>
                    @if($current_step > 1)
                    <button type="button" wire:click="previousStep" 
                            class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Vorige
                    </button>
                    @endif
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('app.clients.index') }}" 
                       class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold">
                        Annuleren
                    </a>
                    @if($current_step < $total_steps)
                    <button type="button" wire:click="nextStep" 
                            class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                        Volgende
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                    @else
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $client ? 'Bijwerken' : 'Aanmaken' }}
                    </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
