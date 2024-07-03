<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="DSAThemes" />
    <meta name="description" content="Martex - Software, App, SaaS & Startup Landing Pages Pack" />
    <meta name="keywords" content="Responsive, HTML5, DSAThemes, Landing, Software, Mobile App, SaaS, Startup, Creative, Digital Product" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SITE TITLE -->
    <title>Martex - Software, App, SaaS & Startup Landing Pages Pack</title>

    <!-- FAVICON AND TOUCH ICONS -->
    <link rel="shortcut icon" href="{{ asset('assets/frontend/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('assets/frontend/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/frontend/images/apple-touch-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/frontend/images/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/frontend/images/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/images/apple-touch-icon.png') }}" />
    <link rel="icon" href="{{ asset('assets/frontend/images/apple-touch-icon.png') }}" type="image/x-icon" />

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />

    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- FONT ICONS -->
    <link href="{{ asset('assets/frontend/css/flaticon.css') }}" rel="stylesheet" />

    <!-- PLUGINS STYLESHEET -->
    <link href="{{ asset('assets/frontend/css/menu.css') }}" rel="stylesheet" />
    <link id="effect" href="{{ asset('assets/frontend/css/dropdown-effects/fade-down.css') }}" media="all" rel="stylesheet" />
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
    <link href="{{ asset('assets/frontend/css/magenta-theme.css') }}" rel="alternate stylesheet" title="magenta-theme" />
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
                    <span class="smllogo"><img src="{{asset('assets/frontend/images/logo-skyblue.png')}}" alt="mobile-logo" /></span>
                    <a id="wsnavtoggle" class="wsanimated-arrow"><span></span></a>
                </div>

                <!-- NAVIGATION MENU -->
                <div class="wsmainfull menu clearfix">
                    <div class="wsmainwp clearfix">
                        <!-- HEADER BLACK LOGO -->
                        <div class="desktoplogo">
                            <a href="#hero-3" class="logo-black">
                                <img class="light-theme-img" src="{{asset('assets/frontend/images/logo-skyblue.png')}}" alt="logo" />
                                <img class="dark-theme-img" src="{{asset('assets/frontend/images/logo-skyblue-white.png')}}" alt="logo" />
                            </a>
                        </div>

                        <!-- HEADER WHITE LOGO -->
                        <div class="desktoplogo">
                            <a href="#hero-3" class="logo-white"><img src="{{asset('assets/frontend/images/logo-white.png')}}" alt="logo" /></a>
                        </div>

                        <!-- MAIN MENU -->
                        <nav class="wsmenu clearfix">
                            <ul class="wsmenu-list nav-theme">
                                <!-- DROPDOWN SUB MENU -->
                                <li aria-haspopup="true"><a href="#hero-3" class="h-link">Home</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#features-11" class="h-link">Features</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#pricing-1" class="h-link">Pricing</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#faqs-3" class="h-link">FAQs</a></li>

                                <!-- SIMPLE NAVIGATION LINK -->
                                <li class="nl-simple" aria-haspopup="true"><a href="#contacts-1" class="h-link">Contact Us</a></li>
                                
                                @guest
                                <li class="nl-simple reg-fst-link mobile-last-link" aria-haspopup="true">
                                    <a href="{{route('login')}}" class="h-link">Sign in</a>
                                </li>
                                <li class="nl-simple" aria-haspopup="true">
                                    <a href="{{route('register')}}" class="btn r-04 btn--theme hover--tra-white last-link">Sign up</a>
                                </li>
                                @else
                                <li class="nl-simple" aria-haspopup="true">
                                    <a href="{{route('home')}}" class="btn r-04 btn--theme hover--tra-white last-link">Dashboard</a>
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
                            <h2 class="s-60 w-700">Increase your website traffic with Martex</h2>

                            <!-- Text -->
                            <p class="p-lg">Mauris donec turpis suscipit sapien ociis sagittis sapien tempor a volute ligula and aliquet tortor</p>

                            <!-- HERO DIGITS -->
                            <div class="hero-digits">
                                <!-- DIGIT BLOCK #1 -->
                                <div id="hd-1-1" class="wow fadeInUp">
                                    <div class="hero-digits-block">
                                        <!-- Digit -->
                                        <div class="block-digit">
                                            <h2 class="s-46 statistic-number">3<span>x</span></h2>
                                        </div>

                                        <!-- Text -->
                                        <div class="block-txt">
                                            <p class="p-sm">Tempor sapien and quaerat placerat</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- END DIGIT BLOCK #1 -->

                                <!-- DIGIT BLOCK #2 -->
                                <div id="hd-1-2" class="wow fadeInUp">
                                    <div class="hero-digits-block">
                                        <!-- Digit -->
                                        <div class="block-digit">
                                            <h2 class="s-46 statistic-number">29<span>%</span></h2>
                                        </div>

                                        <!-- Text -->
                                        <div class="block-txt">
                                            <p class="p-sm">Ligula suscipit vitae and rutrum turpis</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- END DIGIT BLOCK #2 -->
                            </div>
                            <!-- END HERO DIGITS -->
                        </div>
                    </div>
                    <!-- END HERO TEXT -->

                    <!-- HERO IMAGE -->
                    <div class="col-md-6">
                        <div class="hero-3-img wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/tablet-01.png')}}" alt="hero-image" />
                        </div>
                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </section>
        <!-- END HERO-3 -->

        <!-- FEATURES-11
			============================================= -->
        <section id="features-11" class="pt-100 features-section division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-70">
                            <!-- Section ID -->
                            <span class="section-id">Endless Possibilities</span>

                            <!-- Title -->
                            <h2 class="s-50 w-700">Digital marketing that drives results for your business</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">Ligula risus auctor tempus magna feugiat lacinia.</p>
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
                                                <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Market Research</h6>
                                    <p>Porta semper lacus cursus feugiat primis ultrice ligula risus ociis auctor and tempus feugiat impedit felis cursus auctor augue mauris blandit ipsum</p>
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
                                                <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">User Experience</h6>
                                    <p>Porta semper lacus cursus feugiat primis ultrice ligula risus ociis auctor and tempus feugiat impedit felis cursus auctor augue mauris blandit ipsum</p>
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
                                                <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Digital Marketing</h6>
                                    <p>Porta semper lacus cursus feugiat primis ultrice ligula risus ociis auctor and tempus feugiat impedit felis cursus auctor augue mauris blandit ipsum</p>
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
                                                <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Web Development</h6>
                                    <p>Porta semper lacus cursus feugiat primis ultrice ligula risus ociis auctor and tempus feugiat impedit felis cursus auctor augue mauris blandit ipsum</p>
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
                                                <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Brand Design Identity</h6>
                                    <p>Porta semper lacus cursus feugiat primis ultrice ligula risus ociis auctor and tempus feugiat impedit felis cursus auctor augue mauris blandit ipsum</p>
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
                                                <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon -->

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">SEO & SMM Services</h6>
                                    <p>Porta semper lacus cursus feugiat primis ultrice ligula risus ociis auctor and tempus feugiat impedit felis cursus auctor augue mauris blandit ipsum</p>
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

        <!-- BOX CONTENT
			============================================= -->
        <section id="lnk-1" class="pt-100 ws-wrapper content-section">
            <div class="container">
                <div class="bc-1-wrapper bg--02 bg--fixed r-16">
                    <div class="section-overlay">
                        <div class="row d-flex align-items-center">
                            <!-- TEXT BLOCK -->
                            <div class="col-md-6 order-last order-md-2">
                                <div class="txt-block left-column wow fadeInRight">
                                    <!-- Section ID -->
                                    <span class="section-id">Strategies That Work</span>

                                    <!-- Title -->
                                    <h2 class="s-46 w-700">Quality traffic leads to quality customers!</h2>

                                    <!-- List -->
                                    <ul class="simple-list">
                                        <li class="list-item">
                                            <p>Cursus purus suscipit vitae cubilia magnis volute egestas vitae sapien turpis sodales magna</p>
                                        </li>

                                        <li class="list-item">
                                            <p class="mb-0">Tempor sapien quaerat an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam congue</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END TEXT BLOCK -->

                            <!-- IMAGE BLOCK -->
                            <div class="col-md-6 order-first order-md-2">
                                <div class="img-block right-column wow fadeInLeft">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/img-06.png')}}" alt="content-image" />
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                    </div>
                    <!-- End section overlay -->
                </div>
                <!-- End content wrapper -->
            </div>
            <!-- End container -->
        </section>
        <!-- END BOX CONTENT -->

        <section id="pricing-1" class="gr--whitesmoke pb-40 inner-page-hero pricing-section">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="section-title mb-70">
                            <!-- Title -->
                            <h2 class="s-52 w-700">Simple, Flexible Pricing</h2>

                            <!-- TOGGLE BUTTON -->
                            <div class="toggle-btn ext-toggle-btn toggle-btn-md mt-30">
                                <span class="toggler-txt">Billed monthly</span>
                                <label class="switch-wrap">
                                    <input type="checkbox" id="checbox" onclick="check()" />
                                    <span class="switcher bg--grey switcher--theme">
                                        <span class="show-annual"></span>
                                        <span class="show-monthly"></span>
                                    </span>
                                </label>
                                <span class="toggler-txt">Billed yearly</span>

                                <!-- Text -->
                                <p class="color--theme">Save up to 35% with yearly billing</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SECTION TITLE -->

                <!-- PRICING TABLES -->
                <div class="pricing-1-wrapper">
                    <div class="row row-cols-1 row-cols-md-3">
                        <!-- STARTER PLAN -->
                        <div class="col">
                            <div id="pt-1-1" class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                <!-- TABLE HEADER -->
                                <div class="pricing-table-header">
                                    <!-- Title -->
                                    <h5 class="s-24 w-700">Starter</h5>

                                    <!-- Price -->
                                    <div class="price">
                                        <sup class="color--black">$</sup>
                                        <span class="color--black">0</span>
                                        <sup class="validity color--grey">&nbsp;/ forever</sup>
                                        <p class="color--grey">For professionals getting started with smaller projects.</p>
                                    </div>

                                    <!-- Button -->
                                    <a href="#" class="pt-btn btn r-04 btn--theme hover--theme">Get srarted - it's free</a>
                                    <p class="p-sm btn-txt text-center color--grey">No credit card required</p>
                                </div>
                                <!-- END TABLE HEADER -->

                                <!-- PRICING FEATURES -->
                                <ul class="pricing-features color--black ico-10 ico--green mt-25">
                                    <li>
                                        <p><span class="flaticon-check"></span> 2 free projects</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> 1 GB of cloud storage</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> For personal use</p>
                                    </li>
                                    <li class="disabled-option">
                                        <p><span class="flaticon-check"></span> Weekly data backup</p>
                                    </li>
                                    <li class="disabled-option">
                                        <p><span class="flaticon-check"></span> No Ads. No trackers</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> 12/5 email support</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END STARTER PLAN -->

                        <!-- BASIC PLAN -->
                        <div class="col">
                            <div id="pt-1-2" class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                <!-- TABLE HEADER -->
                                <div class="pricing-table-header">
                                    <!-- Title -->
                                    <h5 class="s-24">Basic</h5>

                                    <!-- Price -->
                                    <div class="price">
                                        <!-- Monthly Price -->
                                        <div class="price2" style="display: block;">
                                            <sup class="color--black">$</sup>
                                            <span class="color--black">16.99</span>
                                            <sup class="validity color--grey">&nbsp;/ mo</sup>
                                        </div>

                                        <!-- Yearly Price -->
                                        <div class="price1" style="display: none;">
                                            <sup class="color--black">$</sup>
                                            <span class="color--black">142.75</span>
                                            <sup class="validity color--grey">&nbsp;/ yr</sup>

                                            <!-- Discount Badge -->
                                            <div class="pricing-discount bg--yellow-400 color--black r-36">
                                                <h6 class="s-17">Save 30%</h6>
                                            </div>
                                        </div>

                                        <!-- Text -->
                                        <p class="color--grey">For personal use or small teams with simple workflows.</p>
                                    </div>
                                    <!-- End Price -->

                                    <!-- Button -->
                                    <a href="#" class="pt-btn btn r-04 btn--theme hover--theme">Start 14-day trial</a>
                                    <p class="p-sm btn-txt text-center color--grey">7-Day Money Back Guarantee</p>
                                </div>
                                <!-- END TABLE HEADER -->

                                <!-- PRICING FEATURES -->
                                <ul class="pricing-features color--black ico-10 ico--green mt-25">
                                    <li>
                                        <p><span class="flaticon-check"></span> Up to 250 projects</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> 15 GB of Cloud Storage</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> Shared team workspace</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> Daily data backup</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> No Ads. No trackers</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> 12/7 email support</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END BASIC PLAN -->

                        <!-- ADVANCED PLAN -->
                        <div class="col">
                            <div id="pt-1-3" class="p-table pricing-1-table bg--white-100 block-shadow r-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                <!-- TABLE HEADER -->
                                <div class="pricing-table-header">
                                    <!-- Title -->
                                    <h5 class="s-24">Advanced</h5>

                                    <!-- Price -->
                                    <div class="price">
                                        <!-- Monthly Price -->
                                        <div class="price2" style="display: block;">
                                            <sup class="color--black">$</sup>
                                            <span class="color--black">24.99</span>
                                            <sup class="validity color--grey">&nbsp;/ mo</sup>
                                        </div>

                                        <!-- Yearly Price -->
                                        <div class="price1" style="display: none;">
                                            <sup class="color--black">$</sup>
                                            <span class="color--black">194.99</span>
                                            <sup class="validity color--grey">&nbsp;/ yr</sup>

                                            <!-- Discount Badge -->
                                            <div class="pricing-discount bg--yellow-400 color--black r-36">
                                                <h6 class="s-17">Save 35%</h6>
                                            </div>
                                        </div>

                                        <!-- Text -->
                                        <p class="color--grey">For growing teams that need more services and flexibility.</p>
                                    </div>
                                    <!-- End Price -->

                                    <!-- Button -->
                                    <a href="#" class="pt-btn btn r-04 btn--theme hover--theme">Upgrade your plan</a>
                                    <p class="p-sm btn-txt text-center color--grey">7-Day Money Back Guarantee</p>
                                </div>
                                <!-- END TABLE HEADER -->

                                <!-- PRICING FEATURES -->
                                <ul class="pricing-features color--black ico-10 ico--green mt-25">
                                    <li>
                                        <p><span class="flaticon-check"></span> Everything in Basic</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> Private cloud hosting</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> Custom security</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> Advanced user permissions</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> Multi-team management</p>
                                    </li>
                                    <li>
                                        <p><span class="flaticon-check"></span> 24/7 Email Support</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END ADVANCED PLAN -->
                    </div>
                </div>
                <!-- PRICING TABLES -->
            </div>
            <!-- End container -->
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
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-09.png')}}" alt="content-image" />
                        </div>
                    </div>

                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft">
                            <!-- Section ID -->
                            <span class="section-id">Automatic Workflows</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Optimizing your website for success</h2>

                            <!-- Text -->
                            <p>Sodales tempor sapien quaerat ipsum undo congue laoreet turpis neque auctor turpis vitae dolor luctus placerat magna and ligula cursus purus vitae purus an ipsum suscipit</p>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700">Get more done in less time</h5>

                            <!-- List -->
                            <ul class="simple-list">
                                <li class="list-item">
                                    <p>Sapien quaerat tempor an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam undo congue cursus dolor</p>
                                </li>

                                <li class="list-item">
                                    <p class="mb-0">Purus suscipit cursus vitae cubilia magnis volute egestas vitae sapien turpis ultrice auctor congue magna placerat</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->

        <!-- FEATURES-2
			============================================= -->
        <section id="features-2" class="pt-100 features-section division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-80">
                            <!-- Title -->
                            <h2 class="s-50 w-700">The Complete Solutions</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">Ligula risus auctor tempus magna feugiat lacinia.</p>
                        </div>
                    </div>
                </div>

                <!-- FEATURES-2 WRAPPER -->
                <div class="fbox-wrapper text-center">
                    <div class="row row-cols-1 row-cols-md-3">
                        <!-- FEATURE BOX #1 -->
                        <div class="col">
                            <div class="fbox-2 fb-1 wow fadeInUp">
                                <!-- Image -->
                                <div class="fbox-img gr--whitesmoke h-175">
                                    <img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/f_04.png')}}" alt="feature-image" />
                                    <img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/f_04_dark.png')}}" alt="feature-image" />
                                </div>

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Quick Integration</h6>
                                    <p>Luctus egestas augue undo ultrice aliquam in lacus congue dapibus</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #1 -->

                        <!-- FEATURE BOX #2 -->
                        <div class="col">
                            <div class="fbox-2 fb-2 wow fadeInUp">
                                <!-- Image -->
                                <div class="fbox-img gr--whitesmoke h-175">
                                    <img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/f_05.png')}}" alt="feature-image" />
                                    <img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/f_05_dark.png')}}" alt="feature-image" />
                                </div>

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Effortless Integration</h6>
                                    <p>Tempor laoreet augue undo ultrice aliquam in lacusq luctus feugiat</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #2 -->

                        <!-- FEATURE BOX #3 -->
                        <div class="col">
                            <div class="fbox-2 fb-3 wow fadeInUp">
                                <!-- Image -->
                                <div class="fbox-img gr--whitesmoke h-175">
                                    <img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/f_02.png')}}" alt="feature-image" />
                                    <img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/f_02_dark.png')}}" alt="feature-image" />
                                </div>

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h6 class="s-22 w-700">Advanced Analytics</h6>
                                    <p>Egestas luctus augue undo ultrice aliquam in lacus feugiat cursus</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #3 -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- END FEATURES-2 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END FEATURES-2 -->

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
                                    <h2 class="s-50 w-700">Build a customer-centric marketing strategy</h2>

                                    <!-- Text -->
                                    <p class="p-xl">Aliquam a augue suscipit luctus neque purus ipsum neque diam dolor primis libero tempus, blandit and cursus varius and magnis sodales</p>
                                </div>
                            </div>
                        </div>

                        <!-- IMAGE BLOCK -->
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="bc-5-img bc-5-tablet img-block-hidden video-preview wow fadeInUp">
                                    <!-- Play Icon -->
                                    <a class="video-popup1" href="https://www.youtube.com/embed/SZEflIVnhH8">
                                        <div class="video-btn video-btn-xl bg--theme">
                                            <div class="video-block-wrapper"><span class="flaticon-play-button"></span></div>
                                        </div>
                                    </a>

                                    <!-- Preview Image -->
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/tablet-02.png')}}" alt="content-image" />
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
        <div id="statistic-1" class="py-100 statistic-section division">
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
                                        <p class="p-md">Porta justo integer and velna vitae auctor</p>
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
                                        <h2 class="s-46 statistic-number"><span class="count-element">76</span>%</h2>
                                    </div>

                                    <!-- Text -->
                                    <div class="statistic-block-txt color--grey">
                                        <p class="p-md">Ligula magna suscipit vitae and rutrum</p>
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
                                        <h2 class="s-46 statistic-number"><span class="count-element">4</span>.<span class="count-element">93</span></h2>
                                    </div>

                                    <!-- Text -->
                                    <div class="statistic-block-txt color--grey">
                                        <p class="p-md">Sagittis congue augue egestas an egestas</p>
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

        <!-- FEATURES-12
			============================================= -->
        <section id="features-12" class="shape--bg shape--white-500 pt-100 features-section division">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <!-- TEXT BLOCK -->
                    <div class="col-md-5">
                        <div class="txt-block left-column wow fadeInRight">
                            <!-- Section ID -->
                            <span class="section-id">One-Stop Solution</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Smart solutions, real-time results</h2>

                            <!-- Text -->
                            <p>Sodales tempor sapien quaerat ipsum and congue undo laoreet turpis neque auctor turpis vitae dolor luctus placerat magna ligula and cursus vitae</p>

                            <!-- List -->
                            <ul class="simple-list">
                                <li class="list-item">
                                    <p class="mb-0">Tempor sapien quaerat undo ipsum laoreet diam purus sapien a dolor ociis ultrice ipsum aliquam congue a dolor cursus congue varius magnis</p>
                                </li>
                            </ul>

                            <!-- Link -->
                            <div class="txt-block-tra-link mt-25">
                                <a href="#features-5" class="tra-link ico-20 color--theme"> The smarter way to work <span class="flaticon-next"></span> </a>
                            </div>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->

                    <!-- FEATURES-12 WRAPPER -->
                    <div class="col-md-7">
                        <div class="fbox-12-wrapper wow fadeInLeft">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- FEATURE BOX #1 -->
                                    <div id="fb-12-1" class="fbox-12 bg--white-100 block-shadow r-12 mb-30">
                                        <!-- Icon -->
                                        <div class="fbox-ico ico-50">
                                            <div class="shape-ico color--theme">
                                                <!-- Vector Icon -->
                                                <span class="flaticon-layers-1"></span>

                                                <!-- Shape -->
                                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- End Icon -->

                                        <!-- Text -->
                                        <div class="fbox-txt">
                                            <h5 class="s-19 w-700">Content Marketing</h5>
                                            <p>Porta semper lacus and cursus feugiat at primis ultrice a ligula auctor</p>
                                        </div>
                                    </div>

                                    <!-- FEATURE BOX #2 -->
                                    <div id="fb-12-2" class="fbox-12 bg--white-100 block-shadow r-12">
                                        <!-- Icon -->
                                        <div class="fbox-ico ico-50">
                                            <div class="shape-ico color--theme">
                                                <!-- Vector Icon -->
                                                <span class="flaticon-tutorial"></span>

                                                <!-- Shape -->
                                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- End Icon -->

                                        <!-- Text -->
                                        <div class="fbox-txt">
                                            <h5 class="s-19 w-700">Video Marketing</h5>
                                            <p>Porta semper lacus and cursus feugiat at primis ultrice a ligula auctor</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- FEATURE BOX #3 -->
                                    <div id="fb-12-3" class="fbox-12 bg--white-100 block-shadow r-12 mb-30">
                                        <!-- Icon -->
                                        <div class="fbox-ico ico-50">
                                            <div class="shape-ico color--theme">
                                                <!-- Vector Icon -->
                                                <span class="flaticon-pay-per-click"></span>

                                                <!-- Shape -->
                                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- End Icon -->

                                        <!-- Text -->
                                        <div class="fbox-txt">
                                            <h5 class="s-19 w-700">Pay Per Click (PPC)</h5>
                                            <p>Porta semper lacus and cursus feugiat at primis ultrice a ligula auctor</p>
                                        </div>
                                    </div>

                                    <!-- FEATURE BOX #4 -->
                                    <div id="fb-12-4" class="fbox-12 bg--white-100 block-shadow r-12">
                                        <!-- Icon -->
                                        <div class="fbox-ico ico-50">
                                            <div class="shape-ico color--theme">
                                                <!-- Vector Icon -->
                                                <span class="flaticon-taxes"></span>

                                                <!-- Shape -->
                                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M69.8,-23C76.3,-2.7,57.6,25.4,32.9,42.8C8.1,60.3,-22.7,67,-39.1,54.8C-55.5,42.7,-57.5,11.7,-48.6,-11.9C-39.7,-35.5,-19.8,-51.7,5.9,-53.6C31.7,-55.6,63.3,-43.2,69.8,-23Z" transform="translate(100 100)" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- End Icon -->

                                        <!-- Text -->
                                        <div class="fbox-txt">
                                            <h5 class="s-19 w-700">Business Analytics</h5>
                                            <p>Porta semper lacus and cursus feugiat at primis ultrice a ligula auctor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                    </div>
                    <!-- END FEATURES-12 WRAPPER -->
                </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </section>
        <!-- END FEATURES-12 -->

        <!-- TEXT CONTENT
			============================================= -->
        <section class="py-100 ct-02 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-10.png')}}" alt="content-image" />
                        </div>
                    </div>

                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft">
                            <!-- Section ID -->
                            <span class="section-id">Enhance Engagement</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Engage your most valuable visitors</h2>

                            <!-- Text -->
                            <p>Sodales tempor sapien quaerat ipsum undo congue laoreet turpis neque auctor turpis vitae dolor luctus placerat magna and ligula cursus purus vitae purus an ipsum suscipit</p>

                            <!-- List -->
                            <ul class="simple-list">
                                <li class="list-item">
                                    <p>Sapien quaerat tempor an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam undo congue cursus dolor</p>
                                </li>

                                <li class="list-item">
                                    <p class="mb-0">Purus suscipit cursus vitae cubilia magnis volute egestas vitae sapien turpis ultrice auctor congue magna placerat</p>
                                </li>
                            </ul>

                            <!-- Link -->
                            <div class="txt-block-tra-link mt-25">
                                <a href="#integrations-2" class="tra-link ico-20 color--theme"> All-in-one platform <span class="flaticon-next"></span> </a>
                            </div>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->

        <!-- TEXT CONTENT
			============================================= -->
        <section class="bg--white-400 py-100 ct-04 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- TEXT BLOCK -->
                    <div class="col-md-6 order-last order-md-2">
                        <div class="txt-block left-column wow fadeInRight">
                            <!-- CONTENT BOX #1 -->
                            <div class="cbox-2 process-step">
                                <!-- Icon -->
                                <div class="ico-wrap">
                                    <div class="cbox-2-ico bg--theme color--white">1</div>
                                    <span class="cbox-2-line"></span>
                                </div>

                                <!-- Text -->
                                <div class="cbox-2-txt">
                                    <h5 class="s-22 w-700">Enhanced Security Features</h5>
                                    <p>Ligula risus auctor tempus feugiat dolor lacinia nemo purus in lipsum purus sapien quaerat a primis viverra tellus vitae luctus dolor ipsum neque ligula quaerat</p>
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
                                    <h5 class="s-22 w-700">No Personal Data Collected</h5>
                                    <p>Ligula risus auctor tempus feugiat dolor lacinia nemo purus in lipsum purus sapien quaerat a primis viverra tellus vitae luctus dolor ipsum neque ligula quaerat</p>
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
                                    <h5 class="s-22 w-700">Weekly Email Reports</h5>
                                    <p class="mb-0">Ligula risus auctor tempus feugiat dolor lacinia nemo purus in lipsum purus sapien quaerat a primis viverra tellus vitae luctus dolor ipsum n eque ligula quaerat</p>
                                </div>
                            </div>
                            <!-- END CONTENT BOX #3 -->
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->

                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6 order-first order-md-2">
                        <div class="img-block wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/tablet-02.png')}}" alt="content-image" />
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
        <section id="lnk-3" class="pt-100 ct-02 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-02.png')}}" alt="content-image" />
                        </div>
                    </div>

                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft">
                            <!-- Section ID -->
                            <span class="section-id">Easy Integration</span>

                            <!-- Title -->
                            <h2 class="s-46 w-700">Plug your essential tools in few clicks</h2>

                            <!-- List -->
                            <ul class="simple-list">
                                <li class="list-item">
                                    <p>Cursus purus suscipit vitae cubilia magnis volute egestas vitae sapien turpis sodales magna undo aoreet primis</p>
                                </li>

                                <li class="list-item">
                                    <p class="mb-0">Tempor sapien quaerat an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam undo congue dolor cursus purus congue and ipsum purus sapien a blandit</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->
                </div>
                <!-- END SECTION CONTENT (ROW) -->
            </div>
            <!-- End container -->
        </section>
        <!-- END TEXT CONTENT -->

        <!-- FEATURES-5
			============================================= -->
        <section id="features-5" class="pt-100 features-section division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="section-title mb-80">
                            <!-- Title -->
                            <h2 class="s-50 w-700">Reach your audience through social media marketing</h2>

                            <!-- Text -->
                            <p class="s-21 color--grey">Ligula risus auctor tempus magna feugiat lacinia.</p>
                        </div>
                    </div>
                </div>

                <!-- FEATURES-5 WRAPPER -->
                <div class="fbox-wrapper text-center">
                    <div class="row d-flex align-items-center">
                        <!-- FEATURE BOX #1 -->
                        <div class="col-md-6">
                            <div class="fbox-5 fb-1 gr--smoke r-16 wow fadeInUp">
                                <!-- Text -->
                                <div class="fbox-txt order-last order-md-2">
                                    <h5 class="s-26 w-700">Data Integrations</h5>
                                    <p>Aliquam a augue suscipit luctus diam neque purus ipsum neque and dolor primis libero</p>
                                </div>

                                <!-- Image -->
                                <div class="fbox-5-img order-first order-md-2">
                                    <img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/f_06.png')}}" alt="feature-image" />
                                    <img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/f_06_dark.png')}}" alt="feature-image" />
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #1 -->

                        <!-- FEATURE BOX #2 -->
                        <div class="col-md-6">
                            <div class="fbox-5 fb-2 gr--smoke r-16 wow fadeInUp">
                                <!-- Image -->
                                <div class="fbox-5-img">
                                    <img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/f_07.png')}}" alt="feature-image" />
                                    <img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/f_07_dark.png')}}" alt="feature-image" />
                                </div>

                                <!-- Text -->
                                <div class="fbox-txt">
                                    <h5 class="s-26 w-700">Research Solutions</h5>
                                    <p>Aliquam a augue suscipit luctus diam neque purus ipsum neque and dolor primis libero</p>
                                </div>
                            </div>
                        </div>
                        <!-- END FEATURE BOX #2 -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- END FEATURES-5 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END FEATURES-5 -->

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
                                    <p>Quaerat sodales sapien euismod blandit aliquet ipsum primis undo and cubilia laoreet augue and luctus magna dolor luctus egestas sapien vitae</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-1.jpg')}}" alt="review-avatar" />
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
                                    <p>At sagittis congue augue and magna ipsum vitae a purus ipsum primis diam a cubilia laoreet augue egestas luctus a donec vitae ultrice ligula magna suscipit lectus gestas augue into cubilia</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-2.jpg')}}" alt="review-avatar" />
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
                                    <p>An augue cubilia laoreet magna suscipit egestas and ipsum a lectus purus ipsum primis and augue ultrice ligula and egestas a suscipit lectus gestas undo auctor tempus feugiat impedit quaerat</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-5.jpg')}}" alt="review-avatar" />
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
                                    <p>Augue at vitae purus tempus egestas volutpat augue undo cubilia laoreet magna suscipit luctus dolor blandit at purus tempus feugiat impedit</p>

                                    <!-- Author -->
                                    <div class="author-data clearfix">
                                        <!-- Avatar -->
                                        <div class="review-avatar">
                                            <img src="{{asset('assets/frontend/images/review-author-8.jpg')}}" alt="review-avatar" />
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

        <!-- BRANDS-1
			============================================= -->
        <div id="brands-1" class="pt-80 brands-section">
            <div class="container">
                <!-- BRANDS TITLE -->
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        <div class="brands-title mb-50">
                            <h5 class="s-19">Martex is loved and trusted by thousands</h5>
                        </div>
                    </div>
                </div>

                <!-- BRANDS CAROUSEL -->
                <div class="row">
                    <div class="col text-center">
                        <div class="owl-carousel brands-carousel-6">
                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-1.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-1-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-2.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-3-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-4.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-4-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-5.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-5-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-6.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-6-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-7.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-7-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-8.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-8-white.png')}}" alt="brand-logo" /></a>
                            </div>

                            <!-- BRAND LOGO IMAGE -->
                            <div class="brand-logo">
                                <a href="#"><img class="img-fluid light-theme-img" src="{{asset('assets/frontend/images/brand-9.png')}}" alt="brand-logo" /></a>
                                <a href="#"><img class="img-fluid dark-theme-img" src="{{asset('assets/frontend/images/brand-9-white.png')}}" alt="brand-logo" /></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END BRANDS CAROUSEL -->
            </div>
            <!-- End container -->
        </div>
        <!-- END BRANDS-1 -->

        <!-- INTEGRATIONS-2
			============================================= -->
        <section id="integrations-2" class="pt-100 integrations-section">
            <div class="container">
                <!-- INTEGRATIONS-2 WRAPPER -->
                <div class="integrations-2-wrapper bg--white-400 r-12 text-center">
                    <!-- SECTION TITLE -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-9">
                            <div class="section-title mb-50">
                                <!-- Title -->
                                <h2 class="s-50 w-700">Automate your workflow with our integrations</h2>

                                <!-- Text -->
                                <p class="s-21 color--grey">Ligula risus auctor tempus magna feugiat lacinia.</p>
                            </div>
                        </div>
                    </div>

                    <!-- TOOLS ROW -->
                    <div class="row row-cols-1 row-cols-sm-3 row-cols-md-5">
                        <!-- TOOL #1 -->
                        <div class="col">
                            <a href="#" class="in_tool it-1 r-12 wow fadeInUp">
                                <!-- Logo -->
                                <div class="in_tool_logo ico-65 bg--white-100 block-shadow r-12">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/png_icons/tool-1.png')}}" alt="brand-logo" />
                                </div>

                                <!-- Title -->
                                <h6 class="s-17 w-700">Zapier</h6>
                            </a>
                        </div>
                        <!-- END TOOL #1 -->

                        <!-- TOOL #2 -->
                        <div class="col">
                            <a href="#" class="in_tool it-2 r-12 wow fadeInUp">
                                <!-- Logo -->
                                <div class="in_tool_logo ico-65 bg--white-100 block-shadow r-12">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/png_icons/tool-2.png')}}" alt="brand-logo" />
                                </div>

                                <!-- Title -->
                                <h6 class="s-17 w-700">Google Analytics</h6>
                            </a>
                        </div>
                        <!-- END TOOL #2 -->

                        <!-- TOOL #3 -->
                        <div class="col">
                            <a href="#" class="in_tool it-3 r-12 wow fadeInUp">
                                <!-- Logo -->
                                <div class="in_tool_logo ico-65 bg--white-100 block-shadow r-12">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/png_icons/tool-3.png')}}" alt="brand-logo" />
                                </div>

                                <!-- Title -->
                                <h6 class="s-17 w-700">Amplitude</h6>
                            </a>
                        </div>
                        <!-- END TOOL #3 -->

                        <!-- TOOL #4 -->
                        <div class="col">
                            <a href="#" class="in_tool it-4 r-12 wow fadeInUp">
                                <!-- Logo -->
                                <div class="in_tool_logo ico-65 bg--white-100 block-shadow r-12">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/png_icons/tool-4.png')}}" alt="brand-logo" />
                                </div>

                                <!-- Title -->
                                <h6 class="s-17 w-700">Hubspot</h6>
                            </a>
                        </div>
                        <!-- END TOOL #4 -->

                        <!-- TOOL #5 -->
                        <div class="col">
                            <a href="#" class="in_tool it-5 r-12 wow fadeInUp">
                                <!-- Logo -->
                                <div class="in_tool_logo ico-65 bg--white-100 block-shadow r-12">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/png_icons/tool-5.png')}}" alt="brand-logo" />
                                </div>

                                <!-- Title -->
                                <h6 class="s-17 w-700">MailChimp</h6>
                            </a>
                        </div>
                        <!-- END TOOL #5 -->
                    </div>
                    <!-- END TOOLS ROW -->

                    <!-- MORE BUTTON -->
                    <div class="row">
                        <div class="col">
                            <div class="more-btn text-center mt-60 wow fadeInUp">
                                <a href="integrations.html" class="btn btn--tra-grey hover--theme">View all integrations</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END INTEGRATIONS-2 WRAPPER -->
            </div>
            <!-- End container -->
        </section>
        <!-- END INTEGRATIONS-2 -->

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
                                Nemo ipsam egestas volute turpis egestas ipsum and purus sapien ultrice an aliquam quaerat ipsum augue turpis sapien cursus congue magna purus quaerat at ligula purus egestas magna cursus undo varius
                                purus magnis sapien quaerat
                            </p>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700">Get more done in less time</h5>

                            <!-- List -->
                            <ul class="simple-list">
                                <li class="list-item">
                                    <p>Sapien quaerat tempor an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam undo congue cursus dolor</p>
                                </li>

                                <li class="list-item">
                                    <p class="mb-0">Purus suscipit cursus vitae cubilia magnis volute egestas vitae sapien turpis ultrice auctor congue magna placerat</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->

                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6 order-first order-md-2">
                        <div class="img-block right-column wow fadeInLeft">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-05.png')}}" alt="content-image" />
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
        <section class="pt-100 ct-02 content-section division">
            <div class="container">
                <!-- SECTION CONTENT (ROW) -->
                <div class="row d-flex align-items-center">
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-6">
                        <div class="img-block left-column wow fadeInRight">
                            <img class="img-fluid" src="{{asset('assets/frontend/images/img-08.png')}}" alt="content-image" />
                        </div>
                    </div>

                    <!-- TEXT BLOCK -->
                    <div class="col-md-6">
                        <div class="txt-block right-column wow fadeInLeft">
                            <!-- TEXT BOX -->
                            <div class="txt-box">
                                <!-- Title -->
                                <h5 class="s-24 w-700">Advanced Analytics Review</h5>

                                <!-- Text -->
                                <p>Sodales tempor sapien quaerat ipsum undo congue laoreet turpis neque auctor turpis vitae dolor luctus placerat magna and ligula cursus purus vitae purus an ipsum suscipit</p>
                            </div>
                            <!-- END TEXT BOX -->

                            <!-- TEXT BOX -->
                            <div class="txt-box mb-0">
                                <!-- Title -->
                                <h5 class="s-24 w-700">Email Marketing Campaigns</h5>

                                <!-- Text -->
                                <p>Tempor sapien sodales quaerat ipsum undo congue laoreet turpis neque auctor turpis vitae dolor luctus placerat magna and ligula cursus purus an ipsum vitae suscipit purus</p>

                                <!-- List -->
                                <ul class="simple-list">
                                    <li class="list-item">
                                        <p>Tempor sapien quaerat an ipsum laoreet purus and sapien dolor an ultrice ipsum aliquam undo congue dolor cursus</p>
                                    </li>

                                    <li class="list-item">
                                        <p class="mb-0">Cursus purus suscipit vitae cubilia magnis volute egestas vitae sapien turpis ultrice auctor congue magna placerat</p>
                                    </li>
                                </ul>
                            </div>
                            <!-- END TEXT BOX -->
                        </div>
                    </div>
                    <!-- END TEXT BLOCK -->
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
                            <p class="s-21 color--grey">Ligula risus auctor tempus magna feugiat lacinia.</p>
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
                                    <h5 class="s-22 w-700"><span>1.</span> Getting started with Martex</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">Etiam amet mauris suscipit in odio integer congue metus and vitae arcu mollis blandit ultrice ligula egestas magna suscipit lectus magna suscipit luctus blandit and laoreet</p>
                                </div>

                                <!-- QUESTION #2 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>2.</span> What's inside the package?</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">An enim nullam tempor sapien gravida donec ipsum and enim porta justo integer at velna vitae auctor integer congue undo magna laoreet augue pretium purus pretium ligula</p>
                                </div>

                                <!-- QUESTION #3 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>3.</span> How do I choose a plan?</h5>

                                    <!-- Answer -->
                                    <ul class="simple-list color--grey">
                                        <li class="list-item">
                                            <p>Fringilla risus, luctus mauris orci auctor purus ligula euismod pretium purus pretium rutrum tempor sapien</p>
                                        </li>

                                        <li class="list-item">
                                            <p>Nemo ipsam egestas volute undo turpis purus lipsum primis aliquam sapien quaerat sodales pretium a purus</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END QUESTIONS HOLDER -->

                        <!-- QUESTIONS WRAPPER -->
                        <div class="col-lg-6">
                            <div class="questions-holder">
                                <!-- QUESTION #4 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>4.</span> How does Martex handle my privacy?</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">Quaerat sodales sapien euismod blandit purus a purus ipsum primis in cubilia laoreet augue luctus dolor luctus</p>

                                    <!-- Answer -->
                                    <p class="color--grey">An enim nullam tempor sapien gravida donec congue metus. Vitae arcu mollis blandit integer nemo volute velna</p>
                                </div>

                                <!-- QUESTION #5 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>5.</span> I have an issue with my account</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">Cubilia laoreet augue egestas and luctus donec curabite diam vitae dapibus libero and quisque gravida donec neque blandit justo aliquam molestie nunc sapien justo</p>
                                </div>

                                <!-- QUESTION #6 -->
                                <div class="question mb-35 wow fadeInUp">
                                    <!-- Question -->
                                    <h5 class="s-22 w-700"><span>6.</span> Can I cancel at anytime?</h5>

                                    <!-- Answer -->
                                    <p class="color--grey">An enim nullam tempor sapien gravida donec ipsum and enim porta justo integer at velna vitae auctor integer congue undo magna laoreet augue pretium purus pretium ligula</p>
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
                                    <a href="contacts.html" class="color--theme">Get in Touch</a>
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
                                    <h2 class="s-45 w-700">Getting started with Martex today!</h2>

                                    <!-- Text -->
                                    <p class="p-lg">Congue laoreet turpis neque auctor turpis vitae dolor a luctus placerat and magna ligula cursus</p>

                                    <!-- Button -->
                                    <a href="#" class="btn r-04 btn--theme hover--tra-white" data-bs-toggle="modal" data-bs-target="#modal-3">Get srarted - it's free</a>
                                </div>
                            </div>
                            <!-- END BANNER-13 TEXT -->

                            <!-- BANNER-13 IMAGE -->
                            <div class="col-md-5">
                                <div class="banner-13-img text-center">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/img-04.png')}}" alt="banner-image" />
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

        <!-- MODAL WINDOW (IMAGE LINK)
			============================================= -->
        <div id="modal-1" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- CLOSE BUTTON -->
                    <button type="button" class="btn-close ico-10 white-color" data-bs-dismiss="modal" aria-label="Close">
                        <span class="flaticon-cancel"></span>
                    </button>

                    <!-- MODAL CONTENT -->
                    <div class="bg-img rounded">
                        <div class="overlay-light">
                            <div class="modal-img text-center">
                                <a href="pricing-1.html">
                                    <img class="img-fluid" src="{{asset('assets/frontend/images/modal-1-img.jpg')}}" alt="modal-image" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL CONTENT -->
                </div>
            </div>
        </div>
        <!-- END MODAL WINDOW (IMAGE LINK) -->

        <!-- MODAL WINDOW (REQUEST FORM)
			============================================= -->
        <div id="modal-3" class="modal auto-off fade" tabindex="-1" role="dialog" aria-labelledby="modal-3">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <!-- CLOSE BUTTON -->
                    <button type="button" class="btn-close ico-10 white-color" data-bs-dismiss="modal" aria-label="Close">
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
                                            <p class="color--grey">Aliquam augue suscipit, luctus neque purus ipsum neque dolor primis libero</p>
                                        </div>

                                        <!-- FORM -->
                                        <form name="requestForm" class="row request-form">
                                            <!-- Form Input -->
                                            <div class="col-md-12">
                                                <input type="text" name="name" class="form-control name" placeholder="Enter Your Name*" autocomplete="off" required />
                                            </div>

                                            <!-- Form Input -->
                                            <div class="col-md-12">
                                                <input type="email" name="email" class="form-control email" placeholder="Enter Your Email*" autocomplete="off" required />
                                            </div>

                                            <!-- Form Button -->
                                            <div class="col-md-12 form-btn">
                                                <button type="submit" class="btn btn--theme hover--theme submit">Get Started Now</button>
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
                            <p class="p-lg">Want to learn more about Martex, get a quote, or speak with an expert? Let us know what you are looking for and we’ll get back to you right away</p>
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
                                    <input type="text" name="email" class="form-control email" placeholder="Email Address*" />
                                </div>

                                <div class="col-md-12">
                                    <p class="p-lg">Explain your question in details:</p>
                                    <span>Your OS version, Martex version &amp; build, steps you did. Be VERY precise!</span>
                                    <textarea class="form-control message" name="message" rows="6" placeholder="I have a problem with..."></textarea>
                                </div>

                                <!-- Contact Form Button -->
                                <div class="col-md-12 mt-15 form-btn text-right">
                                    <button type="submit" class="btn btn--theme hover--theme submit">Submit Request</button>
                                </div>

                                <div class="contact-form-notice">
                                    <p class="p-sm">
                                        We are committed to your privacy. Martex uses the information you provide us to contact you about our relevant content, products, and services. You may unsubscribe from these communications at any
                                        time. For more information, check out our <a href="privacy.html">Privacy Policy</a>.
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
                            <img class="footer-logo" src="{{asset('assets/frontend/images/logo-skyblue.png')}}" alt="footer-logo" />
                            <img class="footer-logo-dark" src="{{asset('assets/frontend/images/logo-skyblue-white.png')}}" alt="footer-logo" />
                        </div>
                    </div>

                    <!-- FOOTER LINKS -->
                    <div class="col-sm-4 col-lg-3 col-xl-2">
                        <div class="footer-links fl-1">
                            <!-- Title -->
                            <h6 class="s-17 w-700">Company</h6>

                            <!-- Links -->
                            <ul class="foo-links clearfix">
                                <li>
                                    <p><a href="about.html">About Us</a></p>
                                </li>
                                <li>
                                    <p><a href="blog-listing.html">Our Blog</a></p>
                                </li>
                                <li>
                                    <p><a href="testimonials.html">Customers</a></p>
                                </li>
                                <li>
                                    <p><a href="#">Community</a></p>
                                </li>
                            </ul>
                        </div>
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
                                    <p><a href="features.html">Integration</a></p>
                                </li>
                                <li>
                                    <p><a href="download.html">What's New</a></p>
                                </li>
                                <li>
                                    <p><a href="pricing-1.html">Pricing</a></p>
                                </li>
                                <li>
                                    <p><a href="help-center.html">Help Center</a></p>
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
                                    <input type="email" class="form-control" placeholder="Email Address" required id="s-email" />
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
                                <p class="p-sm">&copy; 2023 Martex. <span>All Rights Reserved</span></p>
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