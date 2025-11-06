<div>
    @if(session('message'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center space-x-3 animate-fade-in">
        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-green-400 font-semibold">{{ session('message') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center space-x-3 animate-fade-in">
        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-red-400 font-semibold">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Upcoming Deadlines Alert -->
    @if(count($upcomingDeadlines) > 0)
    <div class="mb-6 bg-gradient-to-r from-orange-500/10 via-red-500/10 to-orange-500/10 rounded-xl border border-orange-500/30 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Aankomende Deadlines
            </h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            @foreach($upcomingDeadlines as $deadline)
            <div class="bg-gray-900/50 rounded-lg p-4 border {{ $deadline['is_overdue'] ? 'border-red-500/50' : ($deadline['days_until'] <= 7 ? 'border-orange-500/50' : 'border-gray-700') }}">
                <p class="text-sm font-semibold text-gray-300 mb-1">{{ $deadline['period'] }}</p>
                <p class="text-xs text-gray-500 mb-2">{{ $deadline['deadline']->format('d M Y') }}</p>
                @if($deadline['is_overdue'])
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-500/20 text-red-400">
                        Achterstallig
                    </span>
                @elseif($deadline['days_until'] <= 7)
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-orange-500/20 text-orange-400">
                        Over {{ $deadline['days_until'] }} dagen
                    </span>
                @else
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-500/20 text-green-400">
                        Over {{ $deadline['days_until'] }} dagen
                    </span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Generate Form -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">BTW Aangifte Genereren</h2>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-semibold border border-blue-500/20">
                    {{ $settings->btw_stelsel === 'kassa' ? 'Kassastelsel' : 'Factuurstelsel' }}
                </span>
            </div>
        </div>
        
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
            <div class="flex items-center gap-4">
                <h2 class="text-2xl font-bold text-white">Resultaten</h2>
                @if($btwAangifte->deadline)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm text-gray-400">
                        Deadline: {{ $btwAangifte->deadline->format('d M Y') }}
                    </span>
                    @if($btwAangifte->is_overdue)
                        <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded text-xs font-bold">Achterstallig</span>
                    @else
                        <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded text-xs font-bold">
                            Over {{ now()->diffInDays($btwAangifte->deadline) }} dagen
                        </span>
                    @endif
                </div>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if($btwAangifte->is_validated)
                    <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-xs font-semibold border border-green-500/20">
                        ✓ Gevalideerd
                    </span>
                @else
                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-lg text-xs font-semibold border border-yellow-500/20">
                        ⚠ Niet gevalideerd
                    </span>
                @endif
                <span class="px-4 py-2 rounded-xl text-sm font-semibold {{ $btwAangifte->status === 'ingediend' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                    {{ ucfirst($btwAangifte->status) }}
                </span>
            </div>
        </div>

        <!-- Validation Errors -->
        @if($btwAangifte->validation_errors && count($btwAangifte->validation_errors) > 0)
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl">
            <p class="text-red-400 font-semibold mb-2">Validatiefouten:</p>
            <ul class="list-disc list-inside text-red-300 text-sm space-y-1">
                @foreach($btwAangifte->validation_errors as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Main Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Omzet</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->omzet_excl_btw, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Excl. BTW</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Uitgaven</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->uitgaven_excl_btw, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Excl. BTW</p>
            </div>

            <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">BTW Ontvangen</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->ontvangen_btw, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Van klanten</p>
            </div>

            <div class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/30 rounded-xl p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">BTW Betaald</p>
                </div>
                <h3 class="text-2xl font-bold text-white">€{{ number_format($btwAangifte->betaalde_btw, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Van uitgaven</p>
            </div>
        </div>

        <!-- BTW Percentage Breakdown -->
        <div class="mb-6 bg-gray-800/50 rounded-xl p-6 border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">BTW Percentage Verdeling</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Ontvangen 0%</p>
                    <p class="text-lg font-bold text-blue-400">€{{ number_format($btwAangifte->ontvangen_btw_0 ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Ontvangen 9%</p>
                    <p class="text-lg font-bold text-green-400">€{{ number_format($btwAangifte->ontvangen_btw_9 ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Ontvangen 21%</p>
                    <p class="text-lg font-bold text-yellow-400">€{{ number_format($btwAangifte->ontvangen_btw_21 ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Betaald 0%</p>
                    <p class="text-lg font-bold text-blue-400">€{{ number_format($btwAangifte->betaalde_btw_0 ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Betaald 9%</p>
                    <p class="text-lg font-bold text-green-400">€{{ number_format($btwAangifte->betaalde_btw_9 ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Betaald 21%</p>
                    <p class="text-lg font-bold text-yellow-400">€{{ number_format($btwAangifte->betaalde_btw_21 ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Result -->
        <div class="border-2 {{ $btwAangifte->btw_afdracht > 0 ? 'border-red-400' : 'border-green-400' }} rounded-xl p-6 bg-{{ $btwAangifte->btw_afdracht > 0 ? 'red' : 'green' }}-400/10 mb-6">
            @if($btwAangifte->btw_afdracht > 0)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Te Betalen aan Belastingdienst</p>
                    <h3 class="text-3xl font-bold text-red-400">€{{ number_format($btwAangifte->btw_afdracht, 2) }}</h3>
                    @if($btwAangifte->late_filing_penalty > 0)
                        <p class="text-sm text-red-300 mt-2">Late boete: €{{ number_format($btwAangifte->late_filing_penalty, 2) }}</p>
                    @endif
                </div>
                <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            @elseif($btwAangifte->btw_terug > 0)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Te Ontvangen van Belastingdienst</p>
                    <h3 class="text-3xl font-bold text-green-400">€{{ number_format($btwAangifte->btw_terug, 2) }}</h3>
                </div>
                <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between gap-4">
            @if($btwAangifte->status === 'concept' && !$btwAangifte->correction_of_id)
            <button wire:click="$set('showCorrectionForm', true)" class="px-6 py-3 bg-purple-500/10 text-purple-400 border border-purple-500/30 rounded-xl font-semibold hover:bg-purple-500/20 transition-all">
                Correctie Maken
            </button>
            @endif
            
            @if($btwAangifte->status === 'concept' && $btwAangifte->is_validated)
            <button wire:click="markAsSubmitted" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all ml-auto">
                Markeren als Ingediend
            </button>
            @endif
        </div>

        <!-- Correction Form -->
        @if($showCorrectionForm)
        <div class="mt-6 p-6 bg-purple-500/10 border border-purple-500/30 rounded-xl">
            <h3 class="text-lg font-bold text-white mb-4">Correctie Aangifte Maken</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Ontdekkingsdatum</label>
                    <input type="date" wire:model="correctionDiscoveredDate" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-purple-400 transition-all">
                    @error('correctionDiscoveredDate') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Reden voor Correctie</label>
                    <textarea wire:model="correctionReason" rows="3" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-purple-400 transition-all" placeholder="Beschrijf waarom deze correctie nodig is..."></textarea>
                    @error('correctionReason') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="createCorrection" class="px-6 py-3 bg-purple-500 hover:bg-purple-600 rounded-xl font-semibold text-white transition-all">
                        Correctie Aanmaken
                    </button>
                    <button wire:click="$set('showCorrectionForm', false)" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-xl font-semibold text-gray-300 transition-all">
                        Annuleren
                    </button>
                </div>
            </div>
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
                        @if($aangifte->correction_of_id)
                            <span class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded text-xs font-semibold">
                                Correctie
                            </span>
                        @endif
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $aangifte->status === 'ingediend' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ ucfirst($aangifte->status) }}
                        </span>
                        @if($aangifte->is_overdue)
                            <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded text-xs font-semibold">
                                Achterstallig
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-6 mt-2 text-sm text-gray-500">
                        <span>Ontvangen: €{{ number_format($aangifte->ontvangen_btw, 2) }}</span>
                        <span>Betaald: €{{ number_format($aangifte->betaalde_btw, 2) }}</span>
                        @if($aangifte->deadline)
                            <span>Deadline: {{ $aangifte->deadline->format('d M Y') }}</span>
                        @endif
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
