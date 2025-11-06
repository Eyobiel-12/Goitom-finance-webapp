<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Klanten</h1>
                    <p class="mt-2 text-gray-400 text-lg">Beheer je klanten en hun gegevens</p>
                </div>
                <a href="{{ route('app.clients.create') }}" class="group relative px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300 hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nieuwe Klant
                </a>
            </div>

            <!-- Search and Filters -->
            <div class="mb-6 flex gap-4 items-center">
                <form method="GET" action="{{ route('app.clients.index') }}" class="flex-1 relative flex gap-4 items-center">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoek klanten..." 
                               class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-xl hover:bg-yellow-400/20 transition-all duration-150 font-semibold">
                        Zoeken
                    </button>
                    @if(request('search'))
                    <a href="{{ route('app.clients.index') }}" class="px-6 py-3 bg-gray-800/50 text-gray-300 border border-gray-700 rounded-xl hover:bg-gray-800 transition-all duration-150 font-semibold">
                        Reset
                    </a>
                    @endif
                </form>
                <div class="flex items-center bg-gray-900 rounded-xl p-1 border border-gray-700">
                    <button onclick="showGridView()" id="gridViewBtn" class="px-4 py-2 bg-gray-800 text-yellow-400 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                        </svg>
                    </button>
                    <button onclick="showListView()" id="listViewBtn" class="px-4 py-2 text-gray-400 rounded-lg hover:bg-gray-800 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Clients Grid -->
            <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($clients as $client)
                <div class="group relative bg-gradient-to-br from-gray-900/60 to-gray-950/60 backdrop-blur-sm rounded-2xl border border-gray-700/50 hover:border-yellow-400/40 transition-all duration-300 hover:shadow-xl hover:shadow-yellow-400/10 overflow-hidden">
                    <!-- Gradient overlay on hover -->
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/0 to-yellow-600/0 group-hover:from-yellow-400/5 group-hover:to-yellow-600/5 transition-all duration-500 pointer-events-none"></div>
                    
                    <div class="relative p-6">
                        <!-- Header: Avatar + Quick Access -->
                        <div class="flex items-start justify-between mb-6">
                            <!-- Avatar -->
                            <div class="relative">
                                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-xl font-bold text-gray-900 shadow-lg group-hover:shadow-yellow-400/30 group-hover:scale-105 transition-all">
                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                </div>
                                @if($client->invoices_count > 0)
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-yellow-500 border-2 border-gray-900 rounded-full flex items-center justify-center text-[10px] font-bold text-gray-900">
                                        {{ $client->invoices_count }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Status Badge -->
                            <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-semibold">
                                Actief
                            </span>
                        </div>

                        <!-- Client Name -->
                        <a href="{{ route('app.clients.show', $client) }}" 
                           class="block mb-4 group/name">
                            <h3 class="text-lg font-bold text-white group-hover/name:text-yellow-400 transition-colors mb-1">
                                {{ $client->name }}
                            </h3>
                            @if($client->contact_name)
                                <p class="text-xs text-gray-500">{{ $client->contact_name }}</p>
                            @endif
                        </a>
                        
                        <!-- Quick Contact Actions -->
                        <div class="space-y-2.5 mb-6">
                            @if($client->email)
                            <a href="mailto:{{ $client->email }}" 
                               class="flex items-center px-3 py-2.5 bg-gray-800/40 rounded-lg hover:bg-blue-500/10 border border-gray-700/50 hover:border-blue-500/30 transition-all group/contact">
                                <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center mr-3 group-hover/contact:bg-blue-500/20 transition-all">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-400 group-hover/contact:text-blue-400 truncate transition-colors">{{ $client->email }}</span>
                            </a>
                            @endif
                            
                            @if($client->phone)
                            <a href="tel:{{ $client->phone }}" 
                               class="flex items-center px-3 py-2.5 bg-gray-800/40 rounded-lg hover:bg-emerald-500/10 border border-gray-700/50 hover:border-emerald-500/30 transition-all group/contact">
                                <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center mr-3 group-hover/contact:bg-emerald-500/20 transition-all">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-400 group-hover/contact:text-emerald-400 transition-colors">{{ $client->phone }}</span>
                            </a>
                            @endif
                        </div>

                        <!-- Stats Row -->
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="text-center p-3 bg-gradient-to-br from-gray-800/50 to-gray-900/50 rounded-lg border border-gray-700/30">
                                <p class="text-2xl font-bold text-white">{{ $client->projects_count }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Projecten</p>
                            </div>
                            <div class="text-center p-3 bg-gradient-to-br from-gray-800/50 to-gray-900/50 rounded-lg border border-gray-700/30">
                                <p class="text-2xl font-bold text-white">{{ $client->invoices_count }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Facturen</p>
                            </div>
                        </div>

                        <!-- Smart Quick Actions (Hidden by default, slides in on hover) -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-gray-950 via-gray-900/95 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <div class="flex items-center justify-center gap-2">
                                @if($client->email)
                                <a href="mailto:{{ $client->email }}" 
                                   title="Email verzenden"
                                   class="flex-1 flex items-center justify-center h-11 bg-blue-500/10 border border-blue-500/30 rounded-lg hover:bg-blue-500/20 hover:scale-105 transition-all group/action">
                                    <svg class="w-5 h-5 text-blue-400 group-hover/action:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                                @endif
                                
                                @if($client->phone)
                                <a href="tel:{{ $client->phone }}" 
                                   title="Bellen"
                                   class="flex-1 flex items-center justify-center h-11 bg-emerald-500/10 border border-emerald-500/30 rounded-lg hover:bg-emerald-500/20 hover:scale-105 transition-all group/action">
                                    <svg class="w-5 h-5 text-emerald-400 group-hover/action:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                                @endif
                                
                                <a href="{{ route('app.invoices.create', ['client_id' => $client->id]) }}" 
                                   title="Nieuwe factuur maken"
                                   class="flex-1 flex items-center justify-center h-11 bg-yellow-500/10 border border-yellow-500/30 rounded-lg hover:bg-yellow-500/20 hover:scale-105 transition-all group/action">
                                    <svg class="w-5 h-5 text-yellow-400 group-hover/action:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('app.clients.edit', $client) }}" 
                                   title="Bewerken"
                                   class="flex-1 flex items-center justify-center h-11 bg-gray-500/10 border border-gray-500/30 rounded-lg hover:bg-gray-500/20 hover:scale-105 transition-all group/action">
                                    <svg class="w-5 h-5 text-gray-400 group-hover/action:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-400 mb-2">Geen klanten</h3>
                        <p class="text-gray-600">Begin met het toevoegen van je eerste klant!</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Clients List View -->
            <div id="listView" class="hidden space-y-4">
                @forelse($clients as $client)
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 hover:border-yellow-400/30 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6 flex-1">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center text-2xl font-bold text-gray-900 shadow-lg">
                                {{ strtoupper(substr($client->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $client->name }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-400 mt-1">
                                    @if($client->email)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $client->email }}
                                    </span>
                                    @endif
                                    @if($client->phone)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $client->phone }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Projecten</p>
                                    <p class="text-lg font-bold text-white">{{ $client->projects_count }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Facturen</p>
                                    <p class="text-lg font-bold text-white">{{ $client->invoices_count }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('app.clients.show', $client) }}" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all text-sm font-medium">
                                    Bekijken
                                </a>
                                <a href="{{ route('app.clients.edit', $client) }}" class="px-4 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Geen klanten</h3>
                    <p class="text-gray-600">Begin met het toevoegen van je eerste klant!</p>
                </div>
                @endforelse
            </div>
            
            @if($clients->hasPages())
            <div class="mt-8 px-6 py-4 border-t border-gray-800/50 bg-gray-800/20 rounded-xl">
                {{ $clients->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
        function showGridView() {
            document.getElementById('gridView').classList.remove('hidden');
            document.getElementById('listView').classList.add('hidden');
            document.getElementById('gridViewBtn').classList.add('bg-gray-800', 'text-yellow-400');
            document.getElementById('gridViewBtn').classList.remove('text-gray-400');
            document.getElementById('listViewBtn').classList.remove('bg-gray-800', 'text-yellow-400');
            document.getElementById('listViewBtn').classList.add('text-gray-400');
        }
        
        function showListView() {
            document.getElementById('gridView').classList.add('hidden');
            document.getElementById('listView').classList.remove('hidden');
            document.getElementById('listViewBtn').classList.add('bg-gray-800', 'text-yellow-400');
            document.getElementById('listViewBtn').classList.remove('text-gray-400');
            document.getElementById('gridViewBtn').classList.remove('bg-gray-800', 'text-yellow-400');
            document.getElementById('gridViewBtn').classList.add('text-gray-400');
        }
    </script>
</x-layouts.app>