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
                                    <h4>Edit Partner Profile</h4>
                                    <span>Edit the details of the partner.</span>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Partner Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name', $partner->name) }}" placeholder="Enter partner name"
                                                required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email', $partner->email) }}"
                                                placeholder="Enter email address" required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" name="address" id="address" class="form-control"
                                                value="{{ old('address', $partner->address) }}" placeholder="Enter address"
                                                required>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" id="city" class="form-control"
                                                value="{{ old('city', $partner->city) }}" placeholder="Enter city" required>
                                            @error('city')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" name="postal_code" id="postal_code" class="form-control"
                                                value="{{ old('postal_code', $partner->postal_code) }}"
                                                placeholder="Enter postal code" required>
                                            @error('postal_code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="contact_number" class="form-label">Contact Number</label>
                                            <input type="text" name="contact_number" id="contact_number"
                                                class="form-control"
                                                value="{{ old('contact_number', $partner->phone_number) }}"
                                                placeholder="Enter contact number" required>
                                            @error('contact_number')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="access_type" class="form-label">Access Type</label>
                                            <select name="access_type" id="access_type" class="form-control" required>
                                                <option value="">Select Access Type</option>
                                                <option value="Friends & Family" {{ old('access_type', $partner->access_type) == 'Friends & Family' ? 'selected' : '' }}>Friends
                                                    & Family</option>
                                                <option value="Direct Partners" {{ old('access_type', $partner->access_type) == 'Direct Partners' ? 'selected' : '' }}>Direct
                                                    Partners</option>
                                                <option value="Will Power Staff" {{ old('access_type', $partner->access_type) == 'Will Power Staff' ? 'selected' : '' }}>Will Power Staff</option>
                                                <option value="Partner Organisations" {{ old('access_type', $partner->access_type) == 'Partner Organisations' ? 'selected' : '' }}>Partner Organisations</option>
                                            </select>
                                            @error('access_type')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
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