@extends('admin.layout')

@section('title', 'Gebruikers Beheer')

@section('content')
<div class="space-y-6">
    <!-- Header with Export -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Gebruikers Beheer</h2>
        <a href="{{ route('admin.users.export') }}" 
           class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 rounded-xl text-white font-semibold hover:from-green-600 hover:to-green-700 hover:shadow-xl hover:shadow-green-500/30 transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 group">
            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H5a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Export CSV</span>
        </a>
    </div>

    <!-- Filters -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 p-6 shadow-xl animate-fade-in">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Zoeken</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Naam, email..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition-all duration-300">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Rol</label>
                <select name="role" class="w-full px-4 py-2.5 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition-all duration-300">
                    <option value="">Alle</option>
                    <option value="ondernemer" {{ request('role') === 'ondernemer' ? 'selected' : '' }}>Ondernemer</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 rounded-xl font-semibold text-white hover:from-red-600 hover:to-red-700 hover:shadow-xl hover:shadow-red-500/30 transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.414.586V17l-4 4v-6.586a1 1 0 00-.414-.586L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card-hover bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 rounded-xl border border-gray-800/50 overflow-hidden shadow-xl animate-fade-in" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-800/80 to-gray-800/50 backdrop-blur-sm">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Gebruiker</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Rol</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Organisatie</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">Aangemaakt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-800/30 transition-all duration-200 hover:shadow-lg">
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-700 text-gray-300">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $user->organization->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-300">{{ $user->created_at->format('d-m-Y') }}</span>
                                <div class="flex items-center space-x-1 ml-auto">
                                    @if(str_contains($user->email, '.suspended'))
                                    <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 text-xs bg-green-500/20 text-green-400 border border-green-500/40 rounded-lg hover:bg-green-500/30 transition-all" title="Activeren">
                                            ▶
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt opschorten?')" 
                                                class="px-3 py-2 text-xs bg-red-500/20 text-red-400 border border-red-500/40 rounded-lg hover:bg-red-500/30 hover:border-red-500/60 hover:scale-110 transition-all duration-300 transform" title="Opschorten">
                                            ⏸
                                        </button>
                                    </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-2 text-xs bg-red-500/20 text-red-400 border border-red-500/40 rounded-lg hover:bg-red-500/30 hover:border-red-500/60 hover:scale-110 transition-all duration-300 transform" title="Verwijderen">
                                            🗑
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Geen gebruikers gevonden</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

