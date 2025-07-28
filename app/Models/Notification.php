<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the notifiable entity that the notification belongs to.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread()
    {
        if (!is_null($this->read_at)) {
            $this->forceFill(['read_at' => null])->save();
        }
    }

    /**
     * Determine if a notification has been read.
     */
    public function read()
    {
        return $this->read_at !== null;
    }

    /**
     * Determine if a notification has not been read.
     */
    public function unread()
    {
        return $this->read_at === null;
    }

    /**
     * Get the notification's title.
     */
    public function getTitle()
    {
        return $this->data['title'] ?? 'Notification';
    }

    /**
     * Get the notification's message.
     */
    public function getMessage()
    {
        return $this->data['message'] ?? '';
    }

    /**
     * Get the notification's action URL.
     */
    public function getActionUrl()
    {
        return $this->data['action_url'] ?? null;
    }

    /**
     * Get the notification's icon.
     */
    public function getIcon()
    {
        return $this->data['icon'] ?? 'bell';
    }

    /**
     * Get the notification type for display.
     */
    public function getTypeForDisplay()
    {
        $type = class_basename($this->type);
        return str_replace('Notification', '', $type);
    }

    /**
     * Get the time ago format for the notification.
     */
    public function getTimeAgo()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope for recent notifications.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
