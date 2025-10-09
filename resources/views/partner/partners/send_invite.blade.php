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
                                <h4>Send Invite</h4>
                                <span>Invite your Friends and Family Members to use Executor Hub For Free. Enter their Email and an Invite will be sent to them. They can sign up using that email and get free access to the Portal.</span>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('partner.partners.send_invite_email') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="coupon_code" value="{{ auth()->user()->coupon_code ?? 'No Coupon Code Available' }}">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Enter full name" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Send Invitation</button>
                                    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Cancel</a>
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
