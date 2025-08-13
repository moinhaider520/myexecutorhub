@extends('layouts.master')

@section('content')
<style>
    .beneficiary-line-container {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 5px 0;
        position: relative;
    }

    .beneficiary-name,
    .beneficiary-share {
        position: relative;
        z-index: 2;
        /* Ensures text is on top of the dotted line */
        background: white;
        /* Use the background color of your card */
        padding: 0 5px;
        /* Adds a small gap between the text and the dots */
    }

    .beneficiary-line-container::after {
        content: "";
        /* The content is empty, the border creates the dots */
        flex-grow: 1;
        /* This makes the pseudo-element fill the available space */
        border-bottom: 1px dotted #000;
        /* Creates the dotted line */
        position: absolute;
        bottom: 50%;
        left: 0;
        right: 0;
        z-index: 1;
        /* Ensures the dots are behind the text */
    }

    .backup-plan {
        font-size: 0.875rem;
        color: #4b5563;
        margin-left: 10px;
        /* Indent the backup plan for better readability */
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <!-- STEPS -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>STEP 1 - About You</h4>
                            </div>
                            <div class="card-body">
                                <p>{{ @$will_user_info->legal_name }}</p>
                                <p>{{ @$will_user_info->date_of_birth }}</p>
                                <p>{{ @$will_user_info->address_line_1 }}</p>
                                <p>Is {{ @$will_user_info->martial_status }}</p>
                                @if (@$will_user_info->children == 'yes')
                                <p>The Parent of
                                    @foreach ($will_user_info->child as $child)
                                    {{ @$child->first_name }},
                                    @endforeach
                                </p>
                                @else
                                <p>No children</p>
                                @endif
                                @if (@$will_user_info->pets == 'yes')
                                <p>The owner of
                                    @foreach ($will_user_info->pet as $pet)
                                    {{ @$pet->first_name }},
                                    @endforeach
                                </p>
                                @else
                                <p>No pet</p>
                                @endif
                                <a href="{{ route('partner.will_generator.about_you', $will_user_info->id) }}">Edit</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>STEP 2 - Accounts and Property</h4>
                            </div>
                            <div class="card-body">
                                @if ($will_user_info->account_properties)
                                @foreach ($will_user_info->account_properties as $account_property)
                                <p>{{ $account_property->asset_name }} ({{ @$account_property->asset_type }})
                                </p>
                                @endforeach
                                @endif
                                <a
                                    href="{{ route('partner.will_generator.account_properties', $will_user_info->id) }}">Edit</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>STEP 3 - Your Estate</h4>
                            </div>
                            <div class="card-body">
                                @forelse($will_user_info->beneficiaries as $beneficiary)
                                <div class="beneficiary-line-container">
                                    <span class="beneficiary-name">
                                        @if (isset($beneficiary->type) && $beneficiary->type === 'charity')
                                        £ {{ $beneficiary->name }}
                                        @else
                                        {{ $beneficiary->getNameAttribute() }}
                                        @endif
                                    </span>
                                    <span class="beneficiary-share">
                                        {{ number_format($beneficiary->share_percentage, 2) }}%
                                    </span>
                                </div>
                                @if (isset($beneficiary->death_backup_plan))
                                <p class="backup-plan">Backups: {{ $beneficiary->death_backup_plan }}</p>
                                @endif
                                @empty
                                <p class="text-gray-500">No beneficiaries added yet.</p>
                                @endforelse

                                <a href="{{ route('partner.will_generator.estates',$will_user_info->id) }}">Edit</a>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>STEP 4 - Executors</h4>
                            </div>
                            <div class="card-body">
                                <p>
                                    Your Executor'@if($will_user_info->executors->count() > 1)s are
                                    @else 
                                    is
                                    @endif
                                    @foreach($will_user_info->executors as $executor)
                                    {{ $executor->first_name }} {{ $executor->last_name }}
                                @if (!$loop->last),
                                 @endif
                                    @endforeach
                                </p>
                                <a href="{{ route('partner.will_generator.executor',$will_user_info->id) }}">Edit</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Gifts (Optional)</h4>
                            </div>
                            <div class="card-body">
                                @forelse ($will_user_info->gift as $gift)
                                <span class="gift-recipient block">
                                    <p>{{ $gift->gift_name }} to
                                        @if ($gift->inherited_people->isNotEmpty())

                                        @foreach ($gift->inherited_people as $person)
                                        {{ $person->first_name }} {{ $person->last_name }}@if (!$loop->last)
                                        ,
                                        @endif
                                        @endforeach
                                        @endif
                                    </p>
                                    @empty
                                    <p class="text-gray-600">No physical gifts added yet.</p>
                                    @endforelse


                                    <a href="{{ route('partner.will_generator.gift', $will_user_info->id) }}">Edit</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Funeral wishes (Optional)</h4>
                            </div>
                            <div class="card-body">
                                @if ($will_user_info->funeral->isNotEmpty())
                                @foreach ($will_user_info->funeral as $funeral)
                                <p>I want my funeral to <strong>{{ $funeral->funeral_type }}</strong></p>
                                @if ($funeral->funeral_wish== 'yes')
                                You have added wishes about your funeral.
                                </p>
                                @endif
                                @endforeach
                                @else
                                <p>Give your family less to worry about. Add your wishes so they know what to do when
                                    the time comes.
                                </p>
                                @endif
                                <a href="{{ route('partner.will_generator.funeral', $will_user_info->id) }}">Edit</a>
                            </div>
                        </div>
                    </div>
                    <!-- ACTION BUTTONS -->
                    <div class="col-md-6">
                        <!-- {{-- Your Progress
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" id="myProgressBar"
                                    style="width: 0%;" aria-valuemin="0" aria-valuemax="100">
                                    0%
                                </div>
                            </div> --}}
                        <img
                            src="https://res.cloudinary.com/dwr27vxv7/image/upload/c_scale,f_auto,q_auto,w_600/illustrations/experts.png" />
                        
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function setProgress(percent) {
        var progressBar = document.getElementById('myProgressBar');
        progressBar.style.width = percent + '%';
        progressBar.innerText = percent + '%';
        progressBar.setAttribute('aria-valuenow', percent);
    }

    // Example usage:
    setProgress(70); // sets it to 70%
</script>

@endsection