<!-- Upgrade to Pro Modal -->
<div x-data="{ show: false }" 
     @show-upgrade-modal.window="show = true"
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
     style="display: none;">
    <div @click.away="show = false" class="bg-gray-900 border-2 border-yellow-400/30 rounded-2xl p-8 w-full max-w-lg shadow-2xl shadow-yellow-400/20">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Upgrade naar Pro</h3>
            <p class="text-gray-400">Deze functie is alleen beschikbaar voor Pro gebruikers</p>
        </div>

        <div class="bg-gray-950/50 border border-gray-800 rounded-xl p-4 mb-6">
            <h4 class="text-sm font-semibold text-yellow-400 mb-3">Met Pro krijg je:</h4>
            <ul class="space-y-2 text-sm text-gray-300">
                <li class="flex items-center"><svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> E-mail verzenden & herinneringen</li>
                <li class="flex items-center"><svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Geavanceerde BTW correcties</li>
                <li class="flex items-center"><svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Priority support</li>
                <li class="flex items-center"><svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> API toegang</li>
            </ul>
        </div>

        <div class="text-center mb-6">
            <div class="text-3xl font-extrabold text-white mb-1">€22<span class="text-base text-gray-400">/maand</span></div>
            <p class="text-xs text-gray-500">Annuleer op elk moment</p>
        </div>

        <div class="flex gap-3">
            <button @click="show = false" class="flex-1 px-6 py-3 border border-gray-700 rounded-xl text-gray-300 hover:bg-gray-800 transition-all font-semibold">
                Misschien later
            </button>
            <a href="{{ route('app.subscription.index') }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all text-center">
                Upgrade Nu
            </a>
        </div>
    </div>
</div>

