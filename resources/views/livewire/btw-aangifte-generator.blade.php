<div>
    @if(session('message'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center space-x-3 animate-fade-in">
        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-green-400 font-semibold">{{ session('message') }}</p>
    </div>
    @endif

    <!-- Generate Form -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 mb-8">
        <h2 class="text-2xl font-bold text-white mb-6">BTW Aangifte Genereren</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Jaar</label>
                <select wire:model="jaar" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
                    @for($year = date('Y'); $year >= 2020; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                @error('jaar') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Kwartaal</label>
                <select wire:model="kwartaal" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-yellow-400 transition-all">
                    <option value="">Jaar</option>
                    <option value="1">Q1 (Jan - Mar)</option>
                    <option value="2">Q2 (Apr - Jun)</option>
                    <option value="3">Q3 (Jul - Sep)</option>
                    <option value="4">Q4 (Okt - Dec)</option>
                </select>
                @error('kwartaal') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-end">
                <button wire:click="generate" class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                    Bereken
                </button>
            </div>
        </div>
    </div>

    <!-- Current Results -->
    @if($btwAangifte)
    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">Resultaten</h2>
            <span class="px-4 py-2 rounded-xl text-sm font-semibold {{ $btwAangifte->status === 'ingediend' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                {{ ucfirst($btwAangifte->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">BTW Ontvangen</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->ontvangen_btw, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Van facturen</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">BTW Betaald</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->betaalde_btw, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Van aftrekposten</p>
            </div>

            @if($btwAangifte->btw_afdracht > 0)
            <div class="bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Te Betalen</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->btw_afdracht, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Aan de belastingdienst</p>
            </div>
            @endif

            @if($btwAangifte->btw_terug > 0)
            <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Te Terug</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->btw_terug, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Van de belastingdienst</p>
            </div>
            @endif
        </div>

        @if($btwAangifte->status === 'concept')
        <div class="flex justify-end">
            <button wire:click="markAsSubmitted" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all">
                Markeren als Ingediend
            </button>
        </div>
        @endif
    </div>
    @endif

    <!-- Aangifte History -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
        <h2 class="text-2xl font-bold text-white mb-6">Aangifte Historie</h2>
        
        <div class="space-y-3">
            @forelse($aangifteList as $aangifte)
            <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-gray-700/50 hover:border-yellow-400/30 transition-all">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-1">
                        <h3 class="font-bold text-white">
                            {{ $aangifte->kwartaal ? 'Q' . $aangifte->kwartaal . ' ' : '' }}{{ $aangifte->jaar }}
                        </h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $aangifte->status === 'ingediend' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ ucfirst($aangifte->status) }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-6 mt-2 text-sm text-gray-500">
                        <span>Ontvangen: €{{ number_format($aangifte->ontvangen_btw, 2) }}</span>
                        <span>Betaald: €{{ number_format($aangifte->betaalde_btw, 2) }}</span>
                    </div>
                </div>
                <div class="text-right ml-4">
                    @if($aangifte->btw_afdracht > 0)
                    <p class="text-xl font-bold text-red-400">-€{{ number_format($aangifte->btw_afdracht, 2) }}</p>
                    @elseif($aangifte->btw_terug > 0)
                    <p class="text-xl font-bold text-green-400">+€{{ number_format($aangifte->btw_terug, 2) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-400 mb-4">Nog geen BTW aangiften</p>
                <p class="text-gray-500">Klik op 'Bereken' om je eerste aangifte te genereren</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

