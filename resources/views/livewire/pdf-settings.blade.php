<div>
    <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-6">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-8 h-8 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            PDF-instellingen
        </h2>

        @if (session()->has('message'))
        <div class="mb-6 px-4 py-3 bg-green-500/20 border border-green-500/30 rounded-xl text-green-400">
            {{ session('message') }}
        </div>
        @endif

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @foreach([1 => 'Template', 2 => 'Kleur', 3 => 'Bedrijf', 4 => 'Review'] as $step => $label)
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center">
                        <button 
                            wire:click="goToStep({{ $step }})"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all {{ $current_step >= $step ? 'bg-yellow-400 text-gray-900' : 'bg-gray-700 text-gray-400' }}">
                            {{ $step }}
                        </button>
                        <span class="ml-2 text-sm font-medium {{ $current_step >= $step ? 'text-yellow-400' : 'text-gray-400' }}">{{ $label }}</span>
                    </div>
                    @if($step < $total_steps)
                    <div class="flex-1 h-0.5 mx-2 {{ $current_step > $step ? 'bg-yellow-400' : 'bg-gray-700' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <form wire:submit.prevent="save">
            <!-- Step 1: Template Selection -->
            @if($current_step === 1)
            <div class="mb-6">
                <h3 class="text-xl font-bold text-white mb-4">Kies je factuur template</h3>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative cursor-pointer block">
                        <input type="radio" wire:model="template" value="modern" class="sr-only">
                        <div class="p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'modern' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 {{ $template === 'modern' ? 'border-yellow-400' : 'border-gray-600' }} mr-3 flex items-center justify-center">
                                    @if($template === 'modern')
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    @endif
                                </div>
                                <span class="font-semibold text-white">Modern</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Groen thema, professioneel</p>
                        </div>
                    </label>
                    <label class="relative cursor-pointer block">
                        <input type="radio" wire:model="template" value="minimal" class="sr-only">
                        <div class="p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'minimal' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 {{ $template === 'minimal' ? 'border-yellow-400' : 'border-gray-600' }} mr-3 flex items-center justify-center">
                                    @if($template === 'minimal')
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    @endif
                                </div>
                                <span class="font-semibold text-white">Minimaal</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Simpel en clean</p>
                        </div>
                    </label>
                    <label class="relative cursor-pointer block">
                        <input type="radio" wire:model="template" value="classic" class="sr-only">
                        <div class="p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'classic' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 {{ $template === 'classic' ? 'border-yellow-400' : 'border-gray-600' }} mr-3 flex items-center justify-center">
                                    @if($template === 'classic')
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    @endif
                                </div>
                                <span class="font-semibold text-white">Klassiek</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Traditionele stijl</p>
                        </div>
                    </label>
                    <label class="relative cursor-pointer block">
                        <input type="radio" wire:model="template" value="bold" class="sr-only">
                        <div class="p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'bold' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 {{ $template === 'bold' ? 'border-yellow-400' : 'border-gray-600' }} mr-3 flex items-center justify-center">
                                    @if($template === 'bold')
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    @endif
                                </div>
                                <span class="font-semibold text-white">Bold</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Opvallende kleuren</p>
                        </div>
                    </label>
                </div>
            </div>
            @endif

            <!-- Step 2: Color Picker -->
            @if($current_step === 2)
            <div class="mb-6">
                <h3 class="text-xl font-bold text-white mb-4">Kies je primaire kleur</h3>
                <div class="flex items-center gap-4 mb-6">
                    <input type="color" wire:model.live="primary_color" class="w-32 h-16 rounded-xl cursor-pointer">
                    <input type="text" wire:model.live="primary_color" class="flex-1 px-4 py-4 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all text-lg" placeholder="#10b981">
                </div>
                <div class="p-6 bg-white rounded-xl" style="background: {{ $primary_color }};">
                    <p class="text-white text-center font-bold text-lg">Voorbeeld van je kleur</p>
                </div>
            </div>
            @endif

            <!-- Step 3: Company Information -->
            @if($current_step === 3)
            <div class="mb-6">
                <h3 class="text-xl font-bold text-white mb-4">Bedrijfsinformatie</h3>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Bedrijfsnaam</label>
                    <input type="text" wire:model.live="company_name" 
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="Je bedrijfsnaam">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Tagline</label>
                    <input type="text" wire:model.live="tagline" 
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="Professionele Financiële Diensten">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Logo uploaden</label>
                    @if($organization->logo_path)
                    <div class="mb-4 p-4 bg-gray-800 border border-gray-700 rounded-xl">
                        <img src="{{ Storage::url($organization->logo_path) }}" alt="Logo" class="h-16 object-contain">
                    </div>
                    @endif
                    <input type="file" wire:model="logo" accept="image/*" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-yellow-400 file:text-gray-900 hover:file:bg-yellow-500 transition-all">
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-800 border border-gray-700 rounded-xl">
                    <div>
                        <label class="block text-sm font-medium text-white mb-1">Logo weergeven</label>
                        <p class="text-sm text-gray-400">Toon logo op de factuur</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="show_logo" class="sr-only peer">
                        <div class="w-14 h-7 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-yellow-400"></div>
                    </label>
                </div>
            </div>
            @endif

            <!-- Step 4: Review -->
            @if($current_step === 4)
            <div class="mb-6">
                <h3 class="text-xl font-bold text-white mb-4">Review</h3>
                
                <div class="p-6 bg-white rounded-xl shadow-lg" style="max-width: 800px;">
                    <div class="flex items-start justify-between mb-4 pb-4 border-b" style="border-color: {{ $primary_color }}">
                        <div>
                            <h4 class="text-xl font-bold" style="color: #1a1a1a;">{{ $company_name }}</h4>
                            @if($tagline)
                            <p class="text-sm text-gray-600">{{ $tagline }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <h2 class="text-2xl font-bold" style="color: {{ $primary_color }};">FACTUUR</h2>
                            <p class="text-sm text-gray-600">#INV-2024-001</p>
                            @if($show_logo && $organization->logo_path)
                            <img src="{{ Storage::url($organization->logo_path) }}" alt="Logo" class="h-8 mt-2 mx-auto">
                            @endif
                        </div>
                    </div>
                    <div class="text-center text-sm text-gray-500 mt-4">
                        {{ $footer_message }}
                    </div>
                </div>

                <div class="mb-6 mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Footer bericht</label>
                    <input type="text" wire:model.live="footer_message" 
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="Bedankt voor je vertrouwen!">
                </div>
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8">
                @if($current_step > 1)
                <button type="button" wire:click="previousStep" class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Vorige
                </button>
                @else
                <div></div>
                @endif

                @if($current_step < $total_steps)
                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all flex items-center">
                    Volgende
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                @else
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all flex items-center">
                    Opslaan
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
                @endif
            </div>
        </form>
    </div>
</div>
