<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('app.projects.index') }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">{{ $project->name }}</h1>
                        <p class="mt-2 text-gray-400 text-lg">Projectdetails en activiteiten</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('app.projects.edit', $project) }}" class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Bewerken
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Project Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Status and Client -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Project Info</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Status</p>
                                <span class="px-3 py-1 bg-{{ $project->status === 'active' ? 'green' : ($project->status === 'completed' ? 'blue' : 'orange') }}-500/20 text-{{ $project->status === 'active' ? 'green' : ($project->status === 'completed' ? 'blue' : 'orange') }}-400 border border-{{ $project->status === 'active' ? 'green' : ($project->status === 'completed' ? 'blue' : 'orange') }}-500/30 rounded-full text-sm font-semibold inline-block">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Klant</p>
                                <a href="{{ route('app.clients.show', $project->client) }}" class="text-white font-semibold hover:text-yellow-400 transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ $project->client->name }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($project->description)
                    <!-- Description -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Omschrijving</h2>
                        <p class="text-gray-400">{{ $project->description }}</p>
                    </div>
                    @endif

                    <!-- Financial Info -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Financiële Info</h2>
                        <div class="space-y-3">
                            @if($project->rate)
                            <div>
                                <p class="text-sm text-gray-400">Uurtarief</p>
                                <p class="text-lg font-bold text-yellow-400">€{{ number_format($project->rate, 2) }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-400">Geregistreerde Uren</p>
                                <p class="text-lg font-bold text-white">{{ $project->hours }}</p>
                            </div>
                            @if($project->rate)
                            <div class="pt-3 border-t border-gray-800">
                                <p class="text-sm text-gray-400">Totaal Projectwaarde</p>
                                <p class="text-2xl font-bold text-yellow-400">€{{ number_format($project->rate * $project->hours, 2) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Overzicht</h2>
                        <div class="bg-gray-800/50 rounded-lg p-4">
                            <p class="text-sm text-gray-400 mb-1">Facturen</p>
                            <p class="text-2xl font-bold text-yellow-400">{{ $project->invoices->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Invoices -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-white">Facturen</h2>
                            <a href="{{ route('app.invoices.create') }}" class="text-sm text-yellow-400 hover:text-yellow-300 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nieuwe Factuur
                            </a>
                        </div>
                        
                        @if($project->invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->invoices as $invoice)
                            <div class="bg-gray-800/30 border border-gray-700/50 rounded-xl p-4 hover:border-yellow-400/30 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-white">#{{ $invoice->number }}</h3>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-400">
                                            <span>{{ $invoice->issue_date->format('d-m-Y') }}</span>
                                            @if($invoice->due_date)
                                            <span>Verval: {{ $invoice->due_date->format('d-m-Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-400">Totaal</p>
                                            <p class="text-lg font-bold text-yellow-400">€{{ number_format($invoice->total, 2) }}</p>
                                        </div>
                                        <span class="px-3 py-1 bg-{{ $invoice->status === 'paid' ? 'green' : ($invoice->status === 'sent' ? 'blue' : ($invoice->status === 'overdue' ? 'red' : 'gray')) }}-500/20 text-{{ $invoice->status === 'paid' ? 'green' : ($invoice->status === 'sent' ? 'blue' : ($invoice->status === 'overdue' ? 'red' : 'gray')) }}-400 border border-{{ $invoice->status === 'paid' ? 'green' : ($invoice->status === 'sent' ? 'blue' : ($invoice->status === 'overdue' ? 'red' : 'gray')) }}-500/30 rounded-full text-xs font-semibold">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                        <a href="{{ route('app.invoices.show', $invoice) }}" class="px-3 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-400">Geen facturen voor dit project</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

