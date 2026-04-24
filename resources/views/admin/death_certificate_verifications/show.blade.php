@extends('layouts.master')

@php
    $normalized = $verification->normalized_data ?? [];
    $documentChecks = $verification->document_checks ?? [];
    $matchChecks = $verification->match_checks ?? [];
    $fraudChecks = $verification->fraud_checks ?? [];
    $mismatchReasons = $verification->mismatch_reasons ?? [];
    $currentDecision = match ($verification->verification_status) {
        'approved_by_admin' => 'approve',
        'rejected_by_admin' => 'reject',
        default => 'approve',
    };
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

            .admin-workspace {
                border: 1px solid #edf1f7;
                border-radius: 14px;
                background: #fff;
                padding: 18px;
            }

            .admin-workspace-copy {
                margin-bottom: 16px;
            }

            .admin-workspace-copy h6 {
                margin-bottom: 4px;
                font-size: 15px;
            }

            .admin-workspace-copy p {
                margin: 0;
                color: #6b7280;
                font-size: 13px;
            }

            .admin-field-group {
                border: 1px solid #eef2f7;
                border-radius: 12px;
                padding: 14px;
                background: #fcfdff;
                margin-top: 14px;
            }

            .admin-field-group h6 {
                margin-bottom: 10px;
                font-size: 14px;
            }

            .admin-action-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .admin-action-grid-full {
                grid-column: 1 / -1;
            }

            .admin-submit-area {
                border-top: 1px solid #eef2f7;
                margin-top: 16px;
                padding-top: 16px;
            }

            .admin-submit-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .admin-submit-copy {
                margin-bottom: 10px;
            }

            .admin-submit-copy h6 {
                margin-bottom: 4px;
                font-size: 14px;
            }

            .admin-submit-copy p {
                margin: 0;
                color: #6b7280;
                font-size: 13px;
                line-height: 1.45;
            }

            .admin-submit-button {
                width: 100%;
                min-width: 0;
            }

            .admin-submit-button.is-loading {
                opacity: 0.85;
                cursor: wait;
            }

            .admin-button-spinner {
                display: inline-block;
                width: 14px;
                height: 14px;
                margin-right: 8px;
                border: 2px solid rgba(255, 255, 255, 0.45);
                border-top-color: #fff;
                border-radius: 50%;
                animation: admin-button-spin 0.7s linear infinite;
                vertical-align: -2px;
            }

            @keyframes admin-button-spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .admin-helper-text {
                margin-top: 8px;
                color: #6b7280;
                font-size: 12px;
            }

            .admin-workspace .form-control {
                width: 100%;
                min-width: 0;
            }

            .admin-current-status {
                border: 1px solid #e5edf8;
                border-radius: 12px;
                background: #f8fbff;
                padding: 14px;
                margin-bottom: 16px;
            }

            .admin-current-status h6 {
                margin-bottom: 10px;
                font-size: 14px;
            }

            .admin-status-badge {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 5px 10px;
                font-size: 12px;
                font-weight: 600;
                text-transform: capitalize;
            }

            .admin-status-badge.status-approved {
                background: #e7f8ee;
                color: #198754;
            }

            .admin-status-badge.status-rejected {
                background: #fdecec;
                color: #dc3545;
            }

            .admin-status-badge.status-pending {
                background: #fff6df;
                color: #b58105;
            }

            .admin-current-status p {
                margin-bottom: 8px;
            }

            .admin-current-status p:last-child {
                margin-bottom: 0;
            }

            .admin-workspace textarea.form-control {
                max-width: 100%;
            }

            @media (max-width: 991.98px) {
                .col-xl-8.col-12,
                .col-xl-4.col-12 {
                    max-width: 100%;
                    flex: 0 0 100%;
                }
            }

            @media (max-width: 767.98px) {
                .admin-submit-grid {
                    grid-template-columns: 1fr;
                }

                .admin-workspace {
                    padding: 14px;
                }

                .admin-field-group {
                    padding: 12px;
                }

                .admin-submit-button {
                    width: 100%;
                    min-width: 0;
                }
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
                        <div class="admin-workspace">
                            <div class="admin-current-status">
                                <h6>Current Review</h6>
                                <p>
                                    <strong>Status:</strong>
                                    <span class="admin-status-badge {{ $verification->verification_status === 'approved_by_admin' ? 'status-approved' : ($verification->verification_status === 'rejected_by_admin' ? 'status-rejected' : 'status-pending') }}">
                                        {{ str_replace('_', ' ', $verification->verification_status) }}
                                    </span>
                                </p>
                                <p><strong>Saved Note:</strong> {{ $verification->admin_notes ?: 'No notes added.' }}</p>
                            </div>

                            <div class="admin-workspace-copy">
                                <h6>Review And Decide</h6>
                                <p>Add notes if needed, choose a decision, then submit.</p>
                            </div>
                            <form id="admin-decision-form"
                                  data-approve-url="{{ route('admin.death_certificates.approve', $verification) }}"
                                  data-reject-url="{{ route('admin.death_certificates.reject', $verification) }}"
                                  data-reprocess-url="{{ route('admin.death_certificates.reprocess', $verification) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Admin Notes</label>
                                    <textarea id="admin-notes" name="notes" class="form-control" rows="3" placeholder="Add notes for this review decision..."></textarea>
                                </div>

                                <div class="admin-submit-area">
                                    <div class="admin-submit-copy">
                                        <h6>Decision</h6>
                                        <p>Pick a status and submit once. Reject still requires notes.</p>
                                    </div>
                                    <div class="admin-submit-grid">
                                        <div>
                                            <label class="form-label">Change Status</label>
                                            <select id="admin-decision" name="decision" class="form-control">
                                                <option value="approve" {{ $currentDecision === 'approve' ? 'selected' : '' }}>Approve</option>
                                                <option value="reject" {{ $currentDecision === 'reject' ? 'selected' : '' }}>Reject</option>
                                                <option value="reprocess" {{ $currentDecision === 'reprocess' ? 'selected' : '' }}>Reprocess</option>
                                            </select>
                                            <div id="admin-decision-help" class="admin-helper-text">Approve will update the certificate status.</div>
                                        </div>
                                        <div>
                                            <button type="submit" id="admin-decision-submit" class="btn btn-primary admin-submit-button">Save Decision</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('admin-decision-form');
        const decisionSelect = document.getElementById('admin-decision');
        const decisionHelp = document.getElementById('admin-decision-help');
        const submitButton = document.getElementById('admin-decision-submit');
        const csrfToken = form.querySelector('input[name="_token"]').value;
        const defaultButtonHtml = submitButton.innerHTML;

        const decisionMeta = {
            approve: {
                url: form.dataset.approveUrl,
                button: 'Approve Certificate',
                help: 'Approve will update the certificate status.',
                loading: 'Approving Certificate...',
            },
            reject: {
                url: form.dataset.rejectUrl,
                button: 'Reject Certificate',
                help: 'Reject requires notes so the reason is recorded in the audit trail.',
                loading: 'Rejecting Certificate...',
            },
            reprocess: {
                url: form.dataset.reprocessUrl,
                button: 'Reprocess Certificate',
                help: 'Reprocess runs the analysis again on the same uploaded file.',
                loading: 'Reprocessing Certificate...',
            }
        };

        const updateDecisionUi = function () {
            const current = decisionMeta[decisionSelect.value] || decisionMeta.approve;
            decisionHelp.textContent = current.help;
            submitButton.textContent = current.button;
            submitButton.className = 'btn admin-submit-button';

            if (decisionSelect.value === 'approve') {
                submitButton.classList.add('btn-success');
            } else if (decisionSelect.value === 'reject') {
                submitButton.classList.add('btn-danger');
            } else {
                submitButton.classList.add('btn-warning');
            }
        };

        const showAlert = function (title, text, icon) {
            if (window.Swal) {
                Swal.fire(title, text, icon);
                return;
            }

            window.alert(text);
        };

        const showLoadingState = function (current) {
            submitButton.disabled = true;
            submitButton.classList.add('is-loading');
            submitButton.innerHTML = '<span class="admin-button-spinner" aria-hidden="true"></span>' + current.loading;

            if (window.Swal) {
                Swal.fire({
                    title: current.loading,
                    text: current.help,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: function () {
                        Swal.showLoading();
                    },
                });
            }
        };

        const hideLoadingState = function () {
            submitButton.disabled = false;
            submitButton.classList.remove('is-loading');
            submitButton.innerHTML = defaultButtonHtml;
            updateDecisionUi();

            if (window.Swal && Swal.isVisible()) {
                Swal.close();
            }
        };

        decisionSelect.addEventListener('change', updateDecisionUi);
        updateDecisionUi();

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const current = decisionMeta[decisionSelect.value] || decisionMeta.approve;
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('notes', document.getElementById('admin-notes').value);

            showLoadingState(current);

            fetch(current.url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            })
                .then(async function (response) {
                    const payload = await response.json().catch(function () {
                        return {};
                    });

                    if (!response.ok) {
                        const message = payload.message || (payload.errors ? Object.values(payload.errors).flat().join(' ') : 'Unable to update death certificate status.');
                        throw new Error(message);
                    }

                    return payload;
                })
                .then(function (payload) {
                    if (window.Swal && Swal.isVisible()) {
                        Swal.close();
                    }

                    showAlert('Success', payload.message || 'Death certificate updated successfully.', 'success');
                    window.location.reload();
                })
                .catch(function (error) {
                    if (window.Swal && Swal.isVisible()) {
                        Swal.close();
                    }

                    showAlert('Error', error.message || 'Unable to update death certificate status.', 'error');
                })
                .finally(function () {
                    hideLoadingState();
                });
        });
    });
</script>
@endsection
