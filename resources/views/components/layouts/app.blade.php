<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 text-gray-100">
    <div class="min-h-screen flex relative">
        @livewire('sidebar-toggle')
        
        <!-- Sidebar -->
        <aside id="sidebar" class="w-72 bg-gray-950/95 backdrop-blur-xl border-r border-yellow-400/20 min-h-screen flex flex-col shadow-2xl transition-all duration-300">
            <!-- Logo -->
            <div class="p-6 border-b border-yellow-400/20">
                <a href="{{ route('app.dashboard') }}" class="group flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-10 rounded-lg shadow-lg shadow-yellow-400/20 group-hover:shadow-yellow-400/40 transition-all group-hover:scale-105 object-contain">
                </a>
            </div>

            <!-- Navigation -->
            <nav id="sidebar-navigation" class="p-4 space-y-2 flex-1 overflow-y-auto">
                <a href="{{ route('app.dashboard') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('app.dashboard') ? 'bg-gradient-to-r from-yellow-400/20 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 shadow-lg shadow-yellow-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3 nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="{{ route('app.clients.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('app.clients.*') ? 'bg-gradient-to-r from-yellow-400/20 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 shadow-lg shadow-yellow-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="nav-text">Klanten</span>
                </a>
                <a href="{{ route('app.projects.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('app.projects.*') ? 'bg-gradient-to-r from-yellow-400/20 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 shadow-lg shadow-yellow-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="nav-text">Projecten</span>
                </a>
                <a href="{{ route('app.invoices.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('app.invoices.*') ? 'bg-gradient-to-r from-yellow-400/20 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 shadow-lg shadow-yellow-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="nav-text">Facturen</span>
                </a>
                <a href="{{ route('app.btw.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('app.btw.*') ? 'bg-gradient-to-r from-yellow-400/20 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 shadow-lg shadow-yellow-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="nav-text">BTW</span>
                </a>
                
                <a href="{{ route('app.pdf-settings') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('app.pdf-settings') ? 'bg-gradient-to-r from-yellow-400/20 to-yellow-600/10 text-yellow-400 border border-yellow-400/30 shadow-lg shadow-yellow-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="nav-text">PDF-instellingen</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-yellow-400/20 bg-gray-950/50 backdrop-blur-xl user-section-container">
                <div id="user-section" class="flex items-center space-x-3 mb-3 p-3 rounded-xl bg-gradient-to-r from-gray-900/50 to-gray-800/50 border border-gray-800 hover:border-yellow-400/20 transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-gray-900 font-bold shadow-lg shadow-yellow-400/20 user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0 user-info">
                        <p class="text-sm font-medium text-gray-100 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-1 user-links">
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-yellow-400 hover:bg-gray-900/50 rounded-lg transition-all group">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="nav-text">Profiel</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-gray-400 hover:text-red-400 hover:bg-gray-900/50 rounded-lg transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="nav-text">Uitloggen</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-gray-950/80 backdrop-blur-xl border-b border-yellow-400/20 px-6 py-4 sticky top-0 z-10 shadow-lg">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold">
                        <span class="text-gray-400">Welkom terug,</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-600">{{ Auth::user()->name }}</span>
                    </h1>
                    @livewire('notification-bell')
                </div>
            </header>

            <!-- Welcome Popup Overlay -->
            @if(request()->routeIs('app.dashboard') && session('show_welcome'))
            <div id="welcomePopupOverlay" class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none">
                <div id="welcomeMessage" class="welcome-popup opacity-0 pointer-events-none bg-gradient-to-br from-gray-900/95 to-gray-950/95 backdrop-blur-xl rounded-2xl px-8 py-6 border border-yellow-400/30 shadow-2xl">
                    <h1 class="text-3xl font-bold text-center">
                        <span class="text-gray-300">Welkom terug,</span>
                        <br>
                        <span class="text-yellow-400">{{ Auth::user()->name }}</span>
                    </h1>
                </div>
            </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="animate-fade-in">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }
        
        @keyframes welcome-pop {
            0% {
                opacity: 0;
                transform: scale(0.7) translateY(-30px);
                filter: blur(10px);
            }
            10% {
                opacity: 1;
                transform: scale(1.1) translateY(0);
                filter: blur(0);
            }
            15% {
                transform: scale(1) translateY(0);
            }
            85% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            100% {
                opacity: 0;
                transform: scale(0.7) translateY(-30px);
                filter: blur(10px);
            }
        }
        
        .welcome-popup.show {
            animation: welcome-pop 5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        
        #welcomePopupOverlay {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
        }
    </style>

    @livewireScripts
    
    <!-- Onboarding Tour -->
    @livewire('onboarding-tour')
    
    @if(request()->routeIs('app.dashboard') && session('show_welcome'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeMessage = document.getElementById('welcomeMessage');
            const welcomeOverlay = document.getElementById('welcomePopupOverlay');
            if (!welcomeMessage || !welcomeOverlay) return;
            
            // Trigger animatie direct bij eerste load na login
            setTimeout(() => {
                welcomeMessage.classList.add('show');
                welcomeOverlay.classList.remove('pointer-events-none');
            }, 150);
            
            // Verwijder na animatie compleet
            setTimeout(() => {
                welcomeOverlay.style.display = 'none';
            }, 5000);
        });
    </script>
    @endif
</body>
</html>

