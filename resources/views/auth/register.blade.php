<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Registreren</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <div class="min-h-screen flex">
            <!-- Left Side - Image/Pattern -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-yellow-600 to-yellow-400 relative overflow-hidden">
                <div class="absolute inset-0 bg-gray-950/10"></div>
                <div class="relative z-10 flex flex-col justify-center items-center p-12">
                    <div class="text-center space-y-6">
                        <div class="w-32 h-32 bg-white rounded-3xl flex items-center justify-center shadow-2xl mx-auto">
                            <span class="text-6xl font-bold text-gray-900">G</span>
                        </div>
                        <h1 class="text-5xl font-bold text-gray-900">Goitom Finance</h1>
                        <p class="text-xl text-gray-800">Professionele Financiële Diensten</p>
                        <div class="mt-12 space-y-4 text-left max-w-md">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Professioneel Factuurbeheer</h3>
                                    <p class="text-gray-800 text-sm">Maak mooie facturen in minuten</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Automatische BTW-berekeningen</h3>
                                    <p class="text-gray-800 text-sm">Alles automatisch berekend</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">100% Beveiligd</h3>
                                    <p class="text-gray-800 text-sm">Je gegevens zijn veilig</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Registration Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                @livewire('register-multi-step')
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
