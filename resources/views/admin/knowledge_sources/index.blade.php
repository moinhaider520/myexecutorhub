@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 col-lg-12">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end p-2">
                        <button
                            type="button"
                            class="btn btn-primary"
                            id="openKnowledgeSourceModal"
                            data-bs-toggle="modal"
                            data-bs-target="#addKnowledgeSourceModal"
                        >
                            Add Knowledge Source
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Knowledge Sources</h4>
                                <span>Only ready sources will be used by the chatbot.</span>
                            </div>
                            <div class="card-body">
                                @php
                                    $hasActiveProcessing = $sources->contains(function ($source) {
                                        return in_array($source->status, ['pending', 'processing'], true);
                                    });

                                    $statusSnapshot = $sources->mapWithKeys(function ($source) {
                                        return [
                                            $source->id => [
                                                'status' => $source->status,
                                                'error_message' => $source->error_message,
                                                'updated_at' => optional($source->updated_at)->toIso8601String(),
                                            ],
                                        ];
                                    });
                                @endphp

                                @if($hasActiveProcessing)
                                    <div class="alert alert-info mb-4" role="alert">
                                        Knowledge sources are processing in the background. This page refreshes automatically while they are being prepared.
                                    </div>
                                @endif

                                <div class="table-responsive theme-scrollbar">
                                    <table class="table table-striped align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>OpenAI File</th>
                                                <th>Vector Store</th>
                                                <th>Uploaded</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($sources as $source)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $source->title }}</strong>
                                                        @if($source->error_message)
                                                            <div class="text-danger small mt-1">{{ $source->error_message }}</div>
                                                        @endif
                                                    </td>
                                                    <td>{{ strtoupper($source->type) }}</td>
                                                    <td>
                                                        @php
                                                            $badgeClass = match($source->status) {
                                                                'ready' => 'success',
                                                                'failed' => 'danger',
                                                                'processing' => 'warning',
                                                                default => 'secondary',
                                                            };
                                                        @endphp
                                                        <span class="badge badge-{{ $badgeClass }}">{{ str_replace('_', ' ', ucfirst($source->status)) }}</span>
                                                    </td>
                                                    <td class="text-nowrap">{{ $source->openai_file_id ?: 'N/A' }}</td>
                                                    <td class="text-nowrap">{{ $source->openai_vector_store_id ?: 'N/A' }}</td>
                                                    <td>{{ $source->created_at?->format('Y-m-d H:i') }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            @if(in_array($source->status, ['pending', 'processing'], true))
                                                                <span class="text-muted small align-self-center">
                                                                    Processing in background...
                                                                </span>
                                                            @endif

                                                            @if($source->status === 'failed')
                                                                <form method="POST" action="{{ route('admin.knowledge_sources.reprocess', $source) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-warning btn-sm">Retry</button>
                                                                </form>
                                                            @endif

                                                            <form method="POST" action="{{ route('admin.knowledge_sources.destroy', $source) }}" onsubmit="return confirm('Delete this knowledge source?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No knowledge sources uploaded yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    {{ $sources->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addKnowledgeSourceModal" tabindex="-1" aria-labelledby="addKnowledgeSourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKnowledgeSourceModalLabel">Add Knowledge Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.knowledge_sources.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="pdf" @selected(old('type', 'pdf') === 'pdf')>PDF</option>
                            <option value="text" @selected(old('type') === 'text')>Text</option>
                        </select>
                        @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group mb-4 knowledge-pdf-field">
                        <label for="file">PDF File</label>
                        <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
                        @error('file')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group mb-4 knowledge-text-field d-none">
                        <label for="content">Text Content</label>
                        <textarea class="form-control" id="content" name="content" rows="8">{{ old('content') }}</textarea>
                        @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload To Knowledge Base</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shouldWatchStatusChanges = @json($hasActiveProcessing);
        const watchedSourceIds = @json($sources->pluck('id')->values());
        let knownStatusSnapshot = @json($statusSnapshot);
        const modalElement = document.getElementById('addKnowledgeSourceModal');
        const typeField = document.getElementById('type');
        const pdfField = document.querySelector('.knowledge-pdf-field');
        const textField = document.querySelector('.knowledge-text-field');

        function showKnowledgeSourceModal() {
            if (!modalElement || !(window.bootstrap && window.bootstrap.Modal)) {
                return;
            }

            window.bootstrap.Modal.getOrCreateInstance(modalElement).show();
        }

        function syncFields() {
            const isText = typeField && typeField.value === 'text';

            if (pdfField) {
                pdfField.classList.toggle('d-none', isText);
            }

            if (textField) {
                textField.classList.toggle('d-none', !isText);
            }
        }

        if (typeField) {
            typeField.addEventListener('change', syncFields);
            syncFields();
        }

        @if ($errors->any())
            showKnowledgeSourceModal();
        @endif

        async function pollForStatusChanges() {
            if (!shouldWatchStatusChanges || watchedSourceIds.length === 0) {
                return;
            }

            try {
                const response = await fetch(`{{ route('admin.knowledge_sources.status_snapshot') }}?ids=${watchedSourceIds.join(',')}`, {
                    headers: {
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                const nextSnapshot = {};
                let hasChanged = false;

                (data.sources || []).forEach(function (source) {
                    nextSnapshot[source.id] = {
                        status: source.status,
                        error_message: source.error_message,
                        updated_at: source.updated_at,
                    };

                    const previous = knownStatusSnapshot[source.id];

                    if (!previous) {
                        hasChanged = true;
                        return;
                    }

                    if (
                        previous.status !== source.status ||
                        previous.error_message !== source.error_message ||
                        previous.updated_at !== source.updated_at
                    ) {
                        hasChanged = true;
                    }
                });

                if (hasChanged) {
                    window.location.reload();
                    return;
                }

                knownStatusSnapshot = nextSnapshot;
            } catch (error) {
                // Ignore polling failures and try again on the next interval.
            }
        }

        if (shouldWatchStatusChanges) {
            window.setInterval(pollForStatusChanges, 10000);
        }
    });
</script>
@endsection
