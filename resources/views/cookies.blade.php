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


        <section id="cookies-page" class="gr--whitesmoke pb-80 inner-page-hero division">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">


                        <!-- INNER PAGE TITLE -->
                        <div class="inner-page-title">
                            <h2 class="s-52 w-700">Executor Hub Cookie Policy</h2>
                            <p class="p-lg">Last Updated: 19th of February 2025</p>
                        </div>


                        <!-- TEXT BLOCK -->
                        <div class="txt-block legal-info">

                            <!-- Text -->
                            <p>Executor Hub (“we,” “our,” “us”) uses cookies and similar tracking technologies to
                                enhance user experience, improve website performance, and analyze how our platform is
                                used. This Cookie Policy explains what cookies are, how we use them, and how you can
                                manage your cookie preferences.</p>


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>1.</span> What Are Cookies?</h4>

                            <!-- Text -->
                            <p>Cookies are small text files stored on your device (computer, tablet, or smartphone) when
                                you visit a website. They help us remember user preferences, track website performance,
                                and provide a more personalized experience.</p>

                            <!-- Text -->
                            <p>Cookies can be:</p>
                            <ul>
                                <li>Session cookies – Temporary cookies that expire when you close your browser.</li>
                                <li>Persistent cookies – Remain on your device until deleted or after a set period.</li>
                            </ul>

                            <p>Cookies may be set by us (first-party cookies) or by third-party services integrated into
                                our website (third-party cookies).</p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>2.</span> How We Use Cookies?</h4>
                            <p>We use cookies for the following purposes:</p>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700"><span>2.1.</span> Essential cookies</h5>

                            <!-- Text -->
                            <p>These cookies are necessary for the website to function properly and cannot be disabled.
                                They help with:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Security and authentication</p>
                                </li>

                                <li class="list-item">
                                    <p>User session management</p>
                                </li>

                                <li class="list-item">
                                    <p>Accessibility features</p>
                                </li>
                            </ul>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700"><span>2.2.</span> Performance and Analytics Cookies</h5>

                            <!-- Text -->
                            <p>These cookies help us understand how users interact with Executor Hub, allowing us to
                                improve the platform. We use them to:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Monitor website traffic and user behavior</p>
                                </li>

                                <li class="list-item">
                                    <p>Identify technical issues and improve site performance</p>
                                </li>

                                <li class="list-item">
                                    <p>Optimize content based on user engagement</p>
                                </li>
                            </ul>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700"><span>2.3.</span> Functionality cookies</h5>

                            <!-- Text -->
                            <p>Functional cookies allow us to remember user preferences and provide a more personalized
                                experience, such as:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Remembering login details and preferences</p>
                                </li>

                                <li class="list-item">
                                    <p>Storing language and region settings</p>
                                </li>

                            </ul>

                            <!-- Small Title -->
                            <h5 class="s-24 w-700"><span>2.4.</span> Marketing and Advertising Cookies</h5>

                            <!-- Text -->
                            <p>These cookies help us deliver relevant advertisements and track the effectiveness of
                                marketing campaigns. They may be set by third-party advertising networks. We use them
                                to:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Display targeted ads based on browsing behavior</p>
                                </li>

                                <li class="list-item">
                                    <p>Measure the success of marketing efforts</p>
                                </li>

                            </ul>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>3.</span> Third-Party Cookies</h4>

                            <!-- Text -->
                            <p>We may use third-party services, such as analytics tools (e.g., Google Analytics) and
                                advertising platforms, which set cookies on your device. These third parties have their
                                own cookie policies, and we encourage you to review them.</p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>4.</span> Managing Cookie Preferences</h4>

                            <!-- Text -->
                            <p>You can control and manage cookies through your browser settings. Most browsers allow you
                                to:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Block or delete cookies</p>
                                </li>

                                <li class="list-item">
                                    <p>Receive notifications before a cookie is stored</p>
                                </li>
                                <li class="list-item">
                                    <p>Disable specific types of cookies</p>
                                </li>

                            </ul>

                            <p>To adjust your cookie settings, refer to the help section of your browser:</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Google Chrome</p>
                                </li>

                                <li class="list-item">
                                    <p>Mozilla Firefox</p>
                                </li>
                                <li class="list-item">
                                    <p>Microsoft Edge</p>
                                </li>
                                <li class="list-item">
                                    <p>Safari</p>
                                </li>

                            </ul>

                            <p>You can also manage preferences for third-party cookies through tools such as Your Online Choices or Network Advertising Initiative.</p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>5.</span> Changes to This Cookie Policy</h4>

                            <!-- Text -->
                            <p>We may update this Cookie Policy from time to time to reflect changes in technology, legal requirements, or our practices. Any updates will be posted on this page, and we encourage you to review this policy regularly.</p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>6.</span> How to Contact Us</h4>

                            <!-- Text -->
                            <p>If you have any questions about our use of cookies, please contact us at:Hello@executorhub.co.uk</p>

                            <!-- Text -->
                            <p>By continuing to use our website, you consent to the use of cookies as outlined in this policy. </p>

                        </div> <!-- END TEXT BLOCK -->


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
                                    <p><a href="{{route('cookies')}}">Cookie Policy</a></p>
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
            contextmenu: function (e) {
                console.log("ctx menu button:", e.which);

                // Stop the context menu
                e.preventDefault();
            },
            mousedown: function (e) {
                console.log("normal mouse down:", e.which);
            },
            mouseup: function (e) {
                console.log("normal mouse up:", e.which);
            },
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
                text = "Twitter may automatically close accounts after prolonged periods of inactivity. If you want your account closed before to prevent fraud then your family will need your Twitter handle and request to close it via their help centre.";
            }
            document.getElementById('displayText').innerText = text;
        }
    </script>
</body>

</html>