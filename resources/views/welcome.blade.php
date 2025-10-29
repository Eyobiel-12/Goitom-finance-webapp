<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Goitom Finance - De moderne financiële oplossing voor Habesha freelancers</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

            <link rel="stylesheet" href="{{ asset('build/assets/app-BVG48AMd.css') }}">
    <script type="module" src="{{ asset('build/assets/app-CXDpL9bK.js') }}"></script>
    
            <style>
        body {
            background: linear-gradient(to bottom, #0b0b0b 0%, #1a1a1a 50%, #0b0b0b 100%);
        }
            </style>
    </head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gray-950/90 backdrop-blur-xl border-b border-yellow-400/20">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-10 rounded-lg shadow-lg object-contain">
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('app.dashboard') }}" class="px-4 py-2 text-yellow-400 hover:text-yellow-300 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-400 hover:text-yellow-400 transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                            Start Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-24 rounded-lg shadow-2xl shadow-yellow-400/20 object-contain">
                </div>
                
                <h1 class="text-6xl md:text-7xl font-bold mb-6 leading-tight">
                    <span class="text-white">Beheer je financiën</span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">zoals een pro</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto mb-8">
                    De all-in-one oplossing voor Habesha freelancers om klanten, projecten, facturen en BTW naadloos te beheren.
                </p>
                <div class="flex items-center justify-center gap-4 flex-wrap">
                    <a href="{{ route('register') }}" class="group px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300 flex items-center">
                        Start Gratis
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                    <a href="#features" class="px-8 py-4 bg-gray-900 border border-gray-700 rounded-xl font-semibold text-white hover:border-yellow-400 transition-all">
                        Bekijk Features
                    </a>
                </div>
            </div>

            <!-- Dashboard Preview -->
            <div class="mt-16 relative">
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl p-8 border border-yellow-400/20 shadow-2xl">
                    <div class="aspect-video bg-gray-950 rounded-lg overflow-hidden border border-gray-800">
                        <img src="{{ asset('landingpage.png') }}" alt="Goitom Finance Dashboard" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 px-6 bg-gray-950/50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16">
                <span class="text-white">Alles wat je nodig hebt om</span>
                <br>
                <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">succesvol te zijn</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Klant Management</h3>
                    <p class="text-gray-400">Bewaar alle klantgegevens op één plek. Contactinformatie, projecthistorie en meer.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Professionele Facturen</h3>
                    <p class="text-gray-400">Genereer prachtige PDF facturen met je eigen branding. Verzend direct per e-mail.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Project Tracking</h3>
                    <p class="text-gray-400">Houd uren en projectvoortgang bij. Zie direct wat winstgevend is.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Betalingen</h3>
                    <p class="text-gray-400">Track alle betalingen en blijf op de hoogte van openstaande bedragen.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">BTW Rapportage</h3>
                    <p class="text-gray-400">Genereer automatisch BTW rapporten. Altijd klaar voor de belastingdienst.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Dashboard Insights</h3>
                    <p class="text-gray-400">Real-time statistieken en inzichten om je bedrijf te laten groeien.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Klaar om je financiën naar het volgende niveau te tillen?
            </h2>
            <p class="text-xl text-gray-400 mb-8">
                Start vandaag nog met Goitom Finance. Geen creditcard nodig.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                Start Jouw Gratis Trial
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-6 border-t border-gray-800">
        <div class="max-w-7xl mx-auto text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Goitom Finance. Alle rechten voorbehouden.</p>
        </div>
    </footer>
    </body>
</html>
