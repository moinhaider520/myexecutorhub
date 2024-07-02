@extends('layouts.master')

@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('edit_profile') }}">Profile </a></li>
                                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                                <li class="breadcrumb-item active">Update Profiles Details</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Profile Details</h4>
                            <form action="{{ route('edit_profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="label">Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="Enter First Name" value="{{ Auth::user()->name }}" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number"
                                            placeholder="Enter Phone Number" value="{{ Auth::user()->phone_number }}"
                                            required>
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="label">Email Address</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Enter Email Address" value="{{ Auth::user()->email }}"
                                            disabled>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="label">Upload Picture</label>
                                        <input type="file" class="form-control" name="photo">
                                        @error('photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="label">Bio</label>
                                        <textarea class="form-control" name="bio">{{ Auth::user()->bio }}</textarea>
                                        @error('bio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="label">Address</label>
                                        <textarea class="form-control"
                                            name="address">{{ Auth::user()->address }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('edit_profile') }}">Profile </a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Update Profiles Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="card-title">Profile Details</h4>
                    <form action="{{ route('edit_profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group col-xl-6 mb-4">
                                <label class="label">Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name"
                                    value="{{ Auth::user()->name }}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-xl-6 mb-4">
                                <label class="label">Phone Number</label>
                                <input type="text" class="form-control" name="phone_number"
                                    placeholder="Enter Phone Number" value="{{ Auth::user()->phone_number }}" required>
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-xl-6 mb-4">
                                <label class="label">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email Address"
                                    value="{{ Auth::user()->email }}" disabled>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-xl-6 mb-4">
                                <label class="label">Upload Picture</label>
                                <input type="file" class="form-control" name="photo">
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="label">Bio</label>
                                <textarea class="form-control" name="bio">{{ Auth::user()->bio }}</textarea>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="label">Address</label>
                                <textarea class="form-control" name="address">{{ Auth::user()->address }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection