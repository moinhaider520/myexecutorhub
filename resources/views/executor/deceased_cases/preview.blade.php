@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="card">
      <div class="card-header">
        <h4>{{ ucfirst($channel) }} Preview</h4>
        <span>{{ $organization->organisation_name }}</span>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ $channel === 'email' ? route('executor.deceased_cases.organizations.email', $organization) : route('executor.deceased_cases.organizations.letter', $organization) }}">
          @csrf
          @if($channel === 'email')
            <div class="form-group mb-3">
              <label>Subject</label>
              <input type="text" class="form-control" name="subject" value="{{ $subject }}">
            </div>
          @endif
          <div class="form-group mb-3">
            <label>Content</label>
            <textarea class="form-control" name="body" rows="18">{{ $body }}</textarea>
          </div>
          <a href="{{ route('executor.deceased_cases.show') }}" class="btn btn-secondary">Back</a>
          <button type="submit" class="btn btn-primary">
            {{ $channel === 'email' ? 'Send Email' : 'Download PDF Letter' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
