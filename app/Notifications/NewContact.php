<?php

namespace App\Notifications;

use App\NotifData;
use App\Models\User;
use App\Models\ContactForm;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewContact extends Notification implements ShouldQueue
{
    use Queueable;
    private NotifData $notifData;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ContactForm $contact)
    {
        $this->notifData = new NotifData('Détails du fomulaire : ' . $this->contact->id);
        $this->notifData->setSubject('Nouveau message de contact');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $user = User::find($notifiable->id);
        $user->notify(new DefaultNotif($this->notifData));

        $message =  (new MailMessage)
            ->subject($this->notifData->getSubject())
            ->greeting('Bonjour,')
            ->line($this->notifData->getTitle());

        if (is_array($this->contact->entries)) {
            foreach ($this->contact->entries as $key => $value) {
                $message->line(ucfirst($key) . ': ' . $value);
            }
        } else {
            $message->line('Détails supplémentaires : ' . json_encode($this->contact->entries, JSON_PRETTY_PRINT));
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
