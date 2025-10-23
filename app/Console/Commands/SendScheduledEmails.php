<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailSchedule;
use App\Mail\DynamicEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendScheduledEmails extends Command
{
    protected $signature = 'emails:send-scheduled';

    protected $description = 'Send scheduled emails when their time comes';

    public function handle()
    {
        $currentTimeLocal = Carbon::now('Asia/Karachi');
        $emails = EmailSchedule::where('status', 'pending')
            ->where('scheduled_for', '<=', $currentTimeLocal)
            ->get();


        $sentCount = 0;
        $failedCount = 0;

        foreach ($emails as $email) {
            try {
                $name=User::where('email',$email->recipient_email)->value('name');
                Mail::to($email->recipient_email)->send(new DynamicEmail(
                    $email->subject,
                    $email->body,
                    $name
                ));

                $email->update(['status' => 'sent']);
                $sentCount++;
            } catch (\Exception $e) {
                $email->update(['status' => 'failed', 'error_message' => $e->getMessage()]);

                Log::error("Failed to send scheduled email ID: {$email->id}. Error: {$e->getMessage()}");
                $failedCount++;
            }
        }

        $this->info("{$sentCount} scheduled emails sent successfully.");
        if ($failedCount > 0) {
            $this->error("{$failedCount} scheduled emails failed to send. Check logs.");
        }
    }
}
