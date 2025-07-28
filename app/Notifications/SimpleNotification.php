<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SimpleNotification extends Notification implements ShouldQueue
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->data['title'] ?? 'Notification')
            ->line($this->data['message'] ?? '');

        if (isset($this->data['action_url'])) {
            $mail->action('View', $this->data['action_url']);
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
            'title' => $this->data['title'] ?? 'Notification',
            'message' => $this->data['message'] ?? '',
            'action_url' => $this->data['action_url'] ?? null,
            'icon' => $this->data['icon'] ?? 'bell',
            'type' => 'simple',
        ];
    }
}
