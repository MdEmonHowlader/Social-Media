<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('System Announcement: ' . ($this->data['title'] ?? 'Update'))
            ->line($this->data['message'] ?? '')
            ->line('This is a system-wide announcement.');

        if (isset($this->data['action_url'])) {
            $mail->action('Learn More', $this->data['action_url']);
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->data['title'] ?? 'System Announcement',
            'message' => $this->data['message'] ?? '',
            'action_url' => $this->data['action_url'] ?? null,
            'icon' => $this->data['icon'] ?? 'megaphone',
            'type' => 'system',
            'priority' => 'high',
        ];
    }
}
