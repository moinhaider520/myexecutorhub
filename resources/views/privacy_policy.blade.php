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
                            <h2 class="s-52 w-700">Executor Hub Privacy Policy</h2>
                            <p class="p-lg">Welcome to Executor Hub. We are committed to protecting and respecting your
                                privacy. This Privacy Policy outlines how we collect, use, and safeguard your
                                information when you use our platform. By using Executor Hub, you agree to the
                                collection and use of your information in accordance with this policy. For more details
                                on the terms governing your use of our platform, please review our Terms of Use.</p>
                        </div>


                        <!-- TEXT BLOCK -->
                        <div class="txt-block legal-info">


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>1.</span> Who We Are</h4>

                            <!-- Text -->
                            <p>Executor Hub (“we,” “our,” “us”) provides a secure digital platform designed to assist
                                executors, estate planners, and individuals in managing estate administration
                                efficiently.</p>


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>2.</span> Information We Collect</h4>
                            <p>We collect different types of information to provide and improve our services, including:
                            </p>
                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Personal Information: Name, email address, phone number, and other contact
                                        details.</p>
                                </li>

                                <li class="list-item">
                                    <p>Account Information: Login credentials and security questions.</p>
                                </li>

                                <li class="list-item">
                                    <p>Estate & Legal Documents: Wills, trusts, LPAs, statements of assets, and other
                                        sensitive documents uploaded by users.</p>
                                </li>
                                <li class="list-item">
                                    <p>Financial Information: If applicable, payment details for subscriptions.</p>
                                </li>
                                <li class="list-item">
                                    <p>Communication Data: Correspondence with our support team or chatbot interactions.
                                    </p>
                                </li>
                                <li class="list-item">
                                    <p>Usage Data: How you interact with the platform (e.g., pages visited, features
                                        used).</p>
                                </li>
                                <li class="list-item">
                                    <p>Device Information: IP address, browser type, operating system, and other
                                        technical details.</p>
                                </li>
                                <li class="list-item">
                                    <p>Cookies & Tracking Technologies: Used to improve functionality, enhance security,
                                        and personalize your experience.</p>
                                </li>
                            </ul>


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>3.</span> How We Use Your Information</h4>

                            <!-- Text -->
                            <p>We use your information for the following purposes:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>To Provide Services: Securely store and process estate-related documents.</p>
                                </li>

                                <li class="list-item">
                                    <p>To Improve Our Platform: Analyze usage patterns to enhance user experience.</p>
                                </li>

                                <li class="list-item">
                                    <p>To Communicate with You: Provide updates, respond to inquiries, and send
                                        notifications.</p>
                                </li>
                                <li class="list-item">
                                    <p>For Legal Compliance: Ensure compliance with applicable laws and regulations.</p>
                                </li>
                                <li class="list-item">
                                    <p>For Security & Fraud Prevention: Protect accounts and prevent unauthorized
                                        access.</p>
                                </li>
                            </ul>

                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>4.</span> Sharing Your Information</h4>

                            <!-- Text -->
                            <p>We do not sell or rent your personal information. However, we may share information in
                                the following situations:</p>

                            <!-- List -->
                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>With Service Providers: Trusted third-party providers assisting with hosting,
                                        payment processing, or security.</p>
                                </li>

                                <li class="list-item">
                                    <p>With Legal Authorities: When required by law, to enforce our Terms of Use, or to
                                        protect rights and safety.</p>
                                </li>
                                <li class="list-item">
                                    <p>With Authorized Users: If you grant access to executors, solicitors, or family
                                        members.</p>
                                </li>
                            </ul>


                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>5.</span> Data Security</h4>

                            <!-- Text -->
                            <p>We take data security seriously and implement industry-standard measures to protect your
                                information, including:</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Encryption: Secure encryption for stored and transmitted data.</p>
                                </li>

                                <li class="list-item">
                                    <p>Access Controls: Restricted access to authorized personnel only.</p>
                                </li>
                                <li class="list-item">
                                    <p>Regular Security Audits: Continuous monitoring for vulnerabilities.</p>
                                </li>
                            </ul>

                            <p>However, no method of transmission over the internet is 100% secure. We encourage users
                                to take precautions when sharing sensitive information online.</p>

                            <p>Executor Hub is committed to protecting the confidentiality, integrity, and availability
                                of all personal data processed on our platform. This statement outlines the technical
                                and organisational measures we currently have in place, in alignment with UK GDPR and
                                industry best practices.</p>
                            <h5>Hosting & Data Residency</h5>
                            <p>Executor Hub is hosted on secure servers provided by Hostinger, with data centres based
                                in the United Kingdom. This ensures all personal data remains within the UK and is
                                managed under UK data protection law.</p>

                            <h5>Encryption & Secure Transmission</h5>
                            <p>We apply strong encryption measures to protect user data:</p>
                            <ul>
                                <li>In transit: All data is transmitted over encrypted connections using SSL/TLS
                                    protocols.</li>
                                <li>At rest: Data stored on our servers is encrypted to prevent unauthorised access.
                                </li>
                            </ul>
                            <p>These measures are applied universally across user documents, communications, and account
                                data.</p>

                            <h5>Authentication & Access Controls</h5>
                            <p>To prevent unauthorised access to user accounts and administrative systems:</p>
                            <ul>
                                <li>Executor Hub supports Two-Factor Authentication (2FA) for all user accounts.</li>
                                <li>Passwords must comply with our custom Regex security policy, ensuring high
                                    complexity and resistance to brute force attacks.</li>
                                <li>Only authorised Developer and Admin roles have access to the full database. All
                                    access is fully logged for auditing and traceability purposes.</li>
                            </ul>

                            <h5>Data Backup & Disaster Recovery</h5>
                            <ul>
                                <li>Our hosting provider manages monthly backups of platform data.</li>
                                <li>In the event of a serious system failure or data loss, our Recovery Time Objective
                                    (RTO) is approximately 48 hours.</li>
                                <li>All backups are securely stored and encrypted.</li>
                            </ul>

                            <h5>Data Breach Response Protocol</h5>
                            <p>Executor Hub maintains a formal Data Breach Response Protocol, which includes:</p>

                            <ul>
                                <li>Immediate logging and investigation of any breach</li>
                                <li>Risk assessment and containment</li>
                                <li>ICO notification within 72 hours, where required</li>
                                <li>User notification where there is a high risk to their rights or freedoms</li>
                                <li>Root cause analysis and preventive action</li>
                            </ul>

                            <p>All incidents are recorded in our Breach Register, and lessons learned are integrated
                                into security improvements.</p>

                            <h5>Penetration Testing & Vulnerability Management</h5>
                            <p>While we have not yet conducted formal third-party penetration tests or engaged an
                                external security firm, we are actively reviewing our risk posture and plan to implement
                                both automated and manual vulnerability assessments in line with industry growth and
                                partner requirements.</p>

                            <h5>Third-Party APIs & Integrations</h5>
                            <p>Executor Hub does not use any third-party APIs to store or process client data.
                                External APIs are used solely for limited platform features (e.g. notifications,
                                calendar integrations) and do not interact with user-submitted estate planning data.
                                All integrations are reviewed for security compliance and minimised to reduce exposure.
                            </p>

                            <h5>Regulatory & Compliance Information</h5>
                            <ul>
                                <li>Executor Hub is registered with the UK Information Commissioner’s Office (ICO) under
                                    registration number ZB932381.</li>
                                <li>We act as the Data Controller for personal data submitted to the platform, whether
                                    entered by users directly or by an authorised partner acting on their behalf.</li>
                            </ul>
                            <!-- Title -->
                            <h4 class="s-30 w-700"><span>6.</span> Your Rights & Choices</h4>

                            <!-- Text -->
                            <p>You have certain rights regarding your personal information, including:</p>

                            <ul class="simple-list">

                                <li class="list-item">
                                    <p>Access & Correction: Request access to or correction of your personal data.</p>
                                </li>

                                <li class="list-item">
                                    <p>Data Deletion: Request deletion of your account and associated data.</p>
                                </li>
                                <li class="list-item">
                                    <p>Opt-Out of Communications: Unsubscribe from marketing emails and notifications.
                                    </p>
                                </li>
                                <li class="list-item">
                                    <p>Manage Cookies: Adjust browser settings to control cookies.</p>
                                </li>
                            </ul>

                            <p>To exercise these rights, contact us at hello@executorhub.co.uk.</p>


                            <h4 class="s-30 w-700"><span>7.</span> Data Retention</h4>

                            <!-- Text -->
                            <p>We retain personal data only as long as necessary for legal, contractual, or operational
                                reasons. Upon request, we will delete or anonymize your data where possible.</p>

                            <h4 class="s-30 w-700"><span>8.</span> Third-Party Links</h4>

                            <!-- Text -->
                            <p>Executor Hub may contain links to third-party websites. We are not responsible for their
                                privacy practices and encourage you to review their policies.</p>


                            <h4 class="s-30 w-700"><span>9.</span>International Data Transfers</h4>
                            <p>If you access Executor Hub from outside the UK, your data may be transferred and
                                processed in the UK or other jurisdictions with different data protection laws.</p>

                            <h4 class="s-30 w-700"><span>10.</span>Disaster Management and Data Recovery</h4>
                            <p>At Executor Hub, we take the security and integrity of our users’ data very seriously. In the unlikely event of a security breach or hacking incident, we have robust disaster management and recovery protocols in place to ensure minimal disruption and complete data protection.</p>
                            <p>Our system maintains automatic and encrypted backups of all essential data, including user accounts, subscription details, and service-related information. These backups are created at regular intervals and stored securely in separate locations to prevent data loss.</p>
                            <p>If the portal is ever compromised, our immediate response will involve isolating and deleting the affected system to prevent further damage. We will then redeploy the most recent secure backup to restore all services swiftly and safely. This ensures that your access to subscriptions, features, and services will remain uninterrupted.</p>
                            <p>We also want to assure our users that personal and financial information remains secure, as all sensitive data is encrypted and protected according to industry standards. Executor Hub does not store any payment card details directly on its servers, ensuring an additional layer of protection.</p>

                            <h4 class="s-30 w-700"><span>11.</span> Changes to This Privacy Policy</h4>
                            <p>We may update this policy from time to time. Any changes will be posted on this page, and
                                significant updates will be communicated via email or platform notifications.</p>

                            <h4 class="s-30 w-700"><span>12.</span> Contact Us</h4>
                            <p>If you have questions about this Privacy Policy, please contact us at:h
                                ello@executorhub.co.uk</p>
                            <p>By using Executor Hub, you acknowledge that you have read and understood this Privacy
                                Policy. For further details, please review our Terms of Use.</p>

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