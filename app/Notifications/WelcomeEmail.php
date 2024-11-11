<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class WelcomeEmail extends Notification
{
    use Queueable;

    protected $user;

    // Constructor to accept user data
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Define the delivery channels (in this case, email)
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Use a custom Blade template for the email
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Our Service')
            ->markdown('emails.welcome', ['user' => $this->user]);
    }
}
