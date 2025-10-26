<div>
    <div class="w-full max-w-2xl mx-auto space-y-8">
        <!-- Logo -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center shadow-2xl shadow-yellow-400/30">
                    <svg class="w-10 h-10 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">
                Nieuw Wachtwoord Instellen
            </h2>
            <p class="mt-2 text-gray-400">Kies een sterk wachtwoord voor je account</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 shadow-lg">
            <div class="space-y-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Nieuw Wachtwoord</label>
                    <input type="password" id="password" wire:model.defer="password" placeholder="••••••••"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                    @error('password') <span class="text-red-400 text-sm mt-2">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Wachtwoord Bevestigen</label>
                    <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" placeholder="••••••••"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                    @error('password_confirmation') <span class="text-red-400 text-sm mt-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-8">
                <button wire:click="resetPassword"
                        class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                    Wachtwoord Resetten
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-gray-400">
                Weet je je wachtwoord nog? 
                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">Inloggen</a>
            </p>
        </div>
    </div>
</div>

