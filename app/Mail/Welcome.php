<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public array $activities;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
    {
        $this->activities = [
            [
                'title' => "Activation de compte",
                'url' => route('profile.show'),
                'des' => "Lots of people make mistakes while creating paragraphs Some writers just put
                                whitespace in their text",
            ],
            [
                'title' => "Complète ton profil",
                'url' => route('profile.show'),
                'des' => "Complète ton profil pour accéder à toutes les fonctionnalités pour te permettre de
                                construire ton avenir.",
            ],
            [
                'title' => "Découverte",
                'url' => config('app.url'),
                'des' => "Consulte nos offres d’emplois et de bourses.
                                <br>
                                Découvre notre guide pour entreprendre au Bénin.",
            ],
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Bienvenue dans la communauté " . config('app.name') . " ! 🎉",
            to: $this->user->email,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.welcome',
            with: [
                'user' => $this->user,
                'activities' => $this->activities
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
