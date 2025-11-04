<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Projecten</h1>
                    <p class="mt-2 text-gray-400 text-lg">Beheer je projecten en taken</p>
                </div>
                <a href="{{ route('app.projects.create') }}" class="group relative px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300 hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nieuw Project
                </a>
            </div>

            <!-- Controls: Tabs, Search, Sort, View Toggle -->
            <div class="mb-6 flex flex-col lg:flex-row lg:items-center gap-4 justify-between">
                <!-- Tabs with counts -->
                <div class="flex gap-2 bg-gray-900/50 rounded-xl p-1 border border-gray-800">
                    @php $activeFilter = request('filter', 'all'); @endphp
                    <a href="{{ route('app.projects.index', array_filter(['filter' => 'all', 'search' => request('search'), 'sort' => request('sort')])) }}" 
                       class="px-4 py-2 text-sm font-semibold rounded-lg {{ $activeFilter === 'all' ? 'bg-yellow-400 text-gray-900' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        Alle <span class="ml-1 text-xs {{ $activeFilter==='all' ? 'text-gray-900' : 'text-gray-500' }}">({{ $counts['all'] ?? 0 }})</span>
                    </a>
                    <a href="{{ route('app.projects.index', array_filter(['filter' => 'active', 'search' => request('search'), 'sort' => request('sort')])) }}" 
                       class="px-4 py-2 text-sm font-semibold rounded-lg {{ $activeFilter === 'active' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        Actief <span class="ml-1 text-xs {{ $activeFilter==='active' ? 'text-emerald-300' : 'text-gray-500' }}">({{ $counts['active'] ?? 0 }})</span>
                    </a>
                    <a href="{{ route('app.projects.index', array_filter(['filter' => 'completed', 'search' => request('search'), 'sort' => request('sort')])) }}" 
                       class="px-4 py-2 text-sm font-semibold rounded-lg {{ $activeFilter === 'completed' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        Voltooid <span class="ml-1 text-xs {{ $activeFilter==='completed' ? 'text-blue-300' : 'text-gray-500' }}">({{ $counts['completed'] ?? 0 }})</span>
                    </a>
                    <a href="{{ route('app.projects.index', array_filter(['filter' => 'paused', 'search' => request('search'), 'sort' => request('sort')])) }}" 
                       class="px-4 py-2 text-sm font-semibold rounded-lg {{ $activeFilter === 'paused' ? 'bg-orange-500/20 text-orange-300 border border-orange-500/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        Gepauzeerd <span class="ml-1 text-xs {{ $activeFilter==='paused' ? 'text-orange-300' : 'text-gray-500' }}">({{ $counts['paused'] ?? 0 }})</span>
                    </a>
                </div>

                <!-- Search + Sort + View toggle -->
                <form method="GET" action="{{ route('app.projects.index') }}" class="w-full lg:w-auto flex items-center gap-3">
                    <input type="hidden" name="filter" value="{{ request('filter', 'all') }}">
                    <div class="flex-1 lg:flex-none">
                        <div class="relative">
                            <input name="search" value="{{ request('search') }}" placeholder="Zoek op project of klant..." 
                                   class="w-full lg:w-72 bg-gray-900 border border-gray-700 rounded-xl pl-9 pr-3 py-2.5 text-sm text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400/40 focus:border-yellow-400/30" />
                            <svg class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </div>
                    </div>
                    <select name="sort" onchange="this.form.submit()" class="bg-gray-900 border border-gray-700 rounded-xl text-sm text-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400/40">
                        <option value="" {{ (request('sort')===''||request('sort')===null) ? 'selected' : '' }}>Nieuwste</option>
                        <option value="name_asc" {{ request('sort')==='name_asc' ? 'selected' : '' }}>Naam A-Z</option>
                        <option value="name_desc" {{ request('sort')==='name_desc' ? 'selected' : '' }}>Naam Z-A</option>
                        <option value="hours_desc" {{ request('sort')==='hours_desc' ? 'selected' : '' }}>Meeste uren</option>
                        <option value="rate_desc" {{ request('sort')==='rate_desc' ? 'selected' : '' }}>Hoogste tarief</option>
                        <option value="oldest" {{ request('sort')==='oldest' ? 'selected' : '' }}>Oudste</option>
                    </select>
                    <div class="flex items-center bg-gray-900 rounded-xl p-1 border border-gray-700">
                        <button type="button" onclick="showGridView()" id="gridViewBtn" class="px-3 py-2 bg-gray-800 text-yellow-400 rounded-lg transition-all" aria-label="Grid">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="showListView()" id="listViewBtn" class="px-3 py-2 text-gray-400 rounded-lg hover:bg-gray-800 transition-all" aria-label="List">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Projects Grid -->
            <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 hover:border-yellow-400/30 transition-all duration-300 hover:shadow-2xl h-full flex flex-col">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    
                    <div class="relative flex flex-col h-full">
                        <!-- Header -->
                        <div class="mb-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-xl font-bold text-white line-clamp-1">{{ $project->name }}</h3>
                                @if($project->status === 'active')
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-semibold whitespace-nowrap">Actief</span>
                                @elseif($project->status === 'completed')
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full text-xs font-semibold whitespace-nowrap">Voltooid</span>
                                @else
                                <span class="px-3 py-1 bg-orange-500/20 text-orange-400 border border-orange-500/30 rounded-full text-xs font-semibold whitespace-nowrap">{{ ucfirst($project->status) }}</span>
                                @endif
                            </div>
                            <div class="flex items-center text-sm text-gray-400 space-x-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ Str::limit($project->client->name, 15) }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $project->hours }}h
                                </span>
                            </div>
                        </div>

                        @if($project->description)
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($project->description, 80) }}</p>
                        @endif

                        <!-- Progress and Rate -->
                        <div class="mt-auto">
                            @if($project->rate)
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-xs text-gray-500">Uurtarief</p>
                                    <p class="text-sm font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">€{{ number_format($project->rate, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Totaal</p>
                                    <p class="text-sm font-bold text-white">€{{ number_format($project->rate * $project->hours, 2) }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="flex gap-2">
                                <a href="{{ route('app.projects.show', $project) }}" class="flex-1 px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all text-sm font-medium text-center">
                                    Bekijken
                                </a>
                                <a href="{{ route('app.invoices.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-emerald-500/10 text-emerald-300 border border-emerald-500/30 rounded-lg hover:bg-emerald-500/20 transition-all text-sm font-medium">
                                    Factuur
                                </a>
                                <a href="{{ route('app.projects.edit', $project) }}" class="px-4 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Geen projecten</h3>
                    <p class="text-gray-600">Begin met het aanmaken van je eerste project!</p>
                </div>
                @endforelse
            </div>

            <!-- Projects List View -->
            <div id="listView" class="hidden space-y-4">
                @forelse($projects as $project)
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 hover:border-yellow-400/30 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6 flex-1">
                            <h3 class="text-xl font-bold text-white">{{ $project->name }}</h3>
                            <span class="flex items-center text-sm text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $project->client->name }}
                            </span>
                            <span class="flex items-center text-sm text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $project->hours }}h
                            </span>
                            @if($project->rate)
                            <span class="text-sm text-gray-400">€{{ number_format($project->rate, 2) }}/h</span>
                            @endif
                        </div>
                        @if($project->status === 'active')
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-semibold mr-4">Actief</span>
                        @elseif($project->status === 'completed')
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full text-xs font-semibold mr-4">Voltooid</span>
                        @else
                        <span class="px-3 py-1 bg-orange-500/20 text-orange-400 border border-orange-500/30 rounded-full text-xs font-semibold mr-4">{{ ucfirst($project->status) }}</span>
                        @endif
                        <div class="flex gap-2">
                            <a href="{{ route('app.projects.show', $project) }}" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all text-sm font-medium">
                                Bekijken
                            </a>
                            <a href="{{ route('app.projects.edit', $project) }}" class="px-4 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Geen projecten</h3>
                    <p class="text-gray-600">Begin met het aanmaken van je eerste project!</p>
                </div>
                @endforelse
            </div>
            
            @if($projects->hasPages())
            <div class="mt-8 px-6 py-4 border-t border-gray-800/50 bg-gray-800/20 rounded-xl">
                {{ $projects->links() }}
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