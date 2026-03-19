@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">WhatsApp Messages</h2>
                        <p>Some clients respond faster to a quick WhatsApp or text message than to an email or phone call.
                            We’ve prepared short, ready-to-send messages you can use to introduce Executor Hub in a
                            friendly, conversational way.</p>
                        <p>Tips for best results:</p>
                        <ol>
                            <li>Keep it casual and personal — it should feel like a quick note from you, not a marketing
                                blast.</li>
                            <li>Always add your unique referral link.</li>
                            <li>Use emojis sparingly if it fits your style (💡, ❤️, ✅).</li>
                            <li>Follow up with a short call or email if they don’t reply.</li>
                        </ol>

                        <!-- TEMPLATE 1 -->
                        <h2 class="mb-4">Message #1: Trusted Adviser</h2>
                        <p>Hi [First Name], I recommend all my clients use Executor Hub — it’s a secure place to keep your will, LPAs, and wishes together, and it guides your executors step by step. Here’s your free trial link: [referral link]</p>

                        <!-- TEMPLATE 2 -->
                        <h2 class="mb-4">Message#2: Problem/Solution </h2>
                        <p>Hi [First Name], most executors spend months hunting for documents and passwords. Executor Hub solves this by keeping everything secure in one place. It only takes 10 mins to set up your account — try it free here: [referral link]</p>

                        <!-- TEMPLATE 3 -->
                        <h2 class="mb-4">Message#3: Emotional Hook</h2>
                        <p>Hi [First Name], one of the most thoughtful things you can do for your family is leave clarity, not confusion. Executor Hub helps with that. Quick and secure to set up — here’s the free trial link: [referral link]</p>

                        <!-- TEMPLATE 4 -->
                        <h2 class="mb-4">Message#4: Social Proof </h2>
                        <p>Hi [First Name], more and more families are now using Executor Hub as part of their estate planning. It keeps everything in one secure place and makes things easier for executors. You can try it free here: [referral link]</p>

                        <!-- TEMPLATE 5 -->
                        <h2 class="mb-4">Message#5: Urgency & Action</h2>
                        <p>Hi [First Name], Executor Hub takes just 10 mins to set up your account but can save your family months of stress. Don’t put this off — here’s your free trial link: [referral link]</p>
                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Turn messages into email follow-up',
                            'nextUrl' => route('partner.knowledgebase.email_templates'),
                            'nextLabel' => 'Email Templates',
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
