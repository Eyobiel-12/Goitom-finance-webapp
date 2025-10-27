<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">
                        BTW Aftrek
                    </h1>
                    <p class="text-gray-400 text-lg mt-2">Beheer uw BTW-aangifte en aftrekposten</p>
                </div>
                <a href="{{ route('app.btw-aftrek.create') }}" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nieuwe Aftrekpost
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-400">Totaal Aftrek</p>
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white">
                        €{{ number_format(\App\Models\BtwAftrek::forOrganization(auth()->user()->organization_id)->sum('btw_bedrag'), 2) }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-2">Alle aftrekposten bij elkaar</p>
                </div>

                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-400">Aantal Posten</p>
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white">
                        {{ \App\Models\BtwAftrek::forOrganization(auth()->user()->organization_id)->count() }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-2">Totaal aantal aftrekposten</p>
                </div>

                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-400">Dit Jaar</p>
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white">
                        €{{ number_format(\App\Models\BtwAftrek::forOrganization(auth()->user()->organization_id)->whereYear('datum', now()->year)->sum('btw_bedrag'), 2) }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-2">BTW aftrek {{ now()->year }}</p>
                </div>
            </div>

            <!-- BTW Aftrek Items -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                <h2 class="text-2xl font-bold text-white mb-6">BTW Aftrekposten</h2>
                
                <div class="space-y-3">
                    @forelse(\App\Models\BtwAftrek::forOrganization(auth()->user()->organization_id)->orderBy('datum', 'desc')->get() as $aftrek)
                    <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-gray-700/50 hover:border-yellow-400/30 transition-all">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-1">
                                <h3 class="font-bold text-white">{{ $aftrek->naam }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $aftrek->status === 'goedgekeurd' ? 'bg-green-500/20 text-green-400' : ($aftrek->status === 'ingediend' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-gray-500/20 text-gray-400') }}">
                                    {{ ucfirst($aftrek->status) }}
                                </span>
                            </div>
                            @if($aftrek->beschrijving)
                            <p class="text-sm text-gray-400">{{ $aftrek->beschrijving }}</p>
                            @endif
                            <div class="flex items-center space-x-6 mt-2 text-sm text-gray-500">
                                <span>{{ $aftrek->datum->format('d M Y') }}</span>
                                <span>{{ $aftrek->categorie }}</span>
                                <span>BTW: {{ $aftrek->btw_percentage }}%</span>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-xl font-bold text-yellow-400">€{{ number_format($aftrek->btw_bedrag, 2) }}</p>
                            <p class="text-sm text-gray-400">€{{ number_format($aftrek->totaal_bedrag, 2) }} totaal</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-400 mb-4">Nog geen BTW aftrekposten</p>
                        <a href="{{ route('app.btw-aftrek.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900">
                            Eerste aftrekpost toevoegen
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

