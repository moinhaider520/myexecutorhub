@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Deceased Case Not Ready</h4>
            <span>{{ trim(($contextUser->name ?? '') . ' ' . ($contextUser->lastname ?? '')) ?: 'Selected customer' }}</span>
          </div>
          <div class="card-body">
            <div class="alert alert-info mb-0">
              This customer does not have a verified death certificate yet, so the deceased-case workflow is not unlocked.
              Upload and verify the death certificate first. After verification, this page will open the organisation notification workflow automatically.
            </div>
            <div class="mt-3">
              <a href="{{ route('executor.death_certificates.index') }}" class="btn btn-primary">Go to Death Certificate Upload</a>
              <a href="{{ route('executor.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
