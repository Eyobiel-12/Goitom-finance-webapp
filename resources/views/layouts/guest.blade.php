<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Goitom Finance') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('build/assets/app-BVG48AMd.css') }}">
    <script type="module" src="{{ asset('build/assets/app-CXDpL9bK.js') }}"></script>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950">
        <div class="min-h-screen flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-2xl font-bold text-gray-900">G</span>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Goitom Finance</span>
                    </a>
                </div>

                <!-- Card -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl border border-yellow-400/20 shadow-2xl p-8">
                    {{ $slot }}
                </div>

                <!-- Footer Links -->
                <div class="mt-6 text-center text-gray-500">
                    <p class="text-sm">
                        Nog geen account?
                        <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">Registreer hier</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>