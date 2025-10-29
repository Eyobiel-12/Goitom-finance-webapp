<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Wachtwoord Vergeten</title>

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
            <!-- Left Side - Image/Pattern -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-yellow-600 to-yellow-400 relative overflow-hidden">
                <div class="absolute inset-0 bg-gray-950/10"></div>
                <div class="relative z-10 flex flex-col justify-center items-center p-12">
                    <div class="text-center space-y-6">
                        <div class="w-32 h-32 bg-white rounded-3xl flex items-center justify-center shadow-2xl mx-auto">
                            <span class="text-6xl font-bold text-gray-900">G</span>
                        </div>
                        <h1 class="text-5xl font-bold text-gray-900">Goitom Finance</h1>
                        <p class="text-xl text-gray-800">Veilig & Betrouwbaar</p>
                        <div class="mt-12 space-y-4 text-left max-w-md">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">100% Beveiligd</h3>
                                    <p class="text-gray-800 text-sm">Je account is volledig beveiligd</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Snel & Eenvoudig</h3>
                                    <p class="text-gray-800 text-sm">Reset je wachtwoord in minuten</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Verificatie via E-mail</h3>
                                    <p class="text-gray-800 text-sm">OTP-code voor extra beveiliging</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Reset Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                @livewire('forgot-password-multi-step')
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
