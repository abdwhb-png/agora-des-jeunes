<?php

namespace App\Mail;

use App\Enums\FeatureType;
use App\Models\User;
use App\Models\Invitation as InvitationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    public array $list;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $inviter, public InvitationModel $invitation, public array $data)
    {
        $this->list = collect(FeatureType::cases())->map(function ($feature) {
            return [
                'title' => $feature->value,
                'desc' => $feature->description(),
            ];
        })->toArray();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rejoins ' . config('app.name') . ' pour ton avenir !',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invitation',
            with: [
                'list' => $this->list,
                'inviter' => $this->inviter,
                'name' => $this->data['name'] ?? '',
                'url' => $this->data['url'] ?? $this->invitation->link,
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
