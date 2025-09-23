@extends('layouts.master')

@section('content')

    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-2">
                        <h2 class="mb-4">Intro</h2>
                        <p>We’ve created a set of 5 ready-to-use client emails that you can copy, personalise, and send
                            directly to your clients. Each email uses a different approach — from trusted recommendation to
                            urgency — so you can reach clients with the message that resonates best with them.</p>
                        <p>Tips for best results:</p>
                        <ol>
                            <li>Always insert your unique referral link in the call-to-action (CTA).</li>
                            <li>Use the subject line variations we’ve provided and test which ones your clients open most.
                            </li>
                            <li>Keep it personal — add your client’s first name and sign off with your usual adviser
                                signature.</li>
                            <li>Send these emails either as a short sequence (weekly over 3–4 weeks) or as one-offs when
                                you’re following up with clients.</li>
                            <li>Don’t be afraid to re-send in a different style if a client doesn’t respond to the first
                                email — each one is written to persuade in a different way.</li>
                        </ol>
                        <p>These emails are designed to make it simple for you to introduce Executor Hub and maximise the
                            chance of your clients signing up and subscribing.</p>
                        <!-- TEMPLATE 1 -->
                        <h2 class="mb-4">Template#1: Trusted Recommendation (Authority & Credibility)</h2>
                        <p>Best for initial introduction – frames it as part of professional advice.</p>
                        <p>Subject options:</p>
                        <ol>
                            <li>A service I recommend for all my clients</li>
                            <li>A simple step to protect your family</li>
                        </ol>
                        <p>Hi [First Name], </p>
                        <p>As part of the planning work we’ve done together, I always recommend one additional step that
                            makes life much easier for families: **Executor Hub**.</p>
                        <p>Executor Hub is a secure digital vault where you can keep your will, LPAs, trusts, and important
                            information safe. It also gives your chosen executors step-by-step guidance when the time comes.
                        </p>
                        <p>Why I recommend it: </p>
                        <p>✔ Takes just 10–15 minutes to set up </p>
                        <p>✔ Keeps all your key documents and instructions in one place </p>
                        <p>✔ Brings peace of mind to your family when they’ll need it most </p>
                        <p>👉 [Activate your free trial here] (Insert referral link) </p>
                        <p>Warm regards, </p>
                        <p>[Partner/Adviser Name]</p>

                        <!-- TEMPLATE 2 -->
                        <h2 class="mb-4">Template#2: Pain Point & Solution (Problem/Solution)</h2>
                        <p>Best for clients who are more analytical or risk-averse.</p>
                        <p>Subject options:</p>
                        <ol>
                            <li>Don’t leave your family searching for answers</li>
                            <li>Executors spend months untangling paperwork – unless…</li>
                        </ol>
                        <p>Dear [First Name], </p>
                        <p>When someone passes away, their executors often spend months trying to locate documents,
                            accounts, and passwords. It’s stressful, time-consuming, and sometimes leads to important things
                            being missed. </p>
                        <p>Executor Hub solves this. </p>
                        <p>It’s a digital vault where everything is stored securely in one place – your will, LPAs, trusts,
                            bank details, wishes, even personal messages. Executors then receive clear, step-by-step
                            guidance. </p>
                        <p>✨ No lost paperwork </p>
                        <p>✨ No searching for passwords </p>
                        <p>✨ No unanswered questions for your family </p>
                        <p>It takes just 10–15 minutes to set up, and you can try it **free for 14 days**. </p>
                        <p>👉 [Get started today] (Insert referral link)</p>

                        <!-- TEMPLATE 3 -->
                        <h2 class="mb-4">Template#3: Emotional Story (Empathy & Family Focus)</h2>
                        <p>Best for clients motivated by protecting loved ones.</p>
                        <p>Subject options:</p>
                        <ol>
                            <li>The most thoughtful gift you can leave behind</li>
                            <li>Give your family peace of mind, not paperwork</li>
                        </ol>
                        <p>Hi [First Name], </p>
                        <p>I often see families struggling at the hardest possible time – not because of money, but because
                            they don’t know where to find important documents or what their loved one’s wishes were. </p>
                        <p>Executor Hub changes that. </p>
                        <p>It’s a simple, secure way to record your wishes, store your will, LPAs, and trusts, and even
                            leave personal messages for your family. When the time comes, your executors have everything
                            they need, with step-by-step guidance. </p>
                        <p>It takes just minutes to set up, and subscriptions start at £5.99/month after a free 14-day
                            trial. </p>
                        <p>👉 [Set up your account today] (Insert referral link) </p>
                        <p>This is one of the kindest, most thoughtful steps you can take for your loved ones.</p>

                        <!-- TEMPLATE 4 -->
                        <h2 class="mb-4">Template#4: Social Proof & “Everyone’s Doing It” (Bandwagon Effect)</h2>
                        <p>Best for clients who like reassurance that others are taking action too.</p>
                        <p>Subject options:</p>
                        <ol>
                            <li>Why more and more families are choosing Executor Hub</li>
                            <li>A new standard in estate planning</li>
                        </ol>
                        <p>Dear [First Name],</p>
                        <p>
                            Across the UK, more and more families are now using **Executor Hub** as part of their estate planning.  
                        </p>
                        <p>Why? Because it’s fast becoming the new standard for protecting loved ones:  </p>
                        <p>- A secure digital vault for wills, LPAs, trusts, and key documents  </p>
                        <p>- Step-by-step guidance for executors  </p>
                        <p>- Peace of mind for the whole family  </p>
                        <p>I recommend it to all my clients because it prevents confusion, stress, and delays – giving families clarity when they need it most.  </p>
                        <p>You can try Executor Hub free for 14 days. Subscriptions start at just £5.99/month.  </p>
                        <p>👉 [Start your free trial here] (Insert referral link)</p>

                        <!-- TEMPLATE 5 -->
                        <h2 class="mb-4">Template#5: Urgency & Action (Loss Aversion / Scarcity)</h2>
                        <p>Best for clients who procrastinate – gives a gentle nudge to act now.</p>
                        <p>Subject options:</p>
                        <ol>
                            <li>Set this up today while it’s fresh in your mind</li>
                            <li>Don’t put this off – it only takes 10 minutes</li>
                        </ol>
                        <p>Hi [First Name], </p>
                        <p>When it comes to planning ahead, many people have the best intentions – but life gets in the way and things are left unfinished.  </p>
                        <p>Executor Hub takes just 10–15 minutes to subscribe, yet it could save your family months of stress and uncertainty once you have populated it accordingly.</p>
                        <p>✔ Securely store your will, LPAs, trusts, and wishes </p>
                        <p>✔ Leave clear guidance for your executors  </p>
                        <p>✔ Protect your family from confusion and unnecessary pressure  </p>
                        <p>You can try it free for 14 days, and you can update it as often as you need to.  </p>
                        <p>👉 [Complete your free trial signup here] (Insert referral link)  </p>
                        <p>Please don’t put this off – this is a small step now that makes a huge difference for your family later.</p>
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