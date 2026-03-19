<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PartnerActivatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $partnerName,
    ) {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Partner Activated',
            'message' => "{$this->partnerName}, your partner onboarding is now complete.",
        ];
    }
}
