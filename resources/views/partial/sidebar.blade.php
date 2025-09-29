<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a
                href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('customer') ? 'customer.dashboard' : (auth()->user()->hasRole('partner') ? 'partner.dashboard' : (auth()->user()->hasRole('executor') ? 'executor.dashboard' : 'dashboard')))) }}">
                <img class="img-fluid" src="{{ asset('assets/frontend/images/logo-white.png') }}" alt=""
                    style="width:100px;">
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
            <a
                href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('customer') ? 'customer.dashboard' : (auth()->user()->hasRole('partner') ? 'partner.dashboard' : (auth()->user()->hasRole('executor') ? 'executor.dashboard' : 'dashboard')))) }}">
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
                            <h6>Getting Started</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link"
                            href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('customer') ? 'customer.dashboard' : (auth()->user()->hasRole('partner') ? 'partner.dashboard' : (auth()->user()->hasRole('executor') ? 'executor.dashboard' : 'dashboard')))) }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="">Dashboard </span>
                        </a>
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
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Partners </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.partners.create') }}">Create Partner</a></li>
                            <li><a href="{{ route('admin.partners.index') }}">View All</a></li>
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
                            <span>Invite Friends </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.partners.send_invite') }}">Send Invite</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-editors') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-editors') }}"></use>
                            </svg>
                            <span>Withdrawals</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.withdraw.index') }}">Manage Withdrawals</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Notifications </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.notifications.create') }}">Send Notification</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Emails </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.emails.create') }}">Send Email</a></li>
                        </ul>
                    </li>
                    @endrole

                    @role('partner')
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
                            <li><a href="{{ route('partner.customers.index') }}">View All</a></li>
                            <li><a href="{{ route('partner.customers.invite_customers') }}">Invite Customer</a></li>
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
                            <span>Partners </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('partner.partners.create') }}">Create Partner</a></li>
                            <li><a href="{{ route('partner.partners.index') }}">View All</a></li>
                        </ul>
                    </li>


                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Knowledgebase</span>
                        </a>
                        <ul class="sidebar-submenu">
                        <li><a href="{{ route('partner.knowledgebase.quick_start_guide') }}">Quick Start Guide</a></li>    
                        <li><a href="{{ route('partner.knowledgebase.index') }}">Learning Videos</a></li>
                            <li><a href="{{ route('partner.knowledgebase.email_templates') }}">Email Templates</a></li>
                            <li><a href="{{ route('partner.knowledgebase.suggested_scripts') }}">Suggested Scripts</a></li>
                            <li><a href="{{ route('partner.knowledgebase.short_call_openers') }}">Short Call Openers</a></li>
                            <li><a href="{{ route('partner.knowledgebase.whatsapp_texts') }}">Whatsapp/Texts</a></li>
                            <li><a href="{{ route('partner.knowledgebase.social_media_direct_messages') }}">SM Direct Messages(DM)</a></li>
                            <li><a href="{{ route('partner.knowledgebase.social_media_posts') }}">Social Media Posts</a></li>
                            <li><a href="{{ route('partner.knowledgebase.best_practices') }}">FAQ's & Best Practices</a></li>
                            <li><a href="{{ route('partner.knowledgebase.client_reactivation') }}">Client Reactivation Templates</a></li>
                            <li><a href="{{ route('partner.knowledgebase.entry_example') }}">Logos</a></li>
                            
        
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
                            <span>Invite Friends </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('partner.partners.send_invite') }}">Send Invite</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Notifications</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('partner.notifications.index') }}">View Notifications</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Account & Membership</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-editors') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-editors') }}"></use>
                            </svg>
                            <span>Bank Account </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('partner.bank_account.index') }}">Bank Account</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-editors') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-editors') }}"></use>
                            </svg>
                            <span>Withdraw </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('partner.withdraw.view') }}">Withdrawal</a></li>
                            <li><a href="{{ route('partner.withdraw.history') }}">Withdrawal History</a></li>
                        </ul>
                    </li>


                    @endrole

                    @php
                        $package = Auth::user()->subscribed_package; // Retrieve the subscribed package of the logged-in user
                    @endphp
                    @role('customer')
                    @if (in_array($package, ['Basic', 'Standard', 'Premium', 'free_trial']))
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
                                <li><a href="{{ route('customer.investment_accounts.view') }}">Investment
                                        Accounts</a></li>
                                <li><a href="{{ route('customer.properties.view') }}">Property <span
                                            style="all: unset; text-transform: lowercase;">(ies)</span> Owned</a></li>
                                <li><a href="{{ route('customer.personal_chattels.view') }}">Personal Chattels</a>
                                </li>
                                <li><a href="{{ route('customer.business_interests.view') }}">Business Interests</a>
                                </li>
                                <li><a href="{{ route('customer.insurance_policies.view') }}">Insurance Policies</a>
                                </li>
                                <li><a href="{{ route('customer.debt_and_liabilities.view') }}">Debt &
                                        Liabilities</a></li>
                                <li><a href="{{ route('customer.intellectual_properties.view') }}">Intellectual
                                        Properties</a></li>
                                <li><a href="{{ route('customer.foreign_assets.view') }}">Foreign assets</a></li>
                                <li><a href="{{ route('customer.pensions.view') }}">Pensions</a></li>
                                <li><a href="{{ route('customer.funeral_plans.view') }}">Funeral Plans</a></li>
                                <li><a href="{{ route('customer.other_assets.view') }}">Other Assets</a></li>
                                <li><a href="{{ route('customer.other_type_of_assets.view') }}">Other Type of
                                        Assets</a></li>
                            </ul>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="{{ route('customer.bank_accounts.view') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                </svg>
                                <span>Bank Accounts </span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="{{ route('customer.digital_assets.view') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                </svg>
                                <span>Digital Assets </span>
                            </a>
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
                    @endif

                    @if (in_array($package, ['Standard', 'Premium', 'free_trial']))
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
                    @endif

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Legal & Proof</h6>
                        </div>
                    </li>

                    @if (in_array($package, ['Premium', 'free_trial']))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                </svg>
                                <span>Will Generator</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @php
                                    $will_user_info = \App\Models\WillUserInfo::where(
                                        'user_id',
                                        Auth::user()->id,
                                    )->first();
                                @endphp

                                <li>
                                    @if ($will_user_info)
                                        <a href="{{ route('customer.will_generator.create', $will_user_info->id) }}">Edit
                                            Will</a>
                                    @else
                                        <a href="{{ route('customer.will_generator.about_you') }}">Create Will</a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                                </svg>
                                <span>Capacity Proof Video (Will) </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.wills.create') }}">Create</a></li>
                                <li><a href="{{ route('customer.wills.index') }}">View</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                                </svg>
                                <span>Capacity Proof Video (LPA) </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.lpa.create') }}">Create</a></li>
                                <li><a href="{{ route('customer.lpa.index') }}">View</a></li>
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
                                <span>Trust Wishes </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.wishes.view') }}">Manage Trust Wishes</a></li>
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
                                <span>Memorandum of Wishes</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.memorandum_wishes.view') }}">Manage Memorandum
                                        Wishes</a></li>
                            </ul>
                        </li>
                    @endif


                    @if (in_array($package, ['Premium', 'free_trial']))
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Guidance & Instructions</h6>
                            </div>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                                </svg>
                                <span>Guidance For Guardians</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.guidance.view') }}">Guidance For Guardians</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-layout') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-layout') }}"></use>
                                </svg>
                                <span>Funeral</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.funeral_wake.view') }}">Manage</a></li>
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
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-sample-page') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-sample-page') }}"></use>
                                </svg>
                                <span>Donations </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.organs_donation.view') }}">Organ Donations</a></li>
                            </ul>
                        </li>

                    @endif


                    @if (in_array($package, ['Standard', 'Premium', 'free_trial']))
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Documents & Media</h6>
                            </div>
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
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                                </svg>
                                <span>Pictures & Videos </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.pictures.view') }}">Manage Pictures</a></li>
                                <li><a href="{{ route('customer.videos.view') }}">Manage Videos</a></li>
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
                                <li><a href="{{ route('customer.life_remembered.view') }}">Manage Pictures</a></li>
                                <li><a href="{{ route('customer.life_remembered_videos.view') }}">Manage Videos</a>
                                </li>
                                <li><a href="{{ route('customer.voice_notes.view') }}">Manage Voice Notes</a></li>
                            </ul>
                        </li>
                    @endif


                    <li class="sidebar-main-title">
                        <div>
                            <h6>Ongoing Management</h6>
                        </div>
                    </li>
                    @if (in_array($package, ['Premium', 'free_trial']))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                                </svg>
                                <span>Executor Hub AI </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.openai.view') }}">AI Assisstant</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-calendar') }}"></use>
                                </svg>
                                <span>Tasks </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.tasks.index') }}">Manage Tasks</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                                </svg>
                                <span>Inbox </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('customer.messages.view') }}">Manage Inbox</a></li>
                            </ul>
                        </li>
                    @endif


                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Notifications</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.notifications.index') }}">View Notifications</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Useful Contatcs</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.useful_contacts.index') }}">View</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Account & Membership</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('customer.membership.view') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Membership</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.membership.view') }}">Pricing Plans</a></li>
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
                            <li><a href="{{ route('executor.investment_accounts.view') }}">Investment Accounts</a>
                            </li>
                            <li><a href="{{ route('executor.properties.view') }}">Property <span
                                        style="all: unset; text-transform: lowercase;">(ies)</span> Owned</a></li>
                            <li><a href="{{ route('executor.personal_chattels.view') }}">Personal Chattels</a></li>
                            <li><a href="{{ route('executor.business_interests.view') }}">Business Interests</a></li>
                            <li><a href="{{ route('executor.insurance_policies.view') }}">Insurance Policies</a></li>
                            <li><a href="{{ route('executor.debt_and_liabilities.view') }}">Debt & Liabilities</a>
                            </li>
                            <li><a href="{{ route('executor.intellectual_properties.view') }}">Intellectual
                                    Properties</a></li>
                            <li><a href="{{ route('executor.foreign_assets.view') }}">Foreign assets</a></li>
                            <li><a href="{{ route('executor.pensions.view') }}">Pensions</a></li>
                            <li><a href="{{ route('executor.funeral_plans.view') }}">Funeral Plans</a></li>
                            <li><a href="{{ route('executor.other_type_of_assets.view') }}">Other Type of Assets</a>
                            </li>
                            <li><a href="{{ route('executor.other_assets.view') }}">Other Assets</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('executor.bank_accounts.view') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Bank Accounts </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('executor.digital_assets.view') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Digital Assets </span>
                        </a>
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

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Legal & Proof</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Will Generator</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.will_generator.index') }}">View</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                            </svg>
                            <span>Capacity Proof Video (Will) </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.wills.index') }}">View</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                            </svg>
                            <span>Capacity Proof Video (LPA) </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.lpa.index') }}">View</a></li>
                        </ul>
                    </li>



                    <li class="sidebar-main-title">
                        <div>
                            <h6>Guidance & Instructions</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                            </svg>
                            <span>Guidance For Guardians</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.guidance.view') }}">Guidance For Guardians</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-layout') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-layout') }}"></use>
                            </svg>
                            <span>Funeral</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.funeral_wake.view') }}">Manage</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-sample-page') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-sample-page') }}"></use>
                            </svg>
                            <span>Donations </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.organs_donation.view') }}">Organ Donations</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Documents & Media</h6>
                        </div>
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
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                            </svg>
                            <span>Pictures & Videos </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.pictures.view') }}">Manage Pictures</a></li>
                            <li><a href="{{ route('executor.videos.view') }}">Manage Videos</a></li>
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
                            <span>Trust Wishes</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.wishes.view') }}">Manage Trust Wishes</a></li>
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
                            <span>Memorandum of Wishes</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.memorandum_wishes.view') }}">Manage Memorandum Wishes</a>
                            </li>
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
                            <li><a href="{{ route('executor.life_remembered.view') }}">Manage Pictures</a></li>
                            <li><a href="{{ route('executor.life_remembered_videos.view') }}">Manage Videos</a></li>
                            <li><a href="{{ route('executor.voice_notes.view') }}">Manage Voice Notes</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Ongoing Management</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Inbox </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.messages.view') }}">Manage Inbox</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-calendar') }}"></use>
                            </svg>
                            <span>Tasks </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.tasks.index') }}">Manage Tasks</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Useful Contatcs</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('executor.useful_contacts.index') }}">View</a></li>
                        </ul>
                    </li>

                    @endrole

                    @if (Auth::user()->hasAnyRole(['Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers']))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                                </svg>
                                <span>Inbox </span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('messages.view') }}">Manage Inbox</a></li>
                            </ul>
                        </li>
                    @endif

                    @canany([
                        'view bank accounts',
                        'view investment accounts',
                        'view properties',
                        'view personal
                                    chattels',
                        'view business interests',
                        'view insurance policies',
                        'view debt and liabilities',
                        'view
                                    digital assets',
                        'view intellectual properties',
                        'view other assets',
                        'view other type of assets',
                        'view pension',
                        'view funeral plan',
                        'view foreign assets',
                        'view pictures',
                        'view videos'
                    ])

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>Assets & Liabilities</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @can('view bank accounts')
                                <li><a href="{{ route('bank_accounts.view') }}">Bank Accounts</a></li>
                            @endcan
                            @can('view investment accounts')
                                <li><a href="{{ route('investment_accounts.view') }}">Investment Accounts</a></li>
                            @endcan
                            @can('view properties')
                                <li><a href="{{ route('properties.view') }}">Property <span
                                            style="all: unset; text-transform: lowercase;">(ies)</span> Owned</a></li>
                            @endcan
                            @can('view personal chattels')
                                <li><a href="{{ route('personal_chattels.view') }}">Personal Chattels</a></li>
                            @endcan
                            @can('view business interests')
                                <li><a href="{{ route('business_interests.view') }}">Business Interests</a></li>
                            @endcan
                            @can('view insurance policies')
                                <li><a href="{{ route('insurance_policies.view') }}">Insurance Policies</a></li>
                            @endcan
                            @can('view debt and liabilities')
                                <li><a href="{{ route('debt_and_liabilities.view') }}">Debt & Liabilities</a></li>
                            @endcan
                            @can('view digital assets')
                                <li><a href="{{ route('digital_assets.view') }}">Digital Assets</a></li>
                            @endcan
                            @can('view intellectual properties')
                                <li><a href="{{ route('intellectual_properties.view') }}">Intellectual Properties</a>
                                </li>
                            @endcan
                            @can('view foreign assets')
                                <li><a href="{{ route('foreign_assets.view') }}">Foreign assets</a></li>
                            @endcan
                            @can('view pension')
                                <li><a href="{{ route('pensions.view') }}">Pensions</a></li>
                            @endcan
                            @can('view funeral plan')
                                <li><a href="{{ route('funeral_plans.view') }}">Funeral plans</a></li>
                            @endcan
                            @can('view other type of assets')
                                <li><a href="{{ route('other_type_of_assets.view') }}">Other Type of Assets</a></li>
                            @endcan
                            @can('view other assets')
                                <li><a href="{{ route('other_assets.view') }}">Other Assets</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-editors') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-editors') }}"></use>
                            </svg>
                            <span>Withdraw </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('withdraw.view') }}">Withdrawal</a></li>
                            <li><a href="{{ route('withdraw.history') }}">Withdrawal History</a></li>
                        </ul>
                    </li>
                    @endcan

                    @can('view otherss')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>otherss</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('otherss.view') }}">Manage others</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('view advisors')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>Advisors</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('advisors.view') }}">Manage Advisers</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('view documents')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                                </svg>
                                <span>Documents</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('documents.view') }}">Manage Documents</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('view wishes')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                                </svg>
                                <span>Trust Wishes</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('wishes.view') }}">Manage Trust Wishes</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('view memorandum wishes')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                                </svg>
                                <span>Memorandum Wishes</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('memorandum_wishes.view') }}">Manage Memorandum Wish</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('view guidance')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                                </svg>
                                <span>Guidance For Guardians</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('guidance.view') }}">Guidance For Guardians</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('view life remembered')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                                </svg>
                                <span>Life Remembered</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('life_remembered.view') }}">Manage Pictures</a></li>
                                <li><a href="{{ route('life_remembered_videos.view') }}">Manage Videos</a></li>
                                @can('view voice notes')
                                    <li><a href="{{ route('voice_notes.view') }}">Manage Voice Notes</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('view organs donation')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-sample-page') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-sample-page') }}"></use>
                                </svg>
                                <span>Donations</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('organs_donation.view') }}">Organ Donations</a></li>
                            </ul>
                        </li>
                    @endcan
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>