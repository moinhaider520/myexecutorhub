@extends('layouts.master')

@section('content')
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="card">
                    <h2 class="p-2">Onboarding Guide</h2>
                    <button class="btn btn-primary mt-3" id="viewGuideBtn" style="">View Guide</button>
                                                <h2 class="p-2">Access The Gazette Website - <a href="https://www.thegazette.co.uk"
                                    target="_blank">Gazette Website</a></h2>
                </div>
            </div>
        </div>
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
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png"
                                                alt=""></div>
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
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png"
                                                alt=""></div>
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
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/invoice.png"
                                                alt=""></div>
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
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
                                                alt=""></div>
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
                                    <table class="table table-striped table-hover display dataTable no-footer"
                                        id="document-locations-table-view-only">
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
                            <p class="mb-0 text-muted">Designed for straightforward estates with a will, minimal assets, and
                                no inheritance tax.</p>
                            <div class="mt-2">
                                <span class="badge badge-success">{{ $standardCompletedItems }}/{{ $standardTotalItems }}
                                    Completed ({{ $standardCompletionPercentage }}%)</span>
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
                                                            $stageCompleted = $stage->todoItems->sum(function ($item) {
                                                                return $item->currentUserProgress && $item->currentUserProgress->status === 'completed' ? 1 : 0;
                                                            });
                                                            $stageTotal = $stage->todoItems->count();
                                                        @endphp
                                                        <span
                                                            class="badge bg-info">{{ $stageCompleted }}/{{ $stageTotal }}</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="standardCollapse{{ $stage->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="standardHeading{{ $stage->id }}"
                                            data-bs-parent="#standardTodoAccordion">
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
                                                                        <h6
                                                                            class="mb-1 {{ $currentStatus === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                                            {{ $todoItem->title }}
                                                                        </h6>
                                                                        @if($todoItem->description)
                                                                            <small
                                                                                class="text-muted">{{ $todoItem->description }}</small>
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
                                                                <small class="text-muted"><strong>Notes:</strong>
                                                                    {{ $todoItem->currentUserProgress->notes }}</small>
                                                            </div>
                                                        @endif
                                                        @if($todoItem->currentUserProgress && $todoItem->currentUserProgress->completed_at)
                                                            <div class="mt-1">
                                                                <small class="text-muted"><strong>Completed:</strong>
                                                                    {{ $todoItem->currentUserProgress->completed_at->format('d/m/Y H:i') }}</small>
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
                            <p class="mb-0 text-muted">For larger, taxable, or more complex estates — involving property
                                sales, trusts, or disputes.</p>
                            <div class="mt-2">
                                <span class="badge badge-primary">{{ $advancedCompletedItems }}/{{ $advancedTotalItems }}
                                    Completed ({{ $advancedCompletionPercentage }}%)</span>
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
                                                            $stageCompleted = $stage->todoItems->sum(function ($item) {
                                                                return $item->currentUserProgress && $item->currentUserProgress->status === 'completed' ? 1 : 0;
                                                            });
                                                            $stageTotal = $stage->todoItems->count();
                                                        @endphp
                                                        <span
                                                            class="badge bg-secondary">{{ $stageCompleted }}/{{ $stageTotal }}</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="advancedCollapse{{ $stage->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="advancedHeading{{ $stage->id }}"
                                            data-bs-parent="#advancedTodoAccordion">
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
                                                                        <h6
                                                                            class="mb-1 {{ $currentStatus === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                                            {{ $todoItem->title }}
                                                                        </h6>
                                                                        @if($todoItem->description)
                                                                            <small
                                                                                class="text-muted">{{ $todoItem->description }}</small>
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
                                                                <small class="text-muted"><strong>Notes:</strong>
                                                                    {{ $todoItem->currentUserProgress->notes }}</small>
                                                            </div>
                                                        @endif
                                                        @if($todoItem->currentUserProgress && $todoItem->currentUserProgress->completed_at)
                                                            <div class="mt-1">
                                                                <small class="text-muted"><strong>Completed:</strong>
                                                                    {{ $todoItem->currentUserProgress->completed_at->format('d/m/Y H:i') }}</small>
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
         <!-- GUIDE MODAL -->
        <div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Executor Hub Onboarding Guide</h5>
                        <button type="button" class="btn-close" aria-label="Close" id="modalCloseBtn"></button>

                    </div>
                    <div class="modal-body">
                        <!-- Step Contents -->
                        <div class="step active" data-audio="{{ asset('assets/executor_guide_audios/audio1.mp3') }}">
                            <h4>Step 1 – Welcome & Getting Started</h4>
                            <p>Welcome to Executor Hub!</p>
                            <p>You’ve been given access because you are acting as an executor for an estate. This dashboard is your central control panel to guide you through every stage of the process — keeping you organised, compliant, and in control.</p>
                            <p>Before you start:</p>
                            <ul>
                                <li>Download the Executor Hub app from the App Store (iOS) or Google Play (Android) so you can access everything on the go.</li>
                                <li>Log in from your computer, tablet, or mobile.</li>
                                <li>Enable notifications so we can remind you about important deadlines.</li>
                                <li>Familiarise yourself with the menu on the left-hand side — this is how you’ll navigate between sections.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio2.mp3') }}">
                            <h4>Step 2 – Understanding Your Dashboard</h4>
                            <p>When you log in, your Dashboard gives you a clear snapshot of the estate’s progress, including:</p>
                            <ul>
                                <li>Total assets and liabilities recorded so far.</li>
                                <li>Number of documents uploaded.</li>
                                <li>Your executor to-do lists:
                                    <ul>
                                        <li>Standard Executor To-Do List – for simpler estates.</li>
                                        <li>Advanced Executor To-Do List – for more complex estates.</li>
                                    </ul>
                                </li>
                                <li>Progress tracking – see how many tasks are completed and what’s still outstanding.</li>
                                <li>Quick action buttons – upload documents, add assets, or invite advisors with a single click.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio3.mp3') }}">
                            <h4>Step 3 – Your To-Do Lists</h4>
                            <p>Your to-do lists are step-by-step roadmaps to guide you through the executor process in the right order.</p>
                            <p>Standard Executor To-Do List (for straightforward estates):</p>
                            <ul>
                                <li>Immediately After Death</li>
                                <li>Legal Authority</li>
                                <li>Notify & Collect</li>
                                <li>Pay Debts & Liabilities</li>
                                <li>Distribute the Estate</li>
                            </ul>
                            <p>Advanced Executor To-Do List (for complex estates):</p>
                            <ul>
                                <li>A.Immediate Legal & Personal Tasks</li>
                                <li>B.Estate Valuation & Notifications</li>
                                <li>C.Inheritance Tax & Probate</li>
                                <li>D.Estate Administration</li>
                                <li>E.Final Accounting & Distribution</li>
                                <li>F.Final Compliance</li>
                            </ul>
                            <p>Tip: Click each stage to expand tasks. You can:</p>
                            <ul>
                                <li>Mark tasks as complete.</li>
                                <li>Add notes.</li>
                                <li>Upload related documents.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio4.mp3') }}">
                            <h4>Step 4 – Adding Assets & Liabilities</h4>
                            <p>The Assets & Liabilities section is where you record everything in the estate, including:</p>
                            <ul>
                                <li>Bank accounts</li>
                                <li>Property and land</li>
                                <li>Investments and shares</li>
                                <li>Insurance policies</li>
                                <li>Business interests</li>
                                <li>Debts and liabilities</li>
                                <li>Digital and foreign assets</li>
                            </ul>
                            <p>Adding this information early will make valuations, tax calculations, and distributions much smoother.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio5.mp3') }}">
                            <h4>Step 5 – Uploading Documents & Media</h4>
                            <p>Keep everything safe and in one place by uploading:</p>
                            <ul>
                                <li>Wills, trusts, and legal documents</li>
                                <li>Death certificates</li>
                                <li>Valuations and financial statements</li>
                                <li>Photos and videos of assets</li>
                            </ul>
                            <p>You can store these under:</p>
                            <ul>
                                <li>Documents</li>
                                <li>Pictures & Videos</li>
                                <li>Life Remembered – for preserving personal memories through photos, videos, and voice notes.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio6.mp3') }}">
                            <h4>Step 6 – Managing Executors & Advisors</h4>
                            <p>You can add and manage the people helping with the estate:</p>
                            <ul>
                                <li>Executors – add co-executors, assign roles, and control permissions.</li>
                                <li>Advisors – invite solicitors, accountants, or other professionals to securely view or update relevant sections.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio7.mp3') }}">
                            <h4>Step 7 – Wishes, Guidance & Funeral Preferences</h4>
                            <p>Capture the deceased’s personal wishes in dedicated sections:</p>
                            <ul>
                                <li>Trust Wishes</li>
                                <li>Memorandum of Wishes</li>
                                <li>Guidance for Guardians</li>
                                <li>Funeral & Donations</li>
                            </ul>
                            <p>This ensures nothing important is missed and all preferences are respected.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio8.mp3') }}">
                            <h4>Step 8 – Staying On Track</h4>
                            <ul>
                                <li>Your progress updates automatically when tasks are marked complete.</li>
                                <li>Set reminders to prompt you if a task hasn’t been updated for a while.</li>
                                <li>The system highlights important legal or tax deadlines so you never miss them.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio9.mp3') }}">
                            <h4>Step 9 – Support & Help</h4>
                            <ul>
                                <li>Use the “Chat with Us” button on the right for instant help.</li>
                                <li>Look for “?” icons for built-in explanations and tips.</li>
                                <li>Contact your professional advisor directly through the platform if you need expert guidance.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio10.mp3') }}">
                            <h4>Step 10 – Final Compliance & Closing the Estate</h4>
                            <p>When everything is complete:</p>
                            <ul>
                                <li>Submit any final tax returns (if required).</li>
                                <li>Reconcile all accounts and prepare final statements.</li>
                                <li>Upload all documents to Executor Hub to keep a permanent record.</li>
                            </ul>
                            <p>Once archived, you’ll have a complete and secure record of the estate administration.</p>                            
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio11.mp3') }}">
                            <h4>Final Reminder – Stay Connected</h4>
                            <p>To make things even easier, download the Executor Hub app if you haven’t already.</p>
                            <ul>
                                <li>App Store (iOS) – search “Executor Hub”</li>
                                <li>Google Play (Android) – search “Executor Hub”</li>
                            </ul>
                            <p>With the app, you can manage tasks, upload documents, and get reminders anywhere, anytime.</p>                            
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                        <button class="btn btn-primary" id="nextBtn">Next</button>
                        <button class="btn btn-success d-none" id="finishBtn">Finish</button>
                    </div>
                </div>
            </div>
        </div>
        <audio id="stepAudio" autoplay hidden></audio>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function () {
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
        $(document).ready(function () {
            // Handle todo status change
            $('.todo-status-select').on('change', function () {
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
                    success: function (response) {
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
                    error: function () {
                        alert('Error updating status. Please try again.');
                        $(`select[data-todo-id="${todoId}"]`).val(currentStatus);
                    }
                });
            });
        });
    </script>
    <script>
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const finishBtn = document.getElementById('finishBtn');
        const viewGuideBtn = document.getElementById('viewGuideBtn');
        const guideModal = new bootstrap.Modal(document.getElementById('guideModal'));
        const stepAudio = document.getElementById('stepAudio');
        const repeatButtons = document.querySelectorAll('.repeatBtn');
        let currentStep = 0;

        repeatButtons.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const audio = steps[index].getAttribute('data-audio');
                if (audio) {
                    stepAudio.src = audio;
                    stepAudio.play();
                }
            });
        });


        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.remove('active');
                if (i === index) {
                    step.classList.add('active');
                    let audio = step.getAttribute('data-audio');
                    if (audio) {
                        stepAudio.src = audio;
                        stepAudio.play();
                    }
                }
            });

            prevBtn.disabled = index === 0;
            nextBtn.classList.toggle('d-none', index === steps.length - 1);
            finishBtn.classList.toggle('d-none', index !== steps.length - 1);
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        viewGuideBtn.addEventListener('click', () => {
            currentStep = 0;
            showStep(currentStep);
            guideModal.show();
        });

        function stopAudio() {
            const audio = document.getElementById('stepAudio');
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }
        }

        document.getElementById('modalCloseBtn').addEventListener('click', () => {
            stopAudio();
            guideModal.hide();
        });

        document.getElementById('finishBtn').addEventListener('click', () => {
            stopAudio();
            guideModal.hide();
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Show modal only on first visit
            if (!localStorage.getItem('hasVisited')) {
                guideModal.show();
                showStep(currentStep); // ✅ move inside
                localStorage.setItem('hasVisited', 'true');
            }
        });

    </script>

@endsection