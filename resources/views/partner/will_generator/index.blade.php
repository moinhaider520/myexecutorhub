@extends('layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end p-2">
                            <a href="{{ route('partner.will_generator.about_you','') }}" class="btn btn-primary">
                                Add User Will
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Will Generator</h4>
                                    <span>List of Users Will.</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive theme-scrollbar">
                                        <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                            <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                aria-describedby="basic-1_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>Sr</th>
                                                        <th>Legal Name</th>
                                                        <th>User Name</th>
                                                        <th>Date Of Birth</th>
                                                        <th>Address</th>
                                                        <th>City</th>
                                                        <th>Martial Status</th>
                                                        <th>Contact Number(s)</th>

                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user_about_infos as $user_about_info)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $user_about_info->legal_name }}</td>
                                                            <td>{{ $user_about_info->user_name }}</td>
                                                            <td>{{ $user_about_info->date_of_birth }}</td>
                                                            <td>{{ $user_about_info->address_line_1 }}</td>
                                                            <td>{{ $user_about_info->city }}</td>
                                                            <td>{{ $user_about_info->martial_status }}</td>
                                                            <td>{{ $user_about_info->phone_number }}</td>
                                                            <td style="display: flex;">
                                                                <a href="{{route('partner.will_generator.create',$user_about_info->id)}}"
                                                                    class="btn btn-warning btn-sm edit-button"
                                                                    >Edit</a>
                                                                <form
                                                                    action="{{route('partner.will_generator.delete_about_you',$user_about_info->id)}}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Delete</button>
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
    </div>
@endsection
