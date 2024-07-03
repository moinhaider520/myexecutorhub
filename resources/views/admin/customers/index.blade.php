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
                                <h4>Customers List</h4>
                                <span>List of all the Registered Customers.</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>Sr</th>
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Contact Number</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $customer)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $customer->name }}</td>
                                                        <td>{{ $customer->email }}</td>
                                                        <td>{{ $customer->address }}</td>
                                                        <td>{{ $customer->contact_number }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
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