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

    <!-- CUSTOM STYLES -->
    <style>
        /* Pricing Type Button Styles */
        .pricing-type-btn {
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #007bff !important;
        }

        .pricing-type-btn.active {
            background-color: #007bff !important;
            color: white !important;
            border-color: #007bff !important;
        }

        .pricing-type-btn:not(.active) {
            background-color: white !important;
            color: #007bff !important;
        }

        .pricing-type-btn:not(.active):hover {
            background-color: #f8f9fa !important;
        }

        .pricing-type-selector {
            margin-bottom: 40px;
        }

        .pricing-toggle-buttons {
            display: flex;
            gap: 0;
        }

        .pricing-toggle-buttons .btn {
            border-radius: 0;
        }

        .pricing-toggle-buttons .btn:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .pricing-toggle-buttons .btn:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Exit Popup Styles */
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

        /* Button Primary Styles */
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

        /* Welcome Popup Styles */
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

                <!-- COOKIE POP UP -->
                <div id="cookie-popup" class="cookie-popup">
                    <div class="cookie-popup-content">
                        <p>We use cookies to improve your experience. By using our website, you agree to our use of
                            cookies. <a href="{{route('cookies')}}">Learn more</a></p>
                        <div class="cookie-buttons">
                            <button id="manage-cookies" class="manage-cookies-btn">Manage</button>
                            <button id="decline-cookies" class="decline-cookies-btn">Decline</button>
                            <button id="accept-cookies" class="accept-cookies-btn">Accept</button>
                        </div>
                    </div>
                </div>

                <!-- Manage Cookies Modal -->
                <div id="cookie-settings" class="cookie-settings">
                    <div class="cookie-settings-content">
                        <h3>Manage Cookies</h3>
                        <label><input type="checkbox" id="essential-cookies" checked disabled> Essential Cookies (Always
                            Enabled)</label>
                        <label><input type="checkbox" id="analytics-cookies"> Analytics Cookies</label>
                        <label><input type="checkbox" id="marketing-cookies"> Marketing Cookies</label>
                        <div class="cookie-settings-buttons">
                            <button id="save-cookie-settings">Save Preferences</button>
                        </div>
                    </div>
                </div>

                <!-- WELCOME POPUP -->
                <div id="welcomePopup" class="popup">
                    <div class="popup-content">
                        <h2>Welcome to Executor Hub!</h2>
                        <p>We're thrilled to have you here! 😊</p>
                        <p><strong>Important:</strong> Our emails might land in your <b>Spam/Junk</b> folder. Please
                            check and mark them as **Secure** to receive important updates!</p>
                        <button onclick="closePopup()">Got it! 👍</button>
                    </div>
                </div>


                <!-- NAVIGATION MENU -->
                <div class="wsmainfull menu clearfix">
                    <div class="wsmainwp clearfix">
                        <!-- HEADER BLACK LOGO -->
                        <div class="desktoplogo">
                            <a href="#hero-3" class="logo-black">
                                <img class="light-theme-img" src="{{asset('assets/frontend/images/logo-skyblue.png')}}"
                                    alt="logo" />
                                <img class="dark-theme-img"
                                    src="{{asset('assets/frontend/images/logo-skyblue-white.png')}}" alt="logo" />
                            </a>
                        </div>

                        <!-- HEADER WHITE LOGO -->
                        <div class="desktoplogo">
                            <a href="#hero-3" class="logo-white"><img
                                    src="{{asset('assets/frontend/images/logo-white.png')}}" alt="logo" /></a>
                        </div>

                        <!-- MAIN MENU -->
                        <nav class="wsmenu clearfix">
                            <ul class="wsmenu-list nav-theme">
                                <!-- DROPDOWN SUB MENU -->
                                <li aria-haspopup="true"><a href="#hero-3" class="h-link">Home</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#features-11" class="h-link">How It
                                        Works</a></li>


                                <li class="nl-simple" aria-haspopup="true"><a href="#benefits-11"
                                        class="h-link">Benefits</a></li>

                                <li class="nl-simple" aria-haspopup="true"><a href="#case-studies" class="h-link">Case
                                        Studies</a></li>

                                <!-- DROPDOWN MENU FOR ADDITIONAL ITEMS -->
                                <li aria-haspopup="true">
                                    <a href="#" class="h-link">For Professionals</a>
                                    <ul class="sub-menu">
                                        <li><a href="#lnk-3">Partner Program</a></li>
                                        <li><a href="#contacts-2">Enterprise solutions </a></li>
                                        <li><a href="#digitallegacy">Digital Legacies</a></li>
                                    </ul>
                                </li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#pricing-1"
                                        class="h-link">Pricing</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#faqs-3" class="h-link">FAQs</a>
                                </li>


                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#contacts-1"
                                        class="h-link">Contact</a></li>


                                @guest
                                    <li class="nl-simple reg-fst-link mobile-last-link" aria-haspopup="true">
                                        <a href="{{route('login')}}" class="h-link">Sign in</a>
                                    </li>
                                    <li class="nl-simple" aria-haspopup="true">
                                        <a href="{{route('register')}}"
                                            class="btn r-04 btn--theme hover--tra-white last-link">Start Free 14 Days
                                            Trial</a>
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

        <!-- HERO-3
			============================================= -->
        <section id="hero-3" class="bg--fixed hero-section">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <!-- HERO TEXT -->
                    <div class="col-md-6">
                        <div class="hero-3-txt color--white wow fadeInRight">
                            <!-- Title -->
                            <h2 class="s-60 w-700">Executor Hub - Empowering executors, ensuring legacies</h2>

                            <!-- Text -->
                            <p class="p-lg">Executor Hub is a secure web application designed to help individuals
                                organize and store important financial documents, social media passwords, and asset
                                information in one central, encrypted location.</p>
                            <iframe
                                src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                                style="border:none;height:132px;width:132px;"></iframe>
                            <br />
                            <a href="{{route('register')}}" class="btn r-04 btn--theme hover--tra-white last-link">Start
                                Free Trial</a>
                        </div>
                    </div>
                    <!-- END HERO TEXT -->

                    <!-- HERO IMAGE -->
                    <div class="col-md-6">
                        <div class="hero-3-img wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/tablet-01.png')}}"
                                alt="hero-image" />
                        </div>
                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </section>
        <!-- END HERO-3 -->

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
                                    <a href="{{route('register')}}"
                                        class="btn r-04 btn--theme hover--tra-white last-link">Start Free 14 Days
                                        Trial</a>
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


        <section id="pricing-1" style="margin-top:50px;" class="gr--whitesmoke pb-40 inner-page-hero pricing-section">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="section-title mb-70">
                            <!-- Title -->
                            <h2 class="s-52 w-700">Simple, Flexible Pricing</h2>
                            <br />
                            <a href="{{route('register')}}" class="btn r-04 btn--theme hover--tra-white last-link">Start
                                Free 14 Days Trial</a>
                        </div>
                    </div>
                </div>
                <!-- END SECTION TITLE -->

                <!-- PRICING TYPE SELECTOR -->
                <div class="row justify-content-center mb-50">
                    <div class="col-md-8 col-lg-6">
                        <div class="pricing-type-selector bg--white-100 block-shadow r-12 p-30 text-center"
                            style="padding:25px;">
                            <h4 class="s-24 w-700 mb-4">Choose Your Subscription Type</h4>
                            <div class="btn-group pricing-toggle-buttons" role="group" style="width: 100%;">
                                <button type="button" class="btn btn-lg pricing-type-btn btn-primary active"
                                    data-type="monthly" style="flex: 1;">
                                    Monthly Subscription
                                </button>
                                <button type="button" class="btn btn-lg pricing-type-btn btn-outline-primary"
                                    data-type="lifetime" style="flex: 1;">
                                    Lifetime Subscription
                                    <!-- <span class="badge bg-success ms-2">Save Money</span> -->
                                </button>
                            </div>
                            <p class="mt-3 mb-0 text-muted" id="pricingTypeDescription">
                                Flexible monthly payments with the option to cancel anytime.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- END PRICING TYPE SELECTOR -->

                <!-- MONTHLY PRICING TABLES -->
                <div class="pricing-1-wrapper" id="monthlyPricing">
                    <div class="row row-cols-1 row-cols-md-3">
                        <!-- BASIC PLAN -->
                        <div class="col">
                            <div id="pt-1-1"
                                class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp">
                                <!-- TABLE HEADER -->
                                <div class="pricing-table-header">
                                    <h5 class="s-24 w-700">Basic</h5>
                                    <div class="price">
                                        <sup class="color--black">£</sup>
                                        <span class="color--black">5.99</span>
                                        <sup class="validity color--grey">&nbsp;/mo</sup>
                                        <p class="s-18 w-600 color--theme mt-3 mb-3">Essential digital vault</p>
                                    </div>

                                    <!-- Features -->
                                    <div class="pricing-features-wrapper mt-3">
                                        <h6 class="s-18 w-700 mb-3">Features:</h6>
                                        <ul class="pricing-features color--black ico-10 ico--green"
                                            style="list-style: none; padding-left: 0;">
                                            <li class="mb-2">• Assign Executors</li>
                                            <li class="mb-2">• Record Assets & Liabilities</li>
                                            <li class="mb-2">• Upload & Store Key Documents</li>
                                            <li class="mb-2">• Add Notes to Assets</li>
                                            <li class="mb-2">• Download a Simple Executor Summary</li>
                                        </ul>
                                    </div>

                                    <!-- Best For -->
                                    <div class="mt-3 mb-3">
                                        <p class="s-16 w-700 color--black mb-1"><strong>Best for:</strong></p>
                                        <p class="s-14 color--grey">People who want their key information organised
                                            safely in one place without extra features.</p>
                                    </div>

                                    <!-- Why -->
                                    <div class="mt-3 mb-3">
                                        <p class="s-16 w-700 color--black mb-1"><strong>Why £5.99?</strong></p>
                                        <p class="s-14 color--grey">A secure, organised digital vault with document
                                            uploads — the simplest, most affordable way to get your affairs in order.
                                        </p>
                                    </div>

                                    <a href="{{ route('stripe') }}"
                                        class="pt-btn btn r-04 btn--theme hover--theme mt-4">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                        <!-- STANDARD PLAN -->
                        <div class="col">
                            <div id="pt-1-2"
                                class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp"
                                style="border: 2px solid #007bff;">
                                <div class="pricing-table-header">
                                    <h5 class="s-24 w-700">Standard <span class="badge bg-primary ms-2">Most
                                            Popular</span></h5>
                                    <div class="price">
                                        <sup class="color--black">£</sup>
                                        <span class="color--black">11.99</span>
                                        <sup class="validity color--grey">&nbsp;/mo</sup>
                                        <p class="s-18 w-600 color--theme mt-3 mb-3">Guided estate organisation +
                                            adviser access</p>
                                    </div>

                                    <!-- Features -->
                                    <div class="pricing-features-wrapper mt-3">
                                        <h6 class="s-18 w-700 mb-3">Features:</h6>
                                        <ul class="pricing-features color--black ico-10 ico--green"
                                            style="list-style: none; padding-left: 0;">
                                            <li class="mb-2"><strong>Everything in Basic</strong></li>
                                            <li class="mb-2">• Assign Advisers</li>
                                            <li class="mb-2">• Secure Document Sharing</li>
                                            <li class="mb-2">• Step-by-Step Guidance & Checklists</li>
                                            <li class="mb-2">• Smart Review Reminders</li>
                                            <li class="mb-2">• Secure In-App Messaging</li>
                                        </ul>
                                    </div>

                                    <!-- Best For -->
                                    <div class="mt-3 mb-3">
                                        <p class="s-16 w-700 color--black mb-1"><strong>Best for:</strong></p>
                                        <p class="s-14 color--grey">Anyone who wants guidance and adviser support to
                                            stay fully organised and up to date.</p>
                                    </div>

                                    <!-- Why -->
                                    <div class="mt-3 mb-3">
                                        <p class="s-16 w-700 color--black mb-1"><strong>Why £11.99?</strong></p>
                                        <p class="s-14 color--grey">Adds professional collaboration and clear guidance —
                                            helping you get everything right, first time, without overwhelm.</p>
                                    </div>

                                    <a href="{{ route('stripe') }}"
                                        class="pt-btn btn r-04 btn--theme hover--theme mt-4">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                        <!-- PREMIUM PLAN -->
                        <div class="col">
                            <div id="pt-1-3"
                                class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp">
                                <div class="pricing-table-header">
                                    <h5 class="s-24 w-700">Premium</h5>
                                    <div class="price">
                                        <sup class="color--black">£</sup>
                                        <span class="color--black">19.99</span>
                                        <sup class="validity color--grey">&nbsp;/mo</sup>
                                        <p class="s-18 w-600 color--theme mt-3 mb-3">Complete legacy planning & executor
                                            support</p>
                                    </div>

                                    <!-- Features -->
                                    <div class="pricing-features-wrapper mt-3">
                                        <h6 class="s-18 w-700 mb-3">Features:</h6>
                                        <ul class="pricing-features color--black ico-10 ico--green"
                                            style="list-style: none; padding-left: 0;">
                                            <li class="mb-2"><strong>Everything in Standard</strong></li>
                                            <li class="mb-2">• Record Donations & Gifts</li>
                                            <li class="mb-2">• Record Life Notes & Personal Messages</li>
                                            <li class="mb-2">• Record Detailed Wishes (funeral, guardians, digital
                                                accounts)</li>
                                            <li class="mb-2">• Executor Hub AI Access</li>
                                            <li class="mb-2">• Capacity-Proof Video Vault</li>
                                            <li class="mb-2">• Priority Executor Support</li>
                                        </ul>
                                    </div>

                                    <!-- Best For -->
                                    <div class="mt-3 mb-3">
                                        <p class="s-16 w-700 color--black mb-1"><strong>Best for:</strong></p>
                                        <p class="s-14 color--grey">Those who want full legacy protection — personal
                                            messages, advanced wishes, and complete support for their executors.</p>
                                    </div>

                                    <!-- Why -->
                                    <div class="mt-3 mb-3">
                                        <p class="s-16 w-700 color--black mb-1"><strong>Why £19.99?</strong></p>
                                        <p class="s-14 color--grey">The most comprehensive experience, combining
                                            emotional legacy, advanced planning tools, and AI + video protection for
                                            your family.</p>
                                    </div>

                                    <a href="{{ route('stripe') }}"
                                        class="pt-btn btn r-04 btn--theme hover--theme mt-4">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MONTHLY PRICING TABLES -->

                <!-- LIFETIME SUBSCRIPTION -->
                <div class="row justify-content-center" id="lifetimePricing" style="display: none;">
                    <div class="col-lg-12">
                        <div class="lifetime-subscription-form bg--white-100 block-shadow r-12 p-40">
                            <div class="text-center mb-30">
                                <h3 class="s-32 w-700 mb-3">Lifetime Subscription</h3>
                                <p class="s-18 color--theme mb-2">💰 Can work out up to 80% cheaper than paying monthly
                                    long-term.</p>
                                <p class="s-16 color--grey">Get lifetime access to all features with a one-time payment.
                                    No recurring fees, no hassle.</p>
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

                            <form id="lifetimeStep1Form" method="POST" action="{{ route('stripe.lifetime.step1') }}"
                                class="row g-3" style="padding:10px;">
                                @csrf

                                <div class="col-12">
                                    <label for="lifetimeDob" class="form-label">Date of Birth <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="lifetimeDob" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth', 'lifetime')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Select your date of birth to see pricing
                                        options.</small>
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <button type="submit" class="btn btn--theme btn-lg r-04">
                                        Proceed
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End container -->
        </section>

        <!-- Roles
			============================================= -->
        <section id="roles" class="pt-100 faqs-section">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-80">
                            <!-- Title -->
                            <h2 class="s-50 w-700">Executor Hub Roles</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">An overview of type of roles and their access on Executor Hub.
                            </p>
                        </div>
                    </div>
                </div>


                <div class="faqs-3-questions">
                    <div class="row">
                        <!-- QUESTIONS HOLDER -->
                        <div class="col-lg-6">
                            <div class="questions-holder">
                                <!-- QUESTION #1 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>1.</span> Partner</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">A Partner is an affiliate of Executor Hub who has access to
                                        all the functionalities of Executor Hub. They can nominate executors, upload
                                        documents, manage their assets & liabilities and much more. A Partner can also
                                        earn through Executor Hub as they are promoting the services through our
                                        affiliate program.
                                    </p>
                                </div>

                                <!-- QUESTION #2 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>2.</span> Free Trial Customer</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">A Free Trial Customer has access to all the functionalities
                                        of Executor Hub for 14 Days after they sign up for a Free Trial. They can also
                                        nominate their executors, manage documents and much more. However, their access
                                        will be lost after 14 days and they will not be able to continue until they
                                        subscribe to one of our Subscription Packages within 30 Days of losing their
                                        access. Please refer to our Cancellation Policy regarding this.</p>
                                </div>

                                <!-- QUESTION #3 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>3.</span> Basic Customer</h5>

                                    <!-- Answer -->
                                    <p>A Basic Customer is the one who has subscribed to our Basic Subscription Package.
                                        They have a limited access to the Executor Hub and they can only nominate
                                        executors and manage their assets & liabilites.</p>
                                </div>


                                <!-- QUESTION #4 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>4.</span> Standard Customer</h5>

                                    <!-- Answer -->
                                    <p>A Standard Customer is the one who has Subscribed to our Standard Package and
                                        also has a limited access to the Executor Hub. They can nominate executors,
                                        manage their assets & liabilites, manage documents, nominate advisers and
                                        communicate between their nominated executors & advisers.</p>
                                </div>
                            </div>
                        </div>
                        <!-- END QUESTIONS HOLDER -->

                        <!-- QUESTIONS WRAPPER -->
                        <div class="col-lg-6">
                            <div class="questions-holder">


                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>5.</span>Premium Customer</h5>
                                    <p>A Premium Customer is the one who has subscribed to our Premium Package and has
                                        access to all of Executor Hub Functionalities including the nomination of
                                        executors, advisers, Capacity Proof Videos, Document Management and much more.
                                    </p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>6.</span>Executors</h5>
                                    <p>Executors are those users who have been nominated/created by either a partner or
                                        a customer. The Executor has limited access to the Platform which means that
                                        they can only view all the data that is entered by a Customer in all the
                                        modules. To become an
                                        executor, it is mandatory for a partner or a customer to nominate you after they
                                        sign up.</p>
                                </div>

                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>7.</span>Advisers</h5>
                                    <p>Advisers are those users who have been nominated/created by either a partner or
                                        a customer. An Adviser also has limited access to the Platform which means that
                                        they can only view all the data that is entered by a Customer. An Adviser also
                                        has a limited access in such a way that they can only access those modules which
                                        have been assigned by the customer to them.</p>
                                </div>

                            </div>
                        </div>
                        <!-- END QUESTIONS HOLDER -->
                    </div>
                    <!-- End row -->
                </div>

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

        <!-- CASE STUDIES
			============================================= -->
        <section id="case-studies" class="pt-100 pb-100 case-studies-section division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-80">
                            <!-- Title -->
                            <h2 class="s-50 w-700">Case Studies</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">Real-world examples of how Executor Hub protects families and
                                saves executors time.</p>
                        </div>
                    </div>
                </div>

                <!-- CASE STUDIES CARDS -->
                <div class="row g-4">
                    <!-- CASE STUDY 1 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <h5 class="card-title s-24 w-700 mb-3">Preventing a 5-Year Will Challenge</h5>
                                <p class="card-text color--grey">A grandfather wrote a will leaving his entire estate to
                                    his grandson. His son (the grandson's father) was explicitly excluded from
                                    inheriting. Following the grandfather's death, the son launched a serious legal
                                    challenge...</p>
                                <p class="card-text"><small class="text-muted">Learn how Executor Hub could have
                                        prevented years of litigation and saved hundreds of thousands in legal
                                        fees.</small></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('case-study.show', 'preventing-5-year-will-challenge') }}"
                                    class="btn btn--theme hover--tra-white r-04">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- CASE STUDY 2 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <h5 class="card-title s-24 w-700 mb-3">Saving Executors 30-60 Hours of Work</h5>
                                <p class="card-text color--grey">Acting as an executor is legally demanding, emotionally
                                    draining, and extremely time-consuming. Research consistently shows that executors
                                    underestimate the workload...</p>
                                <p class="card-text"><small class="text-muted">Discover how Executor Hub reduces
                                        executor workload by 40-75 hours per estate.</small></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('case-study.show', 'saving-executors-30-60-hours') }}"
                                    class="btn btn--theme hover--tra-white r-04">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- CASE STUDY 3 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <h5 class="card-title s-24 w-700 mb-3">The £400,000 "Hidden Asset"</h5>
                                <p class="card-text color--grey">Three executors were appointed to administer the estate
                                    of a late parent. They believed they had identified all assets and liabilities and
                                    proceeded to apply for probate. Two months later, a previously unknown £400,000
                                    investment account was discovered...</p>
                                <p class="card-text"><small class="text-muted">See how Executor Hub prevents missed
                                        assets and rescinded grants.</small></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('case-study.show', '400000-hidden-asset') }}"
                                    class="btn btn--theme hover--tra-white r-04">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- CASE STUDY 4 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <h5 class="card-title s-24 w-700 mb-3">Preventing Executor Mistakes Through Automation</h5>
                                <p class="card-text color--grey">A family discovered after death that several important documents were missing: the updated will, property valuations, insurance details, and statements for a small investment account. Documents were stored in multiple places causing delays, arguments, and additional legal fees...</p>
                                <p class="card-text"><small class="text-muted">How Executor Hub avoids confusion, missing paperwork, and costly delays.</small></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('case-study.show', 'preventing-executor-mistakes-automation') }}"
                                    class="btn btn--theme hover--tra-white r-04">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- CASE STUDY 5 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <h5 class="card-title s-24 w-700 mb-3">Cutting Delays From Banks, HMRC & DWP</h5>
                                <p class="card-text color--grey">Executors for a modest estate spent over three months waiting on responses from banks, pension providers, HMRC, and the DWP. Most delays were caused by sending wrong forms, missing information, and being asked to provide the same documents repeatedly...</p>
                                <p class="card-text"><small class="text-muted">How Executor Hub eliminates the administrative drag executors face.</small></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('case-study.show', 'cutting-delays-banks-hmrc-dwp') }}"
                                    class="btn btn--theme hover--tra-white r-04">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- CASE STUDY 6 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <h5 class="card-title s-24 w-700 mb-3">Capacity Recording & Golden Rule Compliance</h5>
                                <p class="card-text color--grey">A will was drafted for an elderly lady with early signs of memory decline. When she died, one child challenged the will, arguing she lacked capacity and didn't understand the changes. There was no record explaining why she made her decisions...</p>
                                <p class="card-text"><small class="text-muted">How Executor Hub helps avoid legal challenges to capacity and knowledge & approval.</small></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('case-study.show', 'capacity-recording-golden-rule-compliance') }}"
                                    class="btn btn--theme hover--tra-white r-04">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- CASE STUDY 7 -->
                    <div class="col-lg-12">
                        <div class="card case-study-card h-100 bg--white-100 block-shadow r-12 wow fadeInUp">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="card-title s-24 w-700 mb-3">The Hospital Will: A Complex Family Situation Made Simple</h5>
                                        <p class="card-text color--grey">A man in hospital decided to update his will due to a turbulent marriage with allegations of domestic abuse, children from a previous relationship, and complex financial arrangements. After his death, his wife challenged the will and reported the matter to police, creating accusations, family breakdown, and significant legal costs...</p>
                                        <p class="card-text"><small class="text-muted">How a capacity video and recorded explanation could have prevented a painful dispute.</small></p>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="text-center w-100">
                                            <span class="badge bg-warning text-dark mb-3 p-2">Featured Case Study</span>
                                            <br>
                                            <a href="{{ route('case-study.show', 'hospital-will-complex-family-situation') }}"
                                                class="btn btn--theme hover--tra-white r-04 btn-lg">Read Full Story</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CASE STUDIES CARDS -->
            </div>
            <!-- End container -->
        </section>
        <!-- END CASE STUDIES -->

        <section id="contacts-1" class="pb-50 inner-page-hero contacts-section division">
            <div class="container">
                <!-- Section Title -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title text-center mb-80">
                            <h2 class="s-52 w-700">Questions? Let's Talk</h2>
                            <p class="p-lg">
                                Want to learn more about Executor Hub, get a quote, or speak with an expert? Let us know
                                what
                                you are looking for, and we’ll get back to you right away.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-10 col-xl-8">
                        <div class="form-holder">
                            @if (session('success'))
                                <div class="alert alert-success">
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
                            <form id="contact-form" class="row contact-form" action="{{ route('contact.submit') }}"
                                method="POST">
                                @csrf
                                <!-- Form Select -->
                                <div class="col-md-12 input-subject">
                                    <p class="p-lg">This question is about:</p>
                                    <span>Choose a topic, so we know who to send your request to: </span>
                                    <select class="form-select subject" name="subject" required>
                                        <option value="" selected disabled>This question is about...</option>
                                        <option>Registering/Authorising</option>
                                        <option>Using Application</option>
                                        <option>Troubleshooting</option>
                                        <option>Backup/Restore</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <!-- Name Input -->
                                <div class="col-md-12">
                                    <p class="p-lg">Your Name:</p>
                                    <span>Please enter your real name:</span>
                                    <input type="text" name="name" class="form-control" placeholder="Your Name*"
                                        required />
                                </div>

                                <!-- Email Input -->
                                <div class="col-md-12">
                                    <p class="p-lg">Your Email Address:</p>
                                    <span>Please carefully check your email address for accuracy:</span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address*"
                                        required />
                                </div>

                                <!-- Message Input -->
                                <div class="col-md-12">
                                    <p class="p-lg">Explain your question in detail:</p>
                                    <span>Your Issue/Concern:</span>
                                    <textarea name="message" class="form-control" rows="6" placeholder=""
                                        required></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                    </div>
                                    @error('g-recaptcha-response')
                                        <span class="text-danger d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Submit Button -->
                                <div class="col-md-12 mt-15 form-btn text-right">
                                    <button type="submit" class="btn btn--theme hover--theme">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>





        <!-- DIVIDER LINE -->
        <hr class="divider" />

        <!-- MODAL WINDOW (REQUEST FORM)
			============================================= -->
        <div id="modal-3" class="modal auto-off fade" tabindex="-1" role="dialog" aria-labelledby="modal-3">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <!-- CLOSE BUTTON -->
                    <button type="button" class="btn-close ico-10 white-color" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="flaticon-cancel"></span>
                    </button>

                    <!-- MODAL CONTENT -->
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <!-- BACKGROUND IMAGE -->
                                <div class="col-md-5 bg-img d-none d-sm-flex align-items-end"></div>

                                <!-- REQUEST FORM -->
                                <div class="col-md-7">
                                    <div class="modal-body-content">
                                        <!-- TEXT -->
                                        <div class="request-form-title">
                                            <!-- Title 	-->
                                            <h3 class="s-28 w-700">Get started for Free!</h3>

                                            <!-- Text -->
                                            <p class="color--grey">Aliquam augue suscipit, luctus neque purus ipsum
                                                neque dolor primis libero</p>
                                        </div>

                                        <!-- FORM -->
                                        <form name="requestForm" class="row request-form">
                                            <!-- Form Input -->
                                            <div class="col-md-12">
                                                <input type="text" name="name" class="form-control name"
                                                    placeholder="Enter Your Name*" autocomplete="off" required />
                                            </div>

                                            <!-- Form Input -->
                                            <div class="col-md-12">
                                                <input type="email" name="email" class="form-control email"
                                                    placeholder="Enter Your Email*" autocomplete="off" required />
                                            </div>

                                            <!-- Form Button -->
                                            <div class="col-md-12 form-btn">
                                                <button type="submit" class="btn btn--theme hover--theme submit">Get
                                                    Started Now</button>
                                            </div>

                                            <!-- Form Message -->
                                            <div class="col-md-12 request-form-msg">
                                                <span class="loading"></span>
                                            </div>
                                        </form>
                                        <!-- END FORM -->
                                    </div>
                                </div>
                                <!-- END REQUEST FORM -->
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL CONTENT -->
                </div>
            </div>
        </div>
        <!-- END MODAL WINDOW (REQUEST FORM) -->

        <!-- WORK WITH US -->
        <section id="contacts-2" class="pt-100 ws-wrapper content-section">
            <div class="container">
                <div class="bc-5-wrapper bg--04 hidd bg--scroll r-16">
                    <div class="section-overlay">
                        <!-- SECTION TITLE -->
                        <div class="row justify-content-center">
                            <div class="col-md-11 col-lg-9">
                                <div class="wow fadeInUp mb-60">
                                    <!-- Title -->
                                    <h2 class="s-50 w-700 text-center">Enterprise Solutions</h2>
                                    <p class="text-center">Transforming estate administration for families — at scale.</p>

                                    <!-- Text -->
                                    <p class="p-xl">Executor Hub is the modern digital platform that helps families
                                        manage estates with clarity, confidence, and support. We partner with
                                        forward-thinking organisations that want to improve client outcomes, enhance
                                        brand reputation, and unlock new recurring revenue streams — without building
                                        technology themselves.</p>
                                    <p class="text-left">🚀 Why Leading Organisations Choose Executor Hub</p>
                                    <p>Estate administration is one of the most stressful and fragmented experiences
                                        people ever face.
                                        Executor Hub solves these challenges by empowering executors with:</p>
                                    <p>✔ A guided step-by-step workflow</p>
                                    <p>✔ Secure document storage & sharing</p>
                                    <p>✔ Clear instructions and educational videos</p>
                                    <p>✔ Easy communication with family and professionals</p>
                                    <p>✔ Instant access from anywhere</p>
                                    <p>✔ Complete organisation of assets, liabilities & key contacts</p>
                                    <p>The result?</p>
                                    <p>▶ Faster resolutions</p>
                                    <p>▶ Fewer errors and delays</p>
                                    <p>▶ Happier clients & fewer complaints</p>
                                    <p>▶ Stronger relationships for life</p>
                                    <p>You lead the client relationship.</p>
                                    <p>We power the digital experience.</p>
                                    <p>💼 Partnership Models Built for Growth</p>
                                    <p>We offer commercial models designed for scaling to hundreds or thousands of clients:</p>
                                    <p>1️⃣ Revenue-Share Partnership</p>
                                    <p>Offer Executor Hub as an add-on or bundled service.Earn recurring commission from every subscription or lifetime plan.Perfect for:</p>
                                    <p>•	Adviser networks</p>
                                    <p>•	Estate planning teams</p>
                                    <p>•	Professional services firms</p>
                                    <p>2️⃣ Bulk Licensing</p>
                                    <p>Purchase licences at a discounted enterprise rate and distribute under your brand umbrella. Ideal For:</p>
                                    <p>•	Premium estate planning packages</p>
                                    <p>•	Funeral plan enhancements</p>
                                    <p>•	Insurance policies & employee benefit offerings</p>
                                    <p>Strong upfront revenue and guaranteed client upgrade value.</p>
                                    <p>3️⃣ White-Label & Co-Branded Solutions</p>
                                    <p>Deliver a digital executor platform as your own product. Fully customisable:</p>
                                    <p>•	Logo, branding, URL</p>
                                    <p>•	On-platform messaging</p>
                                    <p>•	Feature permissions</p>
                                    <p>•	Service pathways</p>
                                    <p>•	Client support workflow</p>
                                    <p>The power of Executor Hub — with your identity front and centre.</p>
                                    <p>🧩 Who We Partner With</p>
                                    <p>•	National law firms & probate providers</p>
                                    <p>•	Financial advisers & wealth managers</p>
                                    <p>•	Funeral care & bereavement groups</p>
                                    <p>•	Later-life care organisations</p>
                                    <p>•	Insurance companies & membership benefits</p>
                                    <p>•	Estate technology innovators</p>

                                    <p>If you support families before or after a loss — Executor Hub strengthens your value.</p>
                                    <p>📈 Proven Results for Families & Businesses</p>
                                    <p>Executors using Executor Hub report:</p>
                                    <p>•	50–80 hours saved in admin workload</p>
                                    <p>•	Up to 80% fewer delays & errors</p>
                                    <p>•	Reduced stress, increased confidence, improved outcomes</p>
                                    <p>Business benefits include:</p>
                                    <p>•	Higher client retention & referrals</p>
                                    <p>•	Stronger brand trust & goodwill</p>
                                    <p>•	Increased revenue per client</p>
                                    <p>•	Reduced support burden for staff</p>
                                    <p>•	Compliance-ready processes & full audit trail</p>
                                    <p>•	Improved professional reputation at a critical moment</p>
                                    <p>Executors feel supported. Families feel cared for. Your brand earns loyalty that lasts generations.</p>
                                    <p>🔐 Security & Compliance You Can Trust</p>
                                    <p>Executor Hub protects the most sensitive family information with enterprise-level safeguards:</p>
                                    <p>✔ Cyber Essentials Certified</p>
                                    <p>✔ UK-based hosting & full GDPR compliance</p>
                                    <p>✔ Encrypted storage for documents & passwords</p>
                                    <p>✔ Multi-factor authentication</p>
                                    <p>✔ Role-based access control</p>
                                    <p>✔ Audit logs & document version tracking</p>
                                    <p>✔ Incident-response & data governance framework</p>
                                    <p>Your risk is reduced — and your brand is protected.</p>
                                    <p>🤝 Let’s Elevate Support for Families — Together</p>
                                    <p>Executor Hub is the future of estate administration — and the opportunity to lead that future begins now.</p>
                                    <p>📩 Submit Your Partnership Enquiry</p>
                                    <p>→ One of our enterprise consultants will contact you to discuss your goals and arrange a demonstration.</p>
                                    <p>Executor Hub — empowering executors, and the professionals who support them.</p>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-center mb-4">See why professionals are partnering with Executor Hub</h4>
                        <!-- IMAGE BLOCK -->
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="bc-5-img bc-5-tablet img-block-hidden video-preview wow fadeInUp">
                                    <!-- Play Icon -->
                                    <a class="video-popup1" href="{{ asset('assets/frontend/partner.mp4') }}">
                                        <div class="video-btn video-btn-xl bg--theme">
                                            <div class="video-block-wrapper"><span class="flaticon-play-button"></span>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Preview Image -->
                                    <img class="img-fluid" src="{{asset('assets/frontend/main-card-2.png')}}"
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

        <section id="lnk-3" class="pt-100 ct-02 content-section division">
            <div class="container">


                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">


                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight"
                            style="visibility: visible; animation-name: fadeInRight;">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/dashboard.png')}}"
                                alt="content-image">
                        </div>
                    </div>

                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft"
                            style="visibility: visible; animation-name: fadeInLeft;">

                            <!-- Section ID -->
                            <span class="section-id">🤝 Partner Program</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Help families. Grow your business. Earn more — every month.</h2>

                            <p>Executor Hub lets you support families during one of the hardest moments in life — while giving you a powerful new way to increase your income.</p>
                            <p>Our partnership program is designed for estate planners, will writers, financial advisers, funeral directors, and professionals who want to deliver more value without more work.</p>

                            <p>🌟 Why Join the Partner Program?</p>
                            <p>✔ Add an innovative digital service to your offering</p>
                            <p>✔ Strengthen client relationships & referrals</p>
                            <p>✔ Create immediate cashflow and long-term recurring income</p>
                            <p>✔ No cost to join, no technical experience needed</p>
                            <p>✔ Start earning today</p>
                            <p>You bring your knowledge. We provide the platform. Together, we transform family support.</p>

                            <p>💰 How You Earn — Three Powerful Income Streams</p>
                            <p>Every time you refer a customer using your unique link, you earn:</p>
                            <p>1- Income Stream</p>
                            <p>2- Your Earnings</p>
                            <p>3- Monthly subscriptions</p>
                            <p>4- 30% every month</p>
                            <p>5- Lifetime plans</p>
                            <p>6- 30% one-off upfront</p>
                            <p>7- Team referrals</p>
                            <p>8- 20% from partners you recruit</p>

                            <p>That means you earn from:</p>
                            <p>• Your own clients</p>
                            <p>• People they refer</p>
                            <p>• Partners you introduce</p>
                            <p>• Their clients too</p>
                            <p>Build your network → multiply your income.</p>

                            <hr>

<h4>What You Can Earn (Realistic Examples)</h4>

<p>These examples show what’s possible if you talk to a steady flow of clients and follow our simple process.<br>
They’re based on:</p>

<ul>
    <li>70% of clients choosing a lifetime plan</li>
    <li>30% choosing a monthly subscription</li>
    <li>30% commission on your own clients</li>
    <li>20% commission on clients of partners you recruit</li>
</ul>

<p><em>Actual results will vary – this is not a guarantee of income.</em></p>

<h5>Layout Idea</h5>
<p>Each example is a card:</p>
<ul>
    <li>Top line: Example name + headline earnings</li>
    <li>Sub-line: short description (small start / strong start / growing team)</li>
    <li>Button: “Show me how” (reveals the breakdown underneath)</li>
</ul>

<hr>

<!-- Example 1 -->
<h4>Example 1 – Small Start</h4>

<p><strong>Example 1 – Small Start, No Recruitment</strong><br>
Help 3–5 clients get set up with Executor Hub.</p>

<ul>
    <li><strong>Estimated Month 1 income:</strong> £350–£700</li>
    <li><strong>Ongoing income:</strong> around £4–£7/month</li>
</ul>

<button type="button" class="show-how btn btn-primary">Show me how</button>

<div class="hidden-breakdown" style="display:none; margin-top:10px;">
    <h5>How this is worked out</h5>
    <ul>
        <li>3–5 clients choose Executor Hub</li>
        <li>70% choose a lifetime plan → commission £178.50 each</li>
        <li>30% choose monthly → commission £3.60/month each</li>
    </ul>

    <h6>Lifetime commissions</h6>
    <p>2–4 lifetime clients → £357 – £714 in one-off income</p>

    <h6>Monthly commissions</h6>
    <p>1–2 monthly clients → £3.60 – £7.20/month</p>

    <p>You don’t recruit anyone yet in this example – it’s just you and your clients.</p>

    <p><small>These figures are illustrations only. Your income depends on how many clients you speak to and how you promote the service. Earnings are not guaranteed.</small></p>
</div>

<hr>

<!-- Example 2 -->
<h4>Example 2 – Strong Start</h4>

<p><strong>Example 2 – Strong Start, 1 Partner Recruited</strong><br>
Help 10–15 clients yourself and introduce 1 partner who also starts selling.</p>

<ul>
    <li><strong>Estimated Month 1 income:</strong> £1,600–£2,400</li>
    <li><strong>Ongoing income:</strong> around £13–£23/month</li>
</ul>

<button type="button" class="show-how btn btn-primary">Show me how</button>

<div class="hidden-breakdown" style="display:none; margin-top:10px;">
    <h5>Your own clients</h5>
    <ul>
        <li>10–15 clients choose Executor Hub</li>
        <li>70% choose lifetime = 7–11 lifetime plans</li>
        <li>30% choose monthly = 3–5 monthly plans</li>
    </ul>

    <h6>Your direct commissions (30%)</h6>
    <ul>
        <li>Lifetimes: £1,249.50 – £1,963.50</li>
        <li>Monthlies: £10.80 – £18.00/month</li>
    </ul>

    <h5>Your partner’s clients (recruitment income, 20%)</h5>
    <ul>
        <li>Partner signs up 5 clients</li>
        <li>3–4 lifetime plans → £357 – £476</li>
        <li>1–2 monthly plans → £2.40 – £4.80/month</li>
    </ul>

    <p><strong>Total Month 1:</strong> about £1,606 – £2,439<br>
    <strong>Total ongoing monthly:</strong> about £13.20 – £22.80/month</p>

    <p><small>These figures are illustrations only. Your income depends on your activity and your partner’s activity. Earnings are not guaranteed.</small></p>
</div>

<hr>

<!-- Example 3 -->
<h4>Example 3 – Growing Team</h4>

<p><strong>Example 3 – Growing Team, 4 Active Partners</strong><br>
You help 15–20 clients and recruit 4 partners, each helping 5 clients.</p>

<ul>
    <li><strong>Estimated Month 1 income:</strong> £3,600–£4,200</li>
    <li><strong>Ongoing income:</strong> around £29–£36/month</li>
</ul>

<button type="button" class="show-how btn btn-primary">Show me how</button>

<div class="hidden-breakdown" style="display:none; margin-top:10px;">
    <h5>Your own clients</h5>
    <ul>
        <li>15–20 clients</li>
        <li>70% lifetime → 11–14 lifetime plans</li>
        <li>30% monthly → 4–6 monthly plans</li>
    </ul>

    <h6>Direct commissions (30%)</h6>
    <ul>
        <li>Lifetimes: £1,963 – £2,499</li>
        <li>Monthlies: £14.40 – £21.60/month</li>
    </ul>

    <h5>Your partner team</h5>
    <ul>
        <li>4 partners × 5 clients = 20 clients</li>
        <li>70% lifetime = 14 lifetime plans</li>
        <li>30% monthly = 6 monthly plans</li>
    </ul>

    <h6>Recruitment commissions (20%)</h6>
    <ul>
        <li>Lifetimes: 14 × £119 = £1,666</li>
        <li>Monthlies: 6 × £2.40 = £14.40/month</li>
    </ul>

    <p><strong>Total Month 1:</strong> about £3,629 – £4,165<br>
    <strong>Total ongoing monthly:</strong> about £28.80 – £36/month</p>

    <p><small>These figures are illustrations only. Your income depends on client activity and partner performance. Earnings are not guaranteed.</small></p>
</div>

                            <hr>

                            <h4>🔥 Want a big win fast?</h4>

                            <p>Sell 2 lifetime plans + recruit 2 partners this week:</p>
                            <p>💷 Approx £1,000–£1,500 in upfront income<br>
                            🔥 Plus ongoing subscription revenue long-term</p>

                            <p>A few messages, a couple of conversations — real earnings.</p>

                            <hr>

                            <h4>🚀 Everything You Need to Succeed</h4>

                            <p>We give you:</p>
                            <p>✔ Marketing materials</p>
                            <p>✔ Ready-made scripts, emails & social posts</p>
                            <p>✔ Demo videos & objection handling</p>
                            <p>✔ Partner dashboard to track sales and income</p>
                            <p>✔ Ongoing support and coaching</p>
                            <p>We make success easy.</p>

                            <hr>

                            <h4>🎯 Who Makes the Best Partners?</h4>

                            <p>If you talk to clients about:</p>
                            <ul>
                                <li>Wills, trusts or probate</li>
                                <li>Finances & estate planning</li>
                                <li>Funeral plans or later-life care</li>
                                <li>Insurance & protection</li>
                                <li>Membership benefits</li>
                            </ul>

                            <p>…then Executor Hub fits perfectly into what you already do.</p>

                            <hr>

                            <h4>❤️ Your Clients Will Thank You</h4>

                            <p>Executors often spend:</p>
                            <ul>
                                <li>✔ 50–80 hours on admin (Law Society & industry averages)</li>
                                <li>✔ Months chasing documents and information (HMCTS probate timelines)</li>
                                <li>✔ Thousands lost due to delays, missing documents or interest charges (STEP & probate provider data)</li>
                            </ul>
                            <p>(Sources: Law Society, HMCTS probate statistics, STEP, Co-op Legal Services.)</p>

                            <p>You become the professional who made the hardest time easier.</p>

                            <p>That means more:<br>
                            ✔ 5-star reviews<br>
                            ✔ referrals<br>
                            ✔ lifetime value<br>
                            ✔ trust</p>

                            <hr>

                            <h4>⭐ Simple. Lucrative. Impactful.</h4>

                            <p>You decide:<br>
                            • How much you help<br>
                            • How quickly you grow<br>
                            • How much you earn</p>

                            <p>We'll help you every step of the way.</p>

                            <hr>

                            <h4>Ready to join the fastest-growing estate support network?</h4>

                            <p>📩 <strong>Become a Partner Today</strong><br>
                            — it takes less than 30 seconds.</p>

                            <p>Start helping more families.<br>
                            Start building residual income.<br>
                            Start winning more business.</p>

                            <p><strong>Executor Hub — empowering executors, and the professionals who support them.</strong></p>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>


        <section id="contacts-1" class="pb-50 inner-page-hero contacts-section division">
            <div class="container">
                <!-- Section Title -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title text-center mb-80">
                            <h2 class="s-52 w-700">Partner with Us</h2>
                            <p class="p-lg">
                                Partner with Us
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Partner With Us Form -->
                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-10 col-xl-8">
                        <div class="form-holder">
                            @if (session('success'))
                                <div class="alert alert-success">
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
                            <form id="contact-form" class="row contact-form" method="POST"
                                action="{{ route('partner-registration.store') }}">
                                @csrf
                                <div class="col-md-12">
                                    <p class="p-lg">Name:</p>
                                    <span>Enter your name:</span>
                                    <input type="text" name="name" class="form-control" placeholder="Name*" required />
                                </div>


                                <div class="col-md-12">
                                    <p class="p-lg">Email:</p>
                                    <span>Please enter a valid email address:</span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address*"
                                        required />
                                </div>

                                <!-- Contact Number Input -->
                                <div class="col-md-12">
                                    <p class="p-lg">Create Password:</p>
                                    <span>Enter your password:</span>
                                    <input type="password" name="password" class="form-control" placeholder="******"
                                        required />
                                </div>
                                <div class="col-md-12">
                                    <p class="p-lg">Confirm Password:</p>
                                    <span>Enter your password:</span>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="******" required />
                                </div>

                                <div class="col-md-12">
                                    <p class="p-lg">Referred by a partner?</p>
                                    <span>Enter Code Here (Optional):</span>
                                    <input type="text" name="coupon_code" id="coupon_code" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">What is Your Profession?</label>
                                    <select class="form-control" name="profession" required>
                                        <option value="" selected disabled>Choose Profession</option>
                                        <option value="General Audience">General Audience</option>
                                        <option value="Solicitors">Solicitors</option>
                                        <option value="Will writers">Will writers</option>
                                        <option value="Estate planners">Estate planners</option>
                                        <option value="Financial advisers">Financial advisers</option>
                                        <option value="Ifas">Ifas</option>
                                        <option value="Life insurance specialists">Life insurance specialists</option>
                                        <option value="Accountants">Accountants</option>
                                        <option value="Networks">Networks</option>
                                        <option value="Societies">Societies</option>
                                        <option value="Regulatory bodies">Regulatory bodies</option>
                                        <option value="Institutes">Institutes</option>
                                    </select>
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
                                        <option value="My adviser recommended me">My adviser recommended me</option>
                                        <option value="Other">Other (please specify)</option>
                                    </select>
                                </div>

                                <div class="form-group" id="otherFieldDiv" style="display: none;">
                                    <label class="col-form-label">Please specify:</label>
                                    <input type="text" class="form-control" name="other_hear_about_us"
                                        placeholder="Enter details">
                                </div>

                                <div class="col-md-12">
                                    <p>Use forever — every future update included.</p>
                                    <p>Your adviser will continue to support you using Executor Hub.</p>
                                    <p>Secure. ICO registered. Trusted by professionals across the UK.</p>
                                    <iframe
                                        src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                                        style="border:none;height:132px;width:132px;"></iframe>
                                </div>


                                <!-- Email notifications checkbox -->
                                <div class="form-group">
                                    <div>
                                        <input class="" type="checkbox" name="email_notifications"
                                            id="email_notifications" value="1" {{ old('email_notifications') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">
                                            Opt in to email notifications?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <input class="" type="checkbox" name="privacy_policy" id="privacy_policy"
                                            value="1" {{ old('privacy_policy') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="privacy_policy">
                                            Do you agree with our terms and privacy policy?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                    </div>
                                    @error('g-recaptcha-response')
                                        <span class="text-danger d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Submit Button -->
                                <div class="col-md-12 mt-15 form-btn text-right">
                                    <button type="submit" class="btn btn--theme hover--theme">Sign Up as a
                                        Partner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="pt-100 ct-02 content-section division">
            <div class="container">


                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">


                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight"
                            style="visibility: visible; animation-name: fadeInRight;">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-08.png')}}"
                                alt="content-image">
                        </div>
                    </div>


                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft"
                            style="visibility: visible; animation-name: fadeInLeft;">


                            <!-- TEXT BOX -->
                            <div class="txt-box">

                                <!-- Title -->
                                <h5 class="s-24 w-700">The Benefits of Partnering with Us:</h5>

                                <!-- Text -->
                                <p>Add Value for Clients: Provide clients with a powerful tool that simplifies estate
                                    administration and keeps them organized.
                                </p>
                                <p>Build Passive Income: Earn continuous commission with each subscription, creating a
                                    steady revenue stream for your business.</p>
                                <p>Expand Your Services: Differentiate your offerings by delivering Executor Hub’s
                                    unique, secure digital platform to your clients.</p>

                            </div> <!-- END TEXT BOX -->


                            <!-- TEXT BOX -->
                            <div class="txt-box mb-0">

                                <!-- Title -->
                                <h5 class="s-24 w-700">Join Us Today!</h5>

                                <!-- Text -->
                                <p>Join us today and become part of a growing network of professionals who are helping
                                    clients take control of their legacy while building income for their own businesses.
                                    Get in touch to learn more about how we can work together to make estate
                                    administration simpler and more accessible for everyone.
                                </p>
                            </div> <!-- END TEXT BOX -->


                        </div>
                    </div> <!-- END TEXT BLOCK -->


                </div> <!-- END SECTION CONTENT (ROW) -->


            </div> <!-- End container -->
        </section>

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


        <!-- BANNER-13
			============================================= -->
        <section id="banner-13" class="pt-100 banner-section">
            <div class="container">
                <!-- BANNER-13 WRAPPER -->
                <div class="banner-13-wrapper bg--05 bg--scroll r-16 block-shadow">
                    <div class="banner-overlay">
                        <div class="row d-flex align-items-center">
                            <!-- BANNER-5 TEXT -->
                            <div class="col-md-7">
                                <div class="banner-13-txt color--white">
                                    <!-- Title -->
                                    <h2 class="s-45 w-700">Getting started with Executor Hub today!</h2>

                                    <!-- Text -->
                                    <p class="p-lg">Register Your Account with a Free 14 Days Trial and then purchase
                                        the
                                        account after use.</p>

                                    <!-- Button -->
                                    <a href="{{route('register')}}" class="btn r-04 btn--theme hover--tra-white"
                                        data-bs-toggle="modal" data-bs-target="#modal-3">Get started - it's free</a>
                                </div>
                            </div>
                            <!-- END BANNER-13 TEXT -->

                            <!-- BANNER-13 IMAGE -->
                            <div class="col-md-5">
                                <div class="banner-13-img text-center">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/img-04.png')}}"
                                        alt="banner-image" />
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                    </div>
                    <!-- End banner overlay -->
                </div>
                <!-- END BANNER-13 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END BANNER-13 -->

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
                                    <p><a href="#pricing-1">Pricing</a></p>
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
                        <div class="col">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11"></div>
                        <div class="col-md-1">
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

        <!-- Exit Intent Popup -->
        <div id="exitPopup" class="exit-popup">
            <div class="exit-popup-content">
                <span class="exit-close">&times;</span>
                <h2>Wait! Don’t Leave Just Yet…</h2>
                <p>Executor Hub helps you organize everything your loved ones need in one secure place. 💙</p>
                <p>Before you go, make sure your important documents and passwords are safely stored!</p>
                <a href="{{ url('/register') }}" class="btn btn-primary">Get Started for Free</a>
            </div>
        </div>
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

    <!-- Exit Intent Popup Script -->
    <script>
        $(document).ready(function () {
            let exitPopupShown = false;

            $(document).on("mouseleave", function (event) {
                if (event.clientY < 10 && !exitPopupShown) {
                    $("#exitPopup").fadeIn();
                    exitPopupShown = true;
                }
            });

            $(".exit-close").click(function () {
                $("#exitPopup").fadeOut();
            });

            $(".btn-primary").click(function () {
                $("#exitPopup").fadeOut();
            });
        });
    </script>

    <!-- Theme Switcher Script -->
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

        $(document).ready(function () {
            if ($("body").hasClass("theme--dark")) {
                $(".switch").text("Light Mode");
            } else {
                $(".switch").text("Dark Mode");
            }
        });
    </script>
    <!-- Style Switcher Scripts -->
    <script src="{{ asset('assets/frontend/js/changer.js') }}"></script>
    <script defer src="{{ asset('assets/frontend/js/styleswitch.js') }}"></script>

    <!-- Digital Legacy Selector Script -->
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

    <!-- Cookie Management Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let cookiePopup = document.getElementById("cookie-popup");
            let cookieSettings = document.getElementById("cookie-settings");

            // Check if user has already made a choice
            if (!localStorage.getItem("cookie-preference")) {
                cookiePopup.style.display = "block";
            }

            // Accept Cookies
            document.getElementById("accept-cookies").addEventListener("click", function () {
                localStorage.setItem("cookie-preference", "accepted");
                cookiePopup.style.display = "none";
            });

            // Decline Cookies
            document.getElementById("decline-cookies").addEventListener("click", function () {
                localStorage.setItem("cookie-preference", "declined");
                cookiePopup.style.display = "none";
            });

            // Open Manage Cookies
            document.getElementById("manage-cookies").addEventListener("click", function () {
                cookieSettings.style.display = "block";
            });

            // Save Cookie Preferences
            document.getElementById("save-cookie-settings").addEventListener("click", function () {
                let preferences = {
                    essential: true,
                    analytics: document.getElementById("analytics-cookies").checked,
                    marketing: document.getElementById("marketing-cookies").checked
                };
                localStorage.setItem("cookie-preference", JSON.stringify(preferences));
                cookieSettings.style.display = "none";
                cookiePopup.style.display = "none";
            });
        });
    </script>

    <!-- Welcome Popup Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (!localStorage.getItem("welcomePopupShown")) {
                document.getElementById("welcomePopup").style.display = "block";
            }
        });

        function closePopup() {
            document.getElementById("welcomePopup").style.display = "none";
            localStorage.setItem("welcomePopupShown", "true");
        }
    </script>

    <!-- Lifetime Subscription Form Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hearSelect = document.getElementById('lifetimeHearAboutUs');
            const otherWrapper = document.getElementById('lifetimeHearAboutOtherWrapper');
            const otherInput = document.getElementById('lifetimeHearAboutOther');

            if (!hearSelect || !otherWrapper) {
                return;
            }

            const toggleOtherField = () => {
                if (hearSelect.value === 'Other') {
                    otherWrapper.style.display = 'block';
                } else {
                    otherWrapper.style.display = 'none';
                    if (otherInput) {
                        otherInput.value = '';
                    }
                }
            };

            hearSelect.addEventListener('change', toggleOtherField);
            toggleOtherField();
        });
    </script>

    <!-- Partner Registration Form Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hearAboutUsSelect = document.getElementById('hear_about_us');
            const couponCodeInput = document.getElementById('coupon_code');
            const otherFieldDiv = document.getElementById('otherFieldDiv');
            const otherInput = document.querySelector('input[name="other_hear_about_us"]');

            // Function to handle the conditional required logic
            function handleHearAboutUsChange() {
                const selectedValue = hearAboutUsSelect.value;

                // Handle "My adviser recommended me" option
                if (selectedValue === 'My adviser recommended me') {
                    couponCodeInput.setAttribute('required', 'required');
                    // Add visual indicator (optional)
                    const couponLabel = couponCodeInput.closest('.col-md-12').querySelector('span');
                    if (couponLabel && !couponLabel.textContent.includes('*')) {
                        couponLabel.textContent = couponLabel.textContent.replace('(Optional)', '(Required*)');
                    }
                } else {
                    couponCodeInput.removeAttribute('required');
                    // Remove visual indicator (optional)
                    const couponLabel = couponCodeInput.closest('.col-md-12').querySelector('span');
                    if (couponLabel) {
                        couponLabel.textContent = couponLabel.textContent.replace('(Required*)', '(Optional)');
                    }
                }

                // Handle "Other" option for showing additional text field
                if (selectedValue === 'Other') {
                    otherFieldDiv.style.display = 'block';
                    otherInput.setAttribute('required', 'required');
                } else {
                    otherFieldDiv.style.display = 'none';
                    otherInput.removeAttribute('required');
                }
            }

            // Listen for changes on the select element
            hearAboutUsSelect.addEventListener('change', handleHearAboutUsChange);

            // Run on page load in case there's a pre-selected value
            handleHearAboutUsChange();

            // Add form validation feedback
            const form = document.getElementById('contact-form');
            form.addEventListener('submit', function (e) {
                if (hearAboutUsSelect.value === 'My adviser recommended me' && !couponCodeInput.value.trim()) {
                    e.preventDefault();
                    alert('Please enter a referral code since you were recommended by an adviser.');
                    couponCodeInput.focus();
                    return false;
                }
            });
        });
    </script>

    <!-- Pricing Toggle Script -->
    <script>
        // Handle pricing type toggle (Monthly vs Lifetime)
        document.addEventListener('DOMContentLoaded', function () {
            const pricingTypeButtons = document.querySelectorAll('.pricing-type-btn');
            const monthlyPricing = document.getElementById('monthlyPricing');
            const lifetimePricing = document.getElementById('lifetimePricing');
            const pricingTypeDescription = document.getElementById('pricingTypeDescription');

            pricingTypeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const type = this.getAttribute('data-type');

                    // Update button states
                    pricingTypeButtons.forEach(btn => {
                        btn.classList.remove('active', 'btn-primary');
                        btn.classList.add('btn-outline-primary');
                    });
                    this.classList.add('active', 'btn-primary');
                    this.classList.remove('btn-outline-primary');

                    // Toggle visibility
                    if (type === 'monthly') {
                        monthlyPricing.style.display = 'block';
                        lifetimePricing.style.display = 'none';
                        pricingTypeDescription.textContent = 'Flexible monthly payments with the option to cancel anytime.';
                    } else {
                        monthlyPricing.style.display = 'none';
                        lifetimePricing.style.display = 'block';
                        pricingTypeDescription.textContent = 'Can work out up to 80% cheaper than paying monthly long-term.';
                    }

                    // Smooth scroll to pricing section
                    document.getElementById('pricing-1').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        });

        // Handle lifetime subscription step 1 form submission
        document.addEventListener('DOMContentLoaded', function () {
            const lifetimeForm = document.getElementById('lifetimeStep1Form');
            if (lifetimeForm) {
                lifetimeForm.addEventListener('submit', function (e) {
                    // Show loading state only if form is valid
                    const submitBtn = lifetimeForm.querySelector('button[type="submit"]');

                    // Basic validation - if HTML5 validation passes, proceed
                    if (lifetimeForm.checkValidity()) {
                        // Show loading state
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            const originalText = submitBtn.textContent;
                            submitBtn.textContent = 'Processing...';

                            // Re-enable after 5 seconds as fallback (in case redirect fails)
                            setTimeout(function () {
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }, 5000);
                        }
                        // Allow form to submit normally - don't prevent default
                        return true;
                    } else {
                        // HTML5 validation failed - prevent submission and show errors
                        e.preventDefault();
                        e.stopPropagation();
                        lifetimeForm.classList.add('was-validated');
                        return false;
                    }
                });
            }
        });
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("button.show-how").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const breakdown = btn.nextElementSibling;

            if (breakdown.style.display === "none" || breakdown.style.display === "") {
                breakdown.style.display = "block";
                btn.textContent = "Hide details";
            } else {
                breakdown.style.display = "none";
                btn.textContent = "Show me how";
            }
        });
    });
});
</script>

</body>

</html>