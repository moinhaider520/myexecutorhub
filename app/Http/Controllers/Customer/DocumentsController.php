<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\OnboardingProgress;
use App\Mail\DocumentMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\ImageUpload;
use App\Models\DocumentTypes;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Illuminate\Support\Facades\Http;

class DocumentsController extends Controller
{
    use ImageUpload;

    public function view()
    {
        $documentTypes = DocumentTypes::where('created_by', Auth::id())->get();
        $documents = Document::where('created_by', Auth::id())->get();

        $usedDocumentTypes = $documents->pluck('document_type')->unique()->toArray();

        return view('customer.documents.documents', compact('documents', 'documentTypes', 'usedDocumentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png',
            'reminder_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $path = $this->imageUpload($request->file('file'), 'documents');
            $fullPath = public_path('assets/upload/' . $path);    // now we have the full path

            $extractedText = $this->extract($fullPath, $path);
            $data = $extractedText['data'];
            $document = Document::create([
                'document_type' => $request->document_type,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id(),
                'reminder_date' => $request->reminder_date,
                'reminder_type' => $request->reminder_type,
                'textpdf' => $extractedText['preview'] ?? null,
                'json_response' => json_encode($extractedText['data'] ?? null),
            ]);
            if ($request->document_type == "Will") {

                $willRequest = new Request([
                    'will_user_id' => $request->will_user_id ?? null,
                    'legal_name' => $data['full_legal_name'] ?? null,
                    'user_name' => $data['user_name'] ?? null,
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'address_line_1' => $data['address_line1'] ?? null,
                    'address_line_2' => $data['address_line2'] ?? null,
                    'city' => $data['city'] ?? null,
                    'post_code' => $request->post_code ?? null,
                    'phone_number' => $data['phone_number'] ?? null,
                    'martial_status' => $data['marital_status'] ?? null,
                    'children' => $data['has_children'] ?? 'no',
                    'pets' => $data['has_pets'] ?? 'no',
                ]);
                $willController = new WillGeneratorController();

                $willUser = $willController->store_about_you($willRequest, true);
                $will_user_id = $willUser->id;

                // Now handle assets
                $assets = $extractedText['data']['assets'] ?? [];

                if (is_array($assets)) {
                    // remove dd() when you want code to continue
                    // dd($assets);

                    foreach ($assets as $type => $values) {
                        foreach ((array) $values as $value) {
                            $value = trim((string)$value);
                            if ($value === '') {
                                continue; // skip empty values
                            }

                            $assetRequest = new Request([
                                'asset_type'     => $type,
                                'asset_value'    => $value,
                                'has_mortgage'   => false,
                                'ownership_type' => 'self',
                            ]);

                            $willController->store_account_properties($assetRequest, $will_user_id);
                        }
                    }
                }



                $gifts = $extractedText['data']['gifts'] ?? [];

                if (is_array($gifts)) {
                    foreach ($gifts as $gift) {
                        // ensure $gift is an array
                        if (!is_array($gift)) {
                            // optionally log and skip
                            \Log::warning('Skipping non-array gift item', ['gift' => $gift]);
                            continue;
                        }

                        // normalize keys and values
                        $description = trim((string) ($gift['Description_of_gift'] ?? $gift['description'] ?? ''));
                        $message     = trim((string) ($gift['message_to_gift_receiver'] ?? $gift['message'] ?? ''));
                        if ($description === '' && $message === '') {
                            // nothing meaningful — skip
                            continue;
                        }

                        // prepare executors (example: if extractor returns CSV or array)
                        $executors = $gift['executors'] ?? [];
                        if (is_string($executors)) {
                            // maybe a comma separated list
                            $executors = array_filter(array_map('trim', explode(',', $executors)));
                        }
                        if (!is_array($executors)) {
                            $executors = [];
                        }

                        // create request-like payload
                        $giftRequest = new Request([
                            'type'             => $gift['type'] ?? 'one-off',
                            'item_description' => $description,
                            'message'          => $message ?: null,
                            // if your controller expects JSON string for executors:
                            'executors'        => $executors,
                        ]);
                            $willController->store_add_gift($giftRequest, $will_user_id);
                    }
                }
            }
            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['document_uploaded' => true]
            );

            if (!$progress->document_uploaded) {
                $progress->document_uploaded = true;
                $progress->save();
            }

            DB::commit();

            // Send email
            $user = Auth::user();
            $data = [
                'first_name' => $user->name,
                'document_name' => $document->document_type,
            ];

            // Send push notification
            if ($user->expo_token) {
                $expo = new Expo();
                $message = new ExpoMessage([
                    'title' => 'New Document Uploaded',
                    'body' => "Your document '{$document->document_type}' has been successfully uploaded.",
                ]);
                $expo->send($message)->to($user->expo_token)->push();
            }

            Mail::to($user->email)->send(new DocumentMail($data));

            return response()->json(['success' => true, 'message' => 'Document added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function extract(string $fullPath, string $filename)
    {
        // ===== MOCK MODE: RETURN STATIC DATA =====
        $mock = false; // set true while Python API is down
        if ($mock) {
            return [
                "data" => [
                    "full_legal_name" => "Test",
                    "preferred_name" => null,
                    "date_of_birth" => "08/02/2020",
                    "address_line1" => null,
                    "address_line2" => null,
                    "city" => null,
                    "phone_number" => null,
                    "marital_status" => "married",
                    "has_children" => "no",
                    "has_pets" => "yes",
                    "assets" => [
                        "Bank Account" => ["hsbc"],
                        "Pension" => ["aviva"],
                        "Life Insurance" => ["legal & general"],
                        "Stocks and Shares" => ["invesco"],
                        "Property" => ["9 offington lane"],
                        "Other" => ["money under the mattress"],
                    ],
                    "funeral_Plan_provider_name" => null,
                    "funeral_identification_no" => null,
                    "Type_of_funeral" => "Let the people responsible for my estate decide",
                    "additional_wishes_for_funeral" => "big party",
                    "gifts" => [
                        [
                            "Description_of_gift" => "£1000 to NSPCC (THE NATIONAL SOCIETY FOR THE PREVENTION OF CRUELTY TO CHILDREN)",
                            "message_to_gift_receiver" => null,
                        ],
                        [
                            "Description_of_gift" => "books at the date of my death to FIONA JOHNS",
                            "message_to_gift_receiver" => "i hope you like them",
                        ],
                        [
                            "Description_of_gift" => "wedding ring to RONNIE JOHNS",
                            "message_to_gift_receiver" => "enjoy",
                        ],
                        [
                            "Description_of_gift" => "car aa11 1aa",
                            "message_to_gift_receiver" => "broom broom!",
                        ],
                    ],
                ]
            ];
        }


        // ===== ORIGINAL CODE (for future use) =====
        if (!file_exists($fullPath)) {
            throw new \RuntimeException("File not found: {$fullPath}");
        }

        $resp = Http::asMultipart()
            ->attach('file', fopen($fullPath, 'r'), $filename)
            ->post('http://16.171.35.45:8000/extract', [
                'lang'                => 'eng',
                'dpi'                 => 300,
                'ocr_psm'             => 3,
                'force_ocr'           => false,
                'ocr_on_empty_only'   => true,
                'include_text_preview' => true,
            ]);

        if (!$resp->successful()) {
            throw new \RuntimeException("OCR API failed: {$resp->status()} {$resp->body()}");
        }

        return $resp->json();
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
            'reminder_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $document = Document::findOrFail($id);

            $document->document_type = $request->document_type;
            $document->description = $request->description;
            $document->reminder_type = $request->edit_reminder_type;

            $document->created_by = Auth::id();

            if ($request->hasFile('file')) {
                // Delete the file from the public/assets/upload directory
                $filePath = public_path('assets/upload/' . basename($document->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'documents');
                $document->file_path = $path;
            }

            $document->reminder_date = $request->reminder_date;
            $document->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Document updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $document = Document::findOrFail($id);
            // Delete the file from the public/assets/upload directory
            $filePath = public_path('assets/upload/' . basename($document->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('customer.documents.view')->with('success', 'Document deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_document_type' => 'required|string|max:255|unique:document_types,name'
        ]);

        DocumentTypes::create([
            'name' => $request->custom_document_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
