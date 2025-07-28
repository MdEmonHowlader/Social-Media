<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\User;

class PostLikedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;
    protected $liker;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, User $liker)
    {
        $this->post = $post;
        $this->liker = $liker;
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
            ->subject('Your post received a clap!')
            ->line($this->liker->name . ' clapped for your post.')
            ->line('Post: ' . $this->post->title)
            ->action('View Post', route('post.show', ['username' => $this->post->user->username, 'post' => $this->post->slug]))
            ->line('Keep up the great work!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Your post received a clap!',
            'message' => $this->liker->name . ' clapped for your post "' . $this->post->title . '"',
            'action_url' => route('post.show', ['username' => $this->post->user->username, 'post' => $this->post->slug]),
            'icon' => 'heart',
            'type' => 'post_liked',
            'post_id' => $this->post->id,
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->name,
        ];
    }
}
