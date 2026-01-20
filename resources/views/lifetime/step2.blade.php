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
    <style>
        .plan-option {
            transition: all 0.3s ease;
        }

        .plan-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .plan-option.border-primary {
            box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>
<script src="//code.tidio.co/pdlttcw8ou8viyfubcpwldzw3ygd2kke.js" async></script>
<style>
    .plan-option {
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0 !important;
    }

    .plan-option:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .plan-option.border-primary {
        border-color: #007bff !important;
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3) !important;
    }
</style>

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

                        <!-- PLAN SELECTION -->
                        <!-- PLAN SELECTION -->
                        <div class="plan-selection bg--white-100 block-shadow r-12 p-40 mb-40">
                            <h4 class="s-30 w-700 mb-3">Select Your Lifetime Plan</h4>
                            <p class="mb-4">Date of Birth:
                                <strong>{{ \Carbon\Carbon::parse($date_of_birth)->format('d/m/Y') }}</strong> | Age:
                                <strong>{{ $age }} years</strong>
                            </p>

                            <div class="row g-4 mb-4">
                                @foreach($plans as $index => $plan)
                                    <div class="col-md-4">
                                        <div class="plan-option card h-100 position-relative {{ old('plan_tier') === $plan['tier'] ? 'border-primary border-2' : '' }}"
                                            style="cursor: pointer; transition: all 0.3s; border: 2px solid #e0e0e0;"
                                            onclick="selectPlan('{{ $plan['tier'] }}', '{{ $plan['label'] }}', {{ $plan['amount'] }}, '{{ $plan['currency'] }}', '{{ $plan['price_id'] }}', this)">

                                            @if($plan['tier'] === 'standard')
                                                <span
                                                    style="position: absolute; top: -12px; right: 20px; background: #ffc107; color: #000; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">Most
                                                    Popular</span>
                                            @endif

                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    <div style="font-size: 32px; margin-bottom: 10px;">⭐</div>
                                                    <h5 class="s-22 w-700 mb-3">{{ $plan['label'] }}</h5>
                                                    <p class="s-32 w-700 color--theme mb-2">
                                                        {{ $plan['currency'] }} {{ number_format($plan['amount'], 2) }}
                                                    </p>
                                                    <p class="text-muted small mb-0">One-time payment</p>
                                                </div>

                                                <div style="text-align: left; font-size: 14px; line-height: 1.6;">
                                                    @if($plan['tier'] === 'basic')
                                                        <p><strong>Protect what matters most — safely stored and always
                                                                accessible.</strong></p>
                                                        <p class="mb-3">Includes all essential tools to organise your key
                                                            documents, list your assets and liabilities, and ensure your
                                                            executors can easily find everything when the time comes.</p>
                                                        <p class="mb-2"><strong>Perfect for:</strong></p>
                                                        <p class="mb-3">Anyone who wants a secure digital vault for their most
                                                            important documents — without extra features.</p>
                                                        <div
                                                            style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; text-align: center;">
                                                            <p class="mb-0 small">🔒 <strong>One-time payment. No recurring
                                                                    fees.</strong></p>
                                                        </div>
                                                    @elseif($plan['tier'] === 'standard')
                                                        <p><strong>Everything you need to get organised properly — with
                                                                professional support.</strong></p>
                                                        <p class="mb-3">Includes everything in Basic plus secure collaboration
                                                            with your adviser, step-by-step checklists, guided estate
                                                            organisation, and smart reminders to keep everything up to date.</p>
                                                        <p class="mb-2"><strong>Perfect for:</strong></p>
                                                        <p class="mb-3">People who want confidence and guidance to get it right,
                                                            first time — without overwhelm.</p>
                                                        <div
                                                            style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; text-align: center;">
                                                            <p class="mb-1 small">📌 <strong>Best value for most
                                                                    families.</strong></p>
                                                            <p class="mb-0 small">🔒 <strong>One-time payment. No recurring
                                                                    fees.</strong></p>
                                                        </div>
                                                    @elseif($plan['tier'] === 'premium')
                                                        <p><strong>Complete peace of mind for your loved ones — with full legacy
                                                                protection.</strong></p>
                                                        <p class="mb-3">Everything in Standard plus: advanced wishes, personal
                                                            messages, life notes, gifts and donations, and priority support for
                                                            your executors. Plan beyond paperwork and leave a lasting legacy.
                                                        </p>
                                                        <p class="mb-2"><strong>Perfect for:</strong></p>
                                                        <p class="mb-3">Those who want their family fully protected — and want
                                                            their wishes to be perfectly understood.</p>
                                                        <div
                                                            style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; text-align: center;">
                                                            <p class="mb-1 small">💙 <strong>Save your family stress, time and
                                                                    uncertainty.</strong></p>
                                                            <p class="mb-0 small">🔒 <strong>One-time payment. No recurring
                                                                    fees.</strong></p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div id="selectedPlanSummary" class="alert alert-info" style="display: none;">
                                <h6 class="mb-2">Selected Plan: <span id="selectedPlanLabel"></span></h6>
                                <p class="mb-0">Price: <strong id="selectedPlanPrice"></strong> (One-time payment)</p>
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
                        <div class="lifetime-subscription-form bg--white-100 block-shadow r-12 p-40" id="checkoutForm"
                            style="display: none;">
                            <h4 class="s-30 w-700 mb-3">
                                @if(isset($is_upgrade) && $is_upgrade)
                                    Upgrade to Lifetime Subscription
                                @else
                                    Complete Your Information
                                @endif
                            </h4>
                            @if(isset($is_upgrade) && $is_upgrade)
                                <div class="alert alert-info mb-3">
                                    <strong>Upgrading your account:</strong> Your existing information has been pre-filled.
                                    You can update your password if you wish, or leave it blank to keep your current
                                    password.
                                </div>
                            @endif
                            <form method="POST" action="{{ route('stripe.lifetime') }}" class="row g-3 needs-validation"
                                novalidate style="padding:10px;">
                                @csrf

                                <!-- Hidden fields for step 1 data and selected plan -->
                                <input type="hidden" name="date_of_birth" id="formDateOfBirth"
                                    value="{{ $date_of_birth }}">
                                <input type="hidden" name="plan_tier" id="formPlanTier"
                                    value="{{ old('plan_tier', '') }}" required>
                                <input type="hidden" name="price_id" id="formPriceId" value="">

                                <div class="col-md-6">
                                    <label for="lifetimeName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="lifetimeName" name="name"
                                        value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                                    @error('name', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimeEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="lifetimeEmail" name="email"
                                        value="{{ old('email', isset($user) ? $user->email : '') }}" {{ isset($is_upgrade) && $is_upgrade ? 'readonly' : '' }} required>
                                    @error('email', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    @if(isset($is_upgrade) && $is_upgrade)
                                        <small class="form-text text-muted">Email cannot be changed during upgrade.</small>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimePassword" class="form-label">
                                        Password
                                        @if(isset($is_upgrade) && $is_upgrade)
                                            <span class="text-muted">(Optional - leave blank to keep current
                                                password)</span>
                                        @endif
                                    </label>
                                    <input type="password" class="form-control" id="lifetimePassword" name="password"
                                        minlength="8" value="{{ old('password') }}" {{ isset($is_upgrade) && $is_upgrade ? '' : 'required' }}>
                                    <small class="form-text text-muted">Minimum 8 characters.</small>
                                    @error('password', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimeCoupon" class="form-label">
                                        Coupon Code <span id="couponRequired"
                                            style="display: none; color: red;">*</span>
                                        <span style="font-weight: normal;">(Optional)</span>
                                    </label>
                                    <input type="text" class="form-control" id="lifetimeCoupon" name="coupon_code"
                                        value="{{ old('coupon_code') }}">
                                    @error('coupon_code', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="lifetimeAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="lifetimeAddress" name="address"
                                        value="{{ old('address', isset($user) ? $user->address : '') }}" required>
                                    @error('address', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lifetimeCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="lifetimeCity" name="city"
                                        value="{{ old('city', isset($user) ? $user->city : '') }}" required>
                                    @error('city', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lifetimePostalCode" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="lifetimePostalCode" name="postal_code"
                                        value="{{ old('postal_code', isset($user) ? $user->postal_code : '') }}"
                                        required>
                                    @error('postal_code', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lifetimeCountry" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="lifetimeCountry" name="country"
                                        value="{{ old('country', isset($user) && isset($user->country) ? $user->country : 'United Kingdom') }}"
                                        required>
                                    @error('country', 'lifetime')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lifetimeHearAboutUs" class="form-label">Where did you hear about
                                        us?</label>
                                    <select class="form-select" id="lifetimeHearAboutUs" name="hear_about_us">
                                        <option value="" selected disabled>Select an option</option>
                                        @php
                                            $hearAboutOptions = [
                                                'Friend or Family',
                                                'Social Media',
                                                'Events or Conferences',
                                                'Search Engine',
                                                'News or Media',
                                                'My adviser recommended me',
                                                'Executor Hub',
                                                'Other',
                                            ];
                                            $selectedHearAbout = old('hear_about_us');
                                        @endphp
                                        @foreach ($hearAboutOptions as $option)
                                            <option value="{{ $option }}" {{ $selectedHearAbout === $option ? 'selected' : '' }}>{{ $option }}
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

                                <div id="partnerSection" style="display:none;">
                                    <div class="col-md-12">
                                        <label class="form-label">
                                            Add Partner? (Your Partner Will Receive an Email with a Sign Up Link to
                                            Register & Avail 30% OFF on Checkout)
                                        </label>
                                        <select class="form-control" name="addCouplePartner" id="addPartnerCheckbox">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>

                                    <div id="partnerFields" style="display: none;">
                                        <div class="col-md-6">
                                            <label class="form-label">Enter Partner Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="partnerName"
                                                name="partner_name">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Enter Partner Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="partnerEmail"
                                                name="partner_email">
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <p>Use forever — every future update included.</p>
                                    <p>Your adviser will continue to support you using Executor Hub.</p>
                                    <p>Secure. ICO registered. Trusted by professionals across the UK.</p>
                                    <iframe
                                        src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                                        style="border:none;height:132px;width:132px;"></iframe>
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <button type="button" onclick="goBack()"
                                        class="btn btn-outline-secondary btn-lg r-04 me-3">Back</button>
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
                            <iframe
                                src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                                style="border:none;height:132px;width:132px;"></iframe>
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
        $(document).ready(function () {
            $('#lifetimeHearAboutUs').on('change', function () {
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

    <script>
        function selectPlan(tier, label, amount, currency, priceId, element) {
            // Update hidden form fields
            document.getElementById('formPlanTier').value = tier;
            document.getElementById('formPriceId').value = priceId;

            // Update selected plan summary
            document.getElementById('selectedPlanLabel').textContent = label;
            document.getElementById('selectedPlanPrice').textContent = currency + ' ' + amount.toFixed(2);
            document.getElementById('selectedPlanSummary').style.display = 'block';

            // Highlight selected plan card
            document.querySelectorAll('.plan-option').forEach(card => {
                card.classList.remove('border-primary', 'border-2');
            });
            if (element) {
                element.classList.add('border-primary', 'border-2');
            }

            // Show checkout form
            document.getElementById('checkoutForm').style.display = 'block';

            // Scroll to form
            document.getElementById('checkoutForm').scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            if (tier === 'standard') {  // <-- make sure tier name matches your DB value
                document.getElementById('partnerSection').style.display = 'block';
            } else {
                document.getElementById('partnerSection').style.display = 'none';
                document.getElementById('addPartnerCheckbox').value = 'No';
                document.getElementById('partnerFields').style.display = 'none';
                document.getElementById('partnerName').removeAttribute('required');
                document.getElementById('partnerEmail').removeAttribute('required');
                document.getElementById('partnerName').value = '';
                document.getElementById('partnerEmail').value = '';
            }
        }

        function goBack() {
            window.location.href = '{{ route("home") }}#pricing-1';
        }

        // Validate form submission - ensure plan is selected
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[action="{{ route("stripe.lifetime") }}"]');
            if (form) {
                form.addEventListener('submit', function (e) {
                    const planTier = document.getElementById('formPlanTier').value;
                    if (!planTier) {
                        e.preventDefault();
                        alert('Please select a plan before proceeding.');
                        return false;
                    }
                });
            }
        });

        // If plan_tier is already set (from old input), auto-select it
        @if(old('plan_tier'))
            document.addEventListener('DOMContentLoaded', function () {
                const planTier = '{{ old("plan_tier") }}';
                @foreach($plans as $plan)
                    @if($plan['tier'] === old('plan_tier'))
                        const planElement = document.querySelector('.plan-option[onclick*="{{ $plan['tier'] }}"]');
                        selectPlan('{{ $plan['tier'] }}', '{{ $plan['label'] }}', {{ $plan['amount'] }}, '{{ $plan['currency'] }}', '{{ $plan['price_id'] }}', planElement);
                    @endif
                @endforeach
                                        });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hearAboutSelect = document.getElementById('lifetimeHearAboutUs');
            const otherWrapper = document.getElementById('lifetimeHearAboutOtherWrapper');
            const couponInput = document.getElementById('lifetimeCoupon');
            const couponRequired = document.getElementById('couponRequired');

            function updateCouponRequirement() {
                const selectedValue = hearAboutSelect.value;

                // Show/hide "Other" field
                if (selectedValue === 'Other') {
                    otherWrapper.style.display = 'block';
                } else {
                    otherWrapper.style.display = 'none';
                }

                // Make coupon required if "My adviser recommended me" is selected
                if (selectedValue === 'My adviser recommended me') {
                    couponInput.setAttribute('required', 'required');
                    couponRequired.style.display = 'inline';
                } else {
                    couponInput.removeAttribute('required');
                    couponRequired.style.display = 'none';
                }
            }

            // Initialize on page load
            updateCouponRequirement();

            // Listen for changes
            hearAboutSelect.addEventListener('change', updateCouponRequirement);
        });
    </script>

    <script>
        document.getElementById('addPartnerCheckbox').addEventListener('change', function () {
            const partnerFields = document.getElementById('partnerFields');
            const partnerName = document.getElementById('partnerName');
            const partnerEmail = document.getElementById('partnerEmail');

            if (this.value === "Yes") {
                partnerFields.style.display = 'flex';
                partnerFields.style.flexWrap = 'wrap';
                partnerName.setAttribute('required', 'required');
                partnerEmail.setAttribute('required', 'required');
            } else {
                partnerFields.style.display = 'none';
                partnerName.removeAttribute('required');
                partnerEmail.removeAttribute('required');
                partnerName.value = '';
                partnerEmail.value = '';
            }
        });
    </script>
</body>

</html>