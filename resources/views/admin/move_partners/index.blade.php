@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12">
                <div class="card">
                    <h5 class="card-header">Move Partners</h5>
                    <div class="card-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive theme-scrollbar">
                            <table class="display dataTable no-footer" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Partner Name</th>
                                        <th>Partner Email</th>
                                        <th>Is Partner Under</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($partners as $index => $partner)
                                        @php
                                            $parentPartner = optional($partner->parentPartnerRelation)->parentPartner;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $partner->name }}</td>
                                            <td>{{ $partner->email }}</td>
                                            <td>{{ $parentPartner->name ?? 'Not Assigned' }}</td>
                                            <td>
                                                <button 
                                                    class="btn btn-primary btn-sm set-partner-btn" 
                                                    data-partner-id="{{ $partner->id }}"
                                                    data-partner-name="{{ $partner->name }}"
                                                    data-parent-partner-id="{{ $parentPartner->id ?? '' }}">
                                                    Set Parent Partner
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($partners->isEmpty())
                            <p class="text-center mt-3">No partners found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Set Partner Modal -->
<div class="modal fade" id="setPartnerModal" tabindex="-1" role="dialog" aria-labelledby="setPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('admin.move_partners.assign') }}">
            @csrf
            <input type="hidden" name="partner_id" id="partner_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPartnerModalLabel">Assign Parent Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Assign a parent partner to <strong id="partner_name_display"></strong></p>
                    <div class="form-group">
                        <label for="parent_partner_id">Select Parent Partner</label>
                        <select class="form-control" name="parent_partner_id" id="parent_partner_id">
                            <option value="">-- No Parent (Top Level) --</option>
                            @foreach($allPartners as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('setPartnerModal'));

        document.querySelectorAll('.set-partner-btn').forEach(button => {
            button.addEventListener('click', function () {
                const partnerId = this.dataset.partnerId;
                const partnerName = this.dataset.partnerName;
                const parentPartnerId = this.dataset.parentPartnerId;

                document.getElementById('partner_id').value = partnerId;
                document.getElementById('partner_name_display').textContent = partnerName;

                // Preselect parent partner if one exists
                const select = document.getElementById('parent_partner_id');
                
                // Filter out the current partner from options (can't be its own parent)
                Array.from(select.options).forEach(option => {
                    if (option.value == partnerId) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
                
                if (parentPartnerId) {
                    select.value = parentPartnerId;
                } else {
                    select.value = '';
                }

                modal.show();
            });
        });
    });
</script>
@endsection
