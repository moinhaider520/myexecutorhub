@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">Client Reactivation</h2>
                        <p>Many of your clients already have wills, trusts, or LPAs in place — sometimes completed months or
                            years ago. Executor Hub is the perfect way to re-engage these clients and add extra value,
                            because it’s a service that likely wasn’t available when their documents were done.</p>
                        <p>Use the templates below (email + SMS/WhatsApp) to introduce Executor Hub as a simple, modern
                            upgrade. Position it as part of your ongoing support, not a sales pitch.</p>
                        <p>👉 Tip: Always include your unique referral link so the subscription is tracked to you.</p>
                        <p>👉 Tip: Follow up politely within a few days — by phone, text, or email reminder.</p>

                        <!-- TEMPLATE 1 -->
                        <h2 class="mb-4">📧 Reactivation Email Template</h2>
                        <p>Subject line options:</p>
                        <p>• A simple upgrade to your planning</p>
                        <p>• New: Make your executors’ job much easier</p>
                        <p>• The next step in protecting your family</p>
                        <p>Hi [First Name], </p>
                        <p>When we completed your will and estate planning with you, we made sure your documents were
                            legally sound and your wishes clear. </p>
                        <p>Since then, a new service has launched that I now recommend to all clients — **Executor Hub**.
                        </p>
                        <p>Executor Hub is a secure digital vault where you can: </p>
                        <p>✔ Store your will, trusts, LPAs, and other important documents in one place </p>
                        <p>✔ Record passwords, account details, and personal wishes securely </p>
                        <p>✔ Leave messages for loved ones </p>
                        <p>✔ Give your executors step-by-step guidance when the time comes </p>
                        <p>It’s designed to save families months of stress and uncertainty, and it only takes around 10
                            minutes to set your account up. </p>
                        <p>👉 You can try it completely free for 14 days here: [Insert referral link] </p>
                        <p>I’d strongly encourage you to take a look. This is a small step now that makes a big difference
                            for your family later. </p>
                        <p>Warm regards, </p>
                        <p>[Partner/Adviser Name]</p>

                        <!-- TEMPLATE 2 -->
                        <h2 class="mb-4">SMS / WhatsApp Reactivation Template
                        </h2>
                        <p>Short, casual messages you can send to older clients:</p>
                        <p>Option 1 – Trusted Adviser</p>
                        <p>Hi [First Name], I wanted to let you know about Executor Hub — a new service I now recommend to
                            all clients. It’s a secure vault for wills, LPAs, and wishes that guides executors step by step.
                            Free trial link: [referral link] </p>
                        <p>Option 2 – Problem/Solution</p>
                        <p>Hi [First Name], many executors spend months searching for paperwork and passwords. Executor Hub solves that by storing everything securely in one place. It only takes 10 mins to set up. Free trial: [referral link]  </p>
                        <p>Option 3 – Upgrade Angle</p>
                        <p>Hi [First Name], when we completed your will/trust, services like Executor Hub didn’t exist. It’s a secure app that stores your wishes and guides executors step by step. Try it free here: [referral link]  </p>
                        <p>Adviser Best Practice Notes</p>
                        <p>•	Send the email first, then follow up with a short SMS/WhatsApp within 3–5 days.</p>
                        <p>•	Frame it as a helpful update: “This wasn’t available when we first did your documents, but it’s now the new standard I recommend to all clients.”</p>
                        <p>•	Ask permission to follow up:</p>
                        <p>“Would it be okay if I check in next week to see if you’ve had a chance to set it up?”</p>
                        <p>•	Even if only a small % sign up, this adds up quickly because it’s recurring income and strengthens your relationship with existing clients.</p>

                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Download branded assets',
                            'nextUrl' => route('partner.knowledgebase.entry_example'),
                            'nextLabel' => 'Logos',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Document Reminders -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@endsection
