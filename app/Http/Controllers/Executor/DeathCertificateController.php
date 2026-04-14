<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\DeathCertificateVerification;
use App\Models\Document;
use App\Services\DeathCertificateWorkflowService;
use App\Traits\CloudinaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeathCertificateController extends Controller
{
    use CloudinaryUpload;

    public function index()
    {
        $contextUser = ContextHelper::user();

        $verifications = DeathCertificateVerification::with(['document', 'uploader', 'reviewActions.actor'])
            ->where('customer_id', $contextUser->id)
            ->latest()
            ->get();

        return view('executor.death_certificates.index', compact('verifications', 'contextUser'));
    }

    public function store(Request $request, DeathCertificateWorkflowService $workflowService)
    {
        $request->validate([
            'description' => 'nullable|string',
            'files' => 'required',
            'files.*' => 'file|max:20480|mimes:pdf,jpg,jpeg,png',
        ]);

        try {
            DB::beginTransaction();

            $contextUser = ContextHelper::user();
            $storedFiles = [];
            $text = null;
            $verificationUploadMeta = null;

            foreach ($request->file('files') as $file) {
                if ($verificationUploadMeta === null) {
                    $verificationUploadMeta = [
                        'document_sha256' => hash_file('sha256', $file->getRealPath()),
                        'uploaded_file_name' => $file->getClientOriginalName(),
                        'uploaded_file_size' => $file->getSize(),
                    ];
                }

                $upload = $this->uploadFileToCloud($file, 'executorhub/death-certificates');
                $storedFiles[] = [
                    'url' => $upload['url'],
                    'public_id' => $upload['public_id'],
                ];

                if (strtolower($file->getClientOriginalExtension()) === 'pdf') {
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($file->getRealPath());
                        $text .= "\n" . $pdf->getText();
                    } catch (\Exception) {
                    }
                }
            }

            $document = Document::create([
                'document_type' => 'death_certificate',
                'description' => $request->description ?: 'Death certificate upload',
                'file_path' => json_encode($storedFiles),
                'created_by' => $contextUser->id,
                'textpdf' => $text ? mb_convert_encoding($text, 'UTF-8', 'UTF-8') : null,
            ]);

            $workflowService->createForDocument(
                document: $document,
                customerId: $contextUser->id,
                uploadedBy: Auth::id(),
                uploadMeta: $verificationUploadMeta ?? [],
            );

            DB::commit();

            return redirect()
                ->route('executor.death_certificates.index')
                ->with('success', 'Death certificate uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(DeathCertificateVerification $verification)
    {
        $contextUser = ContextHelper::user();
        abort_if($verification->customer_id !== $contextUser->id, 403);

        try {
            DB::beginTransaction();

            $document = $verification->document;

            if ($document) {
                $storedFiles = $this->decodeStoredFiles($document->getRawOriginal('file_path'));
                $this->deleteStoredFiles($storedFiles);
                $document->delete();
            }

            DB::commit();

            return redirect()
                ->route('executor.death_certificates.index')
                ->with('success', 'Death certificate deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    private function decodeStoredFiles($storedFiles): array
    {
        if (is_array($storedFiles)) {
            return $storedFiles;
        }

        if (empty($storedFiles)) {
            return [];
        }

        $decoded = json_decode($storedFiles, true);

        return is_array($decoded) ? $decoded : [$storedFiles];
    }

    private function deleteStoredFiles(array $storedFiles): void
    {
        foreach ($storedFiles as $file) {
            if (is_array($file) && !empty($file['public_id'])) {
                $this->deleteFromCloud($file['public_id']);
                continue;
            }

            $path = is_array($file) ? ($file['url'] ?? null) : $file;
            if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
                continue;
            }

            $filePath = public_path('assets/upload/' . basename($path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
