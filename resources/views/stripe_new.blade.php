
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        #card-element {
            height: 50px;
            padding-top: 16px;
        }

        .payment-option {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.1);
        }

        .payment-option.active {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .payment-logo {
            max-height: 40px;
            margin-right: 15px;
        }

        .payment-buttons {
            display: none;
            margin-top: 20px;
        }

        .payment-buttons.active {
            display: block;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Choose Your Subscription Plan</h3>

                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('stripe_error'))
                        <div class="alert alert-danger">
                            {{ session('stripe_error') }}
                        </div>
                        @endif

                        @if (session('paypal_error'))
                        <div class="alert alert-danger">
                            {{ session('paypal_error') }}
                        </div>
                        @endif

                        <!-- User Information Form -->
                        <form id="user-info-form">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                                </div>
                            </div>

                            <div class="mt-3">
                                <strong>Password:</strong>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Address Line 1:</strong>
                                    <input type="text" class="form-control" name="address_line1" id="address_line1" placeholder="Enter Address Line 1" required>
                                </div>
                                <div class="col-md-6">
                                    <strong>City:</strong>
                                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Postal Code:</strong>
                                    <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Enter Postal Code" required>
                                </div>
                                <div class="col-md-6">
                                    <strong>Country:</strong>
                                    <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <strong>Membership:</strong>
                                    <select class="form-control" id="plan" name="plan" required>
                                        <option selected="" disabled>Choose...</option>
                                        <option value="basic">Basic - £5.99/month</option>
                                        <option value="standard">Standard - £11.99/month</option>
                                        <option value="premium">Premium - £19.99/month</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <strong>Use Coupon Code (Optional):</strong>
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code">
                            </div>
                        </form>

                        <!-- Payment Method Selection -->
                        <div class="mt-4">
                            <h5>Choose Payment Method:</h5>
                            <div class="row">
                                <!-- Stripe Option -->
                                <div class="col-md-6">
                                    <div class="payment-option border p-3 rounded" data-method="stripe">
                                        <div class="d-flex align-items-center">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" class="payment-logo me-3" style="height: 40px;">
                                            <div>
                                                <h6 class="mb-1">Pay with Stripe</h6>
                                                <small class="text-muted">Secure credit/debit card payment</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PayPal Option -->
                                <div class="col-md-6">
                                    <div class="payment-option border p-3 rounded" data-method="paypal">
                                        <div class="d-flex align-items-center">
                                            <img src="https://www.paypalobjects.com/webstatic/i/logo/rebrand/ppcom.svg" alt="PayPal" class="payment-logo me-3" style="height: 40px;">
                                            <div>
                                                <h6 class="mb-1">Pay with PayPal</h6>
                                                <small class="text-muted">Pay safely with your PayPal account</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Buttons -->
                        <div id="stripe-buttons" class="payment-buttons">
                            <form id="stripe-form" method="post" action="{{ route('stripe.post') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    Subscribe with Stripe
                                </button>
                            </form>
                        </div>

                        <div id="paypal-buttons" class="payment-buttons">
                            <form id="paypal-form" method="post" action="{{ route('paypal.post') }}">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-lg w-100">
                                    Subscribe with PayPal
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Payment method selection
            $('.payment-option').click(function() {
                $('.payment-option').removeClass('active');
                $('.payment-buttons').removeClass('active');

                $(this).addClass('active');
                const method = $(this).data('method');
                $(`#${method}-buttons`).addClass('active');
            });

            // Form validation and submission
            function validateForm() {
                const requiredFields = ['name', 'email', 'password', 'address_line1', 'city', 'postal_code', 'country', 'plan'];

                for (let field of requiredFields) {
                    if (!$(`#${field}`).val()) {
                        alert(`Please fill in the ${field.replace('_', ' ')} field.`);
                        return false;
                    }
                }
                return true;
            }

            function copyFormData(targetForm) {
                const formData = new FormData(document.getElementById('user-info-form'));

                for (let [key, value] of formData.entries()) {
                    if (targetForm.find(`[name="${key}"]`).length === 0) {
                        targetForm.append(`<input type="hidden" name="${key}" value="${value}">`);
                    }
                }
            }

            // Stripe form submission
            $('#stripe-form').submit(function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                copyFormData($(this));

                // Convert plan value for Stripe
                const planValue = $('#plan').val();
                const stripePlans = {
                    'basic': 'price_1R6CY5A22YOnjf5ZrChFVLg2',
                    'standard': 'price_1R6CZDA22YOnjf5ZUEFGbQOE',
                    'premium': 'price_1R6CaeA22YOnjf5Z0sW3CZ9F'
                };

                $(this).find('[name="plan"]').val(stripePlans[planValue]);
            });

            // PayPal form submission
            $('#paypal-form').submit(function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                copyFormData($(this));
            });
        });
    </script>

</body>

</html>