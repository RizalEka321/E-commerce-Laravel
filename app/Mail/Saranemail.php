<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Saranemail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $email;
    public $pesan;

    /**
     * Create a new message instance.
     */
    public function __construct(String $nama, String $email, String $pesan)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->pesan = $pesan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Saranemail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Email.saranemail',
            with: [
                'nama' => $this->nama,
                'email' => $this->email,
                'pesan' => $this->pesan
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
