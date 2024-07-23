<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{route('dashboard')}}">
                <img class="img-fluid" src="{{ asset('assets/frontend/images/logo-white.png') }}" alt="" style="width:100px;">
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
            <a href="{{route('dashboard')}}">
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
                        <a class="sidebar-link" href="{{route('dashboard')}}">
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
                    @role('admin')
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
                            <li><a href="{{ route('admin.customers.index') }}">View All</a></li>
                        </ul>
                    </li>
                    @endrole
                    @role('customer')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Assets & Liabilities </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.bank_accounts.view') }}">Bank Accounts</a></li>
                            <li><a href="{{ route('customer.investment_accounts.view') }}">Investment Accounts</a></li>
                            <li><a href="{{ route('customer.properties.view') }}">Property (ies) Owned</a></li>
                            <li><a href="{{ route('customer.personal_chattels.view') }}">Personal Chattels</a></li>
                            <li><a href="{{ route('customer.business_interests.view') }}">Business Interests</a></li>
                            <li><a href="{{ route('customer.insurance_policies.view') }}">Insurance Policies</a></li>
                            <li><a href="{{ route('customer.debt_and_liabilities.view') }}">Debt & Liabilities</a></li>
                            <li><a href="{{ route('customer.digital_assets.view') }}">Digital Assets</a></li>
                            <li><a href="{{ route('customer.intellectual_properties.view') }}">Intellectual Properties</a></li>
                            <li><a href="{{ route('customer.other_assets.view') }}">Other Assets</a></li>
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
                            <li><a href="{{ route('customer.executors.view') }}">Manage Executors</a></li>
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
                            <li><a href="{{ route('customer.advisors.view') }}">Manage Advisers</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                            </svg>
                            <span>Documents </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.documents.view') }}">Manage Documents</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                            </svg>
                            <span>Wishes </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.wishes.view') }}">Manage Wishes</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                            </svg>
                            <span>Guidance </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.guidance.view') }}">Guidance For Guardians</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                            </svg>
                            <span>Life Remembered </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.life_remembered.view') }}">Manage Notes</a></li>
                            <li><a href="{{ route('customer.voice_notes.view') }}">Manage Voice Notes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                            </svg>
                            <span>Donations </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.organs_donation.view') }}">Organ Donations</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-permissions') }}"></use>
                            </svg>
                            <span>Permissions</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.assign_permissions') }}">Assign Permissions</a></li>
                        </ul>
                    </li>
                    @endrole

                    @role('executor')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Assets & Liabilities </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.bank_accounts.view') }}">Bank Accounts</a></li>
                            <li><a href="{{ route('executor.investment_accounts.view') }}">Investment Accounts</a></li>
                            <li><a href="{{ route('executor.properties.view') }}">Property (ies) Owned</a></li>
                            <li><a href="{{ route('executor.personal_chattels.view') }}">Personal Chattels</a></li>
                            <li><a href="{{ route('executor.business_interests.view') }}">Business Interests</a></li>
                            <li><a href="{{ route('executor.insurance_policies.view') }}">Insurance Policies</a></li>
                            <li><a href="{{ route('executor.debt_and_liabilities.view') }}">Debt & Liabilities</a></li>
                            <li><a href="{{ route('executor.digital_assets.view') }}">Digital Assets</a></li>
                            <li><a href="{{ route('executor.intellectual_properties.view') }}">Intellectual Properties</a></li>
                            <li><a href="{{ route('executor.other_assets.view') }}">Other Assets</a></li>
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
                            <li><a href="{{ route('executor.executors.view') }}">Manage Executors</a></li>
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
                            <li><a href="{{ route('executor.advisors.view') }}">Manage Advisers</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                            </svg>
                            <span>Documents </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.documents.view') }}">Manage Documents</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                            </svg>
                            <span>Wishes </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.wishes.view') }}">Manage Wishes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                            </svg>
                            <span>Guidance </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.guidance.view') }}">Guidance For Guardians</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                            </svg>
                            <span>Life Remembered </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.life_remembered.view') }}">Manage Notes</a></li>
                            <li><a href="{{ route('executor.voice_notes.view') }}">Manage Voice Notes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                            </svg>
                            <span>Donations </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.organs_donation.view') }}">Organ Donations</a></li>
                        </ul>
                    </li>
                    @endrole
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>