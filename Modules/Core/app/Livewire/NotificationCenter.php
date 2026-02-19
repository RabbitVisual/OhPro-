<?php

namespace Modules\Core\Livewire;

use Livewire\Component;

class NotificationCenter extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateCount();
    }

    public function getNotificationsProperty()
    {
        return auth()->user()->notifications()->take(10)->get();
    }

    public function updateCount()
    {
        $this->unreadCount = auth()->user()->unreadNotifications()->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            $this->updateCount();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->updateCount();
    }

    public function render()
    {
        return view('core::livewire.notification-center');
    }
}
