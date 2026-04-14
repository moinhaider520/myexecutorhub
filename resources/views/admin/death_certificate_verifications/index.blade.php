@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Death Certificate Reviews</h4>
                        <span>Review automated decisions, manual review cases, and fraud flags.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Uploaded By</th>
                                        <th>Processing</th>
                                        <th>Decision</th>
                                        <th>Score</th>
                                        <th>Uploaded</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($verifications as $verification)
                                        <tr>
                                            <td>{{ $verification->id }}</td>
                                            <td>{{ $verification->customer->name ?? 'Unknown' }}</td>
                                            <td>{{ $verification->uploader->name ?? 'System' }}</td>
                                            <td>{{ str_replace('_', ' ', $verification->processing_status) }}</td>
                                            <td>{{ str_replace('_', ' ', $verification->verification_status) }}</td>
                                            <td>{{ $verification->confidence_score ?? 'N/A' }}</td>
                                            <td>{{ $verification->created_at?->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.death_certificates.show', $verification) }}" class="btn btn-primary btn-sm">Open</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No death certificate verifications found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $verifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
