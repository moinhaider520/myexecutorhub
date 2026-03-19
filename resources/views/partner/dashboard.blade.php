@extends('layouts.master')

@section('content')
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .why-it-matters {
            border-left: 4px solid #2b7a78;
            background: #f7fbfb;
        }

        .partner-metric-card,
        .partner-checklist-card,
        .partner-blueprint-card {
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
        }

        .partner-checklist-card ul,
        .partner-blueprint-card ol {
            margin-bottom: 0;
            padding-left: 1.2rem;
        }

        .partner-checklist-card li,
        .partner-blueprint-card li {
            margin-bottom: 0.75rem;
        }

        .partner-score {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 0;
            border-bottom: 1px solid #edf2f7;
        }

        .partner-score:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .partner-score:first-child {
            padding-top: 0;
        }

        .partner-score strong {
            color: #183153;
            font-size: 1.1rem;
        }

        .daily-income-card .calculator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .daily-income-card label {
            display: block;
            margin-bottom: 0.45rem;
            font-weight: 600;
            color: #243b53;
        }

        .daily-income-card input {
            width: 100%;
            border: 1px solid #d9e2ec;
            border-radius: 14px;
            padding: 0.8rem 0.95rem;
        }

        .daily-income-output {
            border-top: 1px solid #edf2f7;
            margin-top: 1.25rem;
            padding-top: 1rem;
        }

        .partner-progress-card,
        .leaderboard-card {
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
        }

        .progress-track {
            height: 10px;
            border-radius: 999px;
            background: #e9eef5;
            overflow: hidden;
            margin: 1rem 0 0.75rem;
        }

        .progress-track span {
            display: block;
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #2b7a78 0%, #3caea3 100%);
        }

        .leaderboard-list {
            display: grid;
            gap: 0.85rem;
        }

        .leaderboard-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1rem;
            border: 1px solid #edf2f7;
            border-radius: 16px;
            background: #fff;
        }

        .leaderboard-rank {
            width: 2rem;
            height: 2rem;
            border-radius: 999px;
            background: #183153;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 0.75rem;
        }

        .leaderboard-name {
            display: flex;
            align-items: center;
            color: #183153;
            font-weight: 600;
        }
    </style>
    <div class="page-body">
        @php
            $onboardingStepsComplete = collect($guide ?? [])->where('completed', true)->count();
            $onboardingFullyComplete = ($guide ?? []) && $onboardingStepsComplete === count($guide);
            $activationTotalSteps = \App\Support\PartnerActivationJourney::STEP_FIRST_SALE_BLUEPRINT;
            $activationProgressPercent = (int) round((min($activationCurrentStep, $activationTotalSteps) / $activationTotalSteps) * 100);
            $recruitThreeProgress = min($subpartners, 3);
            $recruitThreePercent = (int) round(($recruitThreeProgress / 3) * 100);
        @endphp
        <!-- Onboarding Video -->
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
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <h2 class="mb-3">Welcome to the Executor Hub Partner Programme</h2>
                            <p class="mb-2">Executor Hub helps families organise their affairs and guides executors step-by-step when the time comes.</p>
                            <p class="mb-0">As a partner, you can introduce this to clients, add meaningful value to your service, and build recurring income without changing your existing workflow.</p>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="text-center mb-4">Generate a Steady Income Stream With Executor Hub</h4>
            <!-- IMAGE BLOCK -->
            <div class="row justify-content-center">
                <div class="col">
                    <div class="bc-5-img bc-5-tablet img-block-hidden video-preview wow fadeInUp">
                        <!-- Play Icon -->
                        <iframe src="{{ asset('assets/frontend/partner_video.mp4') }}" style="width:100%;height:400px;"></iframe>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11"></div>
                <div class="col-md-1">
                    <iframe
                        src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                        style="border:none;height:132px;width:132px;"></iframe>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Access Offer</h4>
                        </div>
                        <div class="card-body">
                            @if($linkedCustomerAccount && $linkedCustomerAccount->provision_status === 'active')
                                <p class="mb-2">Your linked customer login is active: <strong>{{ $linkedCustomerAccount->mailbox_email }}</strong></p>
                            @else
                                <p class="mb-2">Buy your own standard lifetime customer access for £99 + VAT and receive a linked <code>@executorhub.co.uk</code> customer dashboard + webmail account.</p>
                            @endif

                            @if($customerAccessCampaign)
                                <p class="mb-3">
                                    Campaign progress:
                                    <strong>{{ $customerAccessCampaign->qualifying_referrals_count }}/{{ $customerAccessCampaign->qualifying_referrals_required }}</strong>
                                    qualifying lifetime standard/premium customers by
                                    <strong>{{ $customerAccessCampaign->qualification_deadline?->format('d M Y') }}</strong>.
                                </p>
                            @endif

                            <a href="{{ route('partner.customer_access.index') }}" class="btn btn-primary">
                                {{ $linkedCustomerAccount ? 'View Customer Access' : 'Buy Customer Access' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>What Executor Hub Is</h4>
                        </div>
                        <div class="card-body">

                            <p>Executor Hub is your personal vault and instruction manual for the people you leave behind.
                                It stores your important documents securely, helps your executors know exactly what to do,
                                and gives your loved ones clarity when they need it most.</p>
                            <p>Rather than leaving them to play detective at a difficult time, Executor Hub gives you the
                                peace of mind that everything’s organised, accessible, and explained.</p>
                            <p>It’s not just storage – it’s guidance, structure, and a helping hand for the people you care
                                about most. It can save time, money, stress – and even help avoid family fallouts.</p>
                            <p>It’s one of the most thoughtful things you can leave behind.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Partner Benefits - Why Recommend Executor Hub?</h4>
                        </div>
                        <div class="card-body">

                            <p>As a partner, Executor Hub gives you more than just a helpful tool for your clients — it
                                gives you a new recurring income stream and a reason for clients to stay connected to you
                                long after their documents are signed.</p>
                            <p>By introducing your clients to Executor Hub, you can:</p>
                            <p>💰 Earn recurring income for every customer who subscribes using your unique affiliate link.
                            </p>
                            <p>🤝 Add ongoing value to your service by helping clients organise their affairs, guide their
                                executors, and protect loved ones.</p>
                            <p>🧭 Stay at the centre of the conversation when families need guidance, updates, or future
                                estate planning.</p>
                            <p>🧩 Differentiate your service from other will writers and advisers — by offering a digital
                                solution that’s practical, personal, and secure.</p>
                            <p>💬 Build long-term trust — your recommendation helps families at one of the most difficult
                                times of their lives.</p>
                            <p>It’s simple: share your affiliate link, help your clients leave peace of mind behind, and
                                build a lasting income for your business.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card why-it-matters">
                        <div class="card-header">
                            <h4>Why This Matters</h4>
                        </div>
                        <div class="card-body">
                            <p>When someone dies, families often spend months trying to locate documents, passwords, accounts, and instructions while also dealing with grief.</p>
                            <p>Executor Hub removes that confusion by keeping key information in one secure place and giving executors clear guidance on what to do next.</p>
                            <p class="mb-0">By introducing Executor Hub to your clients, you are not just generating income. You are helping protect families from stress, delay, and uncertainty at one of the hardest times in life.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="col text-center">
                        <h5>Your Coupon Code:</h5>
                        <p class="lead" id="couponCode">{{ auth()->user()->coupon_code ?? 'No Coupon Code Available' }}</p>
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#assignModal">Copy
                            Affiliate
                            Link</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col text-center">
                        <h5>{{ $activationCurrentStep >= $activationTotalSteps ? 'Activation Complete' : 'Activation Journey' }}:</h5>
                        <p class="lead">
                            @if($activationCurrentStep >= $activationTotalSteps)
                                Review the final activation page and follow the next steps to start selling confidently.
                            @else
                                Step {{ $activationCurrentStep + 1 }} of {{ $activationTotalSteps }} is ready. Complete the guided pages in order to unlock the final activation page.
                            @endif
                        </p>
                        <a href="{{ $activationCurrentStep >= $activationTotalSteps ? route('partner.knowledgebase.quick_start_guide') : $activationNextRoute }}" class="btn btn-primary mt-3">
                            {{ $activationCurrentStep >= $activationTotalSteps ? 'Open Activation Guide' : 'Continue Activation Journey' }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="card partner-metric-card h-100">
                        <div class="card-header">
                            <h4>Partner Activity</h4>
                        </div>
                        <div class="card-body">
                            <div class="partner-score">
                                <span>Clients referred</span>
                                <strong>{{ $customers_invited }}</strong>
                            </div>
                            <div class="partner-score">
                                <span>Monthly income</span>
                                <strong>£{{ number_format(auth()->user()->commission_amount, 2) }}</strong>
                            </div>
                            <div class="partner-score">
                                <span>Partners introduced</span>
                                <strong>{{ $subpartners }}</strong>
                            </div>
                            <div class="partner-score">
                                <span>Next milestone</span>
                                <strong>
                                    @if($customers_invited >= 10)
                                        10-client milestone reached
                                    @else
                                        {{ 10 - $customers_invited }} more to reach 10 clients
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="card partner-checklist-card h-100">
                        <div class="card-header">
                            <h4>Partner Success Checklist</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">{{ $onboardingStepsComplete }}/{{ count($guide ?? []) }} onboarding actions completed</p>
                            <ul>
                                <li>{!! $onboardingFullyComplete ? '&#9745;' : '&#9744;' !!} Complete onboarding</li>
                                <li>{!! $customers_invited >= 5 ? '&#9745;' : '&#9744;' !!} Make first 5 sales</li>
                                <li>{!! $subpartners >= 1 ? '&#9745;' : '&#9744;' !!} Recruit first partner</li>
                                <li>{!! auth()->user()->commission_amount >= 1000 ? '&#9745;' : '&#9744;' !!} Reach £1,000 commission</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card partner-checklist-card h-100">
                        <div class="card-header">
                            <h4>Partner Milestones</h4>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>{!! $customers_invited > 0 ? '&#9745;' : '&#9744;' !!} First Sale</li>
                                <li>{!! $customers_invited >= 5 ? '&#9745;' : '&#9744;' !!} 5 Clients Referred</li>
                                <li>{!! $subpartners >= 1 ? '&#9745;' : '&#9744;' !!} Recruit 1 Partner</li>
                                <li>{!! $subpartners >= 3 ? '&#9745;' : '&#9744;' !!} Recruit 3 Partners</li>
                                <li>{!! $subpartners >= 10 ? '&#9745;' : '&#9744;' !!} Recruit 10 Partners</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card partner-progress-card h-100">
                        <div class="card-header">
                            <h4>Recruit 3 Partners Challenge</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Bring in three partners to unlock a stronger override income stream and build early momentum.</p>
                            <div class="progress-track">
                                <span style="width: {{ $recruitThreePercent }}%;"></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                <strong>{{ $recruitThreeProgress }}/3 partners recruited</strong>
                                <span class="text-muted">{{ max(3 - $recruitThreeProgress, 0) }} to go</span>
                            </div>
                            <ul class="mb-3">
                                <li>{!! $subpartners >= 1 ? '&#9745;' : '&#9744;' !!} Recruit your first partner</li>
                                <li>{!! $subpartners >= 2 ? '&#9745;' : '&#9744;' !!} Follow up with your second introduction</li>
                                <li>{!! $subpartners >= 3 ? '&#9745;' : '&#9744;' !!} Reach the 3-partner challenge goal</li>
                            </ul>
                            <a href="{{ route('partner.knowledgebase.recruit_partners') }}" class="btn btn-primary">Open Recruit Partners Plan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card leaderboard-card h-100">
                        <div class="card-header">
                            <h4>Top Partners This Month</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">A simple leaderboard based on referred customers recorded this month.</p>
                            <div class="leaderboard-list">
                                @forelse($leaderboardPartners as $index => $leaderboardPartner)
                                    <div class="leaderboard-item">
                                        <div class="leaderboard-name">
                                            <span class="leaderboard-rank">{{ $index + 1 }}</span>
                                            <div>
                                                <div>{{ $leaderboardPartner->name }}{{ $leaderboardPartner->id === auth()->id() ? ' (You)' : '' }}</div>
                                                <small class="text-muted">{{ $leaderboardPartner->company_name ?: 'Executor Hub Partner' }}</small>
                                            </div>
                                        </div>
                                        <strong>{{ $leaderboardPartner->monthly_referrals_count }} referrals</strong>
                                    </div>
                                @empty
                                    <p class="mb-0 text-muted">No partner referrals have been recorded this month yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card partner-blueprint-card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div>
                                <h4 class="mb-1">First Sale Blueprint</h4>
                                <p class="mb-0">A simple plan you can follow today without changing your workflow.</p>
                            </div>
                            <a href="{{ route('partner.knowledgebase.first_sale_blueprint') }}" class="btn btn-primary">Open Blueprint</a>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Partners who complete these steps usually create momentum fast because every action is tied to a clear outreach task.</p>
                            <ol>
                                <li>Copy your referral link.</li>
                                <li>Send the WhatsApp message to 5 clients.</li>
                                <li>Send the email template to 10 clients.</li>
                                <li>Mention Executor Hub at your next meeting.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card daily-income-card">
                        <div class="card-header">
                            <h4>Daily Income Calculator</h4>
                            <p class="mb-0">Use a simple estimate to see what today&apos;s sales activity could look like. These figures are projections, not live sales totals.</p>
                        </div>
                        <div class="card-body">
                            <div class="calculator-grid">
                                <div>
                                    <label for="dailySaleValue">Average Sale Value</label>
                                    <input type="number" id="dailySaleValue" value="695" min="0" step="0.01">
                                </div>
                                <div>
                                    <label for="dailyCommissionRate">Commission %</label>
                                    <input type="number" id="dailyCommissionRate" value="30" min="0" max="100" step="0.01">
                                </div>
                                <div>
                                    <label for="dailyPartnerOverride">Partner Override %</label>
                                    <input type="number" id="dailyPartnerOverride" value="10" min="0" max="100" step="0.01">
                                </div>
                            </div>
                            <div class="daily-income-output">
                                <div class="partner-score">
                                    <span>Estimated income if you sell 1 Executor Hub today</span>
                                    <strong id="dailyIncomeOne">£0.00</strong>
                                </div>
                                <div class="partner-score">
                                    <span>Estimated income if you sell 5 this week</span>
                                    <strong id="dailyIncomeFive">£0.00</strong>
                                </div>
                                <div class="partner-score">
                                    <span>Estimated override income from 3 partners</span>
                                    <strong id="dailyIncomePartners">£0.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <h2>{{ $subpartners }}</h2>
                                            <p class="mb-0 text-truncate">Total Partners</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
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
                                            <h2>{{ $customers_invited }}</h2>
                                            <p class="mb-0 text-truncate">Total Customers</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
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
                                            <h2>{{ $subscribed_customers_invited }}</h2>
                                            <p class="mb-0 text-truncate">Active customers</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
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
                                            <h2>£{{ number_format(auth()->user()->commission_amount, 2) }}</h2>
                                            <p class="mb-0 text-truncate">Revenue </p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Customers Referred with Your Coupon Code (Directly)</h5>
                                <div class="card-body">
                                    @if($referredUsers->isEmpty())
                                        <p>No customer has used your coupon code yet.</p>
                                    @else
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                    aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Package</th>
                                                            <th>Signup Date</th>
                                                            <th>Reffered By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($referredUsers as $index => $referral)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $referral->user->name ?? '-' }}</td>
                                                                <td>{{ $referral->user->email ?? '-' }}</td>
                                                                <td>{{ $referral->user->subscribed_package ?? '-' }} Package</td>
                                                                <td>{{ $referral->created_at->format('d M Y') }}</td>
                                                                <td>{{ $referral->user->reffered_by ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Partners List</h4>
                                    <span>List of all the Registered Partners through your reference.</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive theme-scrollbar">
                                        <div id="basic-2_wrapper" class="dataTables_wrapper no-footer">
                                            <table class="display dataTable no-footer" id="basic-2" role="grid"
                                                aria-describedby="basic-2_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>Sr</th>
                                                        <th>Partner Name</th>
                                                        <th>Email</th>
                                                        <th>Address</th>
                                                        <th>Contact Number</th>
                                                        <th>Access Type</th> <!-- New Column -->
                                                        <th>Profession</th>
                                                        <th>Heard From?</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($partners as $partner)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $partner->name ?? 'N/A' }}</td>
                                                            <td>{{ $partner->email ?? 'N/A' }}</td>
                                                            <td>{{ $partner->address ?? 'N/A' }}</td>
                                                            <td>{{ $partner->phone_number ?? 'N/A' }}</td>
                                                            <td>{{ $partner->access_type ?? 'N/A' }}</td>
                                                            <td>{{ $partner->profession ?? 'N/A' }}</td>
                                                            <td>{{ $partner->hear_about_us ?? 'N/A' }}</td>
                                                            <td>
                                                                <a href="{{ route('partner.partners.view_refferals', $partner->id) }}"
                                                                    class="btn btn-primary btn-sm">View Refferals</a>

                                                            </td>
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
                        <div class="step active" data-audio="{{ asset('assets/partner_guide_audios/audio1.mp3') }}">
                            <h4>STEP 1 — Welcome 🎉</h4>
                            <p>Welcome to Executor Hub for Partners.</p>
                            <p>You’re joining a platform that helps families stay organised and prepared, while giving you a
                                powerful opportunity to build recurring and passive income.</p>
                            <p>This onboarding takes just a few minutes.</p>
                            <p>By the end, you will be able to:</p>
                            <p>1. Sign your first customers</p>
                            <p>2. Recruit partners</p>
                            <p>3. Grow ongoing revenue</p>
                            <p>4. Use the full toolset to maximise your success</p>
                            <p>Let’s begin.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio2.mp3') }}">
                            <h4>STEP 2 — Your Dashboard Overview</h4>
                            <p>Your dashboard is your main control centre.</p>
                            <p>Here, you can:</p>
                            <ol>
                                <li>See all your customers (active & inactive)</li>
                                <li>Track your revenue this month</li>
                                <li>View partners you’ve referred</li>
                                <li>Monitor customers your partners sign up</li>
                                <li>Access scripts, templates, guides, and tools</li>
                                <li>Review your growth at a glance</li>
                            </ol>
                            <p>TIP: Check your dashboard regularly — it shows you exactly where your opportunities are.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio3.mp3') }}">
                            <h4>STEP 3 — Download the Partner App 📱 (Highly Recommended)</h4>
                            <p>To make everything faster and easier, we strongly recommend downloading the Executor Hub
                                Partner App.</p>
                            <p>The app lets you:</p>
                            <ol>
                                <li>Copy your partner link instantly</li>
                                <li>Invite customers in seconds</li>
                                <li>Track your earnings.</li>
                                <li>Manage customers and partners</li>
                                <li>Receive important updates</li>
                                <li>Work from your phone at any time</li>
                            </ol>
                            <p>You’ll use the app daily.</p>
                            <a href="https://apps.apple.com/us/app/executor-hub-partners/id6753773146"
                                target="_blank">Download Partner App</a>
                            <br />
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio4.mp3') }}">
                            <h4>STEP 4 — Your Partner Link & How Earnings Are Tracked</h4>
                            <p>Your partner link and coupon code (shown clearly on your dashboard) are how Executor Hub
                                tracks every referral you make — both customers and partners.</p>
                            <p>Anyone who signs up using your link or your coupon code is instantly assigned to you.</p>
                            <p><b>Do This Now</b></p>
                            <ol>
                                <li>✔ Click Copy Affiliate Link</li>
                                <li>✔ No need to save it — your link and code are always visible and can be copied anytime
                                </li>
                            </ol>
                            <p>You’ll use this link in Step 6.</p>
                            <p>Your link and coupon code are the foundation of all your earnings.</p>
                            <p><b>How to Add New Partners (Two Options)</b></p>
                            <p>There are two ways to recruit partners — both track correctly to you.</p>
                            <p><b>OPTION 1 — Add a Partner Through Your Dashboard</b></p>
                            <p>1.Click Partners</p>
                            <p>2.Click Create Partner</p>
                            <p>3.Enter their name, email, and role</p>
                            <p>4.Send the invite</p>
                            <p>They will receive the same welcome emails and onboarding steps you received.</p>
                            <p><b>OPTION 2 — They Sign Up Using Your Coupon Code</b></p>
                            <p>Partners can join directly from the public partner sign-up page.</p>
                            <p>They must enter your coupon code so the system assigns them to you.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio5.mp3') }}">
                            <h4>STEP 5 — Add Your Bank Details (So We Can Pay You)</h4>
                            <p>Before you can receive any commissions, add your bank details:</p>
                            <ol>
                                <li>Click Withdrawals</li>
                                <li>Enter your bank information securely</li>
                                <li>Save</li>
                            </ol>
                            <p>This only needs to be done once.</p>
                            <p>Commission payments require this step.</p>
                            <a href="{{ route('partner.bank_account.index') }}">Add My Bank Details</a>
                            <br />
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio6.mp3') }}">
                            <h4>STEP 6 — Sign Your First Customers (Talk-First Method)</h4>
                            <p><b>The BEST way to sign customers is to TALK to them.</b></p>
                            <p>A phone call, Zoom call or face-to-face meeting converts far better than messages alone.</p>
                            <p>Executor Hub works best when it’s explained personally.</p>
                            <p><b>How to Introduce Executor Hub</b></p>
                            <p>Keep it simple:</p>
                            <ol>
                                <li>Executor Hub stores all their important documents</li>
                                <li>It guides their executors step-by-step</li>
                                <li>Setup takes only 10–15 minutes</li>
                                <li>It gives their family true peace of mind</li>
                            </ol>
                            <p>For proven call scripts, openers, meetings frameworks and objection handling:</p>
                            <p><b>After the Conversation — Send the Link</b></p>
                            <p>Follow up using:</p>
                            <p>Email</p>
                            <p>Templates are in the Knowledgebase.</p>
                            <p>WhatsApp (from your phone)</p>
                            <p>WhatsApp messages must be sent from mobile.</p>
                            <p>Templates are in the Knowledgebase.</p>
                            <p>Direct Link Sharing</p>
                            <p>Copy your link and send via SMS, Messenger, CRM, or social media.</p>
                            <p><b>FOLLOW-UP IS CRUCIAL</b></p>
                            <p>Most customers sign up after receiving the follow-up message.</p>
                            <p>Even if they show interest:</p>
                            <p>👉 Always follow up</p>
                            <p>👉 Always send the link</p>
                            <p>👉 Follow up again if needed</p>
                            <p>Following up often turns:</p>
                            <p>❌ “I’ll do it later” into ✅ “I’ve signed up”</p>
                            <p>Consistent follow-up dramatically boosts conversions.</p>
                            <p><b>Goal for Today</b></p>
                            <p>⭐ Speak to 5–10 customers</p>
                            <p>⭐ Follow up after the conversation</p>
                            <p>⭐ Mention the partner opportunity to at least one person</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio7.mp3') }}">
                            <h4>STEP 7 — Manage, Follow Up & Support Your Customers</h4>
                            <p>Your Customers page shows:</p>
                            <p>1. Customer name</p>
                            <p>2. Package selected</p>
                            <p>3. Date they signed up</p>
                            <p>4. When their free trial ends</p>
                            <p>5. This lets you see where each customer is in their journey.</p>

                            <p><b>Automated Support Built In</b></p>
                            <p>1. Executor Hub automatically sends:</p>
                            <p>2. Setup reminders</p>
                            <p>3. Benefit reminders</p>
                            <p>4. Trial-ending reminders</p>
                            <p>5. Subscription prompts</p>
                            <p>All designed to give you the best possible chance of conversion.</p>
                            <p>You don’t need to do anything — it’s all done for you.</p>

                            <p><b>Optional Personal Follow-Up</b></p>
                            <p>If you know the customer well or feel it’s appropriate, you may want to reach out personally
                                before the free trial ends.</p>
                            <p>If you choose to follow up:</p>
                            <p>👉 Use the scripts in the Knowledgebase</p>
                            <p>(Phone, WhatsApp, SMS, re-engagement emails)</p>

                            <p><b>If You Don’t Want to Follow Up</b></p>
                            <p>No problem — Executor Hub continues automatically sending reminders to maximise conversions.
                            </p>
                            <p><b>Goal for This Week</b></p>
                            <p>⭐ Check your Customers page</p>
                            <p>⭐ Reach out if appropriate</p>
                            <p>⭐ Let the automated system do the rest</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio8.mp3') }}">
                            <h4>STEP 8 — Explore the Knowledgebase (Your Shortcut to Success)</h4>
                            <p>Inside the Knowledgebase, you’ll find:</p>
                            <ol>
                                <li>Quick Start Guide</li>
                                <li>Learning Videos</li>
                                <li>Phone Scripts</li>
                                <li>WhatsApp & SMS Templates</li>
                                <li>Email Templates</li>
                                <li>Social Media Posts</li>
                                <li>FAQs</li>
                                <li>Best Practices</li>
                                <li>Customer Re-Engagement Templates</li>
                                <li>Logos & Marketing Assets</li>
                            </ol>
                            <p>These tools help you:</p>
                            <ol>
                                <li>Explain Executor Hub easily</li>
                                <li>Sign customers consistently</li>
                                <li>Recruit partners</li>
                                <li>Handle objections</li>
                                <li>Build confidence</li>
                                <li>Grow your income faster</li>
                            </ol>
                            <p>We strongly recommend exploring it today.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio9.mp3') }}">
                            <h4>STEP 9 — You’re Ready to Go 🚀</h4>
                            <p>You are now fully set up:</p>
                            <p>✔ Bank details added</p>
                            <p>✔ Partner link ready</p>
                            <p>✔ App downloaded</p>
                            <p>✔ First conversations done</p>
                            <p>✔ Follow-ups sent</p>
                            <p>✔ Dashboard understood</p>
                            <p>✔ Knowledgebase explored</p>
                            <p>Your next steps:</p>
                            <p>Today</p>
                            <p>⭐ Speak to 5–10 customers</p>
                            <p>⭐ Send follow-up messages</p>
                            <p>⭐ Use the app for quick link sharing</p>
                            <p>⭐ Mention the partner opportunity</p>
                            <p>This Week</p>
                            <p>⭐ Sign 2–3 customers</p>
                            <p>⭐ Recruit your first partner</p>
                            <p>⭐ Check upcoming trial endings</p>
                            <p>⭐ Stay active in the app</p>
                            <p>Welcome to Executor Hub — let’s build something powerful together.</p>
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

        <!-- AFFILIATE MODAL -->
        <!-- Modal -->
        <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModalLabel">Assign To Staff Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="staffMemberName" class="form-control"
                            placeholder="Enter staff member name (optional)">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="generateAndCopyLink()">Copy Affiliate
                            Link</button>
                        <button type="button" class="btn btn-secondary" onclick="generateAndCopyLinkFreeTrial()">Copy
                            Affiliate
                            Link (Free Trial)</button>
                    </div>
                </div>
            </div>
        </div>

        <audio id="stepAudio" autoplay hidden></audio>
        <!-- Container-fluid Ends-->
    </div>

    <!-- Scripts for Document Reminders -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function updateDailyIncomeCalculator() {
            const saleValue = parseFloat(document.getElementById('dailySaleValue')?.value) || 0;
            const commissionRate = (parseFloat(document.getElementById('dailyCommissionRate')?.value) || 0) / 100;
            const partnerOverride = (parseFloat(document.getElementById('dailyPartnerOverride')?.value) || 0) / 100;

            const oneSale = saleValue * commissionRate;
            const fiveSales = oneSale * 5;
            const recruitThreePartners = saleValue * 5 * 3 * partnerOverride;

            const formatCurrency = (value) => `£${value.toFixed(2)}`;

            document.getElementById('dailyIncomeOne').textContent = formatCurrency(oneSale);
            document.getElementById('dailyIncomeFive').textContent = formatCurrency(fiveSales);
            document.getElementById('dailyIncomePartners').textContent = formatCurrency(recruitThreePartners);
        }

        ['dailySaleValue', 'dailyCommissionRate', 'dailyPartnerOverride'].forEach((id) => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', updateDailyIncomeCalculator);
            }
        });

        updateDailyIncomeCalculator();

        $(document).ready(function () {
            // Enable table sorting
            $('#document-reminders-table').DataTable({
                "ordering": true,
                "paging": true,
                "searching": true
            });

            $('#document-locations-table').DataTable({
                "ordering": true,
                "paging": true,
                "searching": true
            });

            // Handle reminder frequency changes
            $('.reminder-frequency').on('change', function () {
                const documentType = $(this).data('document-type');
                const frequency = $(this).val();

                $.ajax({
                    url: "{{ route('partner.dashboard.update-reminder') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        document_type: documentType,
                        frequency: frequency
                    },
                    success: function (response) {
                        if (response.success) {
                            // Show success notification
                            Toastify({
                                text: "Reminder settings updated successfully!",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4caf50"
                            }).showToast();
                        }
                    },
                    error: function (xhr) {
                        // Show error notification
                        Toastify({
                            text: "Error updating reminder settings",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#f44336"
                        }).showToast();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Handle edit button click to populate modal
            $('.edit-location-button').on('click', function () {
                var id = $(this).data('id');
                var location = $(this).data('location');

                $('#editLocationId').val(id);
                $('#editLocation').val(location);
            });

            // Handle update location
            $('#updateLocation').on('click', function () {
                var id = $('#editLocationId').val();

                $.ajax({
                    type: 'POST',
                    url: '/partner/dashboard/update-location/' + id,
                    data: $('#editLocationForm').serialize(),
                    success: function (response) {
                        Toastify({
                            text: "Location updated successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4caf50"
                        }).showToast();

                        // Optional: reload after short delay to let user see toast
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function (response) {
                        var errors = response.responseJSON.errors;
                        if (errors && errors.location) {
                            $('#edit_location_error').text(errors.location[0]);
                        } else {
                            Toastify({
                                text: "Failed to update location",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#f44336"
                            }).showToast();
                        }
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

    <script>
        function generateAndCopyLink() {
            var couponCode = document.getElementById('couponCode').innerText.trim();
            var staffName = document.getElementById('staffMemberName').value.trim();

            if (couponCode && couponCode !== 'No Coupon Code Available') {
                var url = "{{ url('/partner_registration') }}" + "?coupon_code=" + encodeURIComponent(couponCode);
                if (staffName) {
                    url += "&assigned_to=" + encodeURIComponent(staffName);
                }

                navigator.clipboard.writeText(url).then(function () {
                    alert('Affiliate link copied to clipboard!');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('assignModal'));
                    modal.hide(); // Close modal after copying
                }, function (err) {
                    alert('Failed to copy: ' + err);
                });
            } else {
                alert('No valid coupon code available.');
            }
        }

        function generateAndCopyLinkFreeTrial() {
            var couponCode = document.getElementById('couponCode').innerText.trim();
            var staffName = document.getElementById('staffMemberName').value.trim();

            if (couponCode && couponCode !== 'No Coupon Code Available') {
                var url = "{{ url('/register') }}" + "?coupon_code=" + encodeURIComponent(couponCode);
                navigator.clipboard.writeText(url).then(function () {
                    alert('Affiliate link copied to clipboard!');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('assignModal'));
                    modal.hide(); // Close modal after copying
                }, function (err) {
                    alert('Failed to copy: ' + err);
                });
            } else {
                alert('No valid coupon code available.');
            }
        }
    </script>

    <script>
        const video = document.getElementById('referralsVideo');

        video.addEventListener('click', () => {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });
    </script>

    <script>
        const video = document.getElementById('customersVideo');

        video.addEventListener('click', () => {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });
    </script>

    <script>
        const video = document.getElementById('earningVideo');

        video.addEventListener('click', () => {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });
    </script>
    

@endsection
