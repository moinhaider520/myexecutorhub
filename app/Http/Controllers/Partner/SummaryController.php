<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerWeeklySummary;
use Illuminate\Support\Facades\Storage;

class SummaryController extends Controller
{

    public function index()
    {
        $summaries = auth()->user()->weeklySummaries()->latest()->get();
        return view('partner.payout_summary.index', compact('summaries'));
    }
    public function download($id)
    {
        $summary = PartnerWeeklySummary::findOrFail($id);

        if (auth()->id() !== $summary->created_by && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if (!Storage::exists($summary->file_path)) {
            abort(404);
        }

        return Storage::download($summary->file_path, basename($summary->file_path));
    }
}
