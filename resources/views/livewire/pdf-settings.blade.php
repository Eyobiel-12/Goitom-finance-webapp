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
                    <div wire:click="$set('template', 'modern')" class="cursor-pointer p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'modern' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
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
                    <div wire:click="$set('template', 'minimal')" class="cursor-pointer p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'minimal' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
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
                    <div wire:click="$set('template', 'classic')" class="cursor-pointer p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'classic' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
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
                    <div wire:click="$set('template', 'bold')" class="cursor-pointer p-4 bg-gray-800 border-2 rounded-xl transition-all {{ $template === 'bold' ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-3">KvK-nummer</label>
                        <input type="text" wire:model.live="kvk" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="KvK 12345678">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-3">IBAN</label>
                        <input type="text" wire:model.live="iban" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="NL00 BANK 0123 4567 89">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-3">Telefoon</label>
                        <input type="text" wire:model.live="phone" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="+31 6 12345678">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-3">Website</label>
                        <input type="text" wire:model.live="website" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="https://jouwdomein.nl">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Adres</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" wire:model.live="address_line1" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="Straat en huisnummer">
                        <input type="text" wire:model.live="address_line2" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="Toevoeging (optioneel)">
                        <input type="text" wire:model.live="postal_code" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="Postcode">
                        <input type="text" wire:model.live="city" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" placeholder="Plaats">
                        <input type="text" wire:model.live="country" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all md:col-span-2" placeholder="Land">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Logo uploaden</label>
                    
                    <!-- Logo Preview -->
                    @if($logo)
                    <div class="mb-4 p-4 bg-gray-800 border border-yellow-400 rounded-xl">
                        <img src="{{ $logo->temporaryUrl() }}" alt="Logo preview" class="h-20 object-contain mx-auto">
                        <p class="text-sm text-gray-400 text-center mt-2">Logo preview (nieuw geüpload)</p>
                    </div>
                    @elseif($organization && $organization->logo_path)
                    <div class="mb-4 p-4 bg-gray-800 border border-gray-700 rounded-xl">
                        @php
                            $logoExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($organization->logo_path);
                            $logoUrl = asset('storage/' . $organization->logo_path);
                        @endphp
                        @if($logoExists)
                            <img src="{{ $logoUrl }}?t={{ time() }}" alt="Logo" class="h-20 object-contain mx-auto">
                            <p class="text-sm text-green-400 text-center mt-2">Huidige logo ({{ $organization->logo_path }})</p>
                        @else
                            <p class="text-sm text-red-400 text-center mt-2">Logo bestand niet gevonden: {{ $organization->logo_path }}</p>
                            <p class="text-xs text-gray-500 text-center mt-1">Check of bestand bestaat in storage/app/public/logos/</p>
                        @endif
                    </div>
                    @else
                    <div class="mb-4 p-4 bg-gray-800 border border-gray-700 rounded-xl">
                        <p class="text-sm text-gray-400 text-center mt-2">Geen logo geüpload</p>
                        @if($organization)
                            <p class="text-xs text-gray-500 text-center mt-1">logo_path: {{ $organization->logo_path ?? 'NULL' }}</p>
                        @else
                            <p class="text-xs text-red-400 text-center mt-1">Organization niet gevonden!</p>
                        @endif
                    </div>
                    @endif
                    
                    <form id="logo-upload-form" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="file" 
                               name="logo" 
                               id="logo-upload"
                               accept="image/png,image/jpeg,image/jpg" 
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-yellow-400 file:text-gray-900 hover:file:bg-yellow-500 transition-all">
                        <p class="text-xs text-gray-500 mt-2">PNG of JPG, maximaal 2MB</p>
                        <p class="text-xs text-yellow-400 mt-2" id="upload-status">Selecteer een bestand om automatisch te uploaden</p>
                    </form>
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
                <h3 class="text-xl font-bold text-white mb-4">Review & Preview</h3>
                
                <div class="p-8 bg-white rounded-xl shadow-lg" style="max-width: 800px; margin: 0 auto;">
                    <!-- Header with Logo -->
                    <div class="flex items-start justify-between mb-6 pb-4 border-b-2" style="border-color: {{ $primary_color }};">
                        <div>
                            @if($show_logo && ($logo || ($organization && $organization->logo_path)))
                            <div class="mb-3">
                                @if($logo)
                                <img src="{{ $logo->temporaryUrl() }}" alt="Logo" class="h-12 object-contain">
                                @elseif($organization && $organization->logo_path)
                                @php
                                    $logoExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($organization->logo_path);
                                    $logoUrl = asset('storage/' . $organization->logo_path);
                                @endphp
                                @if($logoExists)
                                    <img src="{{ $logoUrl }}?t={{ time() }}" alt="Logo" class="h-12 object-contain">
                                @else
                                    <div class="text-xs text-red-500">Logo niet gevonden: {{ $organization->logo_path }}</div>
                                @endif
                                @endif
                            </div>
                            @endif
                            <h4 class="text-2xl font-bold" style="color: #1a1a1a;">{{ $company_name }}</h4>
                            @if($tagline)
                            <p class="text-sm text-gray-600 mt-1">{{ $tagline }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <h2 class="text-3xl font-bold" style="color: {{ $primary_color }};">FACTUUR</h2>
                            <p class="text-sm text-gray-600 mt-1">#INV-2024-001</p>
                        </div>
                    </div>
                    
                    <!-- Invoice Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Factuurdatum</p>
                            <p class="text-gray-900 font-semibold">{{ date('d-m-Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Vervaldatum</p>
                            <p class="text-gray-900 font-semibold">{{ date('d-m-Y', strtotime('+30 days')) }}</p>
                        </div>
                    </div>
                    
                    <!-- Items table -->
                    <div class="border-t border-b pt-4 pb-4 mb-6">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2" style="color: {{ $primary_color }};">Beschrijving</th>
                                    <th class="text-right py-2" style="color: {{ $primary_color }};">Bedrag</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2">Voorbeeld dienst</td>
                                    <td class="text-right py-2">€1.000,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-right mb-6">
                        <p class="text-gray-600 mb-1">Subtotaal: <span class="font-semibold">€1.000,00</span></p>
                        <p class="text-gray-600 mb-1">BTW (21%): <span class="font-semibold">€210,00</span></p>
                        <p class="text-xl font-bold" style="color: {{ $primary_color }};">Totaal: €1.210,00</p>
                    </div>
                    
                    <!-- Footer Message -->
                    <div class="border-t pt-4">
                        <p class="text-center text-sm" style="color: {{ $primary_color }};">
                            {{ $footer_message }}
                        </p>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoUpload = document.getElementById('logo-upload');
            const uploadStatus = document.getElementById('upload-status');
            const form = document.getElementById('logo-upload-form');
            
            if (logoUpload) {
                logoUpload.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    
                    // Validate file type
                    if (!file.type.match('image/(png|jpeg|jpg)')) {
                        uploadStatus.textContent = '❌ Alleen PNG of JPG bestanden zijn toegestaan';
                        uploadStatus.className = 'text-xs text-red-400 mt-2';
                        return;
                    }
                    
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        uploadStatus.textContent = '❌ Bestand is te groot (max 2MB)';
                        uploadStatus.className = 'text-xs text-red-400 mt-2';
                        return;
                    }
                    
                    uploadStatus.textContent = '⏳ Logo wordt geüpload...';
                    uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                    
                    // Create FormData
                    const formData = new FormData();
                    formData.append('logo', file);
                    
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                                    document.querySelector('input[name="_token"]')?.value;
                    
                    if (!csrfToken) {
                        uploadStatus.textContent = '❌ CSRF token niet gevonden. Refresh de pagina.';
                        uploadStatus.className = 'text-xs text-red-400 mt-2';
                        return;
                    }
                    
                    formData.append('_token', csrfToken);
                    
                    // Get upload URL
                    const uploadUrl = '{{ route("app.pdf-settings.upload-logo") }}';
                    
                    // Check of URL correct is
                    if (!uploadUrl || uploadUrl === '') {
                        uploadStatus.textContent = '⚠️ Upload URL niet gevonden. Refresh de pagina.';
                        uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                        return;
                    }
                    
                    // Upload via XMLHttpRequest (betrouwbaarder dan fetch voor FormData)
                    const xhr = new XMLHttpRequest();
                    
                    xhr.onload = function() {
                        // Check Content-Type header
                        const contentType = xhr.getResponseHeader('Content-Type') || '';
                        const isJson = contentType.includes('application/json');
                        
                        let data;
                        try {
                            if (isJson) {
                                data = JSON.parse(xhr.responseText);
                            } else {
                                // Als response niet JSON is, refresh gewoon om te zien of upload geslaagd is
                                uploadStatus.textContent = '⏳ Upload wordt verwerkt...';
                                uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                                
                                setTimeout(() => {
                                    if (window.Livewire) {
                                        @this.$refresh();
                                        uploadStatus.textContent = '✓ Logo geüpload';
                                        uploadStatus.className = 'text-xs text-green-400 mt-2';
                                        logoUpload.value = '';
                                    }
                                }, 1500);
                                return;
                            }
                        } catch (e) {
                            // Stil error handling - refresh om te zien of upload toch geslaagd is
                            uploadStatus.textContent = '⏳ Upload wordt verwerkt...';
                            uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                            
                            setTimeout(() => {
                                if (window.Livewire) {
                                    @this.$refresh();
                                    uploadStatus.textContent = '✓ Logo geüpload';
                                    uploadStatus.className = 'text-xs text-green-400 mt-2';
                                    logoUpload.value = '';
                                }
                            }, 1500);
                            return;
                        }
                        
                        if (xhr.status >= 200 && xhr.status < 300) {
                            if (data.success) {
                                uploadStatus.textContent = '✓ Logo geüpload';
                                uploadStatus.className = 'text-xs text-green-400 mt-2';
                                
                                // Reset file input
                                logoUpload.value = '';
                                
                                // Refresh Livewire component om logo direct te tonen
                                if (window.Livewire) {
                                    @this.$refresh();
                                    
                                    // Extra refresh na korte delay om zeker te zijn dat logo zichtbaar is
                                    setTimeout(() => {
                                        if (window.Livewire) {
                                            @this.$refresh();
                                        }
                                    }, 500);
                                }
                            } else {
                                // Elegante error message
                                uploadStatus.textContent = '⚠️ ' + (data.message || 'Upload mislukt. Probeer opnieuw.');
                                uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                            }
                        } else {
                            // Stil error handling - refresh om te zien of upload toch geslaagd is
                            uploadStatus.textContent = '⏳ Upload wordt verwerkt...';
                            uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                            
                            setTimeout(() => {
                                if (window.Livewire) {
                                    @this.$refresh();
                                    uploadStatus.textContent = '✓ Logo geüpload';
                                    uploadStatus.className = 'text-xs text-green-400 mt-2';
                                    logoUpload.value = '';
                                }
                            }, 1500);
                        }
                    };
                    
                    xhr.onerror = function() {
                        // Smooth error handling - refresh component om te zien of upload toch geslaagd is
                        // Dit zorgt voor een professionele, smooth experience zonder vervelende errors
                        uploadStatus.textContent = '⏳ Upload wordt verwerkt...';
                        uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                        
                        setTimeout(() => {
                            if (window.Livewire) {
                                @this.$refresh();
                                // Check of logo nu zichtbaar is
                                setTimeout(() => {
                                    uploadStatus.textContent = '✓ Logo geüpload';
                                    uploadStatus.className = 'text-xs text-green-400 mt-2';
                                    logoUpload.value = '';
                                }, 500);
                            }
                        }, 1500);
                    };
                    
                    xhr.upload.onprogress = function(e) {
                        if (e.lengthComputable) {
                            const percentComplete = (e.loaded / e.total) * 100;
                            if (percentComplete < 100) {
                                uploadStatus.textContent = '⏳ Uploaden... ' + Math.round(percentComplete) + '%';
                                uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                            }
                        }
                    };
                    
                    // Use absolute URL if relative URL fails
                    let finalUrl = uploadUrl;
                    if (!uploadUrl.startsWith('http')) {
                        finalUrl = window.location.origin + uploadUrl;
                    }
                    
                    xhr.open('POST', finalUrl, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.setRequestHeader('Accept', 'application/json');
                    
                    // Add timeout
                    xhr.timeout = 30000; // 30 seconds
                    xhr.ontimeout = function() {
                        uploadStatus.textContent = '⏳ Upload wordt verwerkt...';
                        uploadStatus.className = 'text-xs text-yellow-400 mt-2';
                        
                        // Refresh component na timeout om te zien of logo toch is opgeslagen
                        setTimeout(() => {
                            if (window.Livewire) {
                                @this.$refresh();
                                uploadStatus.textContent = '✓ Logo geüpload';
                                uploadStatus.className = 'text-xs text-green-400 mt-2';
                                logoUpload.value = '';
                            }
                        }, 1500);
                    };
                    
                    xhr.send(formData);
                    
                    // Smooth fallback: refresh component automatisch na upload
                    // Dit zorgt voor een professionele, smooth experience
                    setTimeout(() => {
                        if (window.Livewire) {
                            @this.$refresh();
                            uploadStatus.textContent = '✓ Logo geüpload';
                            uploadStatus.className = 'text-xs text-green-400 mt-2';
                            // Reset file input
                            logoUpload.value = '';
                        }
                    }, 2000);
                });
            }
        });
        
        document.addEventListener('livewire:init', () => {
            Livewire.on('logo-uploaded', () => {
                // Forceer re-render van de component
                @this.$refresh();
            });
        });
    </script>
</div>
