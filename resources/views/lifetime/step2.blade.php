<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SITE TITLE -->
    <title>Lifetime Subscription - Checkout - Executor Hub</title>

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
</head>
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
        <!-- HEADER
			============================================= -->
        <header id="header" class="tra-menu navbar-light white-scroll">
            <div class="header-wrapper">
                <!-- MOBILE HEADER -->
                <div class="wsmobileheader clearfix">
                    <span class="smllogo"><img src="{{asset('assets/frontend/images/logo-skyblue.png')}}"
                            alt="mobile-logo" /></span>
                    <a id="wsnavtoggle" class="wsanimated-arrow"><span></span></a>
                </div>

                <!-- NAVIGATION MENU -->
                <div class="wsmainfull menu clearfix">
                    <div class="wsmainwp clearfix">
                        <!-- HEADER BLACK LOGO -->
                        <div class="desktoplogo">
                            <a href="{{route('home')}}" class="logo-black">
                                <img class="light-theme-img" src="{{asset('assets/frontend/images/logo-skyblue.png')}}"
                                    alt="logo" />
                                <img class="dark-theme-img"
                                    src="{{asset('assets/frontend/images/logo-skyblue-white.png')}}" alt="logo" />
                            </a>
                        </div>

                        <!-- HEADER WHITE LOGO -->
                        <div class="desktoplogo">
                            <a href="{{route('home')}}" class="logo-white"><img
                                    src="{{asset('assets/frontend/images/logo-white.png')}}" alt="logo" /></a>
                        </div>

                        <!-- MAIN MENU -->
                        <nav class="wsmenu clearfix">
                            <ul class="wsmenu-list nav-theme">
                                @guest
                                    <li class="nl-simple" aria-haspopup="true">
                                        <a href="{{route('home')}}"
                                            class="btn r-04 btn--theme hover--tra-white last-link">Home</a>
                                    </li>
                                @else
                                    <li class="nl-simple" aria-haspopup="true">
                                        <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('customer') ? 'customer.dashboard' : (auth()->user()->hasRole('partner') ? 'partner.dashboard' : (auth()->user()->hasRole('executor') ? 'executor.dashboard' : 'dashboard')))) }}"
                                            class="btn r-04 btn--theme hover--tra-white last-link">Dashboard</a>
                                    </li>
                                @endguest
                            </ul>
                        </nav>
                        <!-- END MAIN MENU -->
                    </div>
                </div>
                <!-- END NAVIGATION MENU -->
            </div>
            <!-- End header-wrapper -->
        </header>
        <!-- END HEADER -->


        <section id="lifetime-step2-page" class="gr--whitesmoke pb-80 inner-page-hero division">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <!-- INNER PAGE TITLE -->
                        <div class="inner-page-title">
                            <h2 class="s-52 w-700">Lifetime Subscription - Checkout</h2>
                            <p class="p-lg">Complete your information to proceed to secure checkout</p>
                        </div>

                        <!-- PRICING SUMMARY -->
                        <div class="pricing-summary bg--white-100 block-shadow r-12 p-40 mb-40">
                            <h4 class="s-30 w-700 mb-3">Your Selected Plan</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Plan:</strong> {{ $plan_label }}</p>
                                    <p class="mb-2"><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($date_of_birth)->format('d/m/Y') }}</p>
                                    <p class="mb-2"><strong>Age:</strong> {{ $age }} years</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="s-32 w-700 color--theme mb-0">
                                        {{ $currency }} {{ number_format($amount, 2) }}
                                    </p>
                                    <p class="text-muted">One-time payment</p>
                                </div>
                            </div>
                        </div>

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

                        <!-- FORM -->
                        <div class="lifetime-subscription-form bg--white-100 block-shadow r-12 p-40">
                            <form method="POST" action="{{ route('stripe.lifetime') }}" class="row g-3 needs-validation" novalidate style="padding:10px;">
                                @csrf
                                
                                <!-- Hidden fields for step 1 data -->
                                <input type="hidden" name="date_of_birth" value="{{ $date_of_birth }}">
                                <input type="hidden" name="plan_tier" value="{{ $plan_tier }}">

                                <div class="col-md-6">
                                    <label for="lifetimeName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="lifetimeName" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimeEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="lifetimeEmail" name="email"
                                        value="{{ old('email') }}" required>
                                    @error('email', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimePassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="lifetimePassword" name="password"
                                        minlength="8" value="{{ old('password') }}" required>
                                    <small class="form-text text-muted">Minimum 8 characters.</small>
                                    @error('password', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimeCoupon" class="form-label">Coupon Code (Optional)</label>
                                    <input type="text" class="form-control" id="lifetimeCoupon" name="coupon_code"
                                        value="{{ old('coupon_code') }}">
                                    @error('coupon_code', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="lifetimeAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="lifetimeAddress" name="address"
                                        value="{{ old('address') }}" required>
                                    @error('address', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lifetimeCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="lifetimeCity" name="city"
                                        value="{{ old('city') }}" required>
                                    @error('city', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lifetimePostalCode" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="lifetimePostalCode" name="postal_code"
                                        value="{{ old('postal_code') }}" required>
                                    @error('postal_code', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lifetimeCountry" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="lifetimeCountry" name="country"
                                        value="{{ old('country') }}" required>
                                    @error('country', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimeHearAboutUs" class="form-label">Where did you hear about us?</label>
                                    <select class="form-select" id="lifetimeHearAboutUs" name="hear_about_us">
                                        <option value="" selected disabled>Select an option</option>
                                        @php
                                            $hearAboutOptions = [
                                                'Friend or Family',
                                                'Social Media',
                                                'Events or Conferences',
                                                'Search Engine',
                                                'News or Media',
                                                'Other',
                                            ];
                                            $selectedHearAbout = old('hear_about_us');
                                        @endphp
                                        @foreach ($hearAboutOptions as $option)
                                            <option value="{{ $option }}" {{ $selectedHearAbout === $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hear_about_us', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12" id="lifetimeHearAboutOtherWrapper"
                                    style="display: {{ old('hear_about_us') === 'Other' ? 'block' : 'none' }};">
                                    <label for="lifetimeHearAboutOther" class="form-label">Please specify</label>
                                    <input type="text" class="form-control" id="lifetimeHearAboutOther"
                                        name="other_hear_about_us" value="{{ old('other_hear_about_us') }}">
                                    @error('other_hear_about_us', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <a href="{{ route('home') }}#pricing-1" class="btn btn-outline-secondary btn-lg r-04 me-3">Back</a>
                                    <button type="submit" class="btn btn--theme btn-lg r-04">
                                        Proceed to Secure Checkout
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- End row -->
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
                    <div class="row">
                        <div class="col-md-12">
                            <iframe src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent" style="border:none;height:132px;width:132px;"></iframe>
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

    <script>
        $(document).on({
            contextmenu: function (e) {
                e.preventDefault();
            },
            mousedown: function (e) {
                console.log("normal mouse down:", e.which);
            },
            mouseup: function (e) {
                console.log("normal mouse up:", e.which);
            },
        });

        // Show/hide "Other" field based on hear_about_us selection
        $(document).ready(function() {
            $('#lifetimeHearAboutUs').on('change', function() {
                if ($(this).val() === 'Other') {
                    $('#lifetimeHearAboutOtherWrapper').slideDown();
                } else {
                    $('#lifetimeHearAboutOtherWrapper').slideUp();
                }
            });
        });
    </script>

    <script>
        $(function () {
            $(".switch").click(function () {
                $("body").toggleClass("theme--dark");
                if ($("body").hasClass("theme--dark")) {
                    $(".switch").text("Light Mode");
                } else {
                    $(".switch").text("Dark Mode");
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            if ($("body").hasClass("theme--dark")) {
                $(".switch").text("Light Mode");
            } else {
                $(".switch").text("Dark Mode");
            }
        });
    </script>
    <script src="{{ asset('assets/frontend/js/changer.js') }}"></script>
    <script defer src="{{ asset('assets/frontend/js/styleswitch.js') }}"></script>
</body>

</html>

