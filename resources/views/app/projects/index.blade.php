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

            <!-- Status Tabs -->
            <div class="mb-6 flex gap-2 border-b border-gray-800">
                <button class="px-4 py-2 text-sm font-medium border-b-2 border-yellow-400 text-yellow-400">Alle</button>
                <button class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white transition-colors">Actief</button>
                <button class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white transition-colors">Voltooid</button>
                <button class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white transition-colors">Gepauzeerd</button>
            </div>

            <!-- Projects List -->
            <div class="space-y-4">
                @forelse(\App\Models\Project::where('organization_id', auth()->user()->organization_id)->with('client')->latest()->get() as $project)
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6 hover:border-yellow-400/30 transition-all duration-300 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    
                    <div class="relative">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">{{ $project->name }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ $project->client->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $project->hours }} uren
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($project->status === 'active')
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-semibold">Actief</span>
                                @elseif($project->status === 'completed')
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full text-xs font-semibold">Voltooid</span>
                                @else
                                <span class="px-3 py-1 bg-orange-500/20 text-orange-400 border border-orange-500/30 rounded-full text-xs font-semibold">{{ ucfirst($project->status) }}</span>
                                @endif
                            </div>
                        </div>

                        @if($project->description)
                        <p class="text-gray-400 mb-4">{{ Str::limit($project->description, 120) }}</p>
                        @endif

                        <!-- Progress and Rate -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-6">
                                @if($project->rate)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Uurtarief</p>
                                    <p class="text-lg font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">€{{ number_format($project->rate, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Totaal</p>
                                    <p class="text-lg font-bold text-white">€{{ number_format($project->rate * $project->hours, 2) }}</p>
                                </div>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('app.projects.edit', $project) }}" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-yellow-400/10 hover:text-yellow-400 border border-gray-700 hover:border-yellow-400/30 transition-all text-sm font-medium">
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
        </div>
    </div>
</x-layouts.app>