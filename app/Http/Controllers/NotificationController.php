<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\NotificationService;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    use AuthorizesRequests;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display all notifications for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $this->notificationService->getAllNotifications($user, 50);
        $unreadCount = $this->notificationService->getUnreadCount($user);

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Get unread notifications (for AJAX/API calls).
     */
    public function unread()
    {
        $user = Auth::user();
        $notifications = $this->notificationService->getUnreadNotifications($user, 10);
        $unreadCount = $this->notificationService->getUnreadCount($user);

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notification',
                    'message' => $notification->data['message'] ?? '',
                    'action_url' => $notification->data['action_url'] ?? null,
                    'icon' => $notification->data['icon'] ?? 'bell',
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'read' => $notification->read_at !== null,
                ];
            }),
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('notifiable_id', Auth::id())
            ->where('notifiable_type', 'App\Models\User')
            ->first();

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $this->notificationService->markAsRead($id);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        // Check for redirect parameter
        if ($request->has('redirect')) {
            return redirect($request->get('redirect'));
        }

        // If notification has an action URL, redirect to it
        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }

        return back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $this->notificationService->markAllAsRead($user);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification.
     */
    public function destroy(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('notifiable_id', Auth::id())
            ->where('notifiable_type', 'App\Models\User')
            ->first();

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $this->notificationService->deleteNotification($id);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification deleted');
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function destroyAll(Request $request)
    {
        $user = Auth::user();
        $this->notificationService->deleteAllNotifications($user);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications deleted');
    }

    /**
     * Get notification count (for navbar badge).
     */
    public function count()
    {
        $user = Auth::user();
        $unreadCount = $this->notificationService->getUnreadCount($user);

        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * Admin: Send notification to all users.
     */
    public function sendToAll(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'action_url' => 'nullable|url',
            'icon' => 'nullable|string|max:50',
        ]);

        $this->notificationService->broadcastSystemNotification(
            $request->title,
            $request->message,
            $request->action_url,
            $request->icon ?? 'megaphone'
        );

        return back()->with('success', 'Notification sent to all users');
    }

    /**
     * Admin: Get notification statistics.
     */
    public function stats()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $stats = $this->notificationService->getNotificationStats();

        return response()->json($stats);
    }
}
