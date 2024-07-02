@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-12">
                    <form class="card" id="edit-profile">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input class="form-control" type="text" placeholder="Full Name"
                                            name="company_name" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input class="form-control" type="email" placeholder="Email"
                                            name="email_address" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input class="form-control" type="text" placeholder="Address" name="address"
                                            value="" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input class="form-control" type="text" placeholder="City" name="city" value=""
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input class="form-control" type="number" placeholder="ZIP Code"
                                            name="postal_code" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input class="form-control" type="text" placeholder="Contact Number"
                                            name="contact_number" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Edit Profile</button>
                        </div>
                    </form>
                    <form class="card" id="edit-image" enctype="multipart/form-data">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update Profile Image</button>
                        </div>
                    </form>
                    <form class="card" id="edit-password">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Update Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Enter New Password</label>
                                        <input class="form-control" type="password" name="password" required>
                                    </div>
                                    <input type="hidden" name="user_id" value="">
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