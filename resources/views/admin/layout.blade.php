<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }
        .hover-lift:hover { transform: translateY(-2px); }
        .hover-glow:hover { box-shadow: 0 0 20px rgba(239, 68, 68, 0.3); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2); }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: scale(1.02); }
        .modal-backdrop { backdrop-filter: blur(4px); }
        .modal-content { animation: fadeIn 0.2s ease-out; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 text-gray-100">
    <div class="min-h-screen flex relative">
        <!-- Sidebar -->
        <aside class="w-72 bg-gray-950/95 backdrop-blur-xl border-r border-red-400/20 min-h-screen flex flex-col shadow-2xl">
            <!-- Logo -->
            <div class="p-6 border-b border-red-400/20">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center justify-center">
                    <div class="text-2xl font-bold bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">
                        🔐 Admin
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-400/20 to-red-600/10 text-red-400 border border-red-400/30 shadow-lg shadow-red-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.organizations.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.organizations.*') ? 'bg-gradient-to-r from-red-400/20 to-red-600/10 text-red-400 border border-red-400/30 shadow-lg shadow-red-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Organisaties</span>
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-red-400/20 to-red-600/10 text-red-400 border border-red-400/30 shadow-lg shadow-red-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Gebruikers</span>
                </a>
                <a href="{{ route('admin.subscriptions.index') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.subscriptions.*') ? 'bg-gradient-to-r from-red-400/20 to-red-600/10 text-red-400 border border-red-400/30 shadow-lg shadow-red-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span>Abonnementen</span>
                </a>
                <a href="{{ route('admin.statistics') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.statistics') ? 'bg-gradient-to-r from-red-400/20 to-red-600/10 text-red-400 border border-red-400/30 shadow-lg shadow-red-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Statistieken</span>
                </a>
                <a href="{{ route('admin.system-health') }}" 
                   class="group flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.system-health') ? 'bg-gradient-to-r from-red-400/20 to-red-600/10 text-red-400 border border-red-400/30 shadow-lg shadow-red-400/10' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:translate-x-2 hover:shadow-lg' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Systeem Health</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-red-400/20 bg-gray-950/50 backdrop-blur-xl">
                <div class="flex items-center space-x-3 mb-3 p-3 rounded-xl bg-gradient-to-r from-gray-900/50 to-gray-800/50 border border-gray-800">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-red-400/20">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-100 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('app.dashboard') }}" class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-yellow-400 hover:bg-gray-900/50 rounded-lg transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Naar App</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-gray-400 hover:text-red-400 hover:bg-gray-900/50 rounded-lg transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Uitloggen</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-gradient-to-r from-gray-950/80 via-gray-900/80 to-gray-950/80 backdrop-blur-xl px-6 py-4 sticky top-0 z-10 border-b border-gray-800/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">@yield('title', 'Admin Panel')</h1>
                    <div class="flex items-center space-x-4">
                        <div class="px-3 py-1.5 rounded-xl bg-gray-800/50 border border-gray-700/50">
                            <p class="text-sm text-gray-300 font-semibold">{{ now()->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-400 font-semibold">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center space-x-3">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-400 font-semibold">{{ session('error') }}</p>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>

