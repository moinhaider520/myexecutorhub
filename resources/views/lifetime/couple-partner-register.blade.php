<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Registration - Executor Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInDown 0.8s ease;
        }

        .header h1 {
            color: white;
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 12px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            font-weight: 500;
        }

        /* Info Card */
        .info-card {
            background: white;
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.8s ease 0.2s both;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .info-content {
            display: flex;
            gap: 24px;
            align-items: start;
        }

        .icon-wrapper {
            flex-shrink: 0;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .icon-wrapper svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .info-text h3 {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 12px;
        }

        .info-text p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .info-text ul {
            list-style: none;
            padding: 0;
        }

        .info-text ul li {
            color: #4a5568;
            font-size: 15px;
            padding: 8px 0;
            padding-left: 28px;
            position: relative;
        }

        .info-text ul li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: 700;
            font-size: 18px;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .form-section {
            margin-bottom: 48px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .section-title::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .required {
            color: #e53e3e;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-input:hover:not(:disabled) {
            border-color: #cbd5e0;
        }

        .form-input:disabled {
            background: #f7fafc;
            color: #718096;
            cursor: not-allowed;
        }

        .form-input.readonly {
            background: #f7fafc;
            color: #718096;
            cursor: not-allowed;
        }

        .help-text {
            font-size: 13px;
            color: #718096;
            margin-top: 6px;
        }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: start;
            gap: 12px;
            margin-bottom: 32px;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e0;
            border-radius: 6px;
            cursor: pointer;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .checkbox-label {
            font-size: 14px;
            color: #4a5568;
            line-height: 1.6;
        }

        .checkbox-label a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .checkbox-label a:hover {
            color: #764ba2;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 18px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .submit-text {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .loading {
            display: none;
        }

        .loading.active {
            display: flex;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* Security Badge */
        .security-badge {
            text-align: center;
            margin-top: 32px;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .security-content {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 24px;
            border-radius: 50px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .security-content svg {
            width: 20px;
            height: 20px;
            color: #48bb78;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-card {
                padding: 32px 24px;
            }

            .header h1 {
                font-size: 32px;
            }

            .info-content {
                flex-direction: column;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Complete Your Registration</h1>
            <p>Join {{ $primaryUser->name }} on Executor Hub</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-content">
                <div class="icon-wrapper">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="info-text">
                    <h3>Special Couple Partner Discount</h3>
                    <p>You've been invited by <strong>{{ $primaryUser->name }}</strong> to join Executor Hub at a special discounted
                        rate.</p>
                    <ul>
                        <li>Lifetime access to all features</li>
                        <li>Secure document management</li>
                        <li>Estate planning tools</li>
                        <li>No recurring fees</li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Registration Form -->
        <div class="form-card">
            @if ($errors->lifetime->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->lifetime->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form id="registrationForm" method="POST" action="{{ route('couple.partner.checkout') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Personal Information -->
                <div class="form-section">
                    <h2 class="section-title">Personal Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input readonly"
                                value="{{ $registration['partner_name'] ?? '' }}" name="full_name" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input readonly"
                                value="{{ $registration['partner_email'] ?? '' }}" name="email" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date of Birth <span class="required">*</span></label>
                            <input type="date" class="form-input" name="date_of_birth" required>
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="form-section">
                    <h2 class="section-title">Account Security</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Password <span class="required">*</span></label>
                            <input type="password" class="form-input" name="password" required minlength="8">
                            <p class="help-text">Minimum 8 characters</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password <span class="required">*</span></label>
                            <input type="password" class="form-input" name="password_confirmation" required
                                minlength="8">
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-section">
                    <h2 class="section-title">Address Information</h2>
                    <div class="form-group">
                        <label class="form-label">Street Address <span class="required">*</span></label>
                        <input type="text" class="form-input" name="address" placeholder="123 Main Street" required>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">City <span class="required">*</span></label>
                            <input type="text" class="form-input" name="city" placeholder="London" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code <span class="required">*</span></label>
                            <input type="text" class="form-input" name="postal_code" placeholder="SW1A 1AA" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country <span class="required">*</span></label>
                            <select class="form-input" name="country" required>
                                <option value="">Select Country</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="Australia">Australia</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h2 class="section-title">Additional Information (Optional)</h2>
                    <div class="form-group">
                        <label class="form-label">How did you hear about us?</label>
                        <select class="form-input" name="hear_about_us" id="hearAboutUs">
                            <option value="">Select an option</option>
                            <option value="Search Engine">Search Engine</option>
                            <option value="Social Media">Social Media</option>
                            <option value="Friend/Family">Friend/Family</option>
                            <option value="Advertisement">Advertisement</option>
                            <option value="Partner Referral">Partner Referral</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group hidden" id="otherField">
                        <label class="form-label">Please specify</label>
                        <input type="text" class="form-input" name="other_hear_about_us"
                            placeholder="Please tell us more">
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="checkbox-wrapper">
                    <input type="checkbox" class="checkbox-input" id="terms" required>
                    <label class="checkbox-label" for="terms">
                        I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a> <span
                            class="required">*</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="submit-text" id="submitText">
                        Proceed to Payment
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                    <span class="submit-text loading" id="loadingText">
                        <span class="spinner"></span>
                        Processing...
                    </span>
                </button>

                <p class="help-text" style="text-align: center; margin-top: 16px;">
                    By proceeding, you'll be redirected to Stripe's secure payment page to complete your purchase.
                </p>
            </form>
        </div>

        <!-- Security Badge -->
        <div class="security-badge">
            <div class="security-content">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>Secure payment powered by Stripe</span>
            </div>
        </div>
    </div>

    <script>
        // Show/hide "Other" field
        const hearAboutUs = document.getElementById('hearAboutUs');
        const otherField = document.getElementById('otherField');

        hearAboutUs.addEventListener('change', function () {
            if (this.value === 'Other') {
                otherField.classList.remove('hidden');
            } else {
                otherField.classList.add('hidden');
            }
        });

        // Form submission
        const form = document.getElementById('registrationForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const loadingText = document.getElementById('loadingText');

        form.addEventListener('submit', function (e) {
            // Show loading state
            submitBtn.disabled = true;
            submitText.style.display = 'none';
            loadingText.classList.add('active');

            // Form will submit normally and redirect to the route
            // No need to prevent default - let it submit naturally
        });
    </script>
</body>

</html>