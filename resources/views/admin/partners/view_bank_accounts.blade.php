@extends('layouts.master')

@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Bank Accounts</h5>
                                <div class="card-body">
                                    @if($bankAccounts->isEmpty())
                                        <p>You Have No Bank Accounts Added For Withdrawals.</p>
                                    @else
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                    aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Bank Name</th>
                                                            <th>IBAN Number</th>
                                                            <th>Sort Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($bankAccounts as $index => $account)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $account->user->name ?? '-' }}</td>
                                                                <td>{{ $account->user->email ?? '-' }}</td>
                                                                <td>{{ $account->bank_name ?? '-' }}</td>
                                                                <td>{{ $account->iban ?? '-' }}</td>
                                                                <td>{{ $account->sort_code ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
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