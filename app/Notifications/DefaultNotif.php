<?php

namespace App\Notifications;

use App\Jobs\TelegramMsgJob;
use App\NotifData;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\DefaultNotifMail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class DefaultNotif extends Notification
{
    use Queueable;

    protected bool $sendTelegram;

    /**
     * Create a new notification instance.
     */
    public function __construct(public NotifData $notifData, public array $via = ['database', 'broadcast']) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): \Illuminate\Mail\Mailable | MailMessage
    {
        return (new MailMessage)
            ->subject($this->notifData->getSubject() ?? 'Nouvelle notification sur ' . config('app.name'))
            ->line($this->notifData->getTitle());

        // return (new DefaultNotifMail($this->notifData))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            ...$this->notifData->getData(),
            'via' => $this->via
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $data = $this->notifData->getData();
        return (new BroadcastMessage($data))->onConnection('sync');
    }
}
