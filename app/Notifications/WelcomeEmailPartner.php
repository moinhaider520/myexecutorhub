<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailPartner extends Notification
{
    use Queueable;

    protected $user;
    protected $isAfterFreeTrial;

    // Constructor to accept user data and trial status
    public function __construct($user, $isAfterFreeTrial = false)
    {
        $this->user = $user;
        $this->isAfterFreeTrial = $isAfterFreeTrial;
    }

    // Define the delivery channels (in this case, email)
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Use a custom Blade template for the email
    public function toMail($notifiable)
    {
        // Notify admin when a new user joins
        $this->notifyAdminForNewCustomer();

        return (new MailMessage)
            ->subject('Welcome aboard — start earning in 15 minutes 🚀')
            ->markdown('emails.welcome_partner', [
                'user' => $this->user,
                'date' => $this->user->created_at->format('F j, Y'), // Registration date
            ]);
    }

    // Function to notify admin about new customer registration
    protected function notifyAdminForNewCustomer()
    {
        Mail::raw("A new user has signed up as a partner on Executor Hub.\n\nName: {$this->user->name}\nEmail: {$this->user->email}\nRegistration Date: {$this->user->created_at->format('F j, Y')}", function ($message) {
            $message->to('hello@executorhub.co.uk')
                ->subject('New Partner Registered');
        });
    }
}
