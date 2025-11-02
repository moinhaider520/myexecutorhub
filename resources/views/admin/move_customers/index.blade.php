@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12">
                <div class="card">
                    <h5 class="card-header">Move Customers</h5>
                    <div class="card-body">
            
                        <div class="table-responsive theme-scrollbar">
                            <table class="display dataTable no-footer" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Associated Partner</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $index => $customer)
                                        @php
                                            $partner = optional($customer->usedCouponFrom)->partner;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $partner->name ?? 'Not Assigned' }}</td>
                                            <td>
                                                <button 
                                                    class="btn btn-primary btn-sm set-partner-btn" 
                                                    data-customer-id="{{ $customer->id }}"
                                                    data-customer-name="{{ $customer->name }}"
                                                    data-partner-id="{{ $partner->id ?? '' }}">
                                                    Set Partner
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($customers->isEmpty())
                            <p class="text-center mt-3">No customers found.</p>
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
        <form method="POST" action="{{ route('admin.move_customers.assign') }}">
            @csrf
            <input type="hidden" name="customer_id" id="customer_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPartnerModalLabel">Assign Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Assign a partner to <strong id="customer_name_display"></strong></p>
                    <div class="form-group">
                        <label for="partner_id">Select Partner</label>
                        <select class="form-control" name="partner_id" id="partner_id" required>
                            <option value="">-- Select Partner --</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }} ({{ $partner->email }})</option>
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

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('setPartnerModal'));

        document.querySelectorAll('.set-partner-btn').forEach(button => {
            button.addEventListener('click', function () {
                const customerId = this.dataset.customerId;
                const customerName = this.dataset.customerName;
                const partnerId = this.dataset.partnerId;

                document.getElementById('customer_id').value = customerId;
                document.getElementById('customer_name_display').textContent = customerName;

                // Preselect partner if one exists
                const select = document.getElementById('partner_id');
                if (partnerId) select.value = partnerId;
                else select.value = '';

                modal.show();
            });
        });
    });
</script>

