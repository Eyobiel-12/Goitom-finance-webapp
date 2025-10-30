<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">
                    BTW Management
                </h1>
                <p class="text-gray-400 text-lg mt-2">Beheer je BTW-aftrek en bekijk je aangifte op één plek</p>
            </div>

            <!-- Split View -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Side: BTW Aftrek -->
                <div>
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-white">BTW Aftrek</h2>
                            <a href="{{ route('app.btw-aftrek.index') }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold">
                                Alles bekijken →
                            </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="bg-gray-800/30 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-gray-400">Totaal Aftrek</p>
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white">
                                    €{{ number_format($aftrekStats['total'], 2, ',', '.') }}
                                </h3>
                            </div>
                            <div class="bg-gray-800/30 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-gray-400">Aantal Posten</p>
                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white">
                                    {{ $aftrekStats['count'] }}
                                </h3>
                            </div>
                        </div>

                        <!-- Recent Items -->
                        <div class="space-y-2">
                            <p class="text-sm font-semibold text-gray-400 mb-3">Recente Aftrekposten</p>
                            @forelse($recentAftrek as $aftrek)
                            <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-xl border border-gray-700/50">
                                <div class="flex-1">
                                    <p class="font-semibold text-white text-sm">{{ $aftrek->naam }}</p>
                                    <p class="text-xs text-gray-400">{{ $aftrek->datum->format('d M Y') }}</p>
                                </div>
                                <p class="text-yellow-400 font-bold">€{{ number_format($aftrek->btw_bedrag, 2) }}</p>
                            </div>
                            @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500 text-sm">Nog geen aftrekposten</p>
                                <a href="{{ route('app.btw-aftrek.create') }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold mt-2 inline-block">
                                    Eerste toevoegen
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Side: BTW Aangifte -->
                <div>
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-white">BTW Aangifte</h2>
                            <a href="{{ route('app.btw-aangifte.index') }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold">
                                Genereren →
                            </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="bg-gray-800/30 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-gray-400">Dit Jaar</p>
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white">
                                    €{{ number_format($aangifteStats['this_year'], 2, ',', '.') }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->year }}</p>
                            </div>
                        </div>

                        <!-- Recent Aangifte -->
                        <div class="space-y-2">
                            <p class="text-sm font-semibold text-gray-400 mb-3">Recente Aangiften</p>
                            @forelse($recentAangifte as $aangifte)
                            <div class="flex items-center justify-between p-3 bg-gray-800/30 rounded-xl border border-gray-700/50">
                                <div class="flex-1">
                                    <p class="font-semibold text-white text-sm">
                                        {{ $aangifte->kwartaal ? 'Q' . $aangifte->kwartaal . ' ' : '' }}{{ $aangifte->jaar }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ ucfirst($aangifte->status) }}</p>
                                </div>
                                @if($aangifte->btw_afdracht > 0)
                                <p class="text-red-400 font-bold">-€{{ number_format($aangifte->btw_afdracht, 2) }}</p>
                                @elseif($aangifte->btw_terug > 0)
                                <p class="text-green-400 font-bold">+€{{ number_format($aangifte->btw_terug, 2) }}</p>
                                @endif
                            </div>
                            @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500 text-sm">Nog geen aangiften</p>
                                <a href="{{ route('app.btw-aangifte.index') }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold mt-2 inline-block">
                                    Eerste genereren
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('app.btw-aftrek.create') }}" class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-yellow-400/20 p-6 hover:border-yellow-400/40 transition-all group">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-white">Nieuwe Aftrekpost</h3>
                    </div>
                    <p class="text-gray-400">Voeg een nieuwe BTW aftrekpost toe</p>
                </a>

                <a href="{{ route('app.btw-aangifte.index') }}" class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-yellow-400/20 p-6 hover:border-yellow-400/40 transition-all group">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-white">BTW Aangifte</h3>
                    </div>
                    <p class="text-gray-400">Bereken en genereer je BTW aangifte</p>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>

