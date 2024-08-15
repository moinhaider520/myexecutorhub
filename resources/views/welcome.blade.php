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
</head>

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
                                <li class="nl-simple" aria-haspopup="true"><a href="#features-11"
                                        class="h-link">Features</a></li>

                                <li class="nl-simple" aria-haspopup="true"><a href="#benefits-11"
                                        class="h-link">Benefits</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#pricing-1"
                                        class="h-link">Pricing</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#faqs-3" class="h-link">FAQs</a>
                                </li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#contacts-1" class="h-link">Contact
                                        Us</a></li>

                                @guest
                                <li class="nl-simple reg-fst-link mobile-last-link" aria-haspopup="true">
                                    <a href="{{route('login')}}" class="h-link">Sign in</a>
                                </li>
                                <li class="nl-simple" aria-haspopup="true">
                                    <a href="{{route('register')}}"
                                        class="btn r-04 btn--theme hover--tra-white last-link">Start Free Trial</a>
                                </li>
                                @else
                                <li class="nl-simple" aria-haspopup="true">
                                    <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('customer') ? 'customer.dashboard' : (auth()->user()->hasRole('partner') ? 'partner.dashboard' :  (auth()->user()->hasRole('executor') ? 'executor.dashboard' : 'dashboard')))) }}"
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


        <!-- TEXT CONTENT
			============================================= -->
        <section class="pt-100 ct-02 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-09.png')}}"
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
                                            <span class="flaticon-graphics"></span>

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
                                            <span class="flaticon-trophy"></span>

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
                                            <span class="flaticon-search-engine-1"></span>

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
                    </div>
                    <!-- End row -->
                </div>
                <!-- END FEATURES-11 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END FEATURES-11 -->


        <section id="pricing-1" style="margin-top:50px;" class="gr--whitesmoke pb-40 inner-page-hero pricing-section">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="section-title mb-70">
                            <!-- Title -->
                            <h2 class="s-52 w-700">Simple, Flexible Pricing</h2>
                        </div>
                    </div>
                </div>
                <!-- END SECTION TITLE -->

                <!-- PRICING TABLES -->
                <div class="pricing-1-wrapper">
                    <div class="row row-cols-1 row-cols-md-3">
                        <!-- STARTER PLAN -->
                        <div class="col">
                            <div id="pt-1-1" class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp">
                                <!-- TABLE HEADER -->
                                <div class="pricing-table-header">
                                    <h5 class="s-24 w-700">Basic</h5>
                                    <div class="price">
                                        <sup class="color--black">£</sup>
                                        <span class="color--black">8</span>
                                        <sup class="validity color--grey">&nbsp;/mo</sup>
                                        <p class="color--grey">
                                        <ol>
                                            <li>Assign Executors</li>
                                            <li>Record Assets & Liabilities</li>
                                        </ol>
                                        </p>
                                    </div>
                                    <a href="{{ route('stripe') }}" class="pt-btn btn r-04 btn--theme hover--theme">Get Started</a>
                                </div>
                                <!-- PRICING FEATURES -->
                                <ul class="pricing-features color--black ico-10 ico--green mt-25">
                                    <!-- Features here -->
                                </ul>
                            </div>
                        </div>
                        <!-- BASIC PLAN -->
                        <div class="col">
                            <div id="pt-1-2" class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp">
                                <div class="pricing-table-header">
                                    <h5 class="s-24">Standard</h5>
                                    <div class="price">
                                        <div class="price2" style="display: block;">
                                            <sup class="color--black">£</sup>
                                            <span class="color--black">20.00</span>
                                            <sup class="validity color--grey">&nbsp;/mo</sup>
                                        </div>
                                        <p class="color--grey">
                                        <ol>
                                            <li>Assign Executors</li>
                                            <li>Assign Advisers</li>
                                            <li>Document Uploads</li>
                                            <li>Record Assets & Liabilities</li>
                                            <li>Access to Secure Messaging System</li>
                                        </ol>
                                        </p>
                                    </div>
                                    <a href="{{ route('stripe') }}" class="pt-btn btn r-04 btn--theme hover--theme">Get Started</a>
                                </div>
                                <!-- PRICING FEATURES -->
                                <ul class="pricing-features color--black ico-10 ico--green mt-25">
                                    <!-- Features here -->
                                </ul>
                            </div>
                        </div>
                        <!-- ADVANCED PLAN -->
                        <div class="col">
                            <div id="pt-1-3" class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp">
                                <div class="pricing-table-header">
                                    <h5 class="s-24">Premium</h5>
                                    <div class="price">
                                        <div class="price2" style="display: block;">
                                            <sup class="color--black">£</sup>
                                            <span class="color--black">40.00</span>
                                            <sup class="validity color--grey">&nbsp;/mo</sup>
                                        </div>
                                        <p class="color--grey">
                                        <ol>
                                            <li>Assign Executors</li>
                                            <li>Assign Advisers</li>
                                            <li>Document Uploads</li>
                                            <li>Record Assets & Liabilities</li>
                                            <li>Access to Secure Messaging System</li>
                                            <li>Record Donations</li>
                                            <li>Record Life Notes</li>
                                            <li>Record Wishes</li>
                                            <li>Access to Executor Hub AI</li>
                                        </ol>
                                        </p>
                                    </div>
                                    <a href="{{ route('stripe') }}" class="pt-btn btn r-04 btn--theme hover--theme">Get Started</a>
                                </div>
                                <!-- PRICING FEATURES -->
                                <ul class="pricing-features color--black ico-10 ico--green mt-25">
                                    <!-- Features here -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End container -->
        </section>

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
                                    <h2 class="s-50 w-700">Mission statement</h2>

                                    <!-- Text -->
                                    <p class="p-xl">Executor Hub was founded with the mission to empower individuals to
                                        seamlessly manage their digital and financial legacies through a secure,
                                        reliable, and user-friendly platform. In today’s world, where digital solutions
                                        are the emerging trend, we ensure your legacy is preserved and accessible for
                                        future generations.</p>
                                </div>
                            </div>
                        </div>

                        <!-- IMAGE BLOCK -->
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="bc-5-img bc-5-tablet img-block-hidden video-preview wow fadeInUp">
                                    <!-- Play Icon -->
                                    <a class="video-popup1" href="#">
                                        <div class="video-btn video-btn-xl bg--theme">
                                            <div class="video-block-wrapper"><span class="flaticon-play-button"></span>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Preview Image -->
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/tablet-02.png')}}"
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

        <!-- DIVIDER LINE -->
        <hr class="divider" />


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
                            <img class="img-fluid" src="{{asset('assets/frontend/images/tablet-02.png')}}"
                                alt="content-image" />
                        </div>
                    </div>
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->

        <!-- TESTIMONIALS-2
			============================================= -->
        <section id="reviews-2" class="pt-100 reviews-section">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-70">
                            <!-- Title -->
                            <h2 class="s-50 w-700">Our Happy Customers</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">Ligula risus auctor tempus magna feugiat lacinia.</p>
                        </div>
                    </div>
                </div>

                <!-- TESTIMONIALS-2 WRAPPER -->
                <div class="reviews-2-wrapper rel shape--02 shape--whitesmoke">
                    <div class="row align-items-center row-cols-1 row-cols-md-2">
                        <!-- TESTIMONIAL #1 -->
                        <div class="col">
                            <div id="rw-2-1" class="review-2 bg--white-100 block-shadow r-08">
                                <!-- Quote Icon -->
                                <div class="review-ico ico-65"><span class="flaticon-quote"></span></div>

                                <!-- Text -->
                                <div class="review-txt">
                                    <!-- Text -->
                                    <p>Quaerat sodales sapien euismod blandit aliquet ipsum primis undo and cubilia
                                        laoreet augue and luctus magna dolor luctus egestas sapien vitae</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-1.jpg')}}"
                                                alt="review-avatar" />
                                        </div>

                                        <!-- Data -->
                                        <div class="review-author">
                                            <h6 class="s-18 w-700">Scott Boxer</h6>
                                            <p class="p-sm">@scott_boxer</p>
                                        </div>
                                    </div>
                                    <!-- End Author -->
                                </div>
                                <!-- End Text -->
                            </div>
                        </div>
                        <!-- END TESTIMONIAL #1 -->

                        <!-- TESTIMONIAL #2 -->
                        <div class="col">
                            <div id="rw-2-2" class="review-2 bg--white-100 block-shadow r-08">
                                <!-- Quote Icon -->
                                <div class="review-ico ico-65"><span class="flaticon-quote"></span></div>

                                <!-- Text -->
                                <div class="review-txt">
                                    <!-- Text -->
                                    <p>At sagittis congue augue and magna ipsum vitae a purus ipsum primis diam a
                                        cubilia laoreet augue egestas luctus a donec vitae ultrice ligula magna suscipit
                                        lectus gestas augue into cubilia</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-2.jpg')}}"
                                                alt="review-avatar" />
                                        </div>

                                        <!-- Data -->
                                        <div class="review-author">
                                            <h6 class="s-18 w-700">Joel Peterson</h6>
                                            <p class="p-sm">Internet Surfer</p>
                                        </div>
                                    </div>
                                    <!-- End Author -->
                                </div>
                                <!-- End Text -->
                            </div>
                        </div>
                        <!-- END TESTIMONIAL #2 -->

                        <!-- TESTIMONIAL #3 -->
                        <div class="col">
                            <div id="rw-2-3" class="review-2 bg--white-100 block-shadow r-08">
                                <!-- Quote Icon -->
                                <div class="review-ico ico-65"><span class="flaticon-quote"></span></div>

                                <!-- Text -->
                                <div class="review-txt">
                                    <!-- Text -->
                                    <p>An augue cubilia laoreet magna suscipit egestas and ipsum a lectus purus ipsum
                                        primis and augue ultrice ligula and egestas a suscipit lectus gestas undo auctor
                                        tempus feugiat impedit quaerat</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-5.jpg')}}"
                                                alt="review-avatar" />
                                        </div>

                                        <!-- Data -->
                                        <div class="review-author">
                                            <h6 class="s-18 w-700">Jennifer Harper</h6>
                                            <p class="p-sm">App Developer</p>
                                        </div>
                                    </div>
                                    <!-- End Author -->
                                </div>
                                <!-- End Text -->
                            </div>
                        </div>
                        <!-- END TESTIMONIAL #3 -->

                        <!-- TESTIMONIAL #4 -->
                        <div class="col">
                            <div id="rw-2-4" class="review-2 bg--white-100 block-shadow r-08">
                                <!-- Quote Icon -->
                                <div class="review-ico ico-65"><span class="flaticon-quote"></span></div>

                                <!-- Text -->
                                <div class="review-txt">
                                    <!-- Text -->
                                    <p>Augue at vitae purus tempus egestas volutpat augue undo cubilia laoreet magna
                                        suscipit luctus dolor blandit at purus tempus feugiat impedit</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-8.jpg')}}"
                                                alt="review-avatar" />
                                        </div>

                                        <!-- Data -->
                                        <div class="review-author">
                                            <h6 class="s-18 w-700">Evelyn Martinez</h6>
                                            <p class="p-sm">WordPress Consultant</p>
                                        </div>
                                    </div>
                                    <!-- End Author -->
                                </div>
                                <!-- End Text -->
                            </div>
                        </div>
                        <!-- END TESTIMONIAL #4 -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- END TESTIMONIALS-2 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TESTIMONIALS-2 -->

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
                                    <p>Easy to use portal with runtime configurations./p>
                                </li>

                                <li class="list-item">
                                    <p class="mb-0">Easily accessible at anywhere.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->

                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6 order-first order-md-2">
                        <div class="img-block right-column wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-05.png')}}"
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
                                    Have any questions?
                                    <a href="#contacts-1" class="color--theme">Get in Touch</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End container -->
        </section>
        <!-- END FAQs-3 -->

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
                                    <p class="p-lg">Register Your Account with a Free Trial and then purchase the
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

        <section id="contacts-1" class="pb-50 inner-page-hero contacts-section division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title text-center mb-80">
                            <!-- Title -->
                            <h2 class="s-52 w-700">Questions? Let's Talk</h2>

                            <!-- Text -->
                            <p class="p-lg">Want to learn more about Executor Hub, get a quote, or speak with an expert?
                                Let us know what you are looking for and we’ll get back to you right away</p>
                        </div>
                    </div>
                </div>

                <!-- CONTACT FORM -->
                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-10 col-xl-8">
                        <div class="form-holder">
                            <form name="contactform" class="row contact-form" novalidate="novalidate">
                                <!-- Form Select -->
                                <div class="col-md-12 input-subject">
                                    <p class="p-lg">This question is about:</p>
                                    <span>Choose a topic, so we know who to send your request to: </span>
                                    <select class="form-select subject" aria-label="Default select example">
                                        <option selected="">This question is about...</option>
                                        <option>Registering/Authorising</option>
                                        <option>Using Application</option>
                                        <option>Troubleshooting</option>
                                        <option>Backup/Restore</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <!-- Contact Form Input -->
                                <div class="col-md-12">
                                    <p class="p-lg">Your Name:</p>
                                    <span>Please enter your real name: </span>
                                    <input type="text" name="name" class="form-control name" placeholder="Your Name*" />
                                </div>

                                <div class="col-md-12">
                                    <p class="p-lg">Your Email Address:</p>
                                    <span>Please carefully check your email address for accuracy</span>
                                    <input type="text" name="email" class="form-control email"
                                        placeholder="Email Address*" />
                                </div>

                                <div class="col-md-12">
                                    <p class="p-lg">Explain your question in details:</p>
                                    <span>Your Issue/Concern</span>
                                    <textarea class="form-control message" name="message" rows="6"
                                        placeholder="I have a problem with..."></textarea>
                                </div>

                                <!-- Contact Form Button -->
                                <div class="col-md-12 mt-15 form-btn text-right">
                                    <button type="submit" class="btn btn--theme hover--theme submit">Submit
                                        Request</button>
                                </div>

                                <div class="contact-form-notice">
                                    <p class="p-sm">
                                        We are committed to your privacy. Executor Hub uses the information you provide
                                        us to contact you about our relevant content, products, and services. You may
                                        unsubscribe from these communications at any
                                        time. For more information, check out our <a href="privacy.html">Privacy
                                            Policy</a>.
                                    </p>
                                </div>

                                <!-- Contact Form Message -->
                                <div class="col-lg-12 contact-form-msg">
                                    <span class="loading"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END CONTACT FORM -->
            </div>
            <!-- End container -->
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
                                    <p><a href="#pricing-1">Pricing</a></p>
                                </li>
                                <li>
                                    <p><a href="#faqs-3">FAQ's</a></p>
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
                                    <p><a href="terms.html">Terms of Use</a></p>
                                </li>
                                <li>
                                    <p><a href="privacy.html">Privacy Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="cookies.html">Cookie Policy</a></p>
                                </li>
                                <li>
                                    <p><a href="#">Site Map</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END FOOTER LINKS -->

                    <!-- FOOTER NEWSLETTER FORM -->
                    <div class="col-sm-10 col-md-8 col-lg-4 col-xl-3">
                        <div class="footer-form">
                            <!-- Title -->
                            <h6 class="s-17 w-700">Follow the Best</h6>

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
                                <p class="p-sm">&copy; 2024 Executor Box. <span>All Rights Reserved</span></p>
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


    <script>
        $(document).on({
            contextmenu: function(e) {
                console.log("ctx menu button:", e.which);

                // Stop the context menu
                e.preventDefault();
            },
            mousedown: function(e) {
                console.log("normal mouse down:", e.which);
            },
            mouseup: function(e) {
                console.log("normal mouse up:", e.which);
            },
        });
    </script>

    <script>
        $(function() {
            $(".switch").click(function() {
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
        $(document).ready(function() {
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