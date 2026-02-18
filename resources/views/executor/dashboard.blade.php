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
                <div class="col">
                    <div class="card">
                        <h3 class="text-center pt-2 pb-2">
                            View Guide Videos on Youtube -
                            <span> <a href="https://www.youtube.com/@ExecutorHubUK" target="_blank" class="text-center"
                                    style="font-size: 18px;">Click Here to View Channel!</a></span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11 d-flex">

                    <button class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#impersonationModal">
                        Switch Customer
                    </button>

                </div>
                <div class="col-md-1">
                    <iframe
                        src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                        style="border:none;height:132px;width:132px;"></iframe>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <h3 class="text-center pt-2 pb-2">
                            Download the App on App Store -
                            <span> <a href="https://apps.apple.com/us/app/executor-hub/id6737507623" target="_blank"
                                    class="text-center" style="font-size: 18px;">Click Here to Download!</a></span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="card">
                    <h2 class="p-2">Onboarding Guide</h2>
                    <button class="btn btn-primary mt-3" id="viewGuideBtn" style="">View Guide</button>
                    <h3 class="p-2">Access The Gazette Website - <a
                            href="https://www.thegazette.co.uk/wills-and-probate/place-a-deceased-estates-notice"
                            target="_blank">Gazette Website</a></h3>
                    <h3 class="p-2">Access The NWR Website - <a href="https://www.nationalwillregister.co.uk/"
                            target="_blank">NWR Website</a></h3>
                    <h3 class="p-2">Access The Tell Us Once Website - <a
                            href="https://www.gov.uk/after-a-death/organisations-you-need-to-contact-and-tell-us-once"
                            target="_blank">Tell Us Once Website</a></h3>
                    <h3 class="p-2">Access The Estate Search Website - <a href="https://www.estatesearch.co.uk/"
                            target="_blank">Estate Search Website</a></h3>
                    <h3 class="p-2">Access The Probate Registry Website - <a
                            href="https://www.gov.uk/applying-for-probate/apply-for-probate" target="_blank">Probate
                            Registry Website</a></h3>
                    <h3 class="p-2">Access The DVLA Website - <a href="https://www.gov.uk/tell-dvla-about-bereavement"
                            target="_blank">DVLA Website</a></h3>
                    <h3 class="p-2">Access The Royal Mail Website - <a
                            href="https://help.royalmail.com/personal/s/article/Redirecting-mail-on-behalf-of-someone-else"
                            target="_blank">Royal Mail Website</a></h3>
                    <h3 class="p-2">Access The Land Registry Website - <a
                            href="https://www.gov.uk/update-property-records-someone-dies" target="_blank">Land Registry
                            Website</a></h3>
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
                            @if ($documentLocations->isEmpty())
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
                                            @foreach ($documentLocations as $index => $location)
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
                            <p class="mb-0 text-muted">Designed for straightforward estates with a will, minimal assets,
                                and
                                no inheritance tax.</p>
                            <div class="mt-2">
                                <span class="badge badge-success">{{ $standardCompletedItems }}/{{ $standardTotalItems }}
                                    Completed ({{ $standardCompletionPercentage }}%)</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="standardTodoAccordion">
                                @foreach ($standardTodoStages as $stage)
                                    <div class="accordion-item mb-3">
                                        <h2 class="accordion-header" id="standardHeading{{ $stage->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#standardCollapse{{ $stage->id }}"
                                                aria-expanded="false"
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
                                                                return $item->currentUserProgress &&
                                                                    $item->currentUserProgress->status === 'completed'
                                                                    ? 1
                                                                    : 0;
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
                                                @foreach ($stage->todoItems as $todoItem)
                                                    @php
                                                        $currentStatus = $todoItem->currentUserProgress
                                                            ? $todoItem->currentUserProgress->status
                                                            : 'not_completed';
                                                    @endphp
                                                    <div class="todo-item mb-3 p-3 border rounded">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="d-flex align-items-center">
                                                                    @if ($currentStatus === 'completed')
                                                                        <i
                                                                            class="fa fa-check-circle text-success me-2"></i>
                                                                    @elseif($currentStatus === 'not_required')
                                                                        <i
                                                                            class="fa fa-times-circle text-warning me-2"></i>
                                                                    @else
                                                                        <i class="fa fa-circle text-muted me-2"></i>
                                                                    @endif
                                                                    <div>
                                                                        <h6
                                                                            class="mb-1 {{ $currentStatus === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                                            {{ $todoItem->title }}
                                                                        </h6>
                                                                        @if ($todoItem->description)
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
                                                                    <option value="not_completed"
                                                                        {{ $currentStatus === 'not_completed' ? 'selected' : '' }}>
                                                                        Not Completed
                                                                    </option>
                                                                    <option value="completed"
                                                                        {{ $currentStatus === 'completed' ? 'selected' : '' }}>
                                                                        Completed
                                                                    </option>
                                                                    <option value="not_required"
                                                                        {{ $currentStatus === 'not_required' ? 'selected' : '' }}>
                                                                        Not Required
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if ($todoItem->currentUserProgress && $todoItem->currentUserProgress->notes)
                                                            <div class="mt-2">
                                                                <small class="text-muted"><strong>Notes:</strong>
                                                                    {{ $todoItem->currentUserProgress->notes }}</small>
                                                            </div>
                                                        @endif
                                                        @if ($todoItem->currentUserProgress && $todoItem->currentUserProgress->completed_at)
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
                                @foreach ($advancedTodoStages as $stage)
                                    <div class="accordion-item mb-3">
                                        <h2 class="accordion-header" id="advancedHeading{{ $stage->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#advancedCollapse{{ $stage->id }}"
                                                aria-expanded="false"
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
                                                                return $item->currentUserProgress &&
                                                                    $item->currentUserProgress->status === 'completed'
                                                                    ? 1
                                                                    : 0;
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
                                                @foreach ($stage->todoItems as $todoItem)
                                                    @php
                                                        $currentStatus = $todoItem->currentUserProgress
                                                            ? $todoItem->currentUserProgress->status
                                                            : 'not_completed';
                                                    @endphp
                                                    <div class="todo-item mb-3 p-3 border rounded">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="d-flex align-items-center">
                                                                    @if ($currentStatus === 'completed')
                                                                        <i
                                                                            class="fa fa-check-circle text-success me-2"></i>
                                                                    @elseif($currentStatus === 'not_required')
                                                                        <i
                                                                            class="fa fa-times-circle text-warning me-2"></i>
                                                                    @else
                                                                        <i class="fa fa-circle text-muted me-2"></i>
                                                                    @endif
                                                                    <div>
                                                                        <h6
                                                                            class="mb-1 {{ $currentStatus === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                                            {{ $todoItem->title }}
                                                                        </h6>
                                                                        @if ($todoItem->description)
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
                                                                    <option value="not_completed"
                                                                        {{ $currentStatus === 'not_completed' ? 'selected' : '' }}>
                                                                        Not Completed
                                                                    </option>
                                                                    <option value="completed"
                                                                        {{ $currentStatus === 'completed' ? 'selected' : '' }}>
                                                                        Completed
                                                                    </option>
                                                                    <option value="not_required"
                                                                        {{ $currentStatus === 'not_required' ? 'selected' : '' }}>
                                                                        Not Required
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if ($todoItem->currentUserProgress && $todoItem->currentUserProgress->notes)
                                                            <div class="mt-2">
                                                                <small class="text-muted"><strong>Notes:</strong>
                                                                    {{ $todoItem->currentUserProgress->notes }}</small>
                                                            </div>
                                                        @endif
                                                        @if ($todoItem->currentUserProgress && $todoItem->currentUserProgress->completed_at)
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

            <div class="row mt-4">
                <!-- Standard To-Do List -->
                <div class="col-lg-12 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h4>Support Beyond the Paperwork</h4>
                            <p class="mb-0 text-muted">Practical guidance, emotional support, and trusted help when things feel overwhelming</p>
                                                        <p class="mb-0 text-muted">Because dealing with loss is about more than forms and admin.</p>
                        </div>
                        <div class="card-body">
                                <p>Losing someone close can feel overwhelming—emotionally, mentally, and physically. Executor Hub is here to help you manage the practical side of things, but it's just as important to look after yourself. This section brings together trusted support, guidance, and professional help for when things feel heavy, confusing, or simply too much.</p>
    
    <p>Everyone experiences grief differently. There is no "right" way to feel—and no timeline you're expected to follow. If you're struggling, talking to someone can really help.</p>
    
    
    <h3>🌿 Talk to Someone Now</h3>
    <p>For moments when support is needed immediately.</p>
    
    <h4>Samaritans</h4>
    <p>📞 116 123 (UK & ROI–24/7)<br>
    🌐 <a href="https://www.samaritans.org">samaritans.org</a></p>
    <p>Confidential emotional support, day or night.</p>
    
    <h4>NHS 111</h4>
    <p>📞 111</p>
    <p>For urgent mental health advice if you're unsure where to turn.</p>
    
    <h3>🤍 Bereavement-Specific Support</h3>
    <p>Focused help from people who understand loss.</p>
    
    <h4>Cruse Bereavement Support</h4>
    <p>🌐 <a href="https://www.cruse.org.uk">cruse.org.uk</a><br>
    📞 0808 808 1677</p>
    <p>Specialist bereavement counselling & support services.</p>
    
    <h4>Sue Ryder</h4>
    <p>🌐 <a href="https://www.sueryder.org">sueryder.org</a></p>
    <p>Grief support, counselling, & community resources.</p>
    
    <h3>🌱 Mental Health & Wellbeing</h3>
    <p>Support for ongoing emotional wellbeing.</p>
    
    <h4>Mind</h4>
    <p>🌐 <a href="https://www.mind.org.uk">mind.org.uk</a><br>
    📞 0300 123 3393</p>
    <p>Advice, information, & local mental health support.</p>
    
    <h4>NHS Talking Therapies (IAPT)</h4>
    <p>🌐 <a href="https://www.nhs.uk/talking-therapies">nhs.uk/talking-therapies</a></p>
    <p>Free, confidential therapy services via GP self-referral.</p>
    
    <h3>Self-care guidance</h3>
    <p>Grief can affect sleep, appetite, focus, and energy. Small things can help:</p>
    <ul>
        <li>Try to rest when you can</li>
        <li>Eat little and often</li>
        <li>Accept help when it's offered</li>
        <li>Take breaks from admin when needed</li>
    </ul>
    <p>Executor Hub will still be here when you're ready.</p>
    
    <h3>Optional future upgrade</h3>
    <p>You don't need this now, but it's a powerful roadmap:</p>
    
    <h4>🔒 Trusted Partner Support (Coming Soon)</h4>
    <p>In future, Executor Hub may offer access to trusted counselling and wellbeing partners, with optional referrals and support pathways.</p>
    
    <h2>Legal & compliance positioning</h2>
    <p>This protects you.</p>
    
    <h3>Footer disclaimer</h3>
    <p>Executor Hub provides access to information and signposts to third-party support services. We do not provide medical, mental health, or counselling services.</p>
    <p>If you are in immediate danger or feel at risk, please contact emergency services.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Standard To-Do List -->
                <div class="col-lg-12 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h4>Notify banks & building societies</h4>
                            <p class="mb-0 text-muted">Use the Death Notification Service (DNS) to notify multiple banks and building societies at once. It’s free and widely used across the UK</p>
                        </div>
                        <div class="card-body">

    <p>Open Death Notification Service<a href="https://www.deathnotificationservice.co.uk/">Death Notification Service</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Standard To-Do List -->
                <div class="col-lg-12 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h4>Banks & building societies</h4>
                            <p class="mb-0 text-muted">Many UK banks and building societies can be notified at once using the Death Notification Service (DNS).</p>
                            <p>DNS is a free, independent service that passes the notification on to participating organisations.</p>
                            <p>Executor Hub will help you prepare the information you need and track what you’ve done — but the notification itself is submitted directly on the DNS website.</p>
                            <p></p>
                        </div>
                        <div class="card-body">

    <p>👉 Go to Death Notification Service<a href="https://www.deathnotificationservice.co.uk/">Death Notification Service</a></p>
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
                            <h4>Welcome & Getting Started</h4>
                            <p>Welcome to Executor Hub</p>
                            <p>Your guided assistant for managing an estate — every task, deadline & document in one secure
                                place.</p>
                            <p>We’ll take this step-by-step together ❤️</p>
                            <p>Click Next to Get Started</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio2.mp3') }}">
                            <h4>Step 1 – Confirm Authority</h4>
                            <p>First things first — we’ll secure your legal right to act.</p>
                            <p>You’ll do 3 key actions:</p>
                            <ul>
                                <li>Confirm who has authority</li>
                                <li>Upload the will (if there is one)</li>
                                <li>Upload the death certificate</li>
                            </ul>
                            <p>Once confirmed, the correct tasks will unlock automatically.</p>
                            <p>🎯 Goal of this step</p>
                            <p>➜ Secure authority → unlock the estate roadmap</p>
                            <p>[ Upload Will ] [ Upload Death Certificate ]</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio3.mp3') }}">
                            <h4>Step 2 – Your Executor Checklist</h4>
                            <p>This is your personalised roadmap — in the correct legal order.</p>
                            <p>You’ll see Milestones such as:</p>
                            <p>A. Secure Authority</p>
                            <p>B. Notify & Protect</p>
                            <p>C. Estate Valuation</p>
                            <p>D. Probate Application</p>
                            <p>E. Administration</p>
                            <p>F. Final Distribution</p>
                            <p>Each task includes:</p>
                            <p>🔗 Correct website links</p>
                            <p>📄 Auto-generated letters & email templates</p>
                            <p>⬆ Upload proof</p>
                            <p>✔ Mark complete</p>
                            <p>You’re never alone — we guide every click.</p>
                            <p>💬 Need help? Watch quick videos & FAQs along the way.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio4.mp3') }}">
                            <h4>Step 3 – Notify All Organisations</h4>
                            <p>We’ll help you handle every notification quickly and correctly.</p>
                            <p>Categories include:</p>
                            <p>🏦 Banks & investments</p>
                            <p>🏡 Property & utilities</p>
                            <p>🏥 Health & care providers</p>
                            <p>📩 Government services</p>
                            <p>📱 Digital accounts & social media</p>
                            <p>📰 Gazette notice</p>
                            <p>Every notification supports:</p>
                            <p>📄 Auto-filled documents</p>
                            <p>✉ Email send + response tracking</p>
                            <p>⬆ Upload proof received</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio5.mp3') }}">
                            <h4>Step 4 – Secure and Upload Information</h4>
                            <p>Keep everything safe, organised, and backed up forever.</p>
                            <p>Add:</p>
                            <p>🧾 Financial documents</p>
                            <p>📸 Photos of property & assets</p>
                            <p>🏷️ Proof of notifications</p>
                            <p>🪪 ID & authority documents</p>
                            <p>📁 Final statements later</p>
                            <p>The system tags items automatically so you can instantly find them.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio6.mp3') }}">
                            <h4>Step 5 – Invite Others (Optional)</h4>
                            <p>You can add people to help…</p>
                            <p>👥 Co-Executors — share workload</p>
                            <p>📚 Professionals — solicitors / accountants</p>
                            <p>👨‍👩‍👧 Beneficiary view (read-only)</p>
                            <p>You stay in full control of what each person sees.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio7.mp3') }}">
                            <h4>Step 6 – Stay on Track</h4>
                            <p>You’ll see:</p>
                            <p>📊 Progress %</p>
                            <p>⭐ Confidence Rating</p>
                            <p>⚠️ Deadline Alerts</p>
                            <p>📝 Tasks waiting for action</p>
                            <p>🔔 Gentle reminders when something stalls</p>
                            <p>We’ll guide the timing — you control the decisions.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio8.mp3') }}">
                            <h4>Step 7 – Help When You Need It</h4>
                            <p>Support includes:</p>
                            <p>💬 Live chat</p>
                            <p>🎥 60-second task explainer videos</p>
                            <p>❓ FAQs for every item</p>
                            <p>👨‍💼 Ask your professional adviser</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/executor_guide_audios/audio9.mp3') }}">
                            <h4>💙 You’re Ready</h4>
                            <p>That’s everything you need to make a strong start.</p>
                            <p>We’ll guide each step as you go.</p>
                            <p>Let’s begin with the first task.</p>
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
    <!-- IMPERSONATION MODAL -->
    <div class="modal fade" id="impersonationModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Act on behalf of</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if ($customers->isEmpty())
                        <p class="text-muted">No customers linked to you.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($customers as $customer)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $customer->name }}</strong><br>
                                        <small class="text-muted">{{ $customer->email }}</small>
                                    </div>
                                    <button class="btn btn-sm btn-primary act-as-btn" data-id="{{ $customer->id }}">
                                        Act as
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $('.act-as-btn').on('click', function() {
            let customerId = $(this).data('id');

            $.post("{{ route('executor.impersonate') }}", {
                    _token: "{{ csrf_token() }}",
                    customer_id: customerId
                })
                .done(function(res) {
                    if (res.success && res.redirect) {
                        window.location.href = res.redirect;
                    }
                })
                .fail(function() {
                    alert('Unable to switch customer.');
                });
        });
    </script>

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
                    url: '{{ route('executor.dashboard.update-todo') }}',
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
                            $(`select[data-todo-id="${todoId}"]`).data('current-status',
                                newStatus);

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

        document.addEventListener("DOMContentLoaded", function() {
            // Show modal only on first visit
            if (!localStorage.getItem('hasVisited')) {
                guideModal.show();
                showStep(currentStep); // ✅ move inside
                localStorage.setItem('hasVisited', 'true');
            }
        });
    </script>

@endsection
