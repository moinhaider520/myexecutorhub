@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 box-col-12">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4>Weekly Payout Summaries</h4>
                                <span>Your weekly commission summary PDF reports.</span>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1">
                                            <thead>
                                                <tr>
                                                    <th>Sr</th>
                                                    <th>Week Start</th>
                                                    <th>Week End</th>
                                                    <th>Summary File</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($summaries as $summary)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $summary->week_start }}</td>
                                                    <td>{{ $summary->week_end }}</td>
                                                    <td>
                                                        <a target="_blank" href="{{ route('partner.summary.download', $summary->id) }}">
                                                            Download PDF
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('partner.summary.download', $summary->id) }}"
                                                           class="btn btn-primary btn-sm">
                                                            Download
                                                        </a>
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
