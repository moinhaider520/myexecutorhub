@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <p class="text-uppercase text-muted small mb-2">Executor Hub Invitation</p>
                    <h1 class="h3 mb-3">
                        @if ($mode === 'invite' && $invite)
                            {{ ucfirst($invite->invite_type) }} invitation from {{ $referrer->name }}
                        @else
                            {{ $referrer->name }} shared Executor Hub with you
                        @endif
                    </h1>

                    <p class="mb-3">
                        Join Executor Hub with a <strong>10% discount</strong> valid for <strong>10 days</strong>.
                    </p>

                    @if ($invite)
                        <div class="alert alert-light border">
                            <div><strong>Invitee:</strong> {{ $invite->email }}</div>
                            <div><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $invite->status)) }}</div>
                            <div><strong>Valid until:</strong> {{ $invite->expires_at?->format('d M Y, H:i') }}</div>
                        </div>
                    @endif

                    <p class="mb-4">
                        Activate your invited account or continue to Executor Hub to learn more about the platform.
                    </p>

                    <a href="{{ $callToActionUrl }}" class="btn btn-primary">{{ $callToActionLabel }}</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Visit Homepage</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
