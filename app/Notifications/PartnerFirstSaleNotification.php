<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PartnerFirstSaleNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $customerName,
    ) {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'First Executor Hub Sale',
            'message' => "Your first recorded sale has been credited for customer {$this->customerName}.",
        ];
    }
}
