<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $post;
    protected $commenter;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, Post $post, User $commenter)
    {
        $this->comment = $comment;
        $this->post = $post;
        $this->commenter = $commenter;
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
            ->subject('New comment on your post')
            ->line($this->commenter->name . ' commented on your post.')
            ->line('Post: ' . $this->post->title)
            ->line('Comment: ' . substr($this->comment->content, 0, 100) . (strlen($this->comment->content) > 100 ? '...' : ''))
            ->action('View Comment', route('post.show', ['username' => $this->post->user->username, 'post' => $this->post->slug]) . '#comment-' . $this->comment->id)
            ->line('Thank you for creating engaging content!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New comment on your post',
            'message' => $this->commenter->name . ' commented on "' . $this->post->title . '"',
            'action_url' => route('post.show', ['username' => $this->post->user->username, 'post' => $this->post->slug]) . '#comment-' . $this->comment->id,
            'icon' => 'chat',
            'type' => 'new_comment',
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->name,
        ];
    }
}
