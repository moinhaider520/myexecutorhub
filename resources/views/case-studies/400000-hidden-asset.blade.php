<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SITE TITLE -->
    <title>Case Study: The £400,000 "Hidden Asset" - Executor Hub</title>

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
                            <h2 class="s-52 w-700">Case Study: The £400,000 "Hidden Asset" – How Executor Hub Would Have Prevented Delays, Rescinded Grants & Family Conflict</h2>
                            <p class="p-lg">See how Executor Hub prevents missed assets and rescinded grants.</p>
                        </div>

                        <!-- TEXT BLOCK -->
                        <div class="txt-block legal-info">
                            <!-- Background -->
                            <h4 class="s-30 w-700"><span>Background</span></h4>
                            <p>Three executors were appointed to administer the estate of a late parent. They believed they had identified all assets and liabilities and proceeded to apply for probate. The Grant of Probate was issued. Two months later, during the sale of a second property, a previously unknown £400,000 investment account was discovered in the deceased's name.</p>
                            
                            <p>This triggered:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Immediate HMRC reporting issues</p></li>
                                <li class="list-item"><p>Inheritance Tax recalculations (additional tax due + interest + potential penalties)</p></li>
                                <li class="list-item"><p>The original Grant being rescinded</p></li>
                                <li class="list-item"><p>A new Grant needing to be issued</p></li>
                                <li class="list-item"><p>Months of additional delay</p></li>
                                <li class="list-item"><p>Breakdown in family communication</p></li>
                                <li class="list-item"><p>Accusations between siblings about "hiding" assets or "not doing things properly"</p></li>
                            </ul>

                            <p>The executors said the same thing many executors say:</p>
                            <p><em>"We simply didn't know this asset existed. We had no central system or checklist that made us check everything."</em></p>

                            <p>This real-life scenario took an additional 8–12 months to fix and cost the estate thousands in professional fees and lost time.</p>

                            <!-- Where It Went Wrong -->
                            <h4 class="s-30 w-700"><span>Where It Went Wrong</span></h4>
                            <p>Without a structured process, the executors:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Missed a major asset (worth £400,000)</p></li>
                                <li class="list-item"><p>Submitted an inaccurate IHT form</p></li>
                                <li class="list-item"><p>Applied for probate prematurely</p></li>
                                <li class="list-item"><p>Had no audit trail showing they had conducted a full search</p></li>
                                <li class="list-item"><p>Had no central place to store documents, statements, records, or digital asset logs</p></li>
                                <li class="list-item"><p>Relied on incomplete paperwork found around the house and outdated bank statements</p></li>
                            </ul>

                            <!-- How Executor Hub Would Have Prevented This Entire Situation -->
                            <h4 class="s-30 w-700"><span>How Executor Hub Would Have Prevented This Entire Situation</span></h4>
                            <p>Executor Hub provides a centralised, guided, and automated process ensuring no asset is missed.</p>

                            <h5 class="s-24 w-700"><span>1. Structured Asset Discovery – prevents missed accounts</span></h5>
                            <p>Executor Hub includes built-in:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Asset Discovery Checklist</p></li>
                                <li class="list-item"><p>Guided prompts for bank accounts, investments, pensions, online accounts, premium bonds, safe deposit boxes, shareholdings, digital assets, etc.</p></li>
                                <li class="list-item"><p>Automatic reminders to search for less obvious assets</p></li>
                            </ul>
                            <p><strong>Typical time saved:</strong> 10–15 hours of manual searching and cross-checking.</p>
                            <p><strong>Most importantly:</strong> This is the step that would have identified the £400k account before probate.</p>

                            <h5 class="s-24 w-700"><span>2. Estate Searches & Section 27 notices – ensuring nothing is overlooked</span></h5>
                            <p>Executor Hub integrates:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Estate search recommendations</p></li>
                                <li class="list-item"><p>Guidance on when to complete a Section 27 notice</p></li>
                                <li class="list-item"><p>Upload area for search results and letters</p></li>
                            </ul>
                            <p>Had an estate search been prompted early, the £400k account would likely have been flagged.</p>
                            <p><strong>Time Saved:</strong> 3–5 hours of organising and tracking searches. Plus avoiding months of rework.</p>

                            <h5 class="s-24 w-700"><span>3. Central Document Vault – stops assets being missed</span></h5>
                            <p>Executors can upload:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Old statements</p></li>
                                <li class="list-item"><p>Policy documents</p></li>
                                <li class="list-item"><p>Investment summaries</p></li>
                                <li class="list-item"><p>Correspondence</p></li>
                                <li class="list-item"><p>Deeds</p></li>
                                <li class="list-item"><p>Insurance documents</p></li>
                            </ul>
                            <p>Executor Hub scans and categorises documents so nothing gets forgotten.</p>
                            <p>In this case, a historic statement found later would have been captured at the start.</p>
                            <p><strong>Time saved:</strong> 5+ hours and avoids £000s of corrective work.</p>

                            <h5 class="s-24 w-700"><span>4. Executor Checklist & Step-By-Step Guidance</span></h5>
                            <p>The Hub gives executors a structured workflow:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>"Have you checked for dormant accounts?"</p></li>
                                <li class="list-item"><p>"Have you checked financial institutions the deceased used historically?"</p></li>
                                <li class="list-item"><p>"Have you searched for accounts under previous addresses or aliases?"</p></li>
                                <li class="list-item"><p>"Upload confirmation here."</p></li>
                            </ul>
                            <p>This stops premature probate applications and ensures the estate information submitted to HMRC is complete.</p>

                            <h5 class="s-24 w-700"><span>5. Avoiding HMRC Penalties & Rescinded Grants</span></h5>
                            <p>With Executor Hub's guided IHT preparation support:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Executors complete all asset sections</p></li>
                                <li class="list-item"><p>Receive prompts if anything appears incomplete</p></li>
                                <li class="list-item"><p>Upload valuation evidence</p></li>
                                <li class="list-item"><p>Log contact with institutions</p></li>
                                <li class="list-item"><p>Track outstanding enquiries</p></li>
                            </ul>
                            <p>This prevents inaccurate IHT returns—the main reason HMRC demand a Grant be rescinded.</p>

                            <p>Executor Hub would have prevented:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Additional tax</p></li>
                                <li class="list-item"><p>Interest</p></li>
                                <li class="list-item"><p>Penalties</p></li>
                                <li class="list-item"><p>Rescinded grant</p></li>
                                <li class="list-item"><p>8–12 months of further delays</p></li>
                            </ul>

                            <h5 class="s-24 w-700"><span>6. Reducing Family Arguments with a Transparent Audit Trail</span></h5>
                            <p>One of the greatest benefits:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Every action is timestamped</p></li>
                                <li class="list-item"><p>Every document is logged</p></li>
                                <li class="list-item"><p>Every message is stored</p></li>
                                <li class="list-item"><p>Every executor sees the same information</p></li>
                                <li class="list-item"><p>Nothing is hidden</p></li>
                                <li class="list-item"><p>No one can be blamed for "missing" something</p></li>
                            </ul>

                            <p>In this real case, the discovery of the £400k asset led to accusations such as:</p>
                            <p><em>"You must have known about this!" "How did you miss it?" "You've caused us thousands in tax!"</em></p>
                            <p>Executor Hub removes blame and provides clarity.</p>

                            <!-- Outcome With Executor Hub -->
                            <h4 class="s-30 w-700"><span>Outcome With Executor Hub</span></h4>
                            <p>If Executor Hub had been used:</p>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Problem</th>
                                        <th>What Happened</th>
                                        <th>With Executor Hub</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hidden £400k asset</td>
                                        <td>Found after probate → major crisis</td>
                                        <td>Identified at start via guided asset discovery</td>
                                    </tr>
                                    <tr>
                                        <td>Incorrect IHT return</td>
                                        <td>Additional tax + penalties</td>
                                        <td>Correct and complete first time</td>
                                    </tr>
                                    <tr>
                                        <td>Grant rescinded</td>
                                        <td>Delays 8–12 months</td>
                                        <td>No rescinding required</td>
                                    </tr>
                                    <tr>
                                        <td>Family arguments</td>
                                        <td>Executors blamed each other</td>
                                        <td>Transparent audit trail prevents conflict</td>
                                    </tr>
                                    <tr>
                                        <td>Stress & professional fees</td>
                                        <td>£000s extra</td>
                                        <td>Minimised</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Conclusion -->
                            <h4 class="s-30 w-700"><span>Conclusion</span></h4>
                            <p>This case shows a major risk in estate administration:</p>
                            <p><strong>Executors don't know what they don't know.</strong></p>

                            <p>Missing a single asset—even unintentionally—can:</p>
                            <ul class="simple-list">
                                <li class="list-item"><p>Extend the estate by a year or more</p></li>
                                <li class="list-item"><p>Trigger tax penalties</p></li>
                                <li class="list-item"><p>Cause family disputes</p></li>
                                <li class="list-item"><p>Damage the executor's reputation</p></li>
                                <li class="list-item"><p>Result in legal liability</p></li>
                            </ul>

                            <p>Executor Hub prevents this by giving executors the tools, guidance, and structure to complete the estate properly and safely from day one.</p>

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




