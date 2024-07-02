<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="#">
                <img class="img-fluid" src="{{ asset('assets/images/logo/logo.webp') }}" alt="" style="width:150px;">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <svg class="stroke-icon sidebar-toggle status_toggle middle">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#toggle-icon') }}"></use>
                </svg>
                <svg class="fill-icon sidebar-toggle status_toggle middle">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-toggle-icon') }}"></use>
                </svg>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="#">
                <img class="img-fluid" src="{{ asset('assets/images/favicon.ico') }}" style="width:20px;" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="pin-title sidebar-main-title">
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="lan-3">Dashboard </span>
                        </a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-8">Applications</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Customers </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">View All</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Assets </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Bank</a></li>
                            <li><a href="{{ route('customers') }}">Savings</a></li>
                            <li><a href="{{ route('customers') }}">Investments</a></li>
                            <li><a href="{{ route('customers') }}">Shares</a></li>
                            <li><a href="{{ route('customers') }}">Life Insurance</a></li>
                            <li><a href="{{ route('customers') }}">Funeral Plan</a></li>
                            <li><a href="{{ route('customers') }}">Properties</a></li>
                            <li><a href="{{ route('customers') }}">National Savings</a></li>
                            <li><a href="{{ route('customers') }}">Pensions</a></li>
                            <li><a href="{{ route('customers') }}">Trusts</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Liabilities </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Mortgages</a></li>
                            <li><a href="{{ route('customers') }}">Credit Cards</a></li>
                            <li><a href="{{ route('customers') }}">Car Loans</a></li>
                            <li><a href="{{ route('customers') }}">Bank Loans</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Executors </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Add Executor</a></li>
                            <li><a href="{{ route('customers') }}">View Executors</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Advisors </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Solicitors</a></li>
                            <li><a href="{{ route('customers') }}">Will Writers</a></li>
                            <li><a href="{{ route('customers') }}">Accountants</a></li>
                            <li><a href="{{ route('customers') }}">Financial Advisers</a></li>
                            <li><a href="{{ route('customers') }}">Stock Brokers</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Documents </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Add Document</a></li>
                            <li><a href="{{ route('customers') }}">View Documents</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Wishes </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Manage Wishes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Life Remebered </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customers') }}">Manage Notes</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
