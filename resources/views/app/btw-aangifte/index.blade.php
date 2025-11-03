<x-layouts.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">
                        BTW Aangifte
                    </h1>
                    <p class="text-gray-400 text-lg mt-2">Automatische BTW-berekening gebaseerd op je facturen en aftrek</p>
                </div>
            </div>

            @livewire('btw-aangifte-generator')
        </div>
    </div>
</x-layouts.app>

