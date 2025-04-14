<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $notifications;
    public $unreadCount;

    public function __construct()
    {
        $user = Auth::user();
        $this->notifications = $user ? $user->notifications()->latest()->take(10)->get() : collect();
        $this->unreadCount = $user ? $user->unreadNotifications()->count() : 0;
    }

    public function render()
    {
        return view('components.notification-bell');
    }
}