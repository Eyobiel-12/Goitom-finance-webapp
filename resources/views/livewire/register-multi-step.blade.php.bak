<div class="w-full max-w-2xl mx-auto space-y-8">
        <!-- Logo -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-20 rounded-2xl shadow-2xl shadow-yellow-400/30 object-contain">
            </div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">
                Account Aanmaken
            </h2>
            <p class="mt-2 text-gray-400 text-lg">Word onderdeel van Goitom Finance</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1 mr-2">
                    <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-600 transition-all duration-500" 
                             style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-400">Stap {{ $currentStep }}/{{ $totalSteps }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="{{ $currentStep >= 1 ? 'text-yellow-400' : 'text-gray-600' }}">Gegevens</span>
                <span class="{{ $currentStep >= 2 ? 'text-yellow-400' : 'text-gray-600' }}">Wachtwoord</span>
                <span class="{{ $currentStep >= 3 ? 'text-yellow-400' : 'text-gray-600' }}">Bevestigen</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-gray-700/50 p-8 shadow-2xl">
            <!-- Step 1: Name and Email -->
            @if($currentStep == 1)
            <div class="space-y-6">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-2">Welkom!</h3>
                    <p class="text-gray-400">Laten we beginnen met je naam en e-mailadres</p>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Volledige Naam</label>
                    <input type="text" 
                           wire:model="name" 
                           id="name"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="John Doe"
                           autofocus>
                    @error('name') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">E-mailadres</label>
                    <input type="email" 
                           wire:model="email" 
                           id="email"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="john@example.com">
                    @error('email') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button wire:click="step1" 
                        class="w-full px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                    Volgende Stap
                </button>
            </div>
            @endif

            <!-- Step 2: Password -->
            @if($currentStep == 2)
            <div class="space-y-6">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-2">Beveiliging</h3>
                    <p class="text-gray-400">Kies een sterk wachtwoord voor je account</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Wachtwoord</label>
                    <input type="password" 
                           wire:model="password" 
                           id="password"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="Minimaal 8 karakters"
                           autofocus>
                    @error('password') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Bevestig Wachtwoord</label>
                    <input type="password" 
                           wire:model="password_confirmation" 
                           id="password_confirmation"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="Herhaal je wachtwoord">
                </div>

                <div class="flex gap-4">
                    <button wire:click="previousStep" 
                            class="flex-1 px-6 py-4 border border-gray-700 rounded-xl font-semibold text-gray-300 hover:bg-gray-800 hover:border-gray-600 transition-all">
                        Terug
                    </button>
                    <button wire:click="sendOtp" 
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                        Code Versturen
                    </button>
                </div>
            </div>
            @endif

            <!-- Step 3: OTP Verification -->
            @if($currentStep == 3)
            <div class="space-y-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">E-mail Bevestigen</h3>
                    <p class="text-gray-400">We hebben een 6-cijferige code gestuurd naar<br><strong class="text-yellow-400">{{ $email }}</strong></p>
                </div>

                <div>
                    <label for="otp_code" class="block text-sm font-medium text-gray-400 mb-2 text-center">Verificatiecode</label>
                    <input type="text" 
                           wire:model="otp_code" 
                           id="otp_code"
                           class="w-full px-4 py-4 bg-gray-800 border-2 border-yellow-400/50 rounded-xl text-center text-3xl font-bold text-yellow-400 tracking-widest focus:outline-none focus:border-yellow-400 transition-all"
                           placeholder="000000"
                           maxlength="6"
                           autofocus
                           style="letter-spacing: 0.5rem;">
                    @error('otp_code') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="bg-yellow-400/10 border border-yellow-400/30 rounded-xl p-4">
                    <p class="text-sm text-yellow-400 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        De code is 10 minuten geldig. Check ook je spambox.
                    </p>
                </div>

                <button wire:click="verifyOtp" 
                        class="w-full px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                    Account Activeren
                </button>

                <button wire:click="sendOtp" 
                        class="w-full px-4 py-2 text-sm text-gray-400 hover:text-yellow-400 transition-all">
                    Code opnieuw versturen
                </button>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-gray-400">
                Heb je al een account? 
                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">Inloggen</a>
            </p>
        </div>
