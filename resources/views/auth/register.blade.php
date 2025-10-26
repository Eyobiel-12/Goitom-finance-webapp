<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6">
            <h2 class="text-3xl font-bold text-white mb-2">Maak je account</h2>
            <p class="text-gray-400">Begin vandaag met het beheren van je financiën</p>
        </div>

        <!-- Name -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Naam</label>
            <input id="name" class="block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" 
                   type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Je naam">
            @if ($errors->has('name'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
            <input id="email" class="block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" 
                   type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="je@email.com">
            @if ($errors->has('email'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Wachtwoord</label>
            <input id="password" class="block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" 
                   type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            @if ($errors->has('password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Wachtwoord bevestigen</label>
            <input id="password_confirmation" class="block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-yellow-400 transition-all" 
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            @if ($errors->has('password_confirmation'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
            Account Aanmaken
        </button>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">
                Al een account?
                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">Log hier in</a>
            </p>
        </div>
    </form>
</x-guest-layout>