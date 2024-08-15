@extends('layouts.master')

@section('content')
<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <form method="GET" action="{{ route('partner.assign_permissions_form') }}">
                            <div class="form theme-form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h5 class="mb-3">Select Role</h5>
                                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required onchange="this.form.submit()">
                                                <option value="" disabled selected>Select Role</option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if(request('role'))
                        <form method="POST" action="{{ route('partner.assign_permissions') }}">
                            @csrf
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <div class="form theme-form">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <h5 class="mb-3">Select Permissions</h5>
                                            @foreach($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}" id="{{ $permission->name }}" {{ in_array($permission->name, $assignedPermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
                                            </div>
                                            @endforeach
                                            @error('permissions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Assign Permissions</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection