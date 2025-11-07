@extends('admin.layout')

@section('title', 'Geavanceerde Statistieken')

@section('content')
<div class="space-y-6">
    <!-- Monthly Organizations Chart -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-white">Organisaties per Maand</h3>
            <span class="text-sm text-gray-400">Laatste 6 maanden</span>
        </div>
        <div class="h-64 flex items-end justify-between space-x-3">
            @foreach($stats['monthly_organizations'] as $index => $data)
            <div class="flex-1 flex flex-col items-center group animate-slide-in" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="w-full bg-gradient-to-t from-blue-500 via-blue-500 to-blue-600 rounded-t-xl mb-3 shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-all duration-300 group-hover:scale-105" 
                     style="height: {{ max(10, ($data['count'] / max(1, $stats['monthly_organizations']->max('count'))) * 100) }}%">
                </div>
                <p class="text-xs text-gray-400 text-center font-semibold">{{ $data['month'] }}</p>
                <p class="text-sm font-bold text-white mt-1 bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">{{ $data['count'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in" style="animation-delay: 0.1s">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-white">Omzet per Maand</h3>
            <span class="text-sm text-gray-400">Laatste 6 maanden</span>
        </div>
        <div class="h-64 flex items-end justify-between space-x-3">
            @php
                $maxRevenue = max(1, $stats['monthly_revenue']->max('revenue'));
            @endphp
            @foreach($stats['monthly_revenue'] as $index => $data)
            <div class="flex-1 flex flex-col items-center group animate-slide-in" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="w-full bg-gradient-to-t from-green-500 via-green-500 to-green-600 rounded-t-xl mb-3 shadow-lg shadow-green-500/30 group-hover:shadow-green-500/50 transition-all duration-300 group-hover:scale-105" 
                     style="height: {{ max(10, ($data['revenue'] / $maxRevenue) * 100) }}%">
                </div>
                <p class="text-xs text-gray-400 text-center font-semibold">{{ $data['month'] }}</p>
                <p class="text-sm font-bold text-white mt-1 bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">€{{ number_format($data['revenue'], 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Subscription Distribution -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.2s">
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-6">Abonnement Distributie</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-gray-700 rounded-full"></div>
                        <span class="text-gray-400 font-semibold">Starter</span>
                    </div>
                    <span class="text-white font-bold text-lg">{{ $stats['subscription_distribution']['starter'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span class="text-gray-400 font-semibold">Pro</span>
                    </div>
                    <span class="text-white font-bold text-lg bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">{{ $stats['subscription_distribution']['pro'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-gray-400 font-semibold">Trial</span>
                    </div>
                    <span class="text-white font-bold text-lg">{{ $stats['subscription_distribution']['trial'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-400 font-semibold">Actief</span>
                    </div>
                    <span class="text-white font-bold text-lg bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">{{ $stats['subscription_distribution']['active'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                        <span class="text-gray-400 font-semibold">Past Due</span>
                    </div>
                    <span class="text-white font-bold text-lg">{{ $stats['subscription_distribution']['past_due'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/30 border border-gray-700/50 hover:border-gray-600 transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-gray-400 font-semibold">Geblokkeerd</span>
                    </div>
                    <span class="text-white font-bold text-lg">{{ $stats['subscription_distribution']['suspended'] }}</span>
                </div>
            </div>
        </div>

        <!-- Pie Chart Placeholder -->
        <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl md:col-span-2">
            <h3 class="text-lg font-bold text-white mb-6">Plan Distributie</h3>
            <div class="flex items-center justify-center h-64">
                <div class="text-center">
                    <div class="flex items-center justify-center space-x-6 mb-6">
                        <div class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-gray-800/30 border border-gray-700/50">
                            <div class="w-4 h-4 bg-gray-700 rounded-full"></div>
                            <span class="text-gray-300 font-semibold">Starter: {{ $stats['subscription_distribution']['starter'] }}</span>
                        </div>
                        <div class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-gray-800/30 border border-gray-700/50">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                            <span class="text-gray-300 font-semibold">Pro: {{ $stats['subscription_distribution']['pro'] }}</span>
                        </div>
                    </div>
                    @php
                        $total = $stats['subscription_distribution']['starter'] + $stats['subscription_distribution']['pro'];
                        $starterPercent = $total > 0 ? round(($stats['subscription_distribution']['starter'] / $total) * 100) : 0;
                        $proPercent = $total > 0 ? round(($stats['subscription_distribution']['pro'] / $total) * 100) : 0;
                    @endphp
                    <div class="relative w-40 h-40 mx-auto">
                        <div class="w-40 h-40 rounded-full border-8 border-gray-700 relative shadow-2xl" 
                             style="background: conic-gradient(from 0deg, #6b7280 {{ $starterPercent * 3.6 }}deg, #eab308 {{ $starterPercent * 3.6 }}deg {{ ($starterPercent + $proPercent) * 3.6 }}deg, #6b7280 {{ ($starterPercent + $proPercent) * 3.6 }}deg);">
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-white">{{ $total }}</p>
                                <p class="text-xs text-gray-400">Totaal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

