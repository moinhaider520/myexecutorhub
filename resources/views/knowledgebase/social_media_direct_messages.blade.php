@extends('layouts.master')

@section('content')

    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-2">
                        <h2 class="mb-4">Intro</h2>
                        <p>Reaching clients or prospects through direct messages (DMs) on LinkedIn, Facebook, or Instagram can be highly effective — especially when it feels personal, helpful, and non-salesy.</p>
                        <p>We’ve provided 5 short DM templates you can copy, personalise, and send. Each uses a different approach — trusted recommendation, solving a problem, emotional angle, social proof, and urgency.</p>
                        <p>Tips for best results:</p>
                        <ol>
                            <li>Personalise the first line (e.g. reference a recent chat, their family, or something you’ve worked on together).</li>
                            <li>Always add your unique referral link.</li>
                            <li>Keep the tone natural — like you’re sending a quick tip, not an advert.</li>
                            <li>If they don’t reply, follow up once a few days later with a gentle nudge.</li>
                        </ol>

                        <!-- TEMPLATE 1 -->
                        <h2 class="mb-4">Direct Message #1: Trusted Adviser</h2>
                        <p>Hi [First Name], as part of the planning work we’ve done together, I wanted to share something I recommend for all my clients — Executor Hub. It’s a secure digital vault for wills, LPAs, and wishes, and it gives executors step-by-step guidance. Here’s your free trial link: [referral link]</p>

                        <!-- TEMPLATE 2 -->
                        <h2 class="mb-4">Direct Message#2: Problem/Solution </h2>
                        <p>Hi [First Name], many executors end up spending months hunting for documents, accounts, and passwords. Executor Hub solves this by keeping everything in one secure place and guiding executors step by step. It only takes 10 mins to set up your account. Free trial link: [referral link]</p>

                        <!-- TEMPLATE 3 -->
                        <h2 class="mb-4">Direct Message#3: Emotional Hook</h2>
                        <p>Hi [First Name], one of the most thoughtful things you can do for your family is make sure they have clarity when the time comes. Executor Hub lets you store your will, LPAs, and wishes safely, and even leave messages for loved ones. Free trial here: [referral link]</p>

                        <!-- TEMPLATE 4 -->
                        <h2 class="mb-4">Direct Message#4: Social Proof </h2>
                        <p>Hi [First Name], more and more families across the UK are now using Executor Hub as part of their planning. It’s becoming the new standard for protecting loved ones — everything stored securely, with clear guidance for executors. Here’s your free trial link: [referral link]</p>

                        <!-- TEMPLATE 5 -->
                        <h2 class="mb-4">Direct Message#5: Urgency & Action</h2>
                        <p>Hi [First Name], Executor Hub takes less than 15 minutes to set up, but it can save your family months of stress later. Since there’s a free 14-day trial, I’d suggest setting it up now while it’s fresh in your mind. Here’s the link: [referral link]</p>
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