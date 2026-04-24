<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeathCertificateVerification;
use App\Services\DeathCertificateWorkflowService;
use Illuminate\Http\Request;

class DeathCertificateVerificationController extends Controller
{
    public function index()
    {
        $verifications = DeathCertificateVerification::with(['customer', 'uploader', 'document'])
            ->latest()
            ->paginate(20);

        return view('admin.death_certificate_verifications.index', compact('verifications'));
    }

    public function show(DeathCertificateVerification $verification)
    {
        $verification->load(['customer', 'uploader', 'verifier', 'document', 'reviewActions.actor']);

        return view('admin.death_certificate_verifications.show', compact('verification'));
    }

    public function approve(Request $request, DeathCertificateVerification $verification, DeathCertificateWorkflowService $workflowService)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $workflowService->approve($verification, [], $validated['notes'] ?? null);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Death certificate approved successfully.',
                'status' => 'approved_by_admin',
            ]);
        }

        return redirect()
            ->route('admin.death_certificates.show', $verification)
            ->with('success', 'Death certificate approved successfully.');
    }

    public function reject(Request $request, DeathCertificateVerification $verification, DeathCertificateWorkflowService $workflowService)
    {
        $validated = $request->validate([
            'notes' => 'required|string',
        ]);

        $workflowService->reject($verification, $validated['notes']);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Death certificate rejected successfully.',
                'status' => 'rejected_by_admin',
            ]);
        }

        return redirect()
            ->route('admin.death_certificates.show', $verification)
            ->with('success', 'Death certificate rejected successfully.');
    }

    public function reprocess(Request $request, DeathCertificateVerification $verification, DeathCertificateWorkflowService $workflowService)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $workflowService->reprocess($verification, $validated['notes'] ?? null);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Death certificate reprocessed successfully.',
                'status' => 'pending',
            ]);
        }

        return redirect()
            ->route('admin.death_certificates.show', $verification)
            ->with('success', 'Death certificate reprocessed successfully.');
    }
}
