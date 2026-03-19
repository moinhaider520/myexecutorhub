@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">Why Clients Buy It</h2>
                        <p>Clients do not buy Executor Hub because it is "nice to have". They buy it because it removes confusion, saves time, and protects their families when life is already difficult.</p>
                        <p>Use this page to understand the real reasons people say yes.</p>

                        <h2 class="mb-4">The Core Pain Points</h2>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Locating documents</h4>
                                    <p class="mb-0">Executors often spend months trying to find wills, LPAs, trusts, and key paperwork after someone dies.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Passwords and accounts</h4>
                                    <p class="mb-0">Families are often left searching for logins, subscriptions, accounts, and digital instructions with no clear starting point.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Knowing what to do next</h4>
                                    <p class="mb-0">Even when documents exist, executors are not always sure which steps to take first or which institutions to contact.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Stress on the family</h4>
                                    <p class="mb-0">Delays, uncertainty, and missing information create avoidable pressure at one of the most emotional times in life.</p>
                                </div>
                            </div>
                        </div>

                        <h2 class="mb-4">What Executor Hub Solves</h2>
                        <ol>
                            <li>It stores important information in one secure place.</li>
                            <li>It gives executors step-by-step guidance instead of guesswork.</li>
                            <li>It helps families find what they need faster.</li>
                            <li>It gives clients peace of mind that their affairs are organised properly.</li>
                        </ol>

                        <h2 class="mb-4">How To Explain It Simply</h2>
                        <p>"Executor Hub removes the confusion families often face after a death. It keeps key documents, wishes, and guidance together so executors are not left trying to piece everything together on their own."</p>

                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Show how the partner earns from it',
                            'nextUrl' => route('partner.commission_calculator.index'),
                            'nextLabel' => 'How You Earn',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
