@extends('layouts.master')

@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Partners List</h4>
                                    <span>List of all the Registered Partners.</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive theme-scrollbar">
                                        <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                            <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                aria-describedby="basic-1_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>Sr</th>
                                                        <th>Partner Name</th>
                                                        <th>Email</th>
                                                        <th>Address</th>
                                                        <th>Contact Number</th>
                                                        <th>Heard From?</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($partners as $partner)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $partner->name ?? 'N/A' }}</td>
                                                            <td>{{ $partner->email ?? 'N/A' }}</td>
                                                            <td>{{ $partner->address ?? 'N/A' }}</td>
                                                            <td>{{ $partner->phone_number ?? 'N/A' }}</td>
                                                            <td>{{ $partner->hear_about_us ?? 'N/A' }}</td>
                                                            <td>
    <div class="btn-group-vertical" role="group" style="width: 100%;">
        <!-- View Actions -->
        <div class="mb-2">
            <a href="{{ route('admin.partners.view_refferals', $partner->id) }}"
                class="btn btn-primary btn-sm me-1 mb-1">
                View Customers
            </a>
            <a href="{{ route('admin.partners.view_partners', $partner->id) }}"
                class="btn btn-primary btn-sm me-1 mb-1">
                View Partners
            </a>
            <a href="{{ route('admin.partners.view_bank_accounts', $partner->id) }}"
                class="btn btn-primary btn-sm mb-1">
         View Bank Accounts
            </a>
        </div>

        <!-- Management Actions -->
        <div class="mb-2">
            <a href="{{ route('admin.partners.edit', \App\Helpers\EncryptionHelper::encryptId($partner->id)) }}"
                class="btn btn-warning btn-sm me-1 mb-1">
                Edit
            </a>
            <form action="{{ route('admin.partners.destroy', $partner->id) }}"
                method="POST" style="display:inline;" 
                onsubmit="return confirm('Are you sure you want to delete this partner?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm mb-1">
                    Delete
                </button>
            </form>
        </div>

        <!-- Report Actions -->
        <div>
            <form action="{{ route('admin.partners.generate-commission-report', $partner->id) }}"
                method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm me-1 mb-1">
                     Generate Report
                </button>
            </form>
            <a href="{{ route('admin.partners.view_reports', $partner->id) }}" class="btn btn-info btn-sm mb-1">
                View Reports
            </a>
        </div>
    </div>
</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection