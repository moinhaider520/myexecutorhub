@extends('layouts.master')

@php
    $normalized = $verification->normalized_data ?? [];
    $documentChecks = $verification->document_checks ?? [];
    $matchChecks = $verification->match_checks ?? [];
    $fraudChecks = $verification->fraud_checks ?? [];
    $mismatchReasons = $verification->mismatch_reasons ?? [];
@endphp

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <style>
            .death-certificate-json {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                color: #212529;
                font-size: 13px;
                line-height: 1.5;
                max-height: 280px;
                overflow: auto;
                padding: 12px;
                white-space: pre-wrap;
                word-break: break-word;
            }
        </style>
        <div class="row widget-grid">
            <div class="col-xl-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Verification #{{ $verification->id }}</h4>
                        <span>{{ $verification->customer->name ?? 'Unknown customer' }} | {{ str_replace('_', ' ', $verification->verification_status) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6>Summary</h6>
                            <p class="mb-1"><strong>Processing:</strong> {{ str_replace('_', ' ', $verification->processing_status) }}</p>
                            <p class="mb-1"><strong>Decision:</strong> {{ str_replace('_', ' ', $verification->verification_status) }}</p>
                            <p class="mb-1"><strong>Confidence Score:</strong> {{ $verification->confidence_score ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Hard Fail Reason:</strong> {{ $verification->hard_fail_reason ?? 'None' }}</p>
                            <p class="mb-0"><strong>Admin Notes:</strong> {{ $verification->admin_notes ?? 'None' }}</p>
                        </div>

                        <div class="mb-4">
                            <h6>Extracted / Normalized Data</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach ($normalized as $key => $value)
                                            <tr>
                                                <th>{{ str_replace('_', ' ', ucfirst($key)) }}</th>
                                                <td>{{ $value ?: 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6>Mismatch Reasons</h6>
                            @if ($mismatchReasons)
                                <ul class="mb-0">
                                    @foreach ($mismatchReasons as $reason)
                                        <li>{{ $reason }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-0">No mismatch reasons recorded.</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h6>OCR Text</h6>
                            <pre class="death-certificate-json">{{ $verification->ocr_raw_text ?? 'No OCR text available yet.' }}</pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Checks</h4>
                    </div>
                    <div class="card-body">
                        <h6>Document Checks</h6>
                        <pre class="death-certificate-json">{{ json_encode($documentChecks, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>

                        <h6>Match Checks</h6>
                        <pre class="death-certificate-json">{{ json_encode($matchChecks, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>

                        <h6>Fraud Checks</h6>
                        <pre class="death-certificate-json">{{ json_encode($fraudChecks, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Admin Actions</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.death_certificates.approve', $verification) }}" class="mb-4">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Override Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="{{ $normalized['full_name'] ?? '' }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Override DOB</label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ $normalized['date_of_birth'] ?? '' }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Override Date of Death</label>
                                <input type="date" name="date_of_death" class="form-control" value="{{ $normalized['date_of_death'] ?? '' }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Override Address</label>
                                <textarea name="usual_address" class="form-control" rows="2">{{ $normalized['usual_address'] ?? '' }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Approve</button>
                        </form>

                        <form method="POST" action="{{ route('admin.death_certificates.reject', $verification) }}" class="mb-4">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Rejection Notes</label>
                                <textarea name="notes" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Reject</button>
                        </form>

                        <form method="POST" action="{{ route('admin.death_certificates.reprocess', $verification) }}">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Reprocess Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Reprocess</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Audit Trail</h4>
                    </div>
                    <div class="card-body">
                        @forelse ($verification->reviewActions as $action)
                            <div class="border-bottom pb-2 mb-2">
                                <strong>{{ ucfirst($action->action) }}</strong><br>
                                <small>{{ $action->actor->name ?? 'System' }} | {{ $action->created_at?->format('Y-m-d H:i') }}</small>
                                <div>{{ $action->notes ?? 'No notes' }}</div>
                            </div>
                        @empty
                            <p class="mb-0">No review actions recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
