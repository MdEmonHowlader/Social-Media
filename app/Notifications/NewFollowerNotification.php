<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewFollowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $follower;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You have a new follower!')
            ->line($this->follower->name . ' is now following you.')
            ->action('View Profile', route('profile.show', $this->follower->username))
            ->line('Your content is inspiring others!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New follower!',
            'message' => $this->follower->name . ' started following you',
            'action_url' => route('profile.show', $this->follower->username),
            'icon' => 'user',
            'type' => 'new_follower',
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_username' => $this->follower->username,
        ];
    }
}
