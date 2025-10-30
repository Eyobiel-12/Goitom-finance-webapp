<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

final class NotificationBell extends Component
{
    public int $unreadCount = 0;
    public $notifications = [];

    public function mount(): void
    {
        $this->loadNotifications();
    }

    #[On('notification-read')]
    public function refresh(): void
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $this->unreadCount = Notification::forUser(auth()->id())
            ->unread()
            ->count();

        $this->notifications = Notification::forUser(auth()->id())
            ->latest()
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function markAsRead(int $notificationId): void
    {
        $notification = Notification::find($notificationId);
        
        if ($notification && $notification->user_id === auth()->id() && !$notification->is_read) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->dispatch('notification-read');
        }
    }

    public function markAllAsRead(): void
    {
        Notification::forUser(auth()->id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->loadNotifications();
        $this->dispatch('notification-read');
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
