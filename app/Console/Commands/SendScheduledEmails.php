<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailSchedule;
use App\Mail\DynamicEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendScheduledEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled emails when their time comes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = EmailSchedule::where('status', 'pending')
            ->where('scheduled_for', '<=', Carbon::now())
            ->get();

        foreach ($emails as $email) {
            Mail::to($email->recipient_email)->send(new DynamicEmail(
                $email->subject,
                $email->body,
                $email->recipient_email
            ));

            $email->update(['status' => 'sent']);
        }

        $this->info(count($emails) . ' scheduled emails sent.');
    }
}
