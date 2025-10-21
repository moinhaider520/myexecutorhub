@extends('layouts.master')

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 box-col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Send Email Using Template</h4>
                                <span>Select recipient type, choose a template or write your own, and choose whether to send now or schedule.</span>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST" id="email-form">
                                    @csrf

                                    {{-- Recipient Type --}}
                                    <div class="mb-3">
                                        <label for="recipient_type" class="form-label">Send to</label>
                                        <select name="recipient_type" id="recipient_type" class="form-select" required>
                                            <option value="" disabled selected>Select recipient type</option>
                                            <option value="partners">Partners</option>
                                            <option value="customers">Customers</option>
                                        </select>
                                        @error('recipient_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Template Selection --}}
                                    <div class="mb-3">
                                        <label for="template" class="form-label">Choose Email Template</label>
                                        <select name="template" id="template" class="form-select">
                                            <option value="" selected>-- Custom Message --</option>
                                            <option value="Day 1">Day 1</option>
                                            <option value="Day 3">Day 3</option>
                                            <option value="Day 5">Day 5</option>
                                            <option value="Day 10">Day 10</option>
                                            <option value="Day 14">Day 14</option>
                                            <option value="Day 21">Day 21</option>
                                        </select>
                                    </div>

                                    {{-- Subject --}}
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Subject</label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Enter Subject" required>
                                    </div>

                                    {{-- Email Body --}}
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Email Body</label>
                                        <div id="quill-editor" style="height: 250px;"></div>
                                        <textarea name="message" id="message" hidden>{{ old('message') }}</textarea>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="mt-4 d-flex gap-3">
                                        <button type="submit" name="action" value="send" class="btn btn-primary">Send Now</button>
                                        <button type="submit" name="action" value="schedule" class="btn btn-secondary">Schedule</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Type your email body here...'
    });

    // Load old content
    var oldMessage = document.getElementById('message').value;
    if (oldMessage) quill.root.innerHTML = oldMessage;

    // Auto-fill subject and body when template selected
    const partnerTemplates = {

    "Day 1": {
        subject: "Partners are already earning — here’s how 💷",
        body: `
        Hi Everyone,<br><br>
        Yesterday, a new partner joined Executor Hub.<br>
        By the afternoon, they had already referred a client and secured 30% commission — all from one conversation.<br><br>
        Here’s what they did:<br>
        ✅ Logged into their portal.<br>
        ✅ Used the referral one-liner from our template.<br>
        ✅ invited their client to use the service.<br><br>
        That was it.<br><br>
        💡 You can do the same in your next meeting today.<br><br>
        ⚡ <a href='https://executorhub.co.uk/'>Log in now and refer your first client</a><br><br>
        Why leave money on the table? Your clients need this, and you’re perfectly placed to help them.<br><br>
        Cheers,<br>
        The Executor Hub Team
        `
    },
        "Day 3": {
            subject: "3 ways to introduce Executor Hub in under 30 seconds ⏱️",
            body : `
            Hi $name,<br><br>
            Not sure what to say to clients? We’ve got you covered.<br><br>
            Here are 3 easy lines partners are using right now:<br>
            1. “One of the most thoughtful things you can leave your family is clarity. I can set you up with Executor Hub today.”<br>
            2. “Executor Hub helps your executors avoid stress — and it only takes a few minutes to get started.”<br>
            3. “Think of it as a secure digital vault for your Will, Trusts, LPAs, and more — all in one place.”<br><br>
            👉 Copy, paste, and drop into your next client call or meeting.<br><br>
            ⚡ <a href='https://executorhub.co.uk/'>Refer a client now</a><br><br>
            Every client you speak to is a chance to add value AND grow your income. Start with one today.<br><br>
            Best,<br>
            The Executor Hub Team`
        },
        "Day 5": {
            subject: "Your Partner Portal builds recurring income for you 📂",
            body: `Hi Everyone!,<br><br>
            You don’t need to learn a new system.<br>
            Your Partner Portal already has everything:<br>
            • Simple referral links.<br>
            • Ready-to-use email scripts.<br>
            • Step-by-step client guides.<br>
            • Knowledge base for any questions.<br><br>
            All you need to do? Log in and refer.<br><br>
            ⚡ <a href='https://executorhub.co.uk/'>Explore your Partner Portal now</a><br><br>
            With every client you add, your monthly commission grows. Aim for just one referral this week and watch how quickly it stacks up.<br><br>
            Talk soon,<br>
            The Executor Hub Team`
        },
        "Day 10": {
            subject: "Don’t miss your first £90 a month (and growing) 💸",
            body: `
            Hi Everyone!,<br><br>
            Partners who act in their first week are the ones who build the fastest recurring income.<br><br>
            Here’s the maths, based on the Standard plan (£11.99/month):<br>
            • Each client = £3.60 every month for you.<br>
            • 25 clients = £90/month recurring (£1,080 a year).<br>
            • 50 clients = £180/month recurring (£2,160 a year).<br><br>
            And it doesn’t stop there — every time you add a new client, your monthly income grows automatically.<br><br>
            ⚡ <a href='https://executorhub.co.uk/'>Submit your first client today</a><br><br>
            Imagine having a monthly income that builds with every referral. Start now and your commissions will keep stacking month after month.<br><br>
            Your first £90/month is waiting.<br><br>
            To your success,<br>
            The Executor Hub Team`
        },
        "Day 14": {
            subject: "Turn 25 clients into £1,000+ a year — recurring 📈",
            body: `
            Hi $name,<br><br>
            Here’s what partners are building right now:<br>
            • 25 clients referred → £90/month recurring (£1,080/year).<br>
            • 50 clients referred → £180/month recurring (£2,160/year).<br>
            • 100 clients referred → £360/month recurring (£4,320/year).<br><br>
            And remember — this isn’t a one-off.<br>
            Executor Hub subscriptions renew every month, so your income grows as you keep adding clients.<br><br>
            ⚡ <a href='https://executorhub.co.uk/'>Log in and add your next client now</a><br><br>
            All it takes is making Executor Hub part of your standard client conversation. The partners who hit 25 clients quickly are the ones who unlock consistent recurring income.<br><br>
            Best regards,<br>
            The Executor Hub Team`
        },
        "Day 21": {
            subject: "Ready to scale your growing monthly income? 🚀",
            body: `
            Hi $name,<br><br>
            You’ve seen how quick and simple referrals are — and here’s the real power: your income grows every single month as clients stay subscribed.<br><br>
            💷 Each client = £3.60/month recurring.<br>
            💷 25 clients = £90/month.<br>
            💷 50 clients = £180/month.<br>
            💷 100 clients = £360/month.<br><br>
            That income repeats every month — and increases every time you add a new client.<br><br>
            ⚡ <a href='https://executorhub.co.uk/'>Log in and add your next client now</a><br><br>
            Now it’s time to scale. Set yourself a simple target (10, 25, 50 clients) and watch your income snowball.<br><br>
            On your side,<br>
            The Executor Hub Team`
        }
    };
    const customerTemplates = {
  "Day 1": {
    subject: "The most important step: add your executor today",
    body: `
      <p>Hi Everyone,</p>
      <p>Executors often spend dozens of hours searching for documents (Exizent 2023, Legal Services Board). Executor Hub cuts this down to a fraction of the time.</p>
      <p>✅ Today’s step: Add your executor.</p>
      <p>This unlocks their personal step-by-step guide — the heart of Executor Hub.</p>
      <a href='https://executorhub.co.uk/'>👉 [Nominate your executor now]</a>
      <p>🔒 Executors will only ever see the guidance you approve — your sensitive data stays private until you allow it to be shared.</p>
      <p>— Executor Hub</p>`
  },

  "Day 2": {
    subject: "Save your executor hours — add one bank account securely",
    body: `
      <p>Hi Everyone,</p>
      <p>Executors can spend weeks just tracking down bank details. Let’s prevent that today.</p>
      <p>✅ Add your first bank account in Executor Hub.</p>
      <a href='https://executorhub.co.uk/'>👉 [Add a bank account now]</a>
      <p>🔒 Executor Hub uses bank-grade security. Details stored here cannot be used to access or move money — they’re only for your records and to guide your executor when the time comes.</p>
      <p>— Executor Hub</p>`
  },

  "Day 3": {
    subject: "Imagine your family hearing your voice ❤️",
    body: `
      <p>Hi Everyone,</p>
      <p>Executor Hub isn’t just about paperwork. It’s about love, memories, and guidance.</p>
      <p>✅ Today’s step: Record your first video or message.</p>
      <a href='https://executorhub.co.uk/'>👉 [Record your first message]</a>
      <p>🔒 All recordings are encrypted and stored securely, only visible to the loved ones you choose.</p>
      <p>— Executor Hub</p>`
  },

  "Day 5": {
    subject: "Guidance for guardians — your voice in their future",
    body: `
      <p>Hi Everyone,</p>
      <p>Executor Hub lets you leave clear guidance for guardians — advice, routines, values.</p>
      <p>✅ Today’s step: Add your first note for guardians.</p>
      <a href='https://executorhub.co.uk/'>👉 [Leave guardian guidance now]</a>
      <p>🔒 Stored securely and only shared with those you authorise.</p>
      <p>— Executor Hub</p>`
  },

  "Day 6": {
    subject: "You’re halfway there — families like Sarah’s save months",
    body: `
      <p>Hi Everyone,</p>
      <p>Your vault is already taking shape 🎉.</p>
      <p>Families without Executor Hub often spend months searching for paperwork (Exizent 2023). With everything in one secure vault, it’s reduced to days.</p>
      <p>✅ Check your dashboard and complete one more item today.</p>
      <a href='https://executorhub.co.uk/'>👉 [See your progress]</a>
      <p>🔒 All your data is protected with AES-256 bank-grade encryption.</p>
      <p>— Executor Hub</p>`
  },

  "Day 7": {
    subject: "1 week in — keep peace of mind for less than £3/week",
    body: `
      <p>Hi Everyone,</p>
      <p>You’ve completed a week 🎉. Already, you’ve:</p>
      <p>✔ Uploaded documents</p>
      <p>✔ Nominated an executor</p>
      <p>✔ Added assets</p>
      <p>For less than £3 a week, you’ll keep:</p>
      <p>- Your secure digital vault</p>
      <p>- Executor’s step-by-step guide</p>
      <p>- Legacy messages & videos</p>
      <p>- Guardian guidance & wishes</p>
      <a href='https://executorhub.co.uk/'>👉 [Continue after your trial — get 2 months free on annual plan]</a>
      <p>🔒 Executors only ever see data you approve — and your financial details can never be used to move money.</p>
      <p>— Executor Hub</p>`
  },

  "Day 8": {
    subject: "Review your property details — keep them up to date",
    body: `
      <p>Hi Everyone,</p>
      <p>Quick check-in on your property details.</p>
      <p>✅ Today’s step: Review your property entry and add any missing info (title number, mortgage, insurer).</p>
      <a href='https://executorhub.co.uk/'>👉 [Review property now]</a>
      <p>🔒 Details are stored securely and cannot be accessed by anyone unless you authorise it.</p>
      <p>— Executor Hub</p>`
  },

  "Day 9": {
    subject: "Your annual capacity proof is due — record in 30 seconds",
    body: `
      <p>Hi Everyone,</p>
      <p>🔒 All recordings are encrypted, time-stamped, and stored securely to protect you against future challenges.</p>
      <p>— Executor Hub</p>`
  },

  "Day 10": {
    subject: "Don’t lose what you’ve built",
    body: `
      <p>Hi Everyone,</p>
      <p>Your executor’s guide is active. Your family’s vault is filling. Your legacy messages are stored.</p>
      <p>In just 4 days, your trial ends. Without a plan, you’ll lose access to it all.</p>
      <a href='https://executorhub.co.uk/'>👉 [Continue for just £5.99/month]</a>
      <p>🔒 All the progress you’ve made is stored under bank-grade security. Keep it safe by continuing your plan.</p>
      <p>— Executor Hub</p>`
  },

  "Day 11": {
    subject: "Your trial ends in 3 days — keep your vault safe",
    body: `
      <p>Hi Everyone,</p>
      <p>Your free trial ends soon. Here’s what you’ll keep:</p>
      <p>- Your secure vault</p>
      <p>- Executor’s step-by-step guide</p>
      <p>- Your videos & messages</p>
      <p>- Guardian guidance & wishes</p>
      <a href='https://executorhub.co.uk/'>👉 [Secure your vault now for £5.99/month]</a>
      <p>🎁 Add your partner for just £2.99/month.</p>
      <p>🔒 All data stays encrypted and private — your executor will only ever see what you approve.</p>
      <p>— Executor Hub</p>`
  },

  "Day 12": {
    subject: "Almost there — complete your onboarding guide",
    body: `
      <p>Hi Everyone,</p>
      <p>You’re nearly there 👏. Here’s what’s left to finish your setup:</p>
      <ul>
        <li>• Add a digital asset (social media, streaming, crypto)</li>
        <li>• Add your property details (or confirm you don’t own property)</li>
        <li>• Record a message/video for your loved ones</li>
        <li>• Add one bank account</li>
        <li>• Upload one document (will/insurance/bank statement)</li>
        <li>• Add your executor (unlocks their step-by-step guide)</li>
      </ul>
      <a href='https://executorhub.co.uk/'>👉 [Open your dashboard to complete the final steps]</a>
      <p>🔒 Everything you add is protected with bank-grade encryption and only visible to people you authorise.</p>
      <p>— Executor Hub</p>`
  },

  "Day 13": {
    subject: "Last chance: don’t lose your vault tomorrow",
    body: `
      <p>Hi Everyone,</p>
      <p>This is your final reminder — tomorrow your trial ends.</p>
      <p>Don’t lose access to the vault, guides, and priceless messages you’ve built.</p>
      <a href='https://executorhub.co.uk/'>👉 [Continue your plan today]</a>
      <p>🔒 Keep everything you’ve secured safe, encrypted, and available when it matters.</p>
      <p>— Executor Hub</p>`
  },

  "Day 14": {
    subject: "Keep everything you’ve built — for less than 2 coffees a month",
    body: `
      <p>Hi Everyone,</p>
      <p>Your free trial ends today. Unless you continue, you’ll lose access to your vault, executor’s guide, and legacy features.</p>
      <a href='https://executorhub.co.uk/stripe'>👉 [Keep my Executor Hub active for £5.99/month]</a>
      <p>or</p>
      <a href='https://executorhub.co.uk/stripe'>Or [Switch to annual — 2 months free]</a>
      <p>Not ready? Pause your plan for 3 months and keep your vault safe.</p>
      <p>🔒 Your data will always remain protected with bank-grade security — but only active plans keep your vault available to executors.</p>
      <p>This is the simplest, most powerful gift you can leave your loved ones.</p>
      <p>— Executor Hub</p>`
  }
};
document.getElementById('recipient_type').addEventListener('change', function() {
    const templateSelect = document.getElementById('template');
    const val = this.value;
    templateSelect.innerHTML = '<option value="">-- Custom Message --</option>';

    // Populate dropdown based on type
    const data = val === 'partners' ? partnerTemplates : val === 'customers' ? customerTemplates : null;

    if (data) {
        Object.keys(data).forEach(day => {
            const opt = document.createElement('option');
            opt.value = day;
            opt.textContent = day;
            templateSelect.appendChild(opt);
        });
    }

    // Reset fields
    document.getElementById('title').value = '';
    quill.root.innerHTML = '';
});

// ===== When template changes =====
document.getElementById('template').addEventListener('change', function() {
    const recipientType = document.getElementById('recipient_type').value;
    const selected = this.value;

    const data = recipientType === 'partners' ? partnerTemplates : customerTemplates;

    if (selected && data[selected]) {
        document.getElementById('title').value = data[selected].subject;
        quill.root.innerHTML = data[selected].body;
    } else {
        document.getElementById('title').value = '';
        quill.root.innerHTML = '';
    }
});

// ===== Sync hidden field on submit =====
document.getElementById('email-form').addEventListener('submit', function() {
    document.getElementById('message').value = quill.root.innerHTML.trim();
});
</script>
@endsection
