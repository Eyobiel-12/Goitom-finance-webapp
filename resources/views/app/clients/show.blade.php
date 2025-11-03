<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('app.clients.index') }}" class="p-2 hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">{{ $client->name }}</h1>
                        <p class="mt-2 text-gray-400 text-lg">Alle gegevens en activiteiten van deze klant</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('app.clients.edit', $client) }}" class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Bewerken
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Client Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Contact Info -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Contactgegevens</h2>
                        <div class="space-y-3">
                            @if($client->contact_name)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-400">Contactpersoon</p>
                                    <p class="text-white font-semibold">{{ $client->contact_name }}</p>
                                </div>
                            </div>
                            @endif
                            @if($client->email)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-400">E-mail</p>
                                    <p class="text-white font-semibold">{{ $client->email }}</p>
                                </div>
                            </div>
                            @endif
                            @if($client->phone)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-400">Telefoon</p>
                                    <p class="text-white font-semibold">{{ $client->phone }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Address -->
                    @if($client->address && !empty(array_filter($client->address)))
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Adres</h2>
                        <div class="text-gray-400 space-y-1">
                            @if(isset($client->address['street']))<p>{{ $client->address['street'] }}</p>@endif
                            <p>
                                @if(isset($client->address['postal_code'])){{ $client->address['postal_code'] }}@endif
                                @if(isset($client->address['city'])) {{ $client->address['city'] }}@endif
                            </p>
                            @if(isset($client->address['country']))<p>{{ $client->address['country'] }}</p>@endif
                        </div>
                    </div>
                    @endif

                    <!-- Tax Info -->
                    @if($client->tax_id || $client->kvk_number)
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Registratie</h2>
                        <div class="space-y-3">
                            @if($client->kvk_number)
                            <div>
                                <p class="text-sm text-gray-400">KVK-nummer</p>
                                <p class="text-white font-semibold">{{ $client->kvk_number }}</p>
                            </div>
                            @endif
                            @if($client->tax_id)
                            <div>
                                <p class="text-sm text-gray-400">BTW-nummer</p>
                                <p class="text-white font-semibold">{{ $client->tax_id }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Stats -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Overzicht</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-800/50 rounded-lg p-4">
                                <p class="text-sm text-gray-400 mb-1">Projecten</p>
                                <p class="text-2xl font-bold text-yellow-400">{{ $client->projects->count() }}</p>
                            </div>
                            <div class="bg-gray-800/50 rounded-lg p-4">
                                <p class="text-sm text-gray-400 mb-1">Facturen</p>
                                <p class="text-2xl font-bold text-yellow-400">{{ $client->invoices->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Projects and Invoices -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Projects -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-white">Projecten</h2>
                            <a href="{{ route('app.projects.create') }}" class="text-sm text-yellow-400 hover:text-yellow-300 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nieuw Project
                            </a>
                        </div>
                        
                        @if($client->projects->count() > 0)
                        <div class="space-y-3">
                            @foreach($client->projects as $project)
                            <div class="bg-gray-800/30 border border-gray-700/50 rounded-xl p-4 hover:border-yellow-400/30 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-white">{{ $project->name }}</h3>
                                        @if($project->description)
                                        <p class="text-sm text-gray-400 mt-1">{{ Str::limit($project->description, 60) }}</p>
                                        @endif
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-400">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $project->hours }} uren
                                            </span>
                                            @if($project->rate)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                €{{ number_format($project->rate * $project->hours, 2) }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 bg-{{ $project->status === 'active' ? 'green' : ($project->status === 'completed' ? 'blue' : 'orange') }}-500/20 text-{{ $project->status === 'active' ? 'green' : ($project->status === 'completed' ? 'blue' : 'orange') }}-400 border border-{{ $project->status === 'active' ? 'green' : ($project->status === 'completed' ? 'blue' : 'orange') }}-500/30 rounded-full text-xs font-semibold">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                        <a href="{{ route('app.projects.edit', $project) }}" class="px-3 py-2 bg-yellow-400/10 text-yellow-400 border border-yellow-400/30 rounded-lg hover:bg-yellow-400/20 transition-all">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-400">Geen projecten voor deze klant</p>
                        </div>
                        @endif
                    </div>

                    <!-- Invoices -->
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
                        
                        @if($client->invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($client->invoices as $invoice)
                            <div class="bg-gray-800/30 border border-gray-700/50 rounded-xl p-4 hover:border-yellow-400/30 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-white">#{{ $invoice->number }}</h3>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-400">
                                            <span>{{ $invoice->issue_date->format('d-m-Y') }}</span>
                                            @if($invoice->project)
                                            <span>{{ $invoice->project->name }}</span>
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
                            <p class="text-gray-400">Geen facturen voor deze klant</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

