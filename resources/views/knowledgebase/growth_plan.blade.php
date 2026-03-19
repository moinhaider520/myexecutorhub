@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">Partner Growth Plan</h2>
                        <p>This page shows what early partner success can look like when activity stays consistent. It is designed as a practical roadmap, not a promise.</p>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Month 1</h4>
                                    <ul>
                                        <li>Learn the platform</li>
                                        <li>Complete onboarding</li>
                                        <li>Introduce Executor Hub to 10 clients</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Month 2</h4>
                                    <ul>
                                        <li>Introduce it to all new clients</li>
                                        <li>Reactivate older clients</li>
                                        <li>Refine your messaging with scripts and follow-ups</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Month 3</h4>
                                    <ul>
                                        <li>Recruit 2 adviser partners</li>
                                        <li>Track which outreach channels convert best</li>
                                        <li>Build weekly momentum from a repeatable process</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <h2 class="mb-4">What Success Looks Like</h2>
                        <p>By the end of the first 90 days, the goal is not perfection. The goal is having a repeatable process: clear messaging, consistent outreach, visible activity, and early partner growth.</p>

                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Start recruiting partners',
                            'nextUrl' => route('partner.knowledgebase.recruit_partners'),
                            'nextLabel' => 'Multiply Your Income',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
