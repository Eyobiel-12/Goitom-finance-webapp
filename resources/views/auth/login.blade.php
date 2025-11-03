<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6">
            <h2 class="text-3xl font-bold text-white mb-2">Welkom terug</h2>
            <p class="text-gray-400">Log in op je account om verder te gaan</p>
        </div>

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
            <input id="email" class="block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" 
                   type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="je@email.com">
            @if ($errors->has('email'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Wachtwoord</label>
            <input id="password" class="block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" 
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @if ($errors->has('password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-700 bg-gray-800 text-yellow-400 focus:ring-yellow-400 focus:ring-offset-gray-900" name="remember">
                <span class="ms-2 text-sm text-gray-400">Onthouden</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-yellow-400 hover:text-yellow-300 transition-colors" href="{{ route('password.request') }}">
                    Wachtwoord vergeten?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
            Inloggen
        </button>
    </form>
</x-guest-layout>