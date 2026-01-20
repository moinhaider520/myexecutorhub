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
                                    <h4>Send Customer Invite</h4>
                                    <span>Enter the name and email address to send an invitation to sign up on Executor
                                        Hub.</span>
                                </div>
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.customers.send_invite') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name') }}" placeholder="Enter full name" required>
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email') }}" placeholder="Enter email address" required>
                                            @error('email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="price_id" id="price_id" class="form-control"
                                            value="price_1SrmW9A22YOnjf5ZKeweQ2hb" required>
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