<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class NotificationService
{
    /**
     * Send a notification to a single user.
     */
    public function sendToUser(User $user, $notificationClass, array $data = [])
    {
        $user->notify(new $notificationClass($data));
        return true;
    }

    /**
     * Send a notification to multiple users.
     */
    public function sendToUsers($users, $notificationClass, array $data = [])
    {
        NotificationFacade::send($users, new $notificationClass($data));
        return true;
    }

    /**
     * Send a notification to all users.
     */
    public function sendToAllUsers($notificationClass, array $data = [])
    {
        $users = User::all();
        NotificationFacade::send($users, new $notificationClass($data));
        return true;
    }

    /**
     * Send a notification to admin users only.
     */
    public function sendToAdmins($notificationClass, array $data = [])
    {
        $admins = User::where('role', 'admin')->get();
        NotificationFacade::send($admins, new $notificationClass($data));
        return true;
    }

    /**
     * Get unread notifications for a user.
     */
    public function getUnreadNotifications(User $user, $limit = null)
    {
        $query = $user->unreadNotifications()->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get all notifications for a user.
     */
    public function getAllNotifications(User $user, $limit = null)
    {
        $query = $user->notifications()->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get unread notification count for a user.
     */
    public function getUnreadCount(User $user)
    {
        return $user->unreadNotifications()->count();
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all notifications as read for a user.
     */
    public function markAllAsRead(User $user)
    {
        $user->unreadNotifications()->update(['read_at' => now()]);
        return true;
    }

    /**
     * Delete a notification.
     */
    public function deleteNotification($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->delete();
            return true;
        }
        return false;
    }

    /**
     * Delete all notifications for a user.
     */
    public function deleteAllNotifications(User $user)
    {
        $user->notifications()->delete();
        return true;
    }

    /**
     * Create a simple notification.
     */
    public function createSimpleNotification(User $user, string $title, string $message, string $actionUrl = null, string $icon = 'bell')
    {
        $data = [
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'icon' => $icon,
        ];

        return $this->sendToUser($user, \App\Notifications\SimpleNotification::class, $data);
    }

    /**
     * Broadcast a system notification to all users.
     */
    public function broadcastSystemNotification(string $title, string $message, string $actionUrl = null, string $icon = 'megaphone')
    {
        $data = [
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'icon' => $icon,
        ];

        return $this->sendToAllUsers(\App\Notifications\SystemNotification::class, $data);
    }

    /**
     * Get notification statistics for admin dashboard.
     */
    public function getNotificationStats()
    {
        return [
            'total_notifications' => Notification::count(),
            'unread_notifications' => Notification::whereNull('read_at')->count(),
            'notifications_today' => Notification::whereDate('created_at', today())->count(),
            'notifications_this_week' => Notification::where('created_at', '>=', now()->startOfWeek())->count(),
            'notifications_this_month' => Notification::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
    }
}
