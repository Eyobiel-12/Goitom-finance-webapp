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

        <form wire:submit.prevent="save">
            <!-- Template Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-400 mb-3">Factuur Template</label>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <input type="radio" wire:model="template" value="modern" id="template-modern" class="peer sr-only">
                        <label for="template-modern" class="flex flex-col p-4 bg-gray-800 border-2 border-gray-700 rounded-xl cursor-pointer hover:border-yellow-400/50 transition-all peer-checked:border-yellow-400">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-600 mr-3 peer-checked:border-yellow-400"></div>
                                <span class="font-semibold text-white">Modern</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Groen thema, professioneel</p>
                        </label>
                    </div>
                    <div class="relative">
                        <input type="radio" wire:model="template" value="minimal" id="template-minimal" class="peer sr-only">
                        <label for="template-minimal" class="flex flex-col p-4 bg-gray-800 border-2 border-gray-700 rounded-xl cursor-pointer hover:border-yellow-400/50 transition-all peer-checked:border-yellow-400">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-600 mr-3 peer-checked:border-yellow-400"></div>
                                <span class="font-semibold text-white">Minimaal</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Simpel en clean</p>
                        </label>
                    </div>
                    <div class="relative">
                        <input type="radio" wire:model="template" value="classic" id="template-classic" class="peer sr-only">
                        <label for="template-classic" class="flex flex-col p-4 bg-gray-800 border-2 border-gray-700 rounded-xl cursor-pointer hover:border-yellow-400/50 transition-all peer-checked:border-yellow-400">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-600 mr-3 peer-checked:border-yellow-400"></div>
                                <span class="font-semibold text-white">Klassiek</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Traditionele stijl</p>
                        </label>
                    </div>
                    <div class="relative">
                        <input type="radio" wire:model="template" value="bold" id="template-bold" class="peer sr-only">
                        <label for="template-bold" class="flex flex-col p-4 bg-gray-800 border-2 border-gray-700 rounded-xl cursor-pointer hover:border-yellow-400/50 transition-all peer-checked:border-yellow-400">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-600 mr-3 peer-checked:border-yellow-400"></div>
                                <span class="font-semibold text-white">Bold</span>
                            </div>
                            <p class="text-sm text-gray-400 ml-9">Opvallende kleuren</p>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Color Picker -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-400 mb-3">Primaire kleur</label>
                <div class="flex items-center gap-4">
                    <input type="color" wire:model="primary_color" class="w-20 h-12 rounded-lg cursor-pointer">
                    <input type="text" wire:model="primary_color" class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="#10b981">
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-400 mb-3">Logo uploaden</label>
                @if($organization->logo_path)
                <div class="mb-4 p-4 bg-gray-800 border border-gray-700 rounded-xl">
                    <img src="{{ Storage::url($organization->logo_path) }}" alt="Logo" class="h-16 object-contain">
                </div>
                @endif
                <input type="file" wire:model="logo" accept="image/*" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-yellow-400 file:text-gray-900 hover:file:bg-yellow-500 transition-all">
                @error('logo') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Show Logo Toggle -->
            <div class="mb-6 flex items-center justify-between p-4 bg-gray-800 border border-gray-700 rounded-xl">
                <div>
                    <label class="block text-sm font-medium text-white mb-1">Logo weergeven</label>
                    <p class="text-sm text-gray-400">Toon logo op de factuur</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="show_logo" class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-yellow-400"></div>
                </label>
            </div>

            <!-- Footer Message -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-400 mb-3">Footer bericht</label>
                <input type="text" wire:model="footer_message" 
                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                       placeholder="Bedankt voor je vertrouwen!">
            </div>

            <!-- Save Button -->
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                Instellingen opslaan
            </button>
        </form>
    </div>
</div>
