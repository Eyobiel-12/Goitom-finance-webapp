<x-layouts.app>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('app.clients.index') }}" 
                   class="inline-flex items-center text-sm text-gray-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Klanten
                </a>
            </div>

            <!-- Modern Header -->
            <div class="flex items-start justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-2xl font-bold text-gray-900 shadow-lg">
                        {{ strtoupper(substr($client->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-white">{{ $client->name }}</h1>
                            <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 rounded-md text-xs font-medium border border-emerald-500/20">
                                Actief
                            </span>
                        </div>
                        @if($client->contact_name)
                            <p class="text-gray-400 text-sm mb-2">{{ $client->contact_name }}</p>
                        @endif
                        <div class="flex items-center gap-3 text-sm">
                            @if($client->email)
                            <a href="mailto:{{ $client->email }}" class="text-blue-400 hover:text-blue-300 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $client->email }}
                            </a>
                            @endif
                            @if($client->phone)
                            <a href="tel:{{ $client->phone }}" class="text-emerald-400 hover:text-emerald-300 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $client->phone }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('app.invoices.create', ['client_id' => $client->id]) }}" 
                       class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg transition-all font-semibold text-sm">
                        + Nieuwe Factuur
                    </a>
                    <a href="{{ route('app.clients.edit', $client) }}" 
                       class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg transition-all text-sm border border-gray-700">
                        Bewerken
                    </a>
                </div>
            </div>

            <!-- Enhanced Stats Bar - Interactive Horizontal Row -->
            <div class="relative bg-gradient-to-r from-gray-900/60 via-gray-900/50 to-gray-900/40 backdrop-blur-xl rounded-2xl border border-gray-800/80 overflow-hidden mb-8 shadow-xl">
                <!-- Animated gradient background -->
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/5 via-transparent to-emerald-400/5 opacity-50"></div>
                
                <div class="relative p-6">
                    <div class="flex items-stretch divide-x divide-gray-800/50">
                        <!-- Stat 1 - Revenue -->
                        <div class="group relative flex-1 px-6 first:pl-0 last:pr-0">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-emerald-500/20">
                                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-emerald-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Totale Omzet</p>
                                    <p class="text-3xl font-bold bg-gradient-to-br from-emerald-400 to-emerald-500 bg-clip-text text-transparent counting-stat" data-value="{{ $client->invoices->where('status', 'paid')->sum('total') }}">
                                        €0
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $client->invoices->where('status', 'paid')->count() }} betaald</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400/0 via-emerald-400/50 to-emerald-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                        
                        <!-- Stat 2 - Projects -->
                        <div class="group relative flex-1 px-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-blue-500/20">
                                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-blue-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Projecten</p>
                                    <p class="text-3xl font-bold bg-gradient-to-br from-blue-400 to-blue-500 bg-clip-text text-transparent counting-stat" data-value="{{ $client->projects->count() }}">
                                        0
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $client->projects->where('status', 'active')->count() }} actief</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400/0 via-blue-400/50 to-blue-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                        
                        <!-- Stat 3 - Invoices -->
                        <div class="group relative flex-1 px-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500/20 to-yellow-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-yellow-500/20">
                                        <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-yellow-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Facturen</p>
                                    <p class="text-3xl font-bold bg-gradient-to-br from-yellow-400 to-yellow-500 bg-clip-text text-transparent counting-stat" data-value="{{ $client->invoices->count() }}">
                                        0
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $client->invoices->where('status', 'sent')->count() }} openstaand</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400/0 via-yellow-400/50 to-yellow-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                        
                        <!-- Stat 4 - Outstanding -->
                        <div class="group relative flex-1 px-6 last:pr-0">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500/20 to-orange-600/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-orange-500/20">
                                        <svg class="w-7 h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 bg-orange-400/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-300 -z-10"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Openstaand</p>
                                    <p class="text-3xl font-bold bg-gradient-to-br from-orange-400 to-orange-500 bg-clip-text text-transparent counting-stat" data-value="{{ $client->invoices->whereIn('status', ['sent', 'overdue'])->sum('total') }}">
                                        €0
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $client->invoices->where('status', 'overdue')->count() }} achterstallig</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-400/0 via-orange-400/50 to-orange-400/0 scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Tabs -->
            <div class="mb-6" x-data="{ tab: 'invoices' }">
                <!-- Modern Tab Navigation -->
                <div class="flex items-center gap-3 mb-6">
                    <button @click="tab = 'invoices'" 
                            :class="tab === 'invoices' ? 'bg-yellow-400 text-gray-900 shadow-lg shadow-yellow-400/30' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-gray-300'"
                            class="px-5 py-2.5 rounded-lg font-semibold text-sm transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Facturen
                        <span :class="tab === 'invoices' ? 'bg-gray-900/30 text-gray-900' : 'bg-gray-700 text-gray-400'" class="px-2 py-0.5 rounded-md text-xs font-bold">{{ $client->invoices->count() }}</span>
                    </button>
                    <button @click="tab = 'projects'" 
                            :class="tab === 'projects' ? 'bg-blue-400 text-white shadow-lg shadow-blue-400/30' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-gray-300'"
                            class="px-5 py-2.5 rounded-lg font-semibold text-sm transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Projecten
                        <span :class="tab === 'projects' ? 'bg-white/20 text-white' : 'bg-gray-700 text-gray-400'" class="px-2 py-0.5 rounded-md text-xs font-bold">{{ $client->projects->count() }}</span>
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
                    <!-- Invoices Tab -->
                    <div x-show="tab === 'invoices'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        @if($client->invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($client->invoices as $invoice)
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
                                                <p class="text-sm text-gray-300 font-medium">{{ $invoice->due_date->format('d M Y') }}</p>
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
                            <p class="text-gray-400 mb-4 font-medium">Nog geen facturen voor deze klant</p>
                            <a href="{{ route('app.invoices.create', ['client_id' => $client->id]) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg font-bold text-sm transition-all hover:scale-105 shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Eerste Factuur Maken
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Projects Tab -->
                    <div x-show="tab === 'projects'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        @if($client->projects->count() > 0)
                        <div class="space-y-3">
                            @foreach($client->projects as $project)
                            <div class="group relative bg-gradient-to-r from-gray-900/40 to-gray-900/20 backdrop-blur-sm hover:from-gray-900/60 hover:to-gray-900/40 rounded-xl border border-gray-800/50 hover:border-blue-400/30 transition-all duration-300 overflow-hidden">
                                <!-- Hover gradient -->
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/0 to-blue-400/0 group-hover:from-blue-400/5 group-hover:to-transparent transition-all duration-500"></div>
                                
                                <div class="relative p-5">
                                    <div class="flex items-center justify-between">
                                        <!-- Left: Project Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center border border-blue-500/20">
                                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-base font-bold text-white group-hover:text-blue-400 transition-colors">{{ $project->name }}</h3>
                                                @php
                                                    $projectStatusColor = match($project->status) {
                                                        'active' => 'emerald',
                                                        'completed' => 'blue',
                                                        'on_hold' => 'orange',
                                                        default => 'gray'
                                                    };
                                                @endphp
                                                <span class="px-2.5 py-1 bg-{{ $projectStatusColor }}-500/10 text-{{ $projectStatusColor }}-400 rounded-lg text-xs font-semibold border border-{{ $projectStatusColor }}-500/20">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </div>
                                            @if($project->description)
                                                <p class="text-sm text-gray-400 mb-3 ml-13">{{ Str::limit($project->description, 120) }}</p>
                                            @endif
                                            <div class="flex items-center gap-6 text-sm ml-13">
                                                <span class="text-gray-500">⏱️ {{ $project->hours }} uren</span>
                                                @if($project->rate)
                                                    <span class="text-gray-500">💶 €{{ number_format($project->rate, 2) }}/uur</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Right: Value & Action -->
                                        <div class="flex items-center gap-4">
                                            @if($project->rate)
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500 mb-0.5">Totale Waarde</p>
                                                <p class="text-xl font-bold text-blue-400">€{{ number_format($project->rate * $project->hours, 2) }}</p>
                                            </div>
                                            @endif
                                            <a href="{{ route('app.projects.show', $project) }}" 
                                               class="p-2 bg-gray-800/50 hover:bg-blue-400/10 text-gray-400 hover:text-blue-400 rounded-lg border border-gray-700 hover:border-blue-400/30 transition-all">
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
                            <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 mb-4 font-medium">Nog geen projecten voor deze klant</p>
                            <a href="{{ route('app.projects.create') }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-blue-400 hover:bg-blue-500 text-white rounded-lg font-bold text-sm transition-all hover:scale-105 shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Eerste Project Maken
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Details Tab -->
                    <div x-show="tab === 'details'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Contact Card -->
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Contact</h3>
                                </div>
                                <div class="space-y-3 text-sm">
                                    @if($client->email)
                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">Email</p>
                                        <a href="mailto:{{ $client->email }}" class="text-blue-400 hover:text-blue-300">{{ $client->email }}</a>
                                    </div>
                                    @endif
                                    @if($client->phone)
                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">Telefoon</p>
                                        <a href="tel:{{ $client->phone }}" class="text-emerald-400 hover:text-emerald-300">{{ $client->phone }}</a>
                                    </div>
                                    @endif
                                    @if($client->contact_name)
                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">Contactpersoon</p>
                                        <p class="text-white">{{ $client->contact_name }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Address Card -->
                            @if($client->address && !empty(array_filter($client->address)))
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Adres</h3>
                                </div>
                                <div class="text-sm text-gray-300 leading-relaxed">
                                    @if(isset($client->address['street']))<p>{{ $client->address['street'] }}</p>@endif
                                    <p>
                                        @if(isset($client->address['postal_code'])){{ $client->address['postal_code'] }}@endif
                                        @if(isset($client->address['city'])) {{ $client->address['city'] }}@endif
                                    </p>
                                    @if(isset($client->address['country']))<p class="text-yellow-400 mt-1">{{ $client->address['country'] }}</p>@endif
                                </div>
                            </div>
                            @endif

                            <!-- Registration Card -->
                            @if($client->tax_id || $client->kvk_number)
                            <div class="bg-gradient-to-br from-gray-900/40 to-gray-900/20 backdrop-blur-sm rounded-xl p-6 border border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Registratie</h3>
                                </div>
                                <div class="space-y-3 text-sm">
                                    @if($client->kvk_number)
                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">KVK-nummer</p>
                                        <p class="text-white font-mono">{{ $client->kvk_number }}</p>
                                    </div>
                                    @endif
                                    @if($client->tax_id)
                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">BTW-nummer</p>
                                        <p class="text-white font-mono">{{ $client->tax_id }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</x-layouts.app>
