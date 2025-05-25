@extends('layouts.master')

@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-6 col-sm-6">
                        <div class="card">
                            <div class="card-body student">
                                <div class="d-flex gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <h2>£{{ number_format($totalBankBalance, 2) }}</h2>
                                        <p class="mb-0 text-truncate"> Total Assets Networth</p>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <div class="card">
                            <div class="card-body student-2">
                                <div class="d-flex gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <h2>£{{ number_format($totalDebt, 2) }}</h2>
                                        <p class="mb-0 text-truncate"> Liabilities Net Worth</p>
                                        <div class="d-flex student-arrow text-truncate">
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <div class="card">
                            <div class="card-body student-3">
                                <div class="d-flex gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <h2>{{ $totalDocuments }}</h2>
                                        <p class="mb-0 text-truncate"> Documents Uploaded</p>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/invoice.png" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <div class="card">
                            <div class="card-body student-4">
                                <div class="d-flex gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <h2>{{ $totalExecutors }}</h2>
                                        <p class="mb-0 text-truncate"> Executors </p>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location of My Documents Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4>Location of My Documents</h4>
                            <span>View your saved document storage locations</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($documentLocations->isEmpty())
                        <p class="text-muted">No locations added yet.</p>
                        @else
                        <div class="table-responsive theme-scrollbar">
                            <table class="table table-striped table-hover display dataTable no-footer" id="document-locations-table-view-only">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Location</th>
                                        <th>Added At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentLocations as $index => $location)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $location->location }}</td>
                                        <td>{{ $location->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Executor To-Do Lists Section -->
        <div class="row mt-4">
            <!-- Standard To-Do List -->
            <div class="col-lg-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h4>Standard Executor To-Do List</h4>
                        <p class="mb-0 text-muted">Designed for straightforward estates with a will, minimal assets, and no inheritance tax.</p>
                        <div class="mt-2">
                            <span class="badge badge-success">{{ $standardCompletedItems }}/{{ $standardTotalItems }} Completed ({{ $standardCompletionPercentage }}%)</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="standardTodoAccordion">
                            @foreach($standardTodoStages as $stage)
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="standardHeading{{ $stage->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#standardCollapse{{ $stage->id }}" aria-expanded="false"
                                        aria-controls="standardCollapse{{ $stage->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <div>
                                                <strong>{{ $stage->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $stage->description }}</small>
                                            </div>
                                            <div class="text-end">
                                                @php
                                                $stageCompleted = $stage->todoItems->sum(function($item) {
                                                return $item->currentUserProgress && $item->currentUserProgress->status === 'completed' ? 1 : 0;
                                                });
                                                $stageTotal = $stage->todoItems->count();
                                                @endphp
                                                <span class="badge bg-info">{{ $stageCompleted }}/{{ $stageTotal }}</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="standardCollapse{{ $stage->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="standardHeading{{ $stage->id }}" data-bs-parent="#standardTodoAccordion">
                                    <div class="accordion-body">
                                        @foreach($stage->todoItems as $todoItem)
                                        @php
                                        $currentStatus = $todoItem->currentUserProgress ? $todoItem->currentUserProgress->status : 'not_completed';
                                        @endphp
                                        <div class="todo-item mb-3 p-3 border rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        @if($currentStatus === 'completed')
                                                        <i class="fa fa-check-circle text-success me-2"></i>
                                                        @elseif($currentStatus === 'not_required')
                                                        <i class="fa fa-times-circle text-warning me-2"></i>
                                                        @else
                                                        <i class="fa fa-circle text-muted me-2"></i>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1 {{ $currentStatus === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                                {{ $todoItem->title }}
                                                            </h6>
                                                            @if($todoItem->description)
                                                            <small class="text-muted">{{ $todoItem->description }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select todo-status-select"
                                                        data-todo-id="{{ $todoItem->id }}"
                                                        data-current-status="{{ $currentStatus }}">
                                                        <option value="not_completed" {{ $currentStatus === 'not_completed' ? 'selected' : '' }}>
                                                            Not Completed
                                                        </option>
                                                        <option value="completed" {{ $currentStatus === 'completed' ? 'selected' : '' }}>
                                                            Completed
                                                        </option>
                                                        <option value="not_required" {{ $currentStatus === 'not_required' ? 'selected' : '' }}>
                                                            Not Required
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            @if($todoItem->currentUserProgress && $todoItem->currentUserProgress->notes)
                                            <div class="mt-2">
                                                <small class="text-muted"><strong>Notes:</strong> {{ $todoItem->currentUserProgress->notes }}</small>
                                            </div>
                                            @endif
                                            @if($todoItem->currentUserProgress && $todoItem->currentUserProgress->completed_at)
                                            <div class="mt-1">
                                                <small class="text-muted"><strong>Completed:</strong> {{ $todoItem->currentUserProgress->completed_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced To-Do List -->
            <div class="col-lg-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h4>Advanced Executor To-Do List</h4>
                        <p class="mb-0 text-muted">For larger, taxable, or more complex estates — involving property sales, trusts, or disputes.</p>
                        <div class="mt-2">
                            <span class="badge badge-primary">{{ $advancedCompletedItems }}/{{ $advancedTotalItems }} Completed ({{ $advancedCompletionPercentage }}%)</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="advancedTodoAccordion">
                            @foreach($advancedTodoStages as $stage)
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="advancedHeading{{ $stage->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#advancedCollapse{{ $stage->id }}" aria-expanded="false"
                                        aria-controls="advancedCollapse{{ $stage->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <div>
                                                <strong>{{ $stage->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $stage->description }}</small>
                                            </div>
                                            <div class="text-end">
                                                @php
                                                $stageCompleted = $stage->todoItems->sum(function($item) {
                                                return $item->currentUserProgress && $item->currentUserProgress->status === 'completed' ? 1 : 0;
                                                });
                                                $stageTotal = $stage->todoItems->count();
                                                @endphp
                                                <span class="badge bg-secondary">{{ $stageCompleted }}/{{ $stageTotal }}</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="advancedCollapse{{ $stage->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="advancedHeading{{ $stage->id }}" data-bs-parent="#advancedTodoAccordion">
                                    <div class="accordion-body">
                                        @foreach($stage->todoItems as $todoItem)
                                        @php
                                        $currentStatus = $todoItem->currentUserProgress ? $todoItem->currentUserProgress->status : 'not_completed';
                                        @endphp
                                        <div class="todo-item mb-3 p-3 border rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        @if($currentStatus === 'completed')
                                                        <i class="fa fa-check-circle text-success me-2"></i>
                                                        @elseif($currentStatus === 'not_required')
                                                        <i class="fa fa-times-circle text-warning me-2"></i>
                                                        @else
                                                        <i class="fa fa-circle text-muted me-2"></i>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1 {{ $currentStatus === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                                {{ $todoItem->title }}
                                                            </h6>
                                                            @if($todoItem->description)
                                                            <small class="text-muted">{{ $todoItem->description }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select todo-status-select"
                                                        data-todo-id="{{ $todoItem->id }}"
                                                        data-current-status="{{ $currentStatus }}">
                                                        <option value="not_completed" {{ $currentStatus === 'not_completed' ? 'selected' : '' }}>
                                                            Not Completed
                                                        </option>
                                                        <option value="completed" {{ $currentStatus === 'completed' ? 'selected' : '' }}>
                                                            Completed
                                                        </option>
                                                        <option value="not_required" {{ $currentStatus === 'not_required' ? 'selected' : '' }}>
                                                            Not Required
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            @if($todoItem->currentUserProgress && $todoItem->currentUserProgress->notes)
                                            <div class="mt-2">
                                                <small class="text-muted"><strong>Notes:</strong> {{ $todoItem->currentUserProgress->notes }}</small>
                                            </div>
                                            @endif
                                            @if($todoItem->currentUserProgress && $todoItem->currentUserProgress->completed_at)
                                            <div class="mt-1">
                                                <small class="text-muted"><strong>Completed:</strong> {{ $todoItem->currentUserProgress->completed_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<script>
    $(document).ready(function() {
        $('#document-locations-table-view-only').DataTable({
            "ordering": true,
            "paging": true,
            "searching": true,
            "language": {
                "emptyTable": "No document locations available"
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Handle todo status change
        $('.todo-status-select').on('change', function() {
            const todoId = $(this).data('todo-id');
            const newStatus = $(this).val();
            const currentStatus = $(this).data('current-status');

            // Show confirmation for important changes
            if (currentStatus === 'completed' && newStatus !== 'completed') {
                if (!confirm('Are you sure you want to mark this as not completed?')) {
                    $(this).val(currentStatus);
                    return;
                }
            }

            // Add notes option for completed items
            let notes = '';
            if (newStatus === 'completed' || newStatus === 'not_required') {
                notes = prompt('Add any notes (optional):') || '';
            }

            $.ajax({
                url: '{{ route("executor.dashboard.update-todo") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    todo_item_id: todoId,
                    status: newStatus,
                    notes: notes
                },
                success: function(response) {
                    if (response.success) {
                        // Update the current status data attribute
                        $(`select[data-todo-id="${todoId}"]`).data('current-status', newStatus);

                        // Reload the page to update counters and styling
                        location.reload();
                    } else {
                        alert('Error updating status. Please try again.');
                        $(`select[data-todo-id="${todoId}"]`).val(currentStatus);
                    }
                },
                error: function() {
                    alert('Error updating status. Please try again.');
                    $(`select[data-todo-id="${todoId}"]`).val(currentStatus);
                }
            });
        });
    });
</script>

@endsection