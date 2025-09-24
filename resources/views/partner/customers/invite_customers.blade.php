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
    <input type="text" id="emailSubject" class="form-control mb-2"
        value="Don’t leave your family searching for answers">

    <textarea id="emailBody" class="form-control mb-2" rows="10">
<p>Dear [First Name],</p>

<p>When someone passes away, their executors often spend months trying to locate documents, accounts, and passwords. 
It’s stressful, time-consuming, and sometimes leads to important things being missed.</p>

<p><strong>Executor Hub solves this.</strong></p>

<p>It’s a digital vault where everything is stored securely in one place – your will, LPAs, trusts, bank details, wishes, even personal messages. Executors then receive clear, step-by-step guidance.</p>

<ul>
  <li>✨ No lost paperwork</li>
  <li>✨ No searching for passwords</li>
  <li>✨ No unanswered questions for your family</li>
</ul>

<p>It takes just 10–15 minutes to set up, and you can try it 
<strong>free for 14 days</strong>.</p>

<p>👉 <a href="https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}">
Click here to register</a></p>
    </textarea>

    <button class="btn btn-primary" onclick="sendEmail()">Send Email</button>
</div>


                                    <!-- WhatsApp Form -->
                                    <div id="whatsappOption" class="mt-3" style="display:none;">
                                        <input type="text" id="whatsappNumber" class="form-control mb-2"
                                            placeholder="Enter WhatsApp Number (with country code)">
                                        <textarea id="whatsappMessage" class="form-control mb-2"
                                            rows="4">Hi [First Name], I recommend all my clients use Executor Hub — it’s a secure place to keep your will, LPAs, and wishes together, and it guides your executors step by step. Here’s your free trial link: https://executorhub.co.uk/partner_registration?coupon_code={{ $user->coupon_code }}</textarea>
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
        function showOption(option) {
            // Hide both first
            document.getElementById('emailOption').style.display = 'none';
            document.getElementById('whatsappOption').style.display = 'none';

            // Show selected option
            if (option === 'email') {
                document.getElementById('emailOption').style.display = 'block';
            } else if (option === 'whatsapp') {
                document.getElementById('whatsappOption').style.display = 'block';
            }
        }

        function sendEmail() {
            let email = document.getElementById('emailAddress').value;
            let subject = encodeURIComponent(document.getElementById('emailSubject').value);
            let body = encodeURIComponent(document.getElementById('emailBody').value);

            if (!email) {
                alert('Please enter email address');
                return;
            }

            // This will open the default email client (like Outlook/Gmail app)
            window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
        }

        function sendWhatsApp() {
            let number = document.getElementById('whatsappNumber').value;
            let message = encodeURIComponent(document.getElementById('whatsappMessage').value);

            if (!number) {
                alert('Please enter WhatsApp number');
                return;
            }

            // This will open WhatsApp Web or App
            window.open(`https://wa.me/${number}?text=${message}`, '_blank');
        }
    </script>

@endsection