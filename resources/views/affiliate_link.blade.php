<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SITE TITLE -->
    <title>Executor Hub</title>

    <!-- FAVICON AND TOUCH ICONS -->
    <link rel="shortcut icon" href="{{ asset('assets/frontend/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('assets/frontend/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('assets/frontend/images/apple-touch-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('assets/frontend/images/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('assets/frontend/images/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/images/apple-touch-icon.png') }}" />
    <link rel="icon" href="{{ asset('assets/frontend/images/apple-touch-icon.png') }}" type="image/x-icon" />

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />

    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- FONT ICONS -->
    <link href="{{ asset('assets/frontend/css/flaticon.css') }}" rel="stylesheet" />

    <!-- PLUGINS STYLESHEET -->
    <link href="{{ asset('assets/frontend/css/menu.css') }}" rel="stylesheet" />
    <link id="effect" href="{{ asset('assets/frontend/css/dropdown-effects/fade-down.css') }}" media="all"
        rel="stylesheet" />
    <link href="{{ asset('assets/frontend/css/magnific-popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/frontend/css/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/frontend/css/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/frontend/css/lunar.css') }}" rel="stylesheet" />

    <!-- ON SCROLL ANIMATION -->
    <link href="{{ asset('assets/frontend/css/animate.css') }}" rel="stylesheet" />

    <!-- TEMPLATE CSS -->
    <link href="{{ asset('assets/frontend/css/skyblue-theme.css') }}" rel="stylesheet" />

    <!-- Style Switcher CSS -->
    <link href="{{ asset('assets/frontend/css/blue-theme.css') }}" rel="alternate stylesheet" title="blue-theme" />
    <link href="{{ asset('assets/frontend/css/crocus-theme.css') }}" rel="alternate stylesheet" title="crocus-theme" />
    <link href="{{ asset('assets/frontend/css/green-theme.css') }}" rel="alternate stylesheet" title="green-theme" />
    <link href="{{ asset('assets/frontend/css/magenta-theme.css') }}" rel="alternate stylesheet"
        title="magenta-theme" />
    <link href="{{ asset('assets/frontend/css/pink-theme.css') }}" rel="alternate stylesheet" title="pink-theme" />
    <link href="{{ asset('assets/frontend/css/purple-theme.css') }}" rel="alternate stylesheet" title="purple-theme" />
    <link href="{{ asset('assets/frontend/css/red-theme.css') }}" rel="alternate stylesheet" title="red-theme" />
    <link href="{{ asset('assets/frontend/css/violet-theme.css') }}" rel="alternate stylesheet" title="violet-theme" />

    <!-- RESPONSIVE CSS -->
    <link href="{{ asset('assets/frontend/css/responsive.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<style>
    .exit-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
    }

    .exit-popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        width: 50%;
    }

    .exit-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }

    .btn-primary {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Cookie Popup Styles */
    .cookie-popup {
        display: none;
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: #fff;
        padding: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 1000;
    }

    .cookie-popup-content p {
        margin: 0 0 10px;
    }

    .cookie-buttons {
        display: flex;
        gap: 10px;
    }

    .manage-cookies-btn,
    .decline-cookies-btn,
    .accept-cookies-btn {
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .accept-cookies-btn {
        background: #28a745;
        color: #fff;
    }

    .decline-cookies-btn {
        background: #dc3545;
        color: #fff;
    }

    .manage-cookies-btn {
        background: #007bff;
        color: #fff;
    }

    /* Manage Cookies Modal */
    .cookie-settings {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 20px;
        width: 300px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        z-index: 1001;
    }

    .cookie-settings-content label {
        display: block;
        margin: 10px 0;
    }

    .cookie-settings-buttons {
        text-align: center;
        margin-top: 10px;
    }
</style>
<style>
    .btn-primary {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Popup Styles */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 20px;
        text-align: center;
        width: 90%;
        max-width: 700px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .popup-content h2 {
        margin: 0 0 10px;
    }

    .popup-content p {
        margin: 10px 0;
        font-size: 16px;
    }

    .popup-content button {
        background: #28a745;
        color: #fff;
        border: none;
        padding: 10px 20px;
        margin-top: 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .popup-content button:hover {
        background: #218838;
    }
</style>
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
<script src="//code.tidio.co/pdlttcw8ou8viyfubcpwldzw3ygd2kke.js" async></script>

<body>
    <!-- PRELOADER SPINNER
		============================================= -->
    <div id="loading" class="loading--theme">
        <div id="loading-center"><span class="loader"></span></div>
    </div>

    <!-- PAGE CONTENT
		============================================= -->
    <div id="page" class="page font--jakarta">



        <!-- BOX CONTENT
			============================================= -->
        <section id="lnk-2" class="pt-100 ws-wrapper content-section">
            <div class="container">
                <div class="bc-5-wrapper bg--04 hidd bg--scroll r-16">
                    <div class="section-overlay">
                        <!-- SECTION TITLE -->
                        <div class="row justify-content-center">
                            <div class="col-md-11 col-lg-9">
                                <div class="section-title wow fadeInUp mb-60">
                                    <!-- Title -->
                                    <h2 class="s-50 w-700">What is Executor Hub?</h2>

                                    <!-- Text -->
                                    <p class="p-xl">Executor Hub was founded with the mission to empower individuals to
                                        seamlessly manage their digital and financial legacies through a secure,
                                        reliable, and user-friendly platform. In today’s world, where digital solutions
                                        are the emerging trend, we ensure your legacy is preserved and accessible for
                                        future generations.</p>
                                    <br />
                                    <a href="{{route('login')}}"
                                        class="btn r-04 btn--theme hover--tra-white last-link">Login to your
                                        Dashboard.</a>
                                </div>
                            </div>
                        </div>

                        <!-- IMAGE BLOCK -->
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="bc-5-img bc-5-tablet img-block-hidden video-preview wow fadeInUp">
                                    <!-- Play Icon -->
                                    <a class="video-popup1" href="{{ asset('assets/frontend/intro.mp4') }}">
                                        <div class="video-btn video-btn-xl bg--theme">
                                            <div class="video-block-wrapper"><span class="flaticon-play-button"></span>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Preview Image -->
                                    <img class="img-fluid" src="{{asset('assets/frontend/main-card.webp')}}"
                                        alt="content-image" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End section overlay -->
                </div>
                <!-- End content wrapper -->
            </div>
            <!-- End container -->
        </section>
        <!-- END BOX CONTENT -->

        <section id="hero-8" class="bg--fixed hero-section" style="margin-top:100px;">
            <div class="container">
                <div class="row d-flex align-items-center">


                    <div class="col-md-12">
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
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Email:</strong>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Enter Email" required>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <strong>Password:</strong>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Enter Password" required>
                                    </div>

                                    <input type="hidden" name="assigned_to" id="assigned_to">


                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Address Line 1:</strong>
                                            <input type="text" class="form-control" name="address_line1"
                                                id="address_line1" placeholder="Enter Address Line 1" required>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>City:</strong>
                                            <input type="text" class="form-control" name="city" id="city"
                                                placeholder="Enter City" required>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Postal Code:</strong>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code"
                                                placeholder="Enter Postal Code" required>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Country:</strong>
                                            <input type="text" class="form-control" name="country" id="country"
                                                placeholder="Enter Country" required>
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
                                        <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                            placeholder="Enter Coupon Code" readonly>
                                    </div>

                                    <div class="form-group">
                                    <label class="col-form-label">Where Did You Hear About Us?</label>
                                    <select class="form-control" name="hear_about_us" id="hear_about_us" required>
                                        <option value="">Choose Option</option>
                                        <option value="Social Media">Social Media (Facebook, Instagram, LinkedIn, etc.)
                                        </option>
                                        <option value="Google Search">Google Search</option>
                                        <option value="Adviser / Estate Planner">Adviser / Estate Planner</option>
                                        <option value="Solicitor / Law Firm">Solicitor / Law Firm</option>
                                        <option value="Financial Adviser / IFA">Financial Adviser / IFA</option>
                                        <option value="Trade Union / Membership Group">Trade Union / Membership Group
                                        </option>
                                        <option value="Employer / Workplace Benefit">Employer / Workplace Benefit
                                        </option>
                                        <option value="Friend or Family">Friend or Family</option>
                                        <option value="Webinar / Event / Presentation">Webinar / Event / Presentation
                                        </option>
                                        <option value="Email Campaign">Email Campaign</option>
                                        <option value="Partner Referral">Partner Referral</option>
                                        <option value="Press / News Article">Press / News Article</option>
                                        <option value="Other">Other (please specify)</option>
                                    </select>
                                </div>

                                <div class="form-group" id="otherFieldDiv" style="display: none;">
                                    <label class="col-form-label">Please specify:</label>
                                    <input type="text" class="form-control" name="other_hear_about_us"
                                        placeholder="Enter details">
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
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg"
                                                        alt="Stripe" class="payment-logo me-3" style="height: 40px;">
                                                    <div>
                                                        <h6 class="mb-1">Pay with Stripe</h6>
                                                        <small class="text-muted">Secure credit/debit card
                                                            payment</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PayPal Option -->
                                        <div class="col-md-6">
                                            <div class="payment-option border p-3 rounded" data-method="paypal">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://www.paypalobjects.com/webstatic/i/logo/rebrand/ppcom.svg"
                                                        alt="PayPal" class="payment-logo me-3" style="height: 40px;">
                                                    <div>
                                                        <h6 class="mb-1">Pay with PayPal</h6>
                                                        <small class="text-muted">Pay safely with your PayPal
                                                            account</small>
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


                </div> <!-- End row -->
            </div> <!-- End container -->


            <!-- WAVE SHAPE BOTTOM -->
            <div class="wave-shape-bottom">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 165">
                    <path fill-opacity="1"
                        d="M0,160L120,154.7C240,149,480,139,720,128C960,117,1200,107,1320,101.3L1440,96L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z">
                    </path>
                </svg>
            </div>


        </section>


        <!-- TEXT CONTENT
			============================================= -->
        <section class="pt-100 ct-02 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/legacies.jpg')}}"
                                alt="content-image" />
                        </div>
                    </div>

                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft">
                            <!-- Section ID -->
                            <span class="section-id">Executor Hub</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Empowering executors, ensuring legacies</h2>

                            <!-- Text -->
                            <p>Executor Hub is a secure web application designed to streamline the estate execution
                                process. Our platform allows you to organize and store important financial documents,
                                social media passwords, and asset information all in one central, encrypted location.
                                Executors can access this information from any location, enabling them to work remotely
                                with ease. This digital solution is much safer than keeping information on paper, as it
                                reduces the risk of loss, damage, or unauthorized access. You have the flexibility to
                                grant access to your executors at the time of your death or any time prior, should you
                                wish to. With Executor Hub, you can ensure your executors have everything they need,
                                securely and conveniently, making the process as simple and stress-free as possible
                                during a difficult time.</p>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->

        <!-- FEATURES-11
			============================================= -->
        <section id="features-11" class="pt-100 features-section division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-70">
                            <!-- Section ID -->
                            <span class="section-id">Secure Your Legacy</span>

                            <!-- Title -->
                            <h2 class="s-50 w-700">Features of Executor Hub</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">An Online Platform Which Secures Your Information.</p>
                        </div>
                    </div>
                </div>

                <!-- FEATURES-11 WRAPPER -->
                <div class="fbox-wrapper">
                    <div class="row row-cols-1 row-cols-md-2 rows-3">
                        <!-- FEATURE BOX #1 -->
                        <div class="col">
                            <div class="fbox-11 fb-1 wow fadeInUp">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-pdf"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Centralized Storage</h6>
                                    <p>Organize and store all important financial documents, social media passwords, and
                                        asset information in one secure location.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #1 -->

                        <!-- FEATURE BOX #2 -->
                        <div class="col">
                            <div class="fbox-11 fb-2 wow fadeInUp">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-security"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Enhanced Security</h6>
                                    <p>Keep your information safe with top-level encryption, reducing the risk of loss,
                                        damage, or unauthorized access compared to paper storage.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #2 -->

                        <!-- FEATURE BOX #3 -->
                        <div class="col">
                            <div class="fbox-11 fb-3 wow fadeInUp">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-graphic"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Remote Access</h6>
                                    <p>Executors can access the information from any location, allowing them to work
                                        remotely and efficiently.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #3 -->

                        <!-- FEATURE BOX #4 -->
                        <div class="col">
                            <div class="fbox-11 fb-4 wow fadeInUp">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-wireframe"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Simplified Process</h6>
                                    <p>Streamline the estate execution process, making it easier and less stressful for
                                        your executors during a difficult time.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #4 -->

                        <!-- FEATURE BOX #5 -->
                        <div class="col">
                            <div class="fbox-11 fb-5 wow fadeInUp">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-idea"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Memorandum of Wishes</h6>
                                    <p>Leave detailed instructions and wishes to guide your executors in fulfilling your
                                        final requests.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #5 -->

                        <!-- FEATURE BOX #6 -->
                        <div class="col">
                            <div class="fbox-11 fb-6 wow fadeInUp">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-chat"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Messages to Loved Ones</h6>
                                    <p>Include personal messages to be delivered to your loved ones, providing comfort
                                        and closure.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #6 -->

                        <!-- FEATURE BOX #7 -->
                        <div class="col">
                            <div class="fbox-11 fb-6 wow fadeInUp mt-4">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-video-player"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Capacity Proof Videos</h6>
                                    <p>Record Capcity Proof Videos for your Will and LPA with ease.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #7 -->

                        <!-- FEATURE BOX #7 -->
                        <div class="col">
                            <div class="fbox-11 fb-6 wow fadeInUp mt-4">
                                <!-- Icon -->
                                <div class="fbox-ico-wrap">
                                    <div class="fbox-ico ico-50">
                                        <div class="shape-ico color--theme">
                                            <!-- Vector Icon -->
                                            <span class="flaticon-network"></span>

                                            <!-- Shape -->
                                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z"
                                                    transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">AI Assistance</h6>
                                    <p>Executor Hub AI Provides assistance for using the Portal.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #7 -->



                    </div>
                    <!-- End row -->
                </div>
                <!-- END FEATURES-11 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END FEATURES-11 -->


        <!-- STATISTIC-1
			============================================= -->
        <div id="benefits-11" class="py-100 statistic-section division">
            <div class="container">
                <!-- STATISTIC-1 WRAPPER -->
                <div class="statistic-1-wrapper">
                    <div class="row justify-content-md-center row-cols-1 row-cols-md-3">
                        <!-- STATISTIC BLOCK #1 -->
                        <div class="col">
                            <div id="sb-1-1" class="wow fadeInUp">
                                <div class="statistic-block">
                                    <!-- Digit -->
                                    <div class="statistic-block-digit text-center">
                                        <h2 class="s-46 statistic-number"><span class="count-element">89</span>k</h2>
                                    </div>

                                    <!-- Text -->
                                    <div class="statistic-block-txt color--grey">
                                        <p class="p-md">Customers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END STATISTIC BLOCK #1 -->

                        <!-- STATISTIC BLOCK #2 -->
                        <div class="col">
                            <div id="sb-1-2" class="wow fadeInUp">
                                <div class="statistic-block">
                                    <!-- Digit -->
                                    <div class="statistic-block-digit text-center">
                                        <h2 class="s-46 statistic-number"><span class="count-element">276</span>K</h2>
                                    </div>

                                    <!-- Text -->
                                    <div class="statistic-block-txt color--grey">
                                        <p class="p-md">Records</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END STATISTIC BLOCK #2 -->

                        <!-- STATISTIC BLOCK #3 -->
                        <div class="col">
                            <div id="sb-1-3" class="wow fadeInUp">
                                <div class="statistic-block">
                                    <!-- Digit -->
                                    <div class="statistic-block-digit text-center">
                                        <h2 class="s-46 statistic-number"><span class="count-element">4</span>.<span
                                                class="count-element">93</span></h2>
                                    </div>

                                    <!-- Text -->
                                    <div class="statistic-block-txt color--grey">
                                        <p class="p-md">Rating</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END STATISTIC BLOCK #3 -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- END STATISTIC-1 WRAPPER -->
            </div>
            <!-- End container -->
        </div>
        <!-- END STATISTIC-1 -->

        <!-- TEXT CONTENT
			============================================= -->
        <section class="bg--white-400 py-100 ct-04 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- TEXT BLOCK -->
                    <div class="col-md-6 order-last order-md-2">
                        <div class="txt-block left-column wow fadeInRight">
                            <h2>Benefits of Executor Hub</h2>
                            <!-- CONTENT BOX #1 -->
                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">1</div>
                                    <span class="cbox-2-line"></span>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">Digital Legacy Planning</h5>
                                    <p>Manage your digital legacy by including instructions for online accounts and
                                        digital assets.</p>
                                </div>
                            </div>
                            <!-- END CONTENT BOX #1 -->

                            <!-- CONTENT BOX #2 -->
                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">2</div>
                                    <span class="cbox-2-line"></span>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">24/7 Availability</h5>
                                    <p>Access your stored information anytime, ensuring your executors can retrieve
                                        necessary details whenever needed.</p>
                                </div>
                            </div>
                            <!-- END CONTENT BOX #2 -->

                            <!-- CONTENT BOX #3 -->
                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">3</div>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">Audit Trail</h5>
                                    <p class="mb-0">Maintain a record of all updates and access activities, providing
                                        transparency and accountability.</p>
                                </div>
                            </div>

                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">4</div>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">Cost Efficiency</h5>
                                    <p class="mb-0">Save money by avoiding the need for physical document storage
                                        solutions and minimizing the potential for lost paperwork.</p>
                                </div>
                            </div>

                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">5</div>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">Environmental Impact</h5>
                                    <p class="mb-0">Reduce your environmental footprint by eliminating the need for
                                        paper documents.</p>
                                </div>
                            </div>

                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">6</div>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">User-Friendly Interface</h5>
                                    <p class="mb-0">Enjoy an intuitive and easy-to-navigate platform, making it simple
                                        to manage your information.</p>
                                </div>
                            </div>
                            <!-- END CONTENT BOX #3 -->
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->

                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6 order-first order-md-2">
                        <div class="img-block wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/demo.jpg')}}"
                                alt="content-image" />
                        </div>
                    </div>
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->

        <!-- TEXT CONTENT
			============================================= -->
        <section class="pt-100 ct-01 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- TEXT BLOCK -->
                    <div class="col-md-6 order-last order-md-2">
                        <div class="txt-block left-column wow fadeInRight">
                            <!-- Section ID -->
                            <span class="section-id">Easy Onboarding</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Achieve more with better workflows</h2>

                            <!-- Text -->
                            <p>
                                Executor Hub allows a user-friendly interface for managing your documents, executors and
                                assets. You can easily login to the portal at any time and get your work done with ease.
                            </p>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700">Get more done in less time</h5>

                            <!-- List -->
                            <ul class="simple-list">
                                <li class="list-item">
                                    <p>Easy to use portal with runtime configurations.</p>
                                </li>

                                <li class="list-item">
                                    <p class="mb-0">Easily accessible from anywhere, anytime.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->

                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6 order-first order-md-2">
                        <div class="img-block right-column wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/onboarding.png')}}"
                                alt="content-image" />
                        </div>
                    </div>
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->


        <!-- FAQs-3
			============================================= -->
        <section id="faqs-3" class="pt-100 faqs-section">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-80">
                            <!-- Title -->
                            <h2 class="s-50 w-700">Questions & Answers</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">Frequently asked questions about Executor Hub.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQs-3 QUESTIONS -->
                <div class="faqs-3-questions">
                    <div class="row">
                        <!-- QUESTIONS HOLDER -->
                        <div class="col-lg-6">
                            <div class="questions-holder">
                                <!-- QUESTION #1 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>1.</span> What is Executor Hub?</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">Executor Hub is a secure web application designed to help
                                        individuals organize and store important financial documents, social media
                                        passwords, and asset information in one central, encrypted location. It ensures
                                        that all your essential information is readily accessible for your executors.
                                    </p>
                                </div>

                                <!-- QUESTION #2 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>2.</span> How can Executor Hub benefit me?</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">Executor Hub simplifies the process of managing your digital
                                        and financial legacy. By securely storing your sensitive information, Executor
                                        Hub ensures that your loved ones can easily access and manage your affairs in
                                        the event of incapacity or after your passing, reducing stress and confusion
                                        during difficult times.</p>
                                </div>

                                <!-- QUESTION #3 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>3.</span> Is Executor Hub secure?</h5>

                                    <!-- Answer -->
                                    <p>Yes, security is our top priority. Executor Hub uses state-of-the-art encryption
                                        and advanced security measures to protect your data from unauthorized access,
                                        ensuring your information remains private and secure.</p>
                                </div>


                                <!-- QUESTION #4 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>4.</span> Can I share access with family members or
                                        trusted individuals?</h5>

                                    <!-- Answer -->
                                    <p>Yes, Executor Hub allows you to designate trusted contacts who can access your
                                        information in case of emergency or incapacity. This ensures that the right
                                        people have access when it’s needed most.</p>
                                </div>

                                <!-- QUESTION#5 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>5.</span> What types of documents and information can I
                                        store on Executor Hub?</h5>
                                    <p>You can store a wide range of documents, including wills, trusts, insurance
                                        policies, investment accounts, social media account details, digital asset
                                        information, personal messages to loved ones, and more.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>6.</span> How often can I update my information on
                                        Executor Hub?</h5>
                                    <p>You can update your information as often as needed. Executor Hub makes it easy to
                                        keep your documents and details current, reflecting any changes in your
                                        circumstances.</p>
                                </div>


                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>7.</span> How does Executor Hub handle privacy and
                                        confidentiality?</h5>
                                    <p>Executor Hub is committed to maintaining your privacy and confidentiality. We
                                        adhere to strict privacy policies and utilize robust security measures to
                                        safeguard your information at all times.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>8.</span> Can Executor Hub assist with organizing
                                        non-financial aspects of my estate?</h5>
                                    <p>Yes, in addition to financial documents, Executor Hub allows you to store and
                                        organize non-financial aspects such as personal letters, family traditions, and
                                        other important details you wish to pass on.</p>
                                </div>



                            </div>
                        </div>
                        <!-- END QUESTIONS HOLDER -->

                        <!-- QUESTIONS WRAPPER -->
                        <div class="col-lg-6">
                            <div class="questions-holder">


                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>9.</span> What happens to my data if Executor Hub
                                        ceases operations?</h5>
                                    <p>In the unlikely event that Executor Hub ceases operations, your data remains
                                        secure and accessible to you. We have contingency plans in place to ensure
                                        continuity and access to your information.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>10.</span> How can I get support if I have questions or
                                        issues using Executor Hub?</h5>
                                    <p>We provide dedicated customer support to assist you with any questions or issues.
                                        You can reach out to our support team via email or through our helpdesk for
                                        prompt assistance.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>11.</span> Can Executor Hub integrate with other estate
                                        planning services or platforms?</h5>
                                    <p>Yes, Executor Hub is designed to complement other estate planning services and
                                        platforms. We offer integration options to streamline your overall estate
                                        planning process.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>12.</span> Is there a cost associated with using
                                        Executor Hub?</h5>
                                    <p>Executor Hub offers different subscription plans tailored to meet your needs. We
                                        provide transparent pricing information on our website, including any additional
                                        fees for premium features or storage capacities.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>13.</span> How is my data secure?</h5>
                                    <p>Yes, your data security is of utmost importance to us at Executor Hub. We employ
                                        several layers of security measures to protect your information:</p>
                                    <ul>
                                        <li><b>Encryption: </b>All sensitive data, including passwords and stored
                                            documents, are encrypted using advanced encryption algorithms. This means
                                            that your data is transformed into unreadable ciphertext, which can only be
                                            decrypted with a specific key held only by authorized parties.</li>
                                        <li><b>Password Security: </b> User passwords are hashed before being stored in
                                            our database. Hashing is a one-way cryptographic process that converts
                                            passwords into a fixed-length string of characters. This ensures that even
                                            if our database were compromised, passwords cannot be easily reversed or
                                            deciphered.</li>
                                        <li><b>Secure Authentication:</b> When you log into Executor Hub, we use secure
                                            protocols and hashing techniques to verify your identity. This prevents
                                            unauthorized access by ensuring that only you or your designated contacts
                                            can access your account.</li>
                                        <li><b>Data Access Controls:</b> We implement strict access controls and
                                            authentication mechanisms to limit who can access your stored information.
                                            This includes multi-factor authentication options for added security.</li>
                                        <li><b></b></li>
                                    </ul>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>14.</span> How many Documents can I upload?</h5>
                                    <p>You can upload unlimited documents. However, there is a limitation of document
                                        size. Each document, picture or video should not exceed the maximum size limit
                                        of 100 MB.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>15.</span>Can I use one email for multiple roles on
                                        Executor Hub?</h5>
                                    <p>No, Executor Hub allows only one email per role. For example, if you are a
                                        Customer and want to nominate yourself as an executor. Then you will have to
                                        choose unique emails for both roles.</p>
                                </div>

                            </div>
                        </div>
                        <!-- END QUESTIONS HOLDER -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- END FAQs-3 QUESTIONS -->

                <!-- MORE QUESTIONS LINK -->
                <div class="row">
                    <div class="col">
                        <div class="more-questions mt-40">
                            <div class="more-questions-txt bg--white-400 r-100">
                                <p class="p-lg">
                                    Download the App on App Store <i class="fa-brands fa-app-store-ios"></i>
                                    <a href="https://apps.apple.com/us/app/executor-hub/id6737507623" target="_blank"
                                        class="color--theme">Download App</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End container -->
        </section>
        <!-- END FAQs-3 -->





        <!-- DIVIDER LINE -->
        <hr class="divider" />

        <section class="pt-100 ct-02 content-section division" id="digitallegacy">
            <div class="container">


                <div class="row">

                    <div class="section-title text-center mb-80">
                        <!-- Title -->
                        <h2 class="s-52 w-700">
                            Digital legacies and their policies</h2>

                        <!-- Text -->
                        <p class="p-lg">A guide to estate planning for digital assets</p>
                    </div>
                    <!-- Left Column -->
                    <div class="col-md-6 border-end">
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2"
                            onclick="selectItem('Google')">
                            Google
                        </button>
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2"
                            onclick="selectItem('Facebook')">
                            Facebook
                        </button>
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2"
                            onclick="selectItem('Instagram')">
                            Instagram
                        </button>
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2" onclick="selectItem('Apple')">
                            Apple
                        </button>
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2"
                            onclick="selectItem('Linkedin')">
                            LinkedIn
                        </button>
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2" onclick="selectItem('Avios')">
                            Avios
                        </button>
                        <button class="btn btn--theme hover--theme w-100 text-start mb-2"
                            onclick="selectItem('Twitter')">
                            X (Twitter)
                        </button>
                    </div>

                    <!-- Right Column -->
                    <div id="displayText"
                        class="col-md-6 d-flex align-items-center justify-content-center text-secondary">
                        Select an Asset to see details here.
                    </div>
                </div>


            </div> <!-- End container -->
        </section>

        <!-- FOOTER-3
			============================================= -->
        <footer id="footer-3" class="pt-100 footer ft-3-ntr">
            <div class="container">
                <!-- FOOTER CONTENT -->
                <div class="row">
                    <!-- FOOTER LOGO -->
                    <div class="col-xl-3">
                        <div class="footer-info">
                            <img class="footer-logo" src="{{asset('assets/frontend/images/logo-skyblue.png')}}"
                                alt="footer-logo" />
                            <img class="footer-logo-dark"
                                src="{{asset('assets/frontend/images/logo-skyblue-white.png')}}" alt="footer-logo" />
                        </div>
                    </div>

                    <!-- FOOTER LINKS -->
                    <div class="col-sm-4 col-lg-3 col-xl-2">

                    </div>
                    <!-- END FOOTER LINKS -->

                    <!-- FOOTER LINKS -->
                    <div class="col-sm-4 col-lg-2">
                        <div class="footer-links fl-2">
                            <!-- Title -->
                            <h6 class="s-17 w-700">Product</h6>

                            <!-- Links -->
                            <ul class="foo-links clearfix">
                                <li>
                                    <p><a href="#features-11">Features</a></p>
                                </li>
                                <li>
                                    <p><a href="#faqs-3">FAQ's</a></p>
                                </li>
                                <li>
                                    <p><a href="https://apps.apple.com/us/app/executor-hub/id6737507623"
                                            target="_blank">Download From AppStore</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END FOOTER LINKS -->

                    <!-- FOOTER LINKS -->
                    <div class="col-sm-4 col-lg-3 col-xl-2">
                        <div class="footer-links fl-3">
                            <!-- Title -->
                            <h6 class="s-17 w-700">Legal</h6>

                            <!-- Links -->
                            <ul class="foo-links clearfix">
                                <li>
                                    <p><a href="{{route('terms_of_use')}}">Terms of Use</a></p>
                                </li>
                                <li>
                                    <p><a href="{{route('privacy_policy')}}">Privacy Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="{{route('pricing_policy')}}">Pricing Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="{{route('cookies')}}">Cookie Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="{{route('cancellation_policy')}}">Cancellation Policy</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END FOOTER LINKS -->

                    <!-- FOOTER NEWSLETTER FORM -->
                    <div class="col-sm-10 col-md-8 col-lg-4 col-xl-3">
                        <div class="footer-form">
                            <!-- Title -->
                            <h6 class="s-17 w-700">Subscribe to our newsletter</h6>

                            <!-- Newsletter Form Input -->
                            <form class="newsletter-form">
                                <div class="input-group r-06">
                                    <input type="email" class="form-control" placeholder="Email Address" required
                                        id="s-email" />
                                    <span class="input-group-btn ico-15">
                                        <button type="submit" class="btn color--theme">
                                            <span class="flaticon-right-arrow-1"></span>
                                        </button>
                                    </span>
                                </div>

                                <!-- Newsletter Form Notification -->
                                <label for="s-email" class="form-notification"></label>
                            </form>
                        </div>
                    </div>
                    <!-- END FOOTER NEWSLETTER FORM -->
                </div>
                <!-- END FOOTER CONTENT -->

                <hr />
                <!-- FOOTER DIVIDER LINE -->

                <!-- BOTTOM FOOTER -->
                <div class="bottom-footer">
                    <div class="row row-cols-1 row-cols-md-2 d-flex align-items-center">
                        <!-- FOOTER COPYRIGHT -->
                        <div class="col">
                            <div class="footer-copyright">
                                <p class="p-sm">&copy; 2024 Executor Hub. <span>All Rights Reserved</span></p>
                            </div>
                        </div>

                        <!-- FOOTER SOCIALS -->
                        <div class="col">
                            <ul class="bottom-footer-socials ico-20 text-end">
                                <li>
                                    <a href="#"><span class="flaticon-facebook"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="flaticon-twitter"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="flaticon-instagram"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="flaticon-youtube"></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End row -->
                </div>
                <!-- END BOTTOM FOOTER -->
            </div>
            <!-- End container -->
        </footer>
        <!-- END FOOTER-3 -->

    </div>
    <!-- END PAGE CONTENT -->

    <!-- EXTERNAL SCRIPTS
		============================================= -->
    <script src="{{ asset('assets/frontend/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.easing.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/menu.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/pricing-toggle.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/request-form.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/lunar.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wow.js') }}"></script>

    <!-- Custom Script -->
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <script src="{{ asset('assets/frontend/js/changer.js') }}"></script>
    <script defer src="{{ asset('assets/frontend/js/styleswitch.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Payment method selection
            $('.payment-option').click(function () {
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
            $('#stripe-form').submit(function (e) {
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
            $('#paypal-form').submit(function (e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                copyFormData($(this));
            });
        });
    </script>

    <script>
        function selectItem(item) {
            let text = "";
            if (item === "Google") {
                text = "Google has a pre-planning tool called “Inactive account manager” which allows the user to set up a nominated individual to access their Google account if they have not logged in after a set period of time. It is therefore important to set up this service if you wish to allow family members to access the relevant information they may need in your Google account. Google accounts can also be closed down via the Inactive account manager page.";
            } else if (item === "Facebook") {
                text = "Facebook provides a legacy contact feature which allows the contact to memorialise and look after the deceased individual’s profile. This includes writing a new pinned post, removing/editing old posts and reading messages. It is therefore essential to only nominate an individual as a legacy contact which someone you would be comfortable sharing this information with after you have passed away. Facebook also has the ability to deactivate a deceased individual’s account in order to prevent fraud and spam. Both of these services can be set up through the Facebook help centre.";
            } else if (item === "Instagram") {
                text = "Instagram offers a memorialisation service, which allows a deceased individual’s account to stay online without the risk of fraud or unwanted changes to your account. It is therefore important to make clear in your wishes if you would want this. Alternatively, the account can be closed and your family will need your Instagram handle and request to close it via their help centre.";
            } else if (item === "Apple") {
                text = "Apple offers a pre-planning tool called “legacy contact” which allows nominated trusted individuals of your choosing to access your account after you have passed away. The legacy contact feature can be very helpful as without it in place family members will need a court order to gain access to a loved one’s Apple account. Apple accounts can also be deactivated to prevent fraud via the help centre.";
            } else if (item === "Linkedin") {
                text = "LinkedIn offers a memorialisation service, which allows a deceased individual’s account to stay online without the risk of fraud or unwanted changes to your account. It is therefore important to make clear in your wishes if you would want this. Alternatively, the account can be closed. Your family will need your LinkedIn URL, death certificate and legal authorisation document to either memorialise or close your account via LinkedIn’s help centre.";
            } else if (item === "Avios") {
                text = "Membership will terminate automatically upon the death of a member, Points accumulated but unused at the time of death shall be cancelled together with membership of the Scheme.";
            } else if (item === "Twitter") {
                text = "X (Twitter) may automatically close accounts after prolonged periods of inactivity. If you want your account closed before to prevent fraud then your family will need your Twitter handle and request to close it via their help centre.";
            }
            document.getElementById('displayText').innerText = text;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const couponCode = urlParams.get('coupon_code');
            const assignedTo = urlParams.get('assigned_to');

            if (couponCode) {
                document.getElementById('coupon_code').value = couponCode;
            }
            if (assignedTo) {
                document.getElementById('assigned_to').value = assignedTo;
            }
        });
    </script>

<script>
        document.getElementById('hear_about_us').addEventListener('change', function () {
            const otherFieldDiv = document.getElementById('otherFieldDiv');
            if (this.value === 'Other') {
                otherFieldDiv.style.display = 'block';
            } else {
                otherFieldDiv.style.display = 'none';
                otherFieldDiv.querySelector('input').value = ''; // clear field if hidden
            }
        });
    </script>
</body>

</html>