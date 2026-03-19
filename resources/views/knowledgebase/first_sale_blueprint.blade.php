@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">First Sale Blueprint</h2>
                        <p>Most partner programmes lose momentum because partners are told to go and sell without being shown exactly what to do today. This page keeps it simple and practical.</p>
                        <p>Follow these steps in order. If you complete them today, you give yourself the best chance of making your first sale quickly.</p>

                        <h2 class="mb-4">Make Your First Sale Today</h2>
                        <ol>
                            <li>Copy your referral link from the dashboard.</li>
                            <li>Send the WhatsApp message to 5 clients who already know and trust you.</li>
                            <li>Send the email template to 10 clients who are a good fit for Executor Hub.</li>
                            <li>Mention Executor Hub in your next client meeting or review call.</li>
                        </ol>

                        <h2 class="mb-4">Use The Right Script For The Right Client</h2>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">New client</h4>
                                    <p class="mb-0">Use the authority script and position Executor Hub as part of your normal best-practice process.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Older client</h4>
                                    <p class="mb-0">Use the reactivation message and frame it as a smart upgrade that was not available before.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Busy client</h4>
                                    <p class="mb-0">Use a short WhatsApp message first, then follow up with the link while it is fresh in their mind.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h4 class="mb-3">Meeting introduction</h4>
                                    <p class="mb-0">Use a call opener that explains the family benefit quickly, then offer to send the free trial link.</p>
                                </div>
                            </div>
                        </div>

                        <h2 class="mb-4">Today&apos;s Quick Links</h2>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('partner.dashboard') }}" class="btn btn-primary">Copy Referral Link</a>
                            <a href="{{ route('partner.knowledgebase.whatsapp_texts') }}" class="btn btn-outline-primary">Open WhatsApp Messages</a>
                            <a href="{{ route('partner.knowledgebase.email_templates') }}" class="btn btn-outline-primary">Open Email Templates</a>
                            <a href="{{ route('partner.knowledgebase.short_call_openers') }}" class="btn btn-outline-primary">Open Call Openers</a>
                        </div>

                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Close the loop with the onboarding summary',
                            'nextUrl' => route('partner.knowledgebase.quick_start_guide'),
                            'nextLabel' => 'Activation Complete',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@endsection
