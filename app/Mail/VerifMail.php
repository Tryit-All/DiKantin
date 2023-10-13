<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $dataController;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->dataController = $data;
    }

    // public function build()
    // {
    //     return view('email.emails', [
    //         'dataController' => $this->dataController
    //     ]);
    // }
    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Verif Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    public function content(): Content
    {
        return new Content(
            view: 'email.emails',
            with: [
                'dataController' => $this->dataController
            ]
        );
    }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}