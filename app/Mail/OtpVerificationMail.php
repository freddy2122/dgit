<?php

namespace App\Mail;

use App\Models\RegistrationDraft;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RegistrationDraft $draft,
        public string $plainCode
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('site.registration.email_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.otp-verification-text',
        );
    }
}
