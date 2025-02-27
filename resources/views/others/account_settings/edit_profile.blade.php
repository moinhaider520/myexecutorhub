@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-12">
                    <form action="{{ route('customer.update_profile') }}" method="POST" class="card" id="edit-profile">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input class="form-control" type="text" placeholder="Full Name"
                                            name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input class="form-control" type="email" placeholder="Email"
                                            name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input class="form-control" type="text" placeholder="Address" name="address"
                                            value="{{ old('address', $user->address) }}" required>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input class="form-control" type="text" placeholder="City" name="city"
                                            value="{{ old('city', $user->city) }}" required>
                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input class="form-control" type="text" placeholder="ZIP Code"
                                            name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
                                        @error('postal_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input class="form-control" type="text" placeholder="Contact Number"
                                            name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required>
                                        @error('contact_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Edit Profile</button>
                        </div>
                    </form>
                    <form action="{{ route('customer.update_profile_image') }}" method="POST" class="card" id="edit-image" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title mb-0">Update Profile Image</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Choose Image</label>
                                        <input class="form-control" type="file" accept="image/jpeg, image/png"
                                            name="profile_image" required>
                                        @error('profile_image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update Profile Image</button>
                        </div>
                    </form>
                    <form action="{{ route('customer.update_password') }}" method="POST" class="card" id="edit-password">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title mb-0">Update Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Enter New Password</label>
                                        <input class="form-control" type="password" name="password" required>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input class="form-control" type="password" name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
