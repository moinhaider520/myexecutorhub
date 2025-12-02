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
        // Notify the admin about new user registration or after the free trial
        if ($this->isAfterFreeTrial) {
            $this->notifyAdminForNewlyPurchasedPackageCustomer();
            return (new MailMessage)
                ->subject('Welcome Back to Our Service!')
                ->markdown('emails.welcome_after_trial', [
                    'user' => $this->user,
                    'date' => $this->user->created_at->format('F j, Y'), // Date of first subscription
                ]);
        }

        // Notify admin when a new user joins
        $this->notifyAdminForNewCustomer();

        return (new MailMessage)
            ->subject('Welcome to Our Service!')
            ->markdown('emails.welcome', [
                'user' => $this->user,
                'date' => $this->user->created_at->format('F j, Y'), // Registration date
            ]);
    }

    // Function to notify admin about new customer registration
    protected function notifyAdminForNewCustomer()
    {
        Mail::raw("A new user has signed up for {$this->user->subscribed_package} of Executor Hub.\n\nName: {$this->user->name}\nEmail: {$this->user->email}\nRegistration Date: {$this->user->created_at->format('F j, Y')}", function ($message) {
            $message->to('hello@executorhub.co.uk')
                ->subject('New User Registered');
        });
    }

    // Function to notify admin when a user joins after free trial and purchased a package
    protected function notifyAdminForNewlyPurchasedPackageCustomer()
    {
        Mail::raw("A user has joined after the free trial and purchased {$this->user->subscribed_package} package.\n\nName: {$this->user->name}\nEmail: {$this->user->email}\nPurchased Date: {$this->user->created_at->format('F j, Y')}\n\nThank you for coming back!", function ($message) {
            $message->to('hello@executorhub.co.uk')
                ->subject('New User After Free Trial');
        });
    }
}
