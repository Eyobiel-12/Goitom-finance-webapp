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

        <form wire:submit.prevent="save">
            <!-- Main Info -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-6">Projectgegevens</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        <label class="block text-sm font-medium text-gray-400 mb-2">Projectnaam *</label>
                        <input type="text" wire:model="name" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
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

            <!-- Description -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                <label class="block text-sm font-medium text-gray-400 mb-2">Omschrijving</label>
                <textarea wire:model="description" rows="5" 
                          class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                          placeholder="Geef een beschrijving van het project..."></textarea>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('app.projects.index') }}" 
                   class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold">
                    Annuleren
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                    {{ $project ? 'Bijwerken' : 'Aanmaken' }}
                </button>
            </div>
        </form>
    </div>
</div>