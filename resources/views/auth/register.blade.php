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
    <link rel="stylesheet" href="{{ asset('build/assets/app-BVG48AMd.css') }}">
    <script type="module" src="{{ asset('build/assets/app-CXDpL9bK.js') }}"></script>
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950">
    <div class="min-h-screen">
        <div class="min-h-screen flex">
            <!-- Left Side - Golden Showcase -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(0,0,0,0.3) 1px, transparent 0); background-size: 40px 40px;"></div>
                </div>
                
                <!-- Animated Blobs -->
                <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-yellow-300 to-yellow-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
                
                <!-- Content -->
                <div class="relative z-10 w-full h-full flex flex-col justify-center items-center p-12">
                    <div class="max-w-lg w-full space-y-8 text-center">
                        <!-- Logo -->
                        <div class="flex justify-center">
                            <div class="relative">
                                <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-40 rounded-3xl shadow-2xl shadow-gray-900/50 object-contain transform hover:scale-105 transition-transform duration-300">
                                <!-- Glow effect -->
                                <div class="absolute inset-0 rounded-3xl bg-yellow-200 blur-xl opacity-50 -z-10"></div>
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="space-y-2">
                            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Goitom Finance</h1>
                            <p class="text-lg text-gray-800 font-medium">Professionele Financiële Diensten</p>
                        </div>

                        <!-- Features -->
                        <div class="space-y-4 mt-8">
                            <div class="flex items-center justify-center space-x-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-gray-900 text-base">Professioneel Factuurbeheer</h3>
                                    <p class="text-gray-700 text-xs">Maak mooie facturen in minuten</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-center space-x-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-gray-900 text-base">Automatische BTW-berekeningen</h3>
                                    <p class="text-gray-700 text-xs">Alles automatisch berekend</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-center space-x-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-gray-900 text-base">100% Beveiligd</h3>
                                    <p class="text-gray-700 text-xs">Je gegevens zijn veilig</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Text -->
                        <div class="mt-8 p-4 bg-gradient-to-r from-gray-900/80 to-gray-800/80 backdrop-blur-md rounded-xl border-2 border-gray-800/50 shadow-xl">
                            <p class="text-white font-semibold text-base">Begin vandaag nog</p>
                            <p class="text-gray-300 text-xs mt-1">Word onderdeel van honderden tevreden ondernemers</p>
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
