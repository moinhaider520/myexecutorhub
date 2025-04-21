<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerMailWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Thank you for completing the New Partner Request Form – we are really pleased to see your interest in Executor Hub.')
                    ->view('emails.partner_welcome')
                    ->with('data', $this->data);
    }
}
