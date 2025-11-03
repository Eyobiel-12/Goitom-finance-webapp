<div>
    <div class="w-full max-w-2xl mx-auto space-y-8">
        <!-- Logo -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center shadow-2xl shadow-yellow-400/30">
                    <span class="text-4xl font-bold text-gray-900">G</span>
                </div>
            </div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">
                Wachtwoord Vergeten?
            </h2>
            <p class="mt-2 text-gray-400">We sturen je een verificatiecode om je wachtwoord te resetten</p>
        </div>

        <!-- Progress Bar -->
        <div class="flex justify-between items-center text-gray-500 mb-8">
            <div class="flex-1 text-center">
                <div class="w-full h-2 rounded-full {{ $currentStep >= 1 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 'bg-gray-700' }} mb-2 transition-all duration-500"></div>
                <span class="text-sm font-medium {{ $currentStep >= 1 ? 'text-yellow-400' : 'text-gray-500' }}">1. E-mail</span>
            </div>
            <div class="flex-1 text-center ml-4">
                <div class="w-full h-2 rounded-full {{ $currentStep >= 2 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 'bg-gray-700' }} mb-2 transition-all duration-500"></div>
                <span class="text-sm font-medium {{ $currentStep >= 2 ? 'text-yellow-400' : 'text-gray-500' }}">2. Bevestigen</span>
            </div>
        </div>

        <!-- Step 1: Email -->
        @if($currentStep === 1)
        <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 shadow-lg">
            <h3 class="text-xl font-bold text-white mb-4">Wat is je e-mailadres?</h3>
            <div class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">E-mailadres</label>
                    <input type="email" id="email" wire:model.defer="email" placeholder="john@example.com"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                    @error('email') <span class="text-red-400 text-sm mt-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-8">
                <button wire:click="nextStep"
                        class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                    Verificatiecode Versturen
                </button>
            </div>
        </div>
        @endif

        <!-- Step 2: OTP Verification -->
        @if($currentStep === 2)
        <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 shadow-lg text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-yellow-400 rounded-2xl flex items-center justify-center text-gray-900 shadow-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">E-mail Bevestigen</h3>
            <p class="text-gray-400 mb-6">We hebben een 6-cijferige code gestuurd naar <span class="text-yellow-400 font-semibold">{{ $email }}</span></p>
            
            @if (session()->has('message'))
            <div class="mb-4 px-4 py-3 bg-green-500/20 border border-green-500/30 rounded-xl text-green-400">
                {{ session('message') }}
            </div>
            @endif

            <div>
                <label for="otp_code" class="sr-only">Verificatiecode</label>
                <input type="text" id="otp_code" wire:model.defer="otp_code" placeholder="123456" maxlength="6"
                       class="w-48 text-center px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all text-3xl font-bold tracking-widest">
                @error('otp_code') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>
            <div class="mt-6 text-sm text-gray-500 flex items-center justify-center">
                <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                De code is 10 minuten geldig. Check ook je spambox.
            </div>
            <div class="mt-8 flex justify-between">
                <button wire:click="previousStep"
                        class="px-6 py-3 bg-gray-800 text-gray-400 rounded-xl font-semibold border border-gray-700 hover:border-yellow-400/30 hover:text-yellow-400 transition-all duration-300">
                    Vorige Stap
                </button>
                <button wire:click="verifyOtp"
                        class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                    Bevestigen
                </button>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="text-center">
            <p class="text-gray-400">
                Weet je je wachtwoord nog? 
                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">Inloggen</a>
            </p>
        </div>
    </div>
</div>

