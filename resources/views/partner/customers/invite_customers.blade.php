@extends('layouts.master')

@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Invite Customer</h5>
                                <div class="card-body text-center">
                                    <!-- Option Buttons -->
                                    <button class="btn btn-primary m-2" onclick="showOption('email')">Email</button>
                                    <button class="btn btn-success m-2" onclick="showOption('whatsapp')">WhatsApp</button>

                                    <!-- Email Form -->
                                    <div id="emailOption" class="mt-3" style="display:none;">
                                        <input type="email" id="emailAddress" class="form-control mb-2"
                                            placeholder="Enter Email Address">

                                        <!-- Template Selector -->
                                        <select id="templateSelector" class="form-control mb-2" onchange="loadTemplate()">
                                            <option value="">-- Select a Template or Draft Your Own --</option>
                                            <option value="template1">Template 1: Trusted Recommendation</option>
                                            <option value="template2">Template 2: Pain Point & Solution</option>
                                            <option value="template3">Template 3: Emotional Story</option>
                                            <option value="template4">Template 4: Social Proof</option>
                                            <option value="template5">Template 5: Urgency & Action</option>
                                        </select>

                                        <input type="text" id="emailSubject" class="form-control mb-2"
                                            placeholder="Email Subject">

                                        <textarea id="emailBody" class="form-control mb-2" rows="12"
                                            placeholder="Type your email message here..."></textarea>

                                        <button class="btn btn-primary" onclick="sendEmail()">Send Email</button>
                                    </div>

                                    <!-- WhatsApp Form -->
                                    <div id="whatsappOption" class="mt-3" style="display:none;">
                                        <input type="text" id="whatsappNumber" class="form-control mb-2"
                                            placeholder="Enter WhatsApp Number (with country code)">
                                        <textarea id="whatsappMessage" class="form-control mb-2"
                                            rows="4">Hi [First Name], I recommend all my clients use Executor Hub — it's a secure place to keep your will, LPAs, and wishes together, and it guides your executors step by step. Here's your free trial link: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}</textarea>
                                        <button class="btn btn-success" onclick="sendWhatsApp()">Send WhatsApp</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

    <script>
        const emailTemplates = {
            template1: {
                subject: "A service I recommend for all my clients",
                body: `Hi [First Name],

    As part of the planning work we've done together, I always recommend one additional step that makes life much easier for families: Executor Hub.

    Executor Hub is a secure digital vault where you can keep your will, LPAs, trusts, and important information safe. It also gives your chosen executors step-by-step guidance when the time comes.

    Why I recommend it:

    ✔ Takes just 10–15 minutes to set up
    ✔ Keeps all your key documents and instructions in one place
    ✔ Brings peace of mind to your family when they'll need it most

    👉 Activate your free trial here: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}

    Warm regards,
    [Partner/Adviser Name]`
            },
            template2: {
                subject: "Don't leave your family searching for answers",
                body: `Dear [First Name],

    When someone passes away, their executors often spend months trying to locate documents, accounts, and passwords. It's stressful, time-consuming, and sometimes leads to important things being missed.

    Executor Hub solves this.

    It's a digital vault where everything is stored securely in one place – your will, LPAs, trusts, bank details, wishes, even personal messages. Executors then receive clear, step-by-step guidance.

    ✨ No lost paperwork
    ✨ No searching for passwords
    ✨ No unanswered questions for your family

    It takes just 10–15 minutes to set up, and you can try it free for 14 days.

    👉 Get started today: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}`
            },
            template3: {
                subject: "The most thoughtful gift you can leave behind",
                body: `Hi [First Name],

    I often see families struggling at the hardest possible time – not because of money, but because they don't know where to find important documents or what their loved one's wishes were.

    Executor Hub changes that.

    It's a simple, secure way to record your wishes, store your will, LPAs, and trusts, and even leave personal messages for your family. When the time comes, your executors have everything they need, with step-by-step guidance.

    It takes just minutes to set up, and subscriptions start at £5.99/month after a free 14-day trial.

    👉 Set up your account today: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}

    This is one of the kindest, most thoughtful steps you can take for your loved ones.`
            },
            template4: {
                subject: "Why more and more families are choosing Executor Hub",
                body: `Dear [First Name],

    Across the UK, more and more families are now using Executor Hub as part of their estate planning.

    Why? Because it's fast becoming the new standard for protecting loved ones:

    - A secure digital vault for wills, LPAs, trusts, and key documents
    - Step-by-step guidance for executors
    - Peace of mind for the whole family

    I recommend it to all my clients because it prevents confusion, stress, and delays – giving families clarity when they need it most.

    You can try Executor Hub free for 14 days. Subscriptions start at just £5.99/month.

    👉 Start your free trial here: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}`
            },
            template5: {
                subject: "Set this up today while it's fresh in your mind",
                body: `Hi [First Name],

    When it comes to planning ahead, many people have the best intentions – but life gets in the way and things are left unfinished.

    Executor Hub takes just 10–15 minutes to subscribe, yet it could save your family months of stress and uncertainty once you have populated it accordingly.

    ✔ Securely store your will, LPAs, trusts, and wishes
    ✔ Leave clear guidance for your executors
    ✔ Protect your family from confusion and unnecessary pressure

    You can try it free for 14 days, and you can update it as often as you need to.

    👉 Complete your free trial signup here: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}

    Please don't put this off – this is a small step now that makes a huge difference for your family later.`
            }
        };

        function showOption(option) {
            document.getElementById('emailOption').style.display = 'none';
            document.getElementById('whatsappOption').style.display = 'none';

            if (option === 'email') {
                document.getElementById('emailOption').style.display = 'block';
            } else if (option === 'whatsapp') {
                document.getElementById('whatsappOption').style.display = 'block';
            }
        }

        function loadTemplate() {
            const selector = document.getElementById('templateSelector');
            const selectedTemplate = selector.value;

            if (selectedTemplate && emailTemplates[selectedTemplate]) {
                document.getElementById('emailSubject').value = emailTemplates[selectedTemplate].subject;
                document.getElementById('emailBody').value = emailTemplates[selectedTemplate].body;
            } else {
                document.getElementById('emailSubject').value = '';
                document.getElementById('emailBody').value = '';
            }
        }

        function sendEmail() {
            let email = document.getElementById('emailAddress').value.trim();
            let subject = document.getElementById('emailSubject').value.trim();
            let body = document.getElementById('emailBody').value.trim();

            // Validation
            if (!email) {
                alert('Please enter an email address');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return;
            }

            if (!subject) {
                alert('Please enter an email subject');
                return;
            }

            if (!body) {
                alert('Please enter an email body');
                return;
            }

            // Create mailto link
            const mailtoLink = `mailto:${encodeURIComponent(email)}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

            // Try to open the mailto link
            try {
                window.location.href = mailtoLink;
            } catch (error) {
                alert('Could not open email client. Please check your email application settings.');
            }
        }

        function sendWhatsApp() {
            let number = document.getElementById('whatsappNumber').value.trim();
            let message = document.getElementById('whatsappMessage').value.trim();

            if (!number) {
                alert('Please enter WhatsApp number');
                return;
            }

            // Remove any spaces, dashes, or parentheses from the number
            number = number.replace(/[\s\-\(\)]/g, '');

            const whatsappLink = `https://wa.me/${number}?text=${encodeURIComponent(message)}`;
            window.open(whatsappLink, '_blank');
        }
    </script>
@endsection
