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

                                        <button class="btn btn-primary" onclick="copyEmailContent()">
                                            <i class="fa fa-copy"></i> Copy Email Content
                                        </button>
                                    </div>

                                    <!-- WhatsApp Form -->
                                    <div id="whatsappOption" class="mt-3" style="display:none;">
                                        <!-- WhatsApp Template Selector -->
                                        <select id="whatsappTemplateSelector" class="form-control mb-2" onchange="loadWhatsappTemplate()">
                                            <option value="">-- Select a Template or Draft Your Own --</option>
                                            <option value="template1">Template 1: Quick Recommendation</option>
                                            <option value="template2">Template 2: Problem Solution</option>
                                            <option value="template3">Template 3: Peace of Mind</option>
                                            <option value="template4">Template 4: Simple & Direct</option>
                                        </select>

                                        <textarea id="whatsappMessage" class="form-control mb-2" rows="8"
                                            placeholder="Type your WhatsApp message here..."></textarea>
                                        
                                        <button class="btn btn-success" onclick="copyWhatsappContent()">
                                            <i class="fa fa-copy"></i> Copy WhatsApp Message
                                        </button>
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

        const whatsappTemplates = {
            template1: {
                message: `Hi [First Name], I recommend all my clients use Executor Hub — it's a secure place to keep your will, LPAs, and wishes together, and it guides your executors step by step. Here's your free trial link: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}`
            },
            template2: {
                message: `Hi [First Name], did you know executors often spend months searching for documents and passwords after someone passes? Executor Hub solves this by keeping everything secure in one place with step-by-step guidance. Try it free: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}`
            },
            template3: {
                message: `Hello [First Name]! 👋 Just wanted to share something that gives real peace of mind: Executor Hub. It stores your will, LPAs, and wishes securely, and makes things so much easier for your family. Takes 10 mins to set up. Free trial: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}`
            },
            template4: {
                message: `Hi [First Name], I use Executor Hub with all my clients. It's a digital vault for your will, LPAs & important docs + step-by-step guidance for executors. 14-day free trial here: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}`
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

        function loadWhatsappTemplate() {
            const selector = document.getElementById('whatsappTemplateSelector');
            const selectedTemplate = selector.value;

            if (selectedTemplate && whatsappTemplates[selectedTemplate]) {
                document.getElementById('whatsappMessage').value = whatsappTemplates[selectedTemplate].message;
            } else {
                document.getElementById('whatsappMessage').value = '';
            }
        }

        function copyEmailContent() {
            let subject = document.getElementById('emailSubject').value.trim();
            let body = document.getElementById('emailBody').value.trim();

            if (!subject && !body) {
                alert('Please select a template or enter email content');
                return;
            }

            // Combine subject and body
            const fullContent = `Subject: ${subject}\n\n${body}`;

            // Copy to clipboard
            navigator.clipboard.writeText(fullContent).then(function() {
                // Show success message
                alert('Email content copied to clipboard!');
            }, function(err) {
                // Fallback method for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = fullContent;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    alert('Email content copied to clipboard!');
                } catch (err) {
                    alert('Failed to copy content. Please copy manually.');
                }
                
                document.body.removeChild(textArea);
            });
        }

        function copyWhatsappContent() {
            let message = document.getElementById('whatsappMessage').value.trim();

            if (!message) {
                alert('Please select a template or enter a WhatsApp message');
                return;
            }

            // Copy to clipboard
            navigator.clipboard.writeText(message).then(function() {
                // Show success message
                alert('WhatsApp message copied to clipboard!');
            }, function(err) {
                // Fallback method for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = message;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    alert('WhatsApp message copied to clipboard!');
                } catch (err) {
                    alert('Failed to copy content. Please copy manually.');
                }
                
                document.body.removeChild(textArea);
            });
        }
    </script>
@endsection