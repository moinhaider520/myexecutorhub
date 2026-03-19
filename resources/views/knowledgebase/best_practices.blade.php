@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">How To Introduce It</h2>
                        <p>Getting the timing right makes a big difference to how clients respond. Executor Hub should feel like a natural part of estate planning, not an afterthought. Below are best practices and answers to common questions to help you maximise results.</p>


                        <!-- TEMPLATE 1 -->
                        <h2 class="mb-4">❓ When should I introduce Executor Hub?</h2>
                        <p>The best approach is Hybrid:</p>
                        <p>•	At the first discussion:</p>
                        <p>Mention Executor Hub briefly so clients see it as part of the estate planning journey:</p>
                        <p>“As part of this process, I’ll also recommend Executor Hub. It’s a secure digital vault that stores your documents and guides your executors. I’ll explain more once your documents are complete.”</p>
                        <p>•	At completion (will/trust/LPA signed):</p>
                        <p>Make the recommendation strongly when everything is fresh:</p>
                        <p>“Now that your planning documents are complete, the next step is Executor Hub. It makes sure your executors can actually use everything we’ve prepared, without stress or delays. It only takes 10 minutes to set up, and there’s a free trial.”</p>
                        <p>This way, Executor Hub feels expected from the start but the conversion push happens at the end, when urgency and emotional buy-in are strongest.</p>


                        <!-- TEMPLATE 2 -->
                        <h2 class="mb-4">❓ How do I introduce Executor Hub to existing clients (documents already done)?</h2>
                        <p>If you have clients whose wills, trusts, or LPAs were prepared months or years ago, Executor Hub is still highly relevant.</p>
                        <p>Suggested approach:</p>
                        <p>•	Use reviews as a trigger:</p>
                        <p>“It’s been a while since we completed your planning. A lot can change in a few years, and I now recommend Executor Hub to all clients. It keeps everything we’ve prepared secure, accessible, and guides your executors step by step.”</p>
                        <p>•	Highlight changing times:</p>
                        <p>“Digital estate planning is becoming the new standard. Executor Hub means your executors won’t be left hunting for documents or passwords — everything will be in one secure place.”</p>
                        <p>•	Position it as an upgrade:</p>
                        <p>“When we first did your will, services like Executor Hub didn’t exist. Now we can add this extra layer of protection for your family, and it only takes minutes to set up.”</p>

                        <!-- TEMPLATE 3 -->
                        <h2 class="mb-4">❓ How often should I follow up?</h2>
                        <p>We recommend:</p>
                        <p>•	Initial introduction → at completion of documents (or during review if it’s an older case).</p>
                        <p>•	Follow-up 1 → 3–5 days later (gentle reminder).</p>
                        <p>•	Follow-up 2 → about 1 week later, using a different angle (e.g. emotional story if the first was logical).</p>
                        <p>👉 Best practice: ask permission to follow up.</p>
                        <p>Example:</p>
                        <p>“If I don’t hear back, would you mind if I check in with you next week?”</p>
                        <p>Even better, schedule it in with them:</p>
                        <p>“Shall we put a quick reminder in the diary for next Tuesday to make sure you’ve had a chance to set it up?”</p>
                        <p>This makes the follow-up expected and welcome, not pushy.</p>

                        <!-- TEMPLATE 4 -->
                        <h2 class="mb-4">❓ What conversion rate should I expect?</h2>
                        <p>Typically and conservatively around 5–15% of clients who are introduced to Executor Hub will subscribe within the first month.</p>
                        <p>However:</p>
                        <p>•	Partners who mention it early, recommend it strongly at completion, and follow up with permission often see significantly higher uptake.</p>
                        <p>•	Remember: even small percentages add up. For every 100 clients introduced, 5–15 subscriptions = recurring monthly income, compounding as your client base grows.</p>
                        <p>With this approach, you can confidently introduce Executor Hub at any stage — whether it’s a new client, a client completing their documents now, or an older client coming back for a review.</p>

                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Finish the onboarding flow',
                            'nextUrl' => route('partner.knowledgebase.quick_start_guide'),
                            'nextLabel' => 'Activation Complete',
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
