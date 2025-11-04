<x-layouts.app>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Profiel</h1>
                <p class="mt-2 text-gray-400 text-lg">Beheer je accountgegevens</p>
            </div>

            <!-- Profile Information -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 mb-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Profielgegevens</h2>
                    <p class="text-gray-400">Update je naam en e-mailadres</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Naam</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                            @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">E-mail</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                            @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-3 p-4 bg-yellow-400/10 border border-yellow-400/30 rounded-xl">
                                <p class="text-sm text-yellow-400 mb-2">{{ __('Your email address is unverified.') }}</p>
                                <form method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-yellow-400 hover:text-yellow-300 underline">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                                Opslaan
                            </button>

                            @if (session('status') === 'profile-updated')
                            <p class="text-sm text-green-400 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Opgeslagen
                            </p>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Password Update -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8 mb-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Wachtwoord Wijzigen</h2>
                    <p class="text-gray-400">Update je wachtwoord om je account veilig te houden</p>
                </div>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="space-y-6">
                        <div>
                            <label for="update_password_current_password" class="block text-sm font-medium text-gray-400 mb-2">Huidig Wachtwoord</label>
                            <input type="password" id="update_password_current_password" name="current_password" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                            @error('updatePassword.current_password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password" class="block text-sm font-medium text-gray-400 mb-2">Nieuw Wachtwoord</label>
                            <input type="password" id="update_password_password" name="password" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                            @error('updatePassword.password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Bevestig Wachtwoord</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation" 
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all">
                            @error('updatePassword.password_confirmation')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                                Opslaan
                            </button>

                            @if (session('status') === 'password-updated')
                            <p class="text-sm text-green-400 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Opgeslagen
                            </p>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-red-500/30 p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Account Verwijderen</h2>
                    <p class="text-gray-400">Eenmaal verwijderd, kunnen al je gegevens niet meer worden hersteld</p>
                </div>

                <button 
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-6 py-3 bg-red-500/20 text-red-400 border border-red-500/30 rounded-xl font-semibold hover:bg-red-500/30 transition-all"
                >
                    Account Verwijderen
                </button>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                        @csrf
                        @method('delete')

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-white mb-4">Account Verwijderen?</h2>
                            <p class="text-gray-400 mb-6">
                                Als je account wordt verwijderd, worden alle gegevens en resources permanent verwijderd. Voer je wachtwoord in om te bevestigen.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Wachtwoord</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all"
                                placeholder="Voer je wachtwoord in"
                            />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-4">
                            <button 
                                type="button"
                                x-on:click="$dispatch('close')"
                                class="px-6 py-3 border border-gray-700 rounded-xl text-gray-400 hover:bg-gray-800 transition-all font-semibold"
                            >
                                Annuleren
                            </button>

                            <button type="submit" class="px-6 py-3 bg-red-500/20 text-red-400 border border-red-500/30 rounded-xl font-semibold hover:bg-red-500/30 transition-all">
                                Account Verwijderen
                            </button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </div>
</x-layouts.app>
