<?php

namespace App\Mail;

use App\Models\PortalNotification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PortalNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $title,
        public string $body,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.portal-notification-text',
            with: [
                'userName' => $this->user->name,
                'title' => $this->title,
                'body' => $this->body,
                'dashboardUrl' => url('/'.portal_route_locale().'/dashboard'),
            ],
        );
    }
}
