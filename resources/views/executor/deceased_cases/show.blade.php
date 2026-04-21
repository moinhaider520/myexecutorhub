@extends('layouts.master')

@section('content')
<div class="page-body deceased-case-page">
  <div class="container-fluid default-dashboard">
    <style>
      .deceased-case-page {
        --case-ink: #1f2933;
        --case-muted: #6b7280;
        --case-line: #e5e7eb;
        --case-panel: #ffffff;
        --case-soft: #f6f8f4;
        --case-green: #27533d;
        --case-blue: #2f80b7;
        --case-orange: #d7723f;
        --case-red: #d94b4b;
      }

      .case-hero {
        background: linear-gradient(135deg, #f8faf6 0%, #ffffff 48%, #eef5ef 100%);
        border: 1px solid #edf1ec;
        border-radius: 24px;
        box-shadow: 0 18px 45px rgba(31, 41, 51, .06);
        margin-bottom: 24px;
        padding: 26px;
      }

      .case-eyebrow {
        color: var(--case-green);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
      }

      .case-title {
        color: var(--case-ink);
        font-size: 28px;
        font-weight: 800;
        margin: 4px 0;
      }

      .case-subtitle {
        color: var(--case-muted);
        font-size: 15px;
      }

      .case-action-button {
        background: var(--case-green);
        border: 0;
        border-radius: 14px;
        color: #fff;
        font-weight: 700;
        padding: 12px 20px;
      }

      .case-switcher {
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
      }

      .case-switcher label {
        color: var(--case-muted);
        font-size: 13px;
        font-weight: 800;
        margin: 0;
      }

      .case-switcher select {
        border: 1px solid var(--case-line);
        border-radius: 12px;
        min-height: 42px;
        min-width: 260px;
        padding: 8px 12px;
      }

      .case-switcher button {
        background: #fff;
        border: 1px solid var(--case-green);
        border-radius: 12px;
        color: var(--case-green);
        font-weight: 800;
        min-height: 42px;
        padding: 8px 14px;
      }

      .case-stat-grid {
        display: grid;
        gap: 14px;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        margin-bottom: 24px;
      }

      .case-stat-card {
        background: var(--case-panel);
        border: 1px solid var(--case-line);
        border-radius: 18px;
        padding: 18px;
      }

      .case-stat-label {
        color: var(--case-muted);
        display: block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
        margin-bottom: 8px;
        text-transform: uppercase;
      }

      .case-stat-value {
        color: var(--case-ink);
        font-size: 20px;
        font-weight: 800;
      }

      .case-panel {
        background: var(--case-panel);
        border: 1px solid var(--case-line);
        border-radius: 22px;
        box-shadow: 0 14px 32px rgba(31, 41, 51, .05);
        overflow: hidden;
      }

      .case-panel-header {
        align-items: center;
        border-bottom: 1px solid var(--case-line);
        display: flex;
        justify-content: space-between;
        padding: 20px 22px;
      }

      .case-panel-title {
        font-size: 19px;
        font-weight: 800;
        margin: 0;
      }

      .case-count-pill {
        background: var(--case-soft);
        border-radius: 999px;
        color: var(--case-green);
        font-size: 13px;
        font-weight: 800;
        padding: 8px 13px;
      }

      .case-table {
        margin-bottom: 0;
      }

      .case-panel .dataTables_wrapper {
        padding: 0 22px 22px;
      }

      .case-panel .dataTables_length,
      .case-panel .dataTables_filter {
        color: var(--case-muted);
        font-size: 13px;
        margin-bottom: 0;
      }

      .case-panel .dataTables_filter input,
      .case-panel .dataTables_length select {
        border: 1px solid var(--case-line);
        border-radius: 10px;
        margin-left: 8px;
        min-height: 36px;
        padding: 6px 10px;
      }

      .case-panel .dataTables_info {
        color: var(--case-muted);
        font-size: 13px;
        padding-top: 16px;
      }

      .case-panel .dataTables_paginate {
        padding-top: 14px;
      }

      .case-panel .dataTables_paginate .paginate_button {
        border: 1px solid var(--case-line) !important;
        border-radius: 10px !important;
        color: var(--case-ink) !important;
        margin-left: 6px;
        padding: 6px 11px !important;
      }

      .case-panel .dataTables_paginate .paginate_button.current {
        background: var(--case-green) !important;
        border-color: var(--case-green) !important;
        color: #fff !important;
      }

      .case-table thead th {
        background: #fbfcfa;
        border-bottom: 1px solid var(--case-line);
        color: #334155;
        font-size: 12px;
        letter-spacing: .07em;
        padding: 14px 18px;
        text-transform: uppercase;
      }

      .case-table tbody td {
        border-top: 1px solid #f0f2f4;
        padding: 18px;
        vertical-align: middle;
      }

      .case-org-name {
        color: var(--case-ink);
        font-size: 16px;
        font-weight: 800;
      }

      .case-org-meta {
        color: var(--case-muted);
        display: block;
        font-size: 13px;
        margin-top: 4px;
      }

      .status-badge {
        border-radius: 999px;
        display: inline-block;
        font-size: 12px;
        font-weight: 800;
        padding: 7px 11px;
      }

      .status-suggested,
      .status-not_started {
        background: #eef5ff;
        color: #2463a6;
      }

      .status-ready_to_send,
      .status-awaiting_reply {
        background: #fff6df;
        color: #9a6200;
      }

      .status-sent,
      .status-reply_received {
        background: #e9f8ef;
        color: #1d6b3a;
      }

      .status-more_info_required {
        background: #fff0ec;
        color: #b94b25;
      }

      .status-completed,
      .status-closed_no_account_found {
        background: #eef1f4;
        color: #475569;
      }

      .case-action-stack {
        align-items: stretch;
        display: grid;
        gap: 8px;
        grid-template-columns: minmax(150px, 1fr) auto;
        max-width: 280px;
      }

      .case-mini-btn {
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        padding: 8px 11px;
      }

      .case-mini-btn-outline {
        background: #fff;
        border: 1px solid var(--case-green);
        color: var(--case-green);
      }

      .case-mini-btn-green {
        background: #0e9f55;
        border: 1px solid #0e9f55;
        color: #fff;
      }

      .case-mini-btn-orange {
        background: var(--case-orange);
        border: 1px solid var(--case-orange);
        color: #fff;
      }

      .case-mini-btn-blue {
        background: var(--case-blue);
        border: 1px solid var(--case-blue);
        color: #fff;
      }

      .case-action-dropdown .dropdown-toggle {
        background: var(--case-green);
      }

      .case-action-select {
        border: 1px solid var(--case-line);
        border-radius: 10px;
        color: var(--case-ink);
        font-size: 13px;
        font-weight: 700;
        min-height: 40px;
        padding: 8px 10px;
        width: 100%;
      }

      .case-action-go {
        background: var(--case-green);
        border: 0;
        border-radius: 10px;
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        min-height: 40px;
        padding: 8px 14px;
      }

      .case-table-toolbar {
        align-items: center;
        border-bottom: 1px solid var(--case-line);
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: space-between;
        padding: 16px 22px;
      }

      .case-table-toolbar .dataTables_filter,
      .case-table-toolbar .dataTables_length {
        float: none;
      }

      .case-empty {
        color: var(--case-muted);
        padding: 32px;
        text-align: center;
      }

      .case-modal-note {
        background: var(--case-soft);
        border-radius: 14px;
        color: var(--case-muted);
        font-size: 13px;
        padding: 12px 14px;
      }

      .deceased-case-page .modal-header .close {
        align-items: center;
        background: #f1f5f2;
        border: 0;
        border-radius: 999px;
        color: var(--case-green);
        display: inline-flex;
        font-size: 22px;
        font-weight: 700;
        height: 36px;
        justify-content: center;
        line-height: 1;
        opacity: 1;
        text-shadow: none;
        transition: background .2s ease, color .2s ease, transform .2s ease;
        width: 36px;
      }

      .deceased-case-page .modal-header .close:hover {
        background: var(--case-green);
        color: #fff;
        transform: rotate(90deg);
      }

      @media (max-width: 991px) {
        .case-stat-grid {
          grid-template-columns: repeat(2, minmax(0, 1fr));
        }
      }

      @media (max-width: 575px) {
        .case-stat-grid {
          grid-template-columns: 1fr;
        }

        .case-panel-header {
          align-items: flex-start;
          flex-direction: column;
          gap: 10px;
        }
      }
    </style>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="case-hero">
      <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
          <div class="case-eyebrow">Deceased Case</div>
          <h2 class="case-title">{{ $deceasedCase->deceased_full_name }}</h2>
          <div class="case-subtitle">
            Case {{ $deceasedCase->case_reference }} | Date of death {{ optional($deceasedCase->deceased_date_of_death)->format('Y-m-d') ?: 'N/A' }}
          </div>
          @if($linkedCustomers->count() > 1)
            <form class="case-switcher" method="POST" action="{{ route('executor.deceased_cases.switch_customer') }}">
              @csrf
              <label for="case_customer_id">Switch customer case</label>
              <select id="case_customer_id" name="customer_id">
                @foreach($linkedCustomers as $linkedCustomer)
                  <option value="{{ $linkedCustomer->id }}" @selected($linkedCustomer->id === $contextUser->id)>
                    {{ trim(($linkedCustomer->name ?? '') . ' ' . ($linkedCustomer->lastname ?? '')) }}
                    - {{ $linkedCustomer->death_verification_status === 'verified' ? 'Deceased case ready' : 'Not verified' }}
                  </option>
                @endforeach
              </select>
              <button type="submit">Switch</button>
            </form>
          @endif
        </div>
        <button class="case-action-button" type="button" data-toggle="modal" data-target="#addOrganisationModal">
          Add Organisation
        </button>
      </div>
    </div>

    <div class="case-stat-grid">
      <div class="case-stat-card">
        <span class="case-stat-label">Organisations</span>
        <div class="case-stat-value">{{ $deceasedCase->organizations->count() }}</div>
      </div>
      <div class="case-stat-card">
        <span class="case-stat-label">Sent</span>
        <div class="case-stat-value">{{ $deceasedCase->organizations->where('status', 'sent')->count() }}</div>
      </div>
      <div class="case-stat-card">
        <span class="case-stat-label">Awaiting Reply</span>
        <div class="case-stat-value">{{ $deceasedCase->organizations->where('status', 'awaiting_reply')->count() }}</div>
      </div>
      <div class="case-stat-card">
        <span class="case-stat-label">Completed</span>
        <div class="case-stat-value">{{ $deceasedCase->organizations->whereIn('status', ['completed', 'closed_no_account_found'])->count() }}</div>
      </div>
    </div>

    <div class="case-panel">
      <div class="case-panel-header">
        <div>
          <h4 class="case-panel-title">Organisation Notifications</h4>
          <span class="case-org-meta">Use actions to preview templates, send emails, download letters, and log replies.</span>
        </div>
        <span class="case-count-pill">{{ $deceasedCase->organizations->count() }} organisations</span>
      </div>
      <div class="case-table-toolbar">
        <div id="case-table-length-slot"></div>
        <div id="case-table-search-slot"></div>
      </div>

      <div class="table-responsive">
        <table class="table case-table display" id="deceased-case-organisations-table">
          <thead>
            <tr>
              <th>Organisation</th>
              <th>Type</th>
              <th>Status</th>
              <th>Reference</th>
              <th>History</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($deceasedCase->organizations as $organization)
              <tr>
                <td>
                  <div class="case-org-name">{{ $organization->organisation_name }}</div>
                  <span class="case-org-meta">
                    {{ $organization->organisation_email ?: 'No email added' }}
                  </span>
                  @if($organization->service_address)
                    <span class="case-org-meta">{{ $organization->service_address }}</span>
                  @endif
                </td>
                <td>
                  <strong>{{ $organisationTypes[$organization->organisation_type] ?? str_replace('_', ' ', ucfirst($organization->organisation_type)) }}</strong>
                  <span class="case-org-meta">Source: {{ str_replace('_', ' ', ucfirst($organization->source)) }}</span>
                </td>
                <td>
                  <span class="status-badge status-{{ $organization->status }}">
                    {{ $organisationStatuses[$organization->status] ?? str_replace('_', ' ', ucfirst($organization->status)) }}
                  </span>
                  <span class="case-org-meta">Channel: {{ $organization->preferred_channel ? ucfirst($organization->preferred_channel) : 'Not selected' }}</span>
                </td>
                <td>
                  <strong>{{ $organization->organisation_reference ?: ($organization->account_number ?: ($organization->policy_number ?: $organization->customer_number ?: 'N/A')) }}</strong>
                  @if($organization->account_number)
                    <span class="case-org-meta">Account: {{ $organization->account_number }}</span>
                  @endif
                  @if($organization->policy_number)
                    <span class="case-org-meta">Policy: {{ $organization->policy_number }}</span>
                  @endif
                </td>
                <td>
                  <strong>{{ $organization->notifications->count() }}</strong> notifications
                  <span class="case-org-meta">{{ $organization->replies->count() }} replies</span>
                  @if($organization->last_sent_at)
                    <span class="case-org-meta">Last sent {{ $organization->last_sent_at->format('Y-m-d') }}</span>
                  @endif
                </td>
                <td>
                  <form class="case-action-stack js-org-action-form"
                        data-edit="#editOrg{{ $organization->id }}"
                        data-reply="#replyOrg{{ $organization->id }}"
                        data-history="#historyOrg{{ $organization->id }}"
                        data-preview-letter="{{ route('executor.deceased_cases.organizations.preview', $organization) }}"
                        data-preview-email="{{ route('executor.deceased_cases.organizations.preview', $organization) }}"
                        data-send-email="{{ route('executor.deceased_cases.organizations.email', $organization) }}"
                        data-send-both="{{ route('executor.deceased_cases.organizations.both', $organization) }}"
                        data-download-pdf="{{ route('executor.deceased_cases.organizations.letter', $organization) }}">
                    @csrf
                    <select class="case-action-select" name="action">
                      <option value="">Choose action</option>
                      <option value="edit">Edit organisation</option>
                      <option value="preview_letter">Preview letter</option>
                      <option value="preview_email">Preview email</option>
                      <option value="send_email">Send email</option>
                      <option value="send_both">Send both</option>
                      <option value="download_pdf">Download PDF</option>
                      <option value="reply">Log reply</option>
                      <option value="history">View history</option>
                    </select>
                    <button class="case-action-go" type="submit">Go</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="case-empty">No organisations suggested yet.</div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="addOrganisationModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Organisation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form method="POST" action="{{ route('executor.deceased_cases.organizations.store') }}">
            @csrf
            <div class="modal-body">
              @include('executor.deceased_cases.partials.organization_fields', ['organization' => null])
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Organisation</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @foreach($deceasedCase->organizations as $organization)
      <div class="modal fade" id="editOrg{{ $organization->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit {{ $organization->organisation_name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="editOrgForm{{ $organization->id }}" method="POST" action="{{ route('executor.deceased_cases.organizations.update', $organization) }}">
              @csrf
              @method('PUT')
              <div class="modal-body">
                @include('executor.deceased_cases.partials.organization_fields', ['organization' => $organization])
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                      @foreach($organisationStatuses as $key => $label)
                        <option value="{{ $key }}" @selected($organization->status === $key)>{{ $label }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Preferred Channel</label>
                    <select class="form-control" name="preferred_channel">
                      <option value="">Not selected</option>
                      <option value="letter" @selected($organization->preferred_channel === 'letter')>Letter</option>
                      <option value="email" @selected($organization->preferred_channel === 'email')>Email</option>
                      <option value="both" @selected($organization->preferred_channel === 'both')>Both</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" rows="3">{{ $organization->notes }}</textarea>
                  </div>
                </div>
              </div>
            </form>
            <div class="modal-footer">
              <form method="POST" action="{{ route('executor.deceased_cases.organizations.destroy', $organization) }}" class="mr-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Remove</button>
              </form>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" form="editOrgForm{{ $organization->id }}" class="btn btn-primary">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="replyOrg{{ $organization->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Log Reply</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{ route('executor.deceased_cases.organizations.replies.store', $organization) }}">
              @csrf
              <div class="modal-body">
                <div class="case-modal-note mb-3">{{ $organization->organisation_name }}</div>
                <div class="form-group">
                  <label>Reply Status</label>
                  <select class="form-control" name="reply_status" required>
                    <option value="reply_received">Reply received</option>
                    <option value="more_info_required">More info required</option>
                    <option value="completed">Completed</option>
                    <option value="closed_no_account_found">Closed - no account found</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Outcome</label>
                  <select class="form-control" name="mapping_outcome">
                    <option value="">Outcome...</option>
                    <option value="asset_found">Asset found</option>
                    <option value="liability_found">Liability found</option>
                    <option value="refund_due">Refund due</option>
                    <option value="no_account_found">No account found</option>
                  </select>
                  <small class="text-muted">Choosing an outcome can create/update estate records automatically.</small>
                </div>
                <div class="form-group">
                  <label>Amount</label>
                  <input class="form-control" type="number" step="0.01" name="amount">
                </div>
                <div class="form-group">
                  <label>Received Date</label>
                  <input class="form-control" type="date" name="received_at">
                </div>
                <div class="form-group">
                  <label>Summary</label>
                  <textarea class="form-control" name="summary" rows="4"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Log Reply</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="historyOrg{{ $organization->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">History - {{ $organization->organisation_name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <h6>Notifications</h6>
              @forelse($organization->notifications as $notification)
                <div class="border rounded p-2 mb-2">
                  <strong>{{ ucfirst($notification->channel) }}</strong> | {{ str_replace('_', ' ', $notification->delivery_status) }}
                  <small class="d-block">{{ $notification->created_at?->format('Y-m-d H:i') }}</small>
                  @if($notification->pdf_path && $notification->delivery_status !== 'sent')
                    <form method="POST" action="{{ route('executor.deceased_cases.notifications.mark_letter_sent', $notification) }}" class="mt-2">
                      @csrf
                      <button class="btn btn-sm btn-outline-primary" type="submit">Mark letter as sent</button>
                    </form>
                  @endif
                </div>
              @empty
                <p class="text-muted">No notifications yet.</p>
              @endforelse

              <h6 class="mt-4">Replies</h6>
              @forelse($organization->replies as $reply)
                <div class="border rounded p-2 mb-2">
                  <strong>{{ str_replace('_', ' ', ucfirst($reply->reply_status)) }}</strong>
                  @if($reply->amount)
                    | GBP {{ number_format($reply->amount, 2) }}
                  @endif
                  <small class="d-block">{{ optional($reply->received_at)->format('Y-m-d') ?: $reply->created_at?->format('Y-m-d') }}</small>
                  <div>{{ $reply->summary ?: 'No summary added.' }}</div>
                  @if($reply->mapped_entity_type)
                    <small class="d-block text-success mt-1">
                      Mapped to estate record #{{ $reply->mapped_entity_id }}
                    </small>
                  @endif
                </div>
              @empty
                <p class="text-muted">No replies yet.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (!window.jQuery || !jQuery.fn.DataTable) {
      return;
    }

    const table = jQuery('#deceased-case-organisations-table');

    if (jQuery.fn.DataTable.isDataTable(table)) {
      table.DataTable().destroy();
    }

    const dataTable = table.DataTable({
      pageLength: 10,
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
      order: [[0, 'asc']],
      dom: '<"case-dt-hidden"lf>rtip',
      columnDefs: [
        { orderable: false, targets: [5] }
      ],
      language: {
        search: 'Search organisations:',
        lengthMenu: 'Show _MENU_ organisations',
        info: 'Showing _START_ to _END_ of _TOTAL_ organisations',
        emptyTable: 'No organisations available yet',
        zeroRecords: 'No matching organisations found',
      },
    });

    jQuery('#deceased-case-organisations-table_length').appendTo('#case-table-length-slot');
    jQuery('#deceased-case-organisations-table_filter').appendTo('#case-table-search-slot');

    jQuery(document).on('submit', '.js-org-action-form', function (event) {
      event.preventDefault();

      const form = jQuery(this);
      const action = form.find('select[name="action"]').val();

      if (!action) {
        return;
      }

      if (action === 'edit' || action === 'reply' || action === 'history') {
        const modalSelector = form.data(action);
        jQuery(modalSelector).modal('show');
        form.find('select[name="action"]').val('');
        return;
      }

      const routeMap = {
        preview_letter: form.data('preview-letter'),
        preview_email: form.data('preview-email'),
        send_email: form.data('send-email'),
        send_both: form.data('send-both'),
        download_pdf: form.data('download-pdf'),
      };

      const submitForm = jQuery('<form>', {
        method: 'POST',
        action: routeMap[action],
      });

      submitForm.append(jQuery('<input>', {
        type: 'hidden',
        name: '_token',
        value: form.find('input[name="_token"]').val(),
      }));

      if (action === 'preview_letter') {
        submitForm.append(jQuery('<input>', { type: 'hidden', name: 'channel', value: 'letter' }));
      }

      if (action === 'preview_email') {
        submitForm.append(jQuery('<input>', { type: 'hidden', name: 'channel', value: 'email' }));
      }

      jQuery('body').append(submitForm);
      submitForm.trigger('submit');
    });

    jQuery(document).on('click', '.deceased-case-page [data-toggle="modal"]', function (event) {
      const target = jQuery(this).attr('data-target');

      if (!target) {
        return;
      }

      event.preventDefault();

      const modal = jQuery(target);

      if (jQuery.fn.modal) {
        modal.modal('show');
        return;
      }

      jQuery('body').addClass('modal-open');
      if (!jQuery('.modal-backdrop').length) {
        jQuery('body').append('<div class="modal-backdrop fade show"></div>');
      }
      modal.show().addClass('show').attr('aria-hidden', 'false');
    });

    jQuery(document).on('click', '.deceased-case-page [data-dismiss="modal"]', function (event) {
      event.preventDefault();

      const modal = jQuery(this).closest('.modal');

      if (jQuery.fn.modal) {
        modal.modal('hide');
        return;
      }

      modal.removeClass('show').hide().attr('aria-hidden', 'true');
      jQuery('.modal-backdrop').remove();
      jQuery('body').removeClass('modal-open').css('padding-right', '');
    });
  });
</script>
@endsection
