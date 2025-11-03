<div class="py-8 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-3 mb-8">
            <a href="{{ route('app.projects.index') }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">
                {{ $project ? 'Project Bewerken' : 'Nieuw Project' }}
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
                    1 => 'Klant',
                    2 => 'Details',
                    3 => 'Financieel'
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
            <!-- Step 1: Client Selection -->
            @if($current_step === 1)
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Kies Klant</h3>
                <div class="space-y-4">
                    @foreach($this->clients as $client)
                    <div wire:click="$set('client_id', '{{ $client->id }}')" 
                         class="cursor-pointer p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $client_id == $client->id ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-white">{{ $client->name }}</div>
                                @if($client->email)
                                <div class="text-sm text-gray-400">{{ $client->email }}</div>
                                @endif
                            </div>
                            <div class="w-6 h-6 rounded-full border-2 {{ $client_id == $client->id ? 'border-yellow-400' : 'border-gray-600' }} flex items-center justify-center">
                                @if($client_id == $client->id)
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('client_id') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>
            @endif

            <!-- Step 2: Project Details -->
            @if($current_step === 2)
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Projectgegevens</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Projectnaam *</label>
                        <input type="text" wire:model="name" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="Bijv. Website Redesign">
                        @error('name') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Omschrijving</label>
                        <textarea wire:model="description" rows="5" 
                                  class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                  placeholder="Beschrijf het project..."></textarea>
                    </div>
                </div>
            </div>
            @endif

            <!-- Step 3: Financial Details -->
            @if($current_step === 3)
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Financiële gegevens</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                        <select wire:model="status" 
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                            <option value="active">Actief</option>
                            <option value="completed">Voltooid</option>
                            <option value="paused">Gepauzeerd</option>
                            <option value="cancelled">Geannuleerd</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Uurtarief</label>
                        <input type="number" step="0.01" wire:model="rate" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="€ 0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Uren</label>
                        <input type="number" step="0.01" wire:model="hours" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                               placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Totale waarde</label>
                        <div class="px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl text-white font-bold">
                            €{{ number_format(($rate ?: 0) * $hours, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex justify-between items-center">
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
                    <a href="{{ route('app.projects.index') }}" 
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
                        {{ $project ? 'Bijwerken' : 'Aanmaken' }}
                    </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
