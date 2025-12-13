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
                                    <h4>Invite For 30% Discount</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.customers.send_discount_invite')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Customer</label>
                                            <select class="form-control" name="customer_id" required>
                                                <option value="" selected disabled> Choose Customer</option>
                                                @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Partner Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name') }}" placeholder="Enter full name" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Partner Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email') }}" placeholder="Enter email address" required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="date_of_birth" class="form-label">Partner Date of Birth</label>
                                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                                value="{{ old('date_of_birth') }}"
                                                required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Invite</button>
                                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Cancel</a>
                                    </form>
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