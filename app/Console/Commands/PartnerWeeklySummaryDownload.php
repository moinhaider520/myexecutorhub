<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PartnerWeeklySummary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PartnerWeeklySummaryDownload extends Command
{
    protected $signature = 'summary:weekly';
    protected $description = 'Generate weekly commission summary PDFs for partners';

    public function handle()
    {
        $partners = User::role('partner')->get();

        foreach ($partners as $partner) {

            $weekStart = now()->subDays(7);
            $weekEnd = now();

            $totalPayouts = $partner->payouts()
                ->where('created_at', '>=', $weekStart)
                ->sum('amount');


            $pdf = Pdf::loadView('partner.pdf.partner-summary', [
                'partner'          => $partner,
                'totalCommission'  => $partner->commission_amount,
                'totalPayouts'     => $totalPayouts,
                'remainingBalance' => $partner->commission_amount,
                'history'          => $partner->payouts()->latest()->take(10)->get()
            ]);

            $fileName = "weekly-summary-{$partner->id}-" . now()->format('YmdHis') . ".pdf";
            $filePath = "summaries/$fileName";

            Storage::put($filePath, $pdf->output());

            PartnerWeeklySummary::create([
                'created_by' => $partner->id,
                'file_path'  => $filePath,
                'week_start' => $weekStart->format('Y-m-d'),
                'week_end'   => $weekEnd->format('Y-m-d'),
            ]);
        }

        return Command::SUCCESS;
    }
}
