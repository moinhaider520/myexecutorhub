@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Your Unread Notifications</h4>
                        <span>List of all unread notifications for your account.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <div id="partner_notifications_wrapper" class="dataTables_wrapper no-footer">
                                <table class="display dataTable no-footer" id="partner_notifications" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>Sr</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($notifications as $notification)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $notification->data['title'] }}</td>
                                                <td>{{ $notification->data['description'] }}</td>
                                                <td>{{ $notification->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <form action="{{ route('partner.notifications.read', $notification->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm">Mark as Read</button>
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
@endsection
