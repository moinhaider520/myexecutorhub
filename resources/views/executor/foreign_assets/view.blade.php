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
                                <h4>Foreign Assets</h4>
                                <span>List of Foreign Assets.</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>Sr</th>
                                                    <th>Foreign Asset</th>
                                                    <th>Asset Type</th>
                                                    <th>Asset Location</th>
                                                    <th>Asset Value</th>
                                                    <th>Contact Details</th>
                                                    <th>Entry Date and Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($foreignAssets as $foreignAsset)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $foreignAsset->foreign_asset }}</td>
                                                    <td>{{ $foreignAsset->asset_type }}</td>
                                                    <td>{{ $foreignAsset->asset_location }}</td>
                                                    <td>{{ $foreignAsset->asset_value }}</td>
                                                    <td>{{ $foreignAsset->contact_details }}</td>
                                                    <td>{{ $foreignAsset->created_at->format('d/m/Y \a\t H:i') }}</td>
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