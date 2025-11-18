<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SITE TITLE -->
    <title>Case Study: Preventing a 5-Year Will Challenge - Executor Hub</title>

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


        <section id="case-study-page" class="gr--whitesmoke pb-80 inner-page-hero division">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <!-- INNER PAGE TITLE -->
                        <div class="inner-page-title">
                            <h2 class="s-52 w-700">Case Study 1: Preventing a 5-Year Will Challenge Through Executor Hub</h2>
                            <p class="p-lg">A real-world example of how Executor Hub could have prevented years of litigation and saved hundreds of thousands in legal fees.</p>
                        </div>

                        <!-- TEXT BLOCK -->
                        <div class="txt-block legal-info">
                            <!-- Background -->
                            <h4 class="s-30 w-700"><span>Background</span></h4>
                            <p>A grandfather wrote a will leaving his entire estate to his grandson. His son (the grandson's father) was explicitly excluded from inheriting. Following the grandfather's death, the son launched a serious legal challenge, alleging:</p>
                            
                            <ul class="simple-list">
                                <li class="list-item"><p>Fraudulent calumny – claiming the grandson had "poisoned the grandfather's mind" against him.</p></li>
                                <li class="list-item"><p>Lack of testamentary capacity – arguing the grandfather did not understand what he was signing.</p></li>
                                <li class="list-item"><p>Lack of proper records – there were no supporting documents, videos, letters of wishes, or evidence beyond the exclusion clause itself.</p></li>
                            </ul>

                            <p>Because there was no contemporaneous evidence, the case became:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Highly contentious</p></li>
                                <li class="list-item"><p>Emotionally draining for the family</p></li>
                                <li class="list-item"><p>Legally complex</p></li>
                                <li class="list-item"><p>Drawn out over more than 5 years</p></li>
                                <li class="list-item"><p>Extremely costly (hundreds of thousands of pounds in combined legal fees)</p></li>
                            </ul>

                            <!-- How Executor Hub Would Have Changed Everything -->
                            <h4 class="s-30 w-700"><span>How Executor Hub Would Have Changed Everything</span></h4>
                            <p>Executor Hub is designed specifically to prevent disputes like this by creating irrefutable, timestamped evidence that validates the person's true wishes.</p>
                            
                            <p>If the grandfather had been using Executor Hub, the following protections would have existed:</p>

                            <h5 class="s-24 w-700"><span>1. Capacity Videos (Annual or One-Off)</span></h5>
                            <p>Executor Hub allows individuals to record short, secure videos confirming:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Their understanding of their estate</p></li>
                                <li class="list-item"><p>Their decision to make or change a will</p></li>
                                <li class="list-item"><p>The reasons behind key choices</p></li>
                                <li class="list-item"><p>Proof that they are of sound mind at the time</p></li>
                            </ul>
                            <p><strong>Impact in this case:</strong> A simple 60-second capacity video uploaded on the day of the will signing would have provided powerful evidence against any claim of incapacity.</p>

                            <h5 class="s-24 w-700"><span>2. Recorded Reason for Exclusion</span></h5>
                            <p>Executor Hub enables users to store:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>A private explanation</p></li>
                                <li class="list-item"><p>A video message</p></li>
                                <li class="list-item"><p>A letter of wishes</p></li>
                                <li class="list-item"><p>Supporting documents</p></li>
                            </ul>
                            <p>All securely timestamped and stored.</p>
                            <p><strong>Impact in this case:</strong> A video explaining exactly why the grandfather excluded his son (in his own words) would have immediately undermined the claim of fraudulent calumny. Courts place heavy weight on clear, contemporaneous evidence.</p>

                            <h5 class="s-24 w-700"><span>3. Secure Document Vault</span></h5>
                            <p>Executor Hub stores:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Wills</p></li>
                                <li class="list-item"><p>Trusts</p></li>
                                <li class="list-item"><p>Letters of wishes</p></li>
                                <li class="list-item"><p>Notes from meetings</p></li>
                                <li class="list-item"><p>Capacity evidence</p></li>
                                <li class="list-item"><p>Voice and video messages</p></li>
                                <li class="list-item"><p>Supporting family documents</p></li>
                            </ul>
                            <p><strong>Impact in this case:</strong> The executor would have had easy access to everything needed to show the will was properly thought through, properly stored, and properly evidenced. This dramatically reduces room for challenge.</p>

                            <h5 class="s-24 w-700"><span>4. Reduced Risk of Disputes & Faster Administration</span></h5>
                            <p>Without evidence, probate disputes become "word vs word". With Executor Hub, everything is:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Timestamped</p></li>
                                <li class="list-item"><p>Stored securely</p></li>
                                <li class="list-item"><p>Recorded directly by the testator</p></li>
                                <li class="list-item"><p>Independently verifiable</p></li>
                            </ul>
                            <p><strong>Impact in this case:</strong> The challenge likely would have been shut down very early, avoiding:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>5+ years of litigation</p></li>
                                <li class="list-item"><p>Hundreds of thousands in legal fees</p></li>
                                <li class="list-item"><p>Stress and conflict between father and son</p></li>
                                <li class="list-item"><p>Delays in the estate being distributed</p></li>
                            </ul>

                            <!-- What This Case Teaches Us -->
                            <h4 class="s-30 w-700"><span>What This Case Teaches Us</span></h4>
                            <p>This real-world scenario highlights one of the biggest risks in estate planning:</p>
                            <p><strong>If you don't record the WHY, someone will later try to rewrite the story.</strong></p>
                            <p>Executor Hub ensures the true wishes of the person cannot be twisted or challenged.</p>

                            <!-- Conclusion -->
                            <h4 class="s-30 w-700"><span>Conclusion: Executor Hub Could Have Saved the Family Years of Pain</span></h4>
                            <p>If Executor Hub had been used:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>✔ Capacity would have been proven</p></li>
                                <li class="list-item"><p>✔ The exclusion would have been explained clearly</p></li>
                                <li class="list-item"><p>✔ Evidence would have been timestamped and secured</p></li>
                                <li class="list-item"><p>✔ The dispute may never have started</p></li>
                                <li class="list-item"><p>✔ The estate could have been settled quickly and cheaply</p></li>
                                <li class="list-item"><p>✔ The relationship between father and son might never have been destroyed</p></li>
                            </ul>

                            <p>Executor Hub turns vulnerable wishes into protected evidence, giving executors and families certainty when they need it most.</p>

                            <!-- Back to Case Studies -->
                            <div class="mt-40">
                                <a href="{{route('home')}}#case-studies" class="btn btn--theme hover--tra-white r-04">Back to Case Studies</a>
                            </div>
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

