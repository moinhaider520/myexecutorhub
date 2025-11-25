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
                                    <h4>Emails Schedules List</h4>
                                    <span>List of all the Scheduled Emails.</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive theme-scrollbar">
                                        <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                            <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                aria-describedby="basic-1_info">
                                                <thead>
    <tr>
        <th>Sr</th>
        <th>Recipient Email</th>
        <th>Subject</th>
        <th>Body</th>
        <th>Status</th>
        <th>Scheduled For</th>
        <th>Created At</th>
        <th></th>
    </tr>
</thead>

                                                <tbody>
                                                    @foreach ($emails as $email)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $email->recipient_email ?? 'N/A' }}</td>
    <td>{{ $email->subject ?? 'N/A' }}</td>
    <td>{!! $email->body ?? 'N/A' !!}</td>
    <td>{{ $email->status ?? 'N/A' }}</td>
    <td>{{ $email->scheduled_for ? \Carbon\Carbon::parse($email->scheduled_for)->format('d M Y, h:i A') : 'N/A' }}</td>
        <td>{{ $email->created_at ? \Carbon\Carbon::parse($email->scheduled_for)->format('d M Y, h:i A') : 'N/A' }}</td>
        <td></td>
        <td></td>
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
        <!-- Container-fluid Ends-->
    </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection