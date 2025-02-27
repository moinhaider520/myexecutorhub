<div class="page-header row">
    <div class="header-logo-wrapper col-auto">
        <div class="logo-wrapper">
            <a href="{{ asset('index.html') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="" />
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_light.png') }}" alt="" />
            </a>
        </div>
    </div>
    <div class="col-4 col-xl-4 page-title">
        <h4 class="f-w-700">
            Dashboard
        </h4>
        <nav>
            <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);"> <i data-feather="home"> </i></a></li>
                <li class="breadcrumb-item f-w-400">
                    Dashboard
                </li>
                <li class="breadcrumb-item f-w-400 active">
                    Dashboard
                </li>
            </ol>
        </nav>
    </div>

    <div class="header-wrapper col m-0">
        <div class="row">
            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper">
                    <a href="{{ asset('dashboard.php') }}">
                        <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                    </a>
                </div>
                <div class="toggle-sidebar">
                    <svg class="stroke-icon sidebar-toggle status_toggle middle">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#toggle-icon') }}"></use>
                    </svg>
                </div>
            </div>
            <div class="nav-right col-xxl-8 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                <ul class="nav-menus">
                    <li class="cart-nav onhover-dropdown"></li>
                    <li class="profile-nav onhover-dropdown px-0 py-0">
                        <div class="d-flex profile-media align-items-center">
                            <img class="img-30" src="{{ Auth::user()->profile_image ? asset('assets/upload/' . Auth::user()->profile_image) : asset('assets/images/dashboard/profile.png') }}" alt="">  
                                <div class="flex-grow-1">
                                    <span>
                                        <h5>{{ucwords(str_replace('_', ' ', Auth::user()->name))}}</h5>
                                    </span>
                                    <p class="mb-0 font-outfit">
                                        <span>{{ ucwords(str_replace('_', ' ', Auth::user()->getRoleNames()[0])) }} </span>
                                        <i class="fa fa-angle-down"></i>
                                    </p>
                                </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li>
                                @role('admin')
                                <a href="{{ route('admin.edit_profile') }}">
                                    <i data-feather="settings"></i>
                                    <span>Settings</span>
                                </a>
                                @endrole
                                @role('customer')
                                <a href="{{ route('customer.edit_profile') }}">
                                    <i data-feather="settings"></i>
                                    <span>Settings</span>
                                </a>
                                @endrole
                                @role('partner')
                                <a href="{{ route('partner.edit_profile') }}">
                                    <i data-feather="settings"></i>
                                    <span>Settings</span>
                                </a>
                                @endrole
                            </li>

                            <li>
                                <a onclick="document.getElementById('logout_form').submit();">
                                    <i data-feather="log-in"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                            <form action="{{route('logout')}}" method="POST" id="logout_form"> @csrf </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>