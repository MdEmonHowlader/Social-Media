<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'admin_reply',
        'admin_reply_subject',
        'replied_at',
        'replied_by',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Get the admin who replied to this contact
     */
    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Check if contact has been replied to
     */
    public function isReplied()
    {
        return $this->status === 'replied';
    }

    /**
     * Check if contact is new
     */
    public function isNew()
    {
        return $this->status === 'new';
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    /**
     * Mark as replied
     */
    public function markAsReplied($adminId, $replySubject, $replyMessage)
    {
        $this->update([
            'status' => 'replied',
            'admin_reply' => $replyMessage,
            'admin_reply_subject' => $replySubject,
            'replied_at' => now(),
            'replied_by' => $adminId,
        ]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        return match ($this->status) {
            'new' => 'bg-red-100 text-red-800',
            'read' => 'bg-yellow-100 text-yellow-800',
            'replied' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
