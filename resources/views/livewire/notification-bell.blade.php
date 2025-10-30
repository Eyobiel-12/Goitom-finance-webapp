<div x-data="{ open: false }" class="relative" wire:poll.5s="loadNotifications">
    <!-- Notification Bell Button -->
    <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-gray-800/50 transition-colors text-gray-400 hover:text-yellow-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        
        @if($unreadCount > 0)
        <span class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-96 bg-gray-900 border border-yellow-400/20 rounded-xl shadow-2xl z-50 overflow-hidden">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-yellow-400/20 bg-gradient-to-r from-yellow-400/10 to-transparent flex items-center justify-between">
            <h3 class="text-lg font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">
                Meldingen
            </h3>
            @if($unreadCount > 0)
            <button wire:click="markAllAsRead" class="text-xs text-yellow-400 hover:text-yellow-300 transition-colors">
                Alles als gelezen markeren
            </button>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
            <div wire:key="notification-{{ $notification['id'] }}" 
                 class="px-4 py-3 border-b border-gray-800 hover:bg-gray-800/50 transition-colors cursor-pointer {{ !$notification['is_read'] ? 'bg-gray-800/30' : '' }}"
                 @click="open = false; $wire.markAsRead({{ $notification['id'] }})">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        @if($notification['type'] === 'invoice_overdue')
                        <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        @elseif($notification['type'] === 'payment_reminder')
                        <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        @elseif($notification['type'] === 'invoice_paid')
                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        @else
                        <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-100 {{ !$notification['is_read'] ? 'font-bold' : '' }}">
                            {{ $notification['title'] }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1 line-clamp-2">
                            {{ $notification['message'] }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                        </p>
                    </div>
                    @if(!$notification['is_read'])
                    <div class="flex-shrink-0 mt-1">
                        <span class="block w-2 h-2 bg-yellow-400 rounded-full"></span>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p>Geen meldingen</p>
            </div>
            @endforelse
        </div>

        <!-- Footer -->
        @if(count($notifications) > 0)
        <div class="px-4 py-2 border-t border-yellow-400/20 text-center">
            <a href="{{ route('app.dashboard') }}" class="text-xs text-yellow-400 hover:text-yellow-300 transition-colors">
                Alle meldingen bekijken
            </a>
        </div>
        @endif
    </div>
</div>
