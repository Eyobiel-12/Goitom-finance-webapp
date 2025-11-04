<x-layouts.app>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('app.projects.index') }}" 
                   class="inline-flex items-center text-sm text-gray-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Projecten
                </a>
            </div>

            <!-- Modern Header -->
            <div class="flex items-start justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-2xl font-bold text-white shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-white">{{ $project->name }}</h1>
                            @php
                                $projectStatusColor = match($project->status) {
                                    'active' => 'emerald',
                                    'completed' => 'blue',
                                    'on_hold' => 'orange',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="px-2 py-1 bg-{{ $projectStatusColor }}-500/10 text-{{ $projectStatusColor }}-400 rounded-md text-xs font-medium border border-{{ $projectStatusColor }}-500/20">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        <p class="text-gray-400 text-sm mb-2">{{ $project->client->name }}</p>
                        <a href="{{ route('app.clients.show', $project->client) }}" class="text-blue-400 hover:text-blue-300 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Bekijk Klant
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('app.projects.edit', $project) }}" 
                       class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg transition-all text-sm border border-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Bewerken
                    </a>
                </div>
            </div>

            <!-- Enhanced Stats Bar - Interactive Horizontal Row -->
            <div class="relative bg-gradient-to-r from-gray-900/60 via-gray-900/50 to-gray-900/40 backdrop-blur-xl rounded-2xl border border-gray-800/80 overflow-hidden mb-8 shadow-xl">
                <!-- Animated gradient background -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/5 via-transparent to-yellow-400/5 opacity-25"></div>
                
                <div class="relative p-6">
                    <div class="flex items-stretch divide-x divide-gray-800/30">
                        <!-- Stat 1 - Total Value -->
                        <div class="group relative flex-1 px-6 first:pl-0 last:pr-0">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500/20 to-yellow-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-yellow-500/20">
                                        <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-yellow-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-300 mb-1 uppercase tracking-wider">Projectwaarde</p>
                                    <p class="text-3xl font-bold bg-gradient-to-br from-yellow-400 to-yellow-500 bg-clip-text text-transparent counting-stat drop-shadow" data-value="{{ $project->rate ? ($project->rate * $project->hours) : 0 }}">
                                        €0
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $project->hours }} uren × €{{ $project->rate ? number_format($project->rate, 2) : '0.00' }}</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400/0 via-yellow-400/50 to-yellow-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                        
                        <!-- Stat 2 - Hours -->
                        <div class="group relative flex-1 px-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-blue-500/20">
                                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-blue-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-300 mb-1 uppercase tracking-wider">Geregistreerde Uren</p>
                                    <p class="text-3xl font-extrabold text-blue-300 counting-stat drop-shadow-md" data-value="{{ $project->hours }}">
                                        {{ $project->hours }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">Totaal gewerkt</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400/0 via-blue-400/50 to-blue-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                        
                        <!-- Stat 3 - Rate -->
                        <div class="group relative flex-1 px-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-emerald-500/20">
                                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-emerald-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-300 mb-1 uppercase tracking-wider">Uurtarief</p>
                                    <p class="text-3xl font-bold bg-gradient-to-br from-emerald-400 to-emerald-500 bg-clip-text text-transparent drop-shadow">
                                        €{{ $project->rate ? number_format($project->rate, 2) : '0.00' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">Per uur</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400/0 via-emerald-400/50 to-emerald-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                        
                        <!-- Stat 4 - Invoices -->
                        <div class="group relative flex-1 px-6 last:pr-0">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-purple-500/20">
                                        <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-purple-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-300 mb-1 uppercase tracking-wider">Facturen</p>
                                    <p class="text-3xl font-extrabold text-purple-300 counting-stat drop-shadow-md" data-value="{{ $project->invoices->count() }}">
                                        0
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $project->invoices->where('status', 'paid')->count() }} betaald</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-400/0 via-purple-400/50 to-purple-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Tabs -->
            <div class="mb-6" x-data="{ tab: 'overview' }">
                <!-- Modern Tab Navigation -->
                <div class="flex items-center gap-3 mb-6">
                    <button @click="tab = 'overview'" 
                            :class="tab === 'overview' ? 'bg-blue-400 text-white shadow-lg shadow-blue-400/30' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-gray-300'"
                            class="px-5 py-2.5 rounded-lg font-semibold text-sm transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Overzicht
                    </button>
                    <button @click="tab = 'invoices'" 
                            :class="tab === 'invoices' ? 'bg-yellow-400 text-gray-900 shadow-lg shadow-yellow-400/30' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-gray-300'"
                            class="px-5 py-2.5 rounded-lg font-semibold text-sm transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Facturen
                        <span :class="tab === 'invoices' ? 'bg-gray-900/30 text-gray-900' : 'bg-gray-700 text-gray-400'" class="px-2 py-0.5 rounded-md text-xs font-bold">{{ $project->invoices->count() }}</span>
                    </button>
                    <button @click="tab = 'details'" 
                            :class="tab === 'details' ? 'bg-purple-400 text-white shadow-lg shadow-purple-400/30' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-gray-300'"
                            class="px-5 py-2.5 rounded-lg font-semibold text-sm transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Details
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="mt-6">
                    <!-- Overview Tab -->
                    <div x-show="tab === 'overview'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Project Info Card -->
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Project Info</h3>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <span class="px-3 py-1 bg-{{ $projectStatusColor }}-500/10 text-{{ $projectStatusColor }}-400 rounded-lg text-xs font-semibold border border-{{ $projectStatusColor }}-500/20 inline-block">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Klant</p>
                                        <a href="{{ route('app.clients.show', $project->client) }}" class="text-white font-semibold hover:text-blue-400 transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            {{ $project->client->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Info Card -->
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Financiële Info</h3>
                                </div>
                                <div class="space-y-4">
                                    @if($project->rate)
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Uurtarief</p>
                                        <p class="text-lg font-bold text-yellow-400">€{{ number_format($project->rate, 2) }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Geregistreerde Uren</p>
                                        <p class="text-lg font-bold text-white">{{ $project->hours }}</p>
                                    </div>
                                    @if($project->rate)
                                    <div class="pt-3 border-t border-gray-800">
                                        <p class="text-xs text-gray-500 mb-1">Totaal Projectwaarde</p>
                                        <p class="text-2xl font-bold text-yellow-400">€{{ number_format($project->rate * $project->hours, 2) }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Description Card -->
                            @if($project->description)
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50 md:col-span-2">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Omschrijving</h3>
                                </div>
                                <p class="text-gray-300 leading-relaxed">{{ $project->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Invoices Tab -->
                    <div x-show="tab === 'invoices'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-white">Facturen</h2>
                            <a href="{{ route('app.invoices.create', ['project_id' => $project->id]) }}" 
                               class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg font-bold text-sm transition-all hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nieuwe Factuur
                            </a>
                        </div>
                        
                        @if($project->invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->invoices as $invoice)
                            <div class="group relative bg-gradient-to-r from-gray-900/40 to-gray-900/20 backdrop-blur-sm hover:from-gray-900/60 hover:to-gray-900/40 rounded-xl border border-gray-800/50 hover:border-yellow-400/30 transition-all duration-300 overflow-hidden">
                                <!-- Hover gradient -->
                                <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/0 to-yellow-400/0 group-hover:from-yellow-400/5 group-hover:to-transparent transition-all duration-500"></div>
                                
                                <div class="relative p-5">
                                    <div class="flex items-center justify-between">
                                        <!-- Left: Invoice Info -->
                                        <div class="flex items-center gap-6 flex-1">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center border border-yellow-500/20">
                                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-base font-bold text-white group-hover:text-yellow-400 transition-colors">#{{ $invoice->number }}</p>
                                                    <p class="text-xs text-gray-500">{{ $invoice->issue_date->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="h-8 w-px bg-gray-800"></div>
                                            
                                            <div>
                                                <p class="text-xs text-gray-500 mb-0.5">Vervaldatum</p>
                                                <p class="text-sm text-gray-300 font-medium">{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : 'N/A' }}</p>
                                            </div>
                                            
                                            <div class="h-8 w-px bg-gray-800"></div>
                                            
                                            <div>
                                                <p class="text-xs text-gray-500 mb-0.5">Totaal</p>
                                                <p class="text-lg font-bold text-yellow-400">€{{ number_format($invoice->total, 2) }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Right: Status & Action -->
                                        <div class="flex items-center gap-4">
                                            @php
                                                $statusColor = match($invoice->status) {
                                                    'paid' => 'emerald',
                                                    'sent' => 'blue',
                                                    'overdue' => 'red',
                                                    default => 'gray'
                                                };
                                            @endphp
                                            <span class="px-3 py-1.5 bg-{{ $statusColor }}-500/10 text-{{ $statusColor }}-400 rounded-lg text-xs font-semibold border border-{{ $statusColor }}-500/20">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                            <a href="{{ route('app.invoices.show', $invoice) }}" 
                                               class="p-2 bg-gray-800/50 hover:bg-yellow-400/10 text-gray-400 hover:text-yellow-400 rounded-lg border border-gray-700 hover:border-yellow-400/30 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-20 bg-gray-900/30 rounded-xl border border-gray-800/50 border-dashed">
                            <div class="w-16 h-16 bg-yellow-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-yellow-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 mb-4 font-medium">Nog geen facturen voor dit project</p>
                            <a href="{{ route('app.invoices.create', ['project_id' => $project->id]) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg font-bold text-sm transition-all hover:scale-105 shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Eerste Factuur Maken
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Details Tab -->
                    <div x-show="tab === 'details'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Client Info Card -->
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Klant</h3>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Naam</p>
                                        <a href="{{ route('app.clients.show', $project->client) }}" class="text-lg font-bold text-white hover:text-blue-400 transition-colors">
                                            {{ $project->client->name }}
                                        </a>
                                    </div>
                                    @if($project->client->email)
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Email</p>
                                        <a href="mailto:{{ $project->client->email }}" class="text-blue-400 hover:text-blue-300">
                                            {{ $project->client->email }}
                                        </a>
                                    </div>
                                    @endif
                                    @if($project->client->phone)
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Telefoon</p>
                                        <a href="tel:{{ $project->client->phone }}" class="text-emerald-400 hover:text-emerald-300">
                                            {{ $project->client->phone }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Project Stats Card -->
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Statistieken</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="bg-gray-800/50 rounded-lg p-4">
                                        <p class="text-sm text-gray-400 mb-1">Facturen</p>
                                        <p class="text-2xl font-bold text-yellow-400">{{ $project->invoices->count() }}</p>
                                    </div>
                                    <div class="bg-gray-800/50 rounded-lg p-4">
                                        <p class="text-sm text-gray-400 mb-1">Totaal Geregistreerde Uren</p>
                                        <p class="text-2xl font-bold text-blue-400">{{ $project->hours }}h</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    // Counting animation for stats
    document.addEventListener('DOMContentLoaded', function() {
        const countingStats = document.querySelectorAll('.counting-stat');
        countingStats.forEach(el => {
            const target = parseFloat(el.getAttribute('data-value'));
            const isEuro = el.textContent.includes('€');
            const duration = 1500;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    if (isEuro) {
                        el.textContent = '€' + Math.round(target).toLocaleString();
                    } else {
                        el.textContent = Math.round(target).toLocaleString();
                    }
                    clearInterval(timer);
                } else {
                    if (isEuro) {
                        el.textContent = '€' + Math.floor(current).toLocaleString();
                    } else {
                        el.textContent = Math.floor(current).toLocaleString();
                    }
                }
            }, 16);
        });
    });
</script>
