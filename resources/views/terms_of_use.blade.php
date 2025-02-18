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
                            <h2 class="s-52 w-700">Executor Hub – Terms of Use</h2>
                            <p class="p-lg">Welcome to Executor Hub (“we,” “us,” or “our”). These Terms of Use (“Terms”)
                                govern your access to and use of our website (www.executorhub.co.uk) and services. By
                                using our platform, you agree to comply with these Terms. If you do not agree, please do
                                not use Executor Hub.</p>
                        </div>


                        <!-- TEXT BLOCK -->
                        <div class="txt-block legal-info">

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>1.</span> About Executor Hub</h4>

                            <!-- Text -->
                            <p>Executor Hub is a digital platform designed to assist executors, estate planners, and
                                individuals in managing estate administration efficiently. Our services include document
                                storage, step-by-step guidance, AI integration, and other estate-related tools to
                                streamline estate management.</p>
                            <p>Executor Hub does not provide legal, financial, or tax advice. You should consult a
                                qualified professional for specific legal, financial, or estate planning matters.</p>


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>2.</span> Who Can Use Executor Hub?</h4>
                            <p>By using our services, you confirm that:</p>
                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>You are at least 18 years old.</p>
                                </li>

                                <li class="list-item">
                                    <p>You have the legal capacity to enter into a binding contract.</p>
                                </li>

                                <li class="list-item">
                                    <p>You will use Executor Hub only for lawful and authorized purposes.</p>
                                </li>
                                <li class="list-item">
                                    <p>If you are acting on behalf of a business or another person, you have the
                                        authority to do so.</p>
                                </li>
                            </ul>


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>3.</span> Account Registration & Security</h4>

                            <!-- Text -->
                            <p>To access certain features, you may need to create an account. By registering, you agree
                                to:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Provide accurate and up-to-date information.</p>
                                </li>

                                <li class="list-item">
                                    <p>Keep your login credentials secure and confidential.</p>
                                </li>

                                <li class="list-item">
                                    <p>Notify us immediately if you suspect unauthorized access to your account.</p>
                                </li>
                            </ul>

                            <p>We reserve the right to suspend or terminate accounts that provide false information,
                                engage in fraudulent activities, or violate these Terms.</p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>4.</span> Use of Services & Acceptable Use Policy</h4>

                            <!-- Text -->
                            <p>Executor Hub is intended for personal and professional estate planning purposes. You must
                                not:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Use the platform for fraudulent, illegal, or deceptive purposes.</p>
                                </li>

                                <li class="list-item">
                                    <p>Share, distribute, or upload harmful content (e.g., viruses, malware, or
                                        malicious code).</p>
                                </li>
                                <li class="list-item">
                                    <p>Attempt to hack, modify, or disrupt the platform’s functionality.</p>
                                </li>
                                <li class="list-item">
                                    <p>Access or attempt to access other users’ data without authorization.</p>
                                </li>
                                <li class="list-item">
                                    <p>Misuse the platform to impersonate another person or entity.</p>
                                </li>
                            </ul>

                            <p>Violation of these Terms may result in account suspension, termination, or legal action.
                            </p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>5.</span> Subscription & Payment Terms</h4>

                            <!-- Text -->
                            <p>Executor Hub offers various pricing plans, including free trials and subscription-based
                                services.</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Billing: If you subscribe to a paid plan, you authorize us to charge the payment method on file.</p>
                                </li>

                                <li class="list-item">
                                    <p>Auto-Renewal: Unless canceled before the renewal date, your subscription will automatically renew.</p>
                                </li>
                                <li class="list-item">
                                    <p>Cancellations & Refunds: You may cancel at any time, but refunds are only issued per our Refund Policy.</p>
                                </li>
                                <li class="list-item">
                                    <p>Non-Payment: Failure to make timely payments may result in restricted access or account suspension.</p>
                                </li>
                            </ul>

                            <p>For full details, refer to our Pricing & Subscription Terms.</p>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>6.</span> Data Protection & Privacy</h4>

                            <!-- Text -->
                            <p>Executor Hub complies with UK GDPR and other relevant data protection laws.</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>We collect and store personal data to provide and improve our services.</p>
                                </li>

                                <li class="list-item">
                                    <p>We do not sell personal data to third parties.</p>
                                </li>
                                <li class="list-item">
                                    <p>For full details, please review our Privacy Policy.</p>
                                </li>
                            </ul>

                            <p>By using Executor Hub, you consent to the processing of your data as outlined in our policies.</p>
                            

                            <h4 class="s-30 w-700"><span>7.</span> Intellectual Property Rights</h4>

                            <!-- Text -->
                            <p>All content, trademarks, and technology on Executor Hub are owned or licensed by us.</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>You may not copy, modify, distribute, or resell any part of the platform without prior written consent.</p>
                                </li>

                                <li class="list-item">
                                    <p>You retain ownership of the documents and data you upload but grant Executor Hub a limited license to store and process this information solely for platform functionality.</p>
                                </li>
                            </ul>

                            <h4 class="s-30 w-700"><span>8.</span> Third-Party Services & Links</h4>

                            <!-- Text -->
                            <p>Executor Hub may contain links to third-party websites or integrations (e.g., payment processors, legal services).</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>We are not responsible for third-party content, services, or privacy practices.</p>
                                </li>

                                <li class="list-item">
                                    <p>Your interactions with third-party services are at your own risk.</p>
                                </li>
                            </ul>

                            <h4 class="s-30 w-700"><span>9.</span> Limitation of Liability</h4>
                            <p>Executor Hub is provided “as is” and “as available”, without warranties of any kind.</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>We do not guarantee uninterrupted or error-free service.</p>
                                </li>

                                <li class="list-item">
                                    <p>We are not responsible for financial or legal losses resulting from reliance on our platform.</p>
                                </li>
                                <li class="list-item">
                                    <p>To the fullest extent permitted by law, Executor Hub is not liable for indirect, incidental, or consequential damages.</p>
                                </li>
                                <li class="list-item">
                                    <p>Our liability, if any, is limited to the fees paid for your use of Executor Hub.</p>
                                </li>
                            </ul>

                            <p>If you experience technical issues, please contact us at hello@executorhub.co.uk.</p>

                            <h4 class="s-30 w-700"><span>10.</span> Termination of Use</h4>
                            <p>We reserve the right to terminate or suspend your account if you:</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Violate these Terms of Use.</p>
                                </li>

                                <li class="list-item">
                                    <p>Use Executor Hub in a way that poses a risk to other users or our business.</p>
                                </li>
                                <li class="list-item">
                                    <p>Engage in fraudulent or illegal activities.</p>
                                </li>
                            </ul>
                            <p>You may close your account at any time by contacting hello@executorhub.co.uk.</p>

                            <h4 class="s-30 w-700"><span>11.</span> Changes to These Terms</h4>
                            <p>We may update these Terms from time to time.</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>If changes are significant, we will provide reasonable notice via email or on our website.</p>
                                </li>

                                <li class="list-item">
                                    <p>Continuing to use Executor Hub after updates constitutes acceptance of the new Terms.</p>
                                </li>
                            </ul>

                            <h4 class="s-30 w-700"><span>12.</span> Governing Law & Disputes</h4>
                            <p>These Terms are governed by the laws of England and Wales.</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>If a dispute arises, we encourage you to contact us to resolve it informally.</p>
                                </li>

                                <li class="list-item">
                                    <p>If necessary, disputes will be settled in the courts of England and Wales.</p>
                                </li>
                            </ul>
                            
                            <h4 class="s-30 w-700"><span>13.</span> Contact Us</h4>
                            <p>If you have any questions about these Terms, please contact us: hello@executorhub.co.uk</p>
                            <p>By using Executor Hub, you acknowledge that you have read, understood, and agree to these Terms.</p>

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