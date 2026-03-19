<div class="mt-4 pt-3 border-top">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <p class="mb-1 text-muted">Keep moving through the partner journey.</p>
            <h5 class="mb-0">{{ $nextHeading ?? 'Next Step' }}</h5>
        </div>
        <a href="{{ $nextUrl }}" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4">
            <span>Continue to {{ $nextLabel }}</span>
            <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</div>
