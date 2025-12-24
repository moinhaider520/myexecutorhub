@extends('layouts.master')

@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">View Reports</h5>
                                <div class="card-body">
                                    @if($reports->isEmpty())
                                        <p>You Have No Reports Generated.</p>
                                    @else
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                    aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Week Start</th>
                                                            <th>Week End</th>
                                                            <th>File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reports as $index => $report)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $report->week_start ?? '-' }}</td>
                                                                <td>{{ $report->week_end ?? '-' }}</td>
                                                                <td><a href="{{ route('admin.summary.download', $report->id) }}">View File</a></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
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