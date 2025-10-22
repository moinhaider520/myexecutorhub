<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $bodyHtml;
    public $recipientName;

    public function __construct($subjectText, $bodyHtml, $recipientName)
    {
        $this->subjectText = $subjectText;
        $this->bodyHtml = $bodyHtml;
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.dynamic')
                    ->with([
                        'bodyHtml' => $this->bodyHtml,
                        'recipientName' => $this->recipientName
                    ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
