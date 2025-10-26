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
                <div class="flex-1 relative">
                    <input type="text" placeholder="Zoek klanten..." 
                           class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select class="px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white focus:outline-none focus:border-yellow-400 transition-all">
                    <option>Alle klanten</option>
                    <option>Actieve klanten</option>
                    <option>Inactieve klanten</option>
                </select>
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
                @forelse(\App\Models\Client::where('organization_id', auth()->user()->organization_id)->latest()->get() as $client)
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 hover:border-yellow-400/30 transition-all duration-300 hover:shadow-2xl hover:shadow-yellow-400/10 hover:-translate-y-1">
                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    
                    <div class="relative">
                        <!-- Avatar and Status -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center text-2xl font-bold text-gray-900 shadow-lg">
                                {{ strtoupper(substr($client->name, 0, 1)) }}
                            </div>
                            <span class="px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-semibold">
                                Actief
                            </span>
                        </div>

                        <!-- Client Info -->
                        <h3 class="text-xl font-bold text-white mb-1">{{ $client->name }}</h3>
                        @if($client->email)
                        <p class="text-gray-400 text-sm mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $client->email }}
                        </p>
                        @endif
                        @if($client->phone)
                        <p class="text-gray-400 text-sm mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $client->phone }}
                        </p>
                        @endif

                        <!-- Stats -->
                        <div class="flex gap-4 mt-4 pt-4 border-t border-gray-800">
                            <div>
                                <p class="text-xs text-gray-500">Projecten</p>
                                <p class="text-lg font-bold text-white">{{ $client->projects->count() }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Facturen</p>
                                <p class="text-lg font-bold text-white">{{ $client->invoices->count() }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('app.clients.show', $client) }}" class="flex-1 px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all text-sm font-medium text-center">
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
                @forelse(\App\Models\Client::where('organization_id', auth()->user()->organization_id)->latest()->get() as $client)
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
                                    <p class="text-lg font-bold text-white">{{ $client->projects->count() }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Facturen</p>
                                    <p class="text-lg font-bold text-white">{{ $client->invoices->count() }}</p>
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