<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidatResponse extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(protected  $title, protected  $description)
    {
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('wassim@example.com', 'wassim ammar'),
            subject: 'Candidat Response',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'response',
            with: [
                'Title' => $this->title,
                'Description' => $this->description,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
