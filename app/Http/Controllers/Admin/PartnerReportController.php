<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PartnerWeeklySummary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PartnerReportController extends Controller
{
    public function generateForPartner($partnerId)
    {
        $partner = User::role('partner')->findOrFail($partnerId);

        $weekStart = now()->subDays(7);
        $weekEnd = now();

        $totalPayouts = $partner->payouts()
            ->where('created_at', '>=', $weekStart)
            ->sum('amount');

        $pdf = Pdf::loadView('partner.pdf.partner-summary', [
            'partner' => $partner,
            'totalCommission' => $partner->commission_amount,
            'totalPayouts' => $totalPayouts,
            'remainingBalance' => $partner->commission_amount,
            'history' => $partner->payouts()->latest()->take(10)->get()
        ]);

        $fileName = "weekly-summary-{$partner->id}-" . now()->format('YmdHis') . ".pdf";
        $filePath = "summaries/$fileName";

        Storage::put($filePath, $pdf->output());

        PartnerWeeklySummary::create([
            'created_by' => $partner->id,
            'file_path' => $filePath,
            'week_start' => $weekStart->format('Y-m-d'),
            'week_end' => $weekEnd->format('Y-m-d'),
        ]);

        return back()->with('success', 'Commission report generated successfully.');
    }

    public function download($id)
    {
        $summary = PartnerWeeklySummary::findOrFail($id);

        if (!Storage::exists($summary->file_path)) {
            abort(404);
        }

        return Storage::download($summary->file_path, basename($summary->file_path));
    }

    public function view_reports($id)
    {
        $reports = PartnerWeeklySummary::where('created_by', $id)
            ->get();

        return view('admin.partners.view_reports', compact('reports'));
    }
}
