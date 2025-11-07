@extends('admin.layout')

@section('title', 'Systeem Health')

@section('content')
<div class="space-y-6">
    <!-- Health Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in">
        <!-- Database -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-blue-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Database</h3>
                <div class="relative">
                    <div class="w-4 h-4 rounded-full {{ $health['database']['status'] === 'healthy' ? 'bg-green-500' : 'bg-red-500' }} shadow-lg {{ $health['database']['status'] === 'healthy' ? 'shadow-green-500/50' : 'shadow-red-500/50' }}"></div>
                    @if($health['database']['status'] === 'healthy')
                    <div class="absolute inset-0 w-4 h-4 rounded-full bg-green-500 animate-pulse opacity-75"></div>
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Status</span>
                    <span class="text-sm font-semibold {{ $health['database']['status'] === 'healthy' ? 'text-green-400' : 'text-red-400' }}">
                        {{ ucfirst($health['database']['status']) }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Connectie</span>
                    <span class="text-sm font-semibold text-white">{{ $health['database']['connections'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Grootte</span>
                    <span class="text-sm font-semibold text-white">{{ $health['database']['size'] }}</span>
                </div>
            </div>
        </div>

        <!-- Storage -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-purple-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Storage</h3>
                <div class="relative">
                    <div class="w-4 h-4 rounded-full {{ $health['storage']['status'] === 'healthy' ? 'bg-green-500' : 'bg-red-500' }} shadow-lg {{ $health['storage']['status'] === 'healthy' ? 'shadow-green-500/50' : 'shadow-red-500/50' }}"></div>
                    @if($health['storage']['status'] === 'healthy')
                    <div class="absolute inset-0 w-4 h-4 rounded-full bg-green-500 animate-pulse opacity-75"></div>
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Status</span>
                    <span class="text-sm font-semibold {{ $health['storage']['status'] === 'healthy' ? 'text-green-400' : 'text-red-400' }}">
                        {{ ucfirst($health['storage']['status']) }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Vrij</span>
                    <span class="text-sm font-semibold text-white">{{ number_format($health['storage']['free_space'] / 1024 / 1024 / 1024, 2) }} GB</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Totaal</span>
                    <span class="text-sm font-semibold text-white">{{ number_format($health['storage']['total_space'] / 1024 / 1024 / 1024, 2) }} GB</span>
                </div>
                @php
                    $usedPercent = (1 - ($health['storage']['free_space'] / $health['storage']['total_space'])) * 100;
                @endphp
                <div class="mt-4">
                    <div class="h-3 bg-gray-800 rounded-full overflow-hidden shadow-inner">
                        <div class="h-full bg-gradient-to-r from-purple-500 via-purple-500 to-purple-600 transition-all duration-500 shadow-lg shadow-purple-500/30" 
                             style="width: {{ $usedPercent }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center font-semibold">{{ number_format($usedPercent, 1) }}% gebruikt</p>
                </div>
            </div>
        </div>

        <!-- Queue -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-orange-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Queue</h3>
                <div class="relative">
                    <div class="w-4 h-4 rounded-full {{ $health['queue']['status'] === 'healthy' ? 'bg-green-500' : 'bg-red-500' }} shadow-lg {{ $health['queue']['status'] === 'healthy' ? 'shadow-green-500/50' : 'shadow-red-500/50' }}"></div>
                    @if($health['queue']['status'] === 'healthy')
                    <div class="absolute inset-0 w-4 h-4 rounded-full bg-green-500 animate-pulse opacity-75"></div>
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Status</span>
                    <span class="text-sm font-semibold {{ $health['queue']['status'] === 'healthy' ? 'text-green-400' : 'text-red-400' }}">
                        {{ ucfirst($health['queue']['status']) }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Pending Jobs</span>
                    <span class="text-sm font-semibold text-white">{{ $health['queue']['pending_jobs'] }}</span>
                </div>
            </div>
        </div>

        <!-- Cache -->
        <div class="stat-card bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl hover:border-cyan-500/30 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Cache</h3>
                <div class="relative">
                    <div class="w-4 h-4 rounded-full {{ $health['cache']['status'] === 'healthy' ? 'bg-green-500' : 'bg-red-500' }} shadow-lg {{ $health['cache']['status'] === 'healthy' ? 'shadow-green-500/50' : 'shadow-red-500/50' }}"></div>
                    @if($health['cache']['status'] === 'healthy')
                    <div class="absolute inset-0 w-4 h-4 rounded-full bg-green-500 animate-pulse opacity-75"></div>
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800/30">
                    <span class="text-sm text-gray-400">Status</span>
                    <span class="text-sm font-semibold {{ $health['cache']['status'] === 'healthy' ? 'text-green-400' : 'text-red-400' }}">
                        {{ ucfirst($health['cache']['status']) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in" style="animation-delay: 0.1s">
        <h3 class="text-xl font-bold text-white mb-6">Systeem Informatie</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                <p class="text-xs text-gray-400 mb-2 font-semibold">PHP Versie</p>
                <p class="text-lg font-bold text-white bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">{{ PHP_VERSION }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                <p class="text-xs text-gray-400 mb-2 font-semibold">Laravel Versie</p>
                <p class="text-lg font-bold text-white bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">{{ app()->version() }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                <p class="text-xs text-gray-400 mb-2 font-semibold">Server Tijd</p>
                <p class="text-lg font-bold text-white">{{ now()->format('d-m-Y H:i:s') }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gradient-to-r from-gray-800/50 to-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                <p class="text-xs text-gray-400 mb-2 font-semibold">Timezone</p>
                <p class="text-lg font-bold text-white">{{ config('app.timezone') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

