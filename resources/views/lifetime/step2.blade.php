@extends(isset($is_upgrade) && $is_upgrade ? 'layouts.master' : 'layouts.app')

@section('content')
    @php
        $selectedHearAbout = old('hear_about_us', isset($user) ? ($user->hear_about_us ?? '') : '');
        $hearAboutOptions = [
            'Google',
            'Facebook',
            'Instagram',
            'TikTok',
            'YouTube',
            'Friend or family',
            'My adviser recommended me',
            'Other',
        ];
        $backUrl = isset($is_upgrade) && $is_upgrade ? route('customer.membership.view') : route('home') . '#pricing-1';
        $vatRate = 0.20; // display-only; Stripe calculates actual tax at checkout
    @endphp

    <style>
        .lifetime-shell {
            max-width: 1200px;
            margin: 0 auto;
        }

        .lifetime-hero {
            background: linear-gradient(135deg, #0f172a 0%, #123560 55%, #dbeafe 100%);
            border-radius: 24px;
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        .lifetime-hero::after {
            content: "";
            position: absolute;
            inset: auto -8% -35% auto;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            filter: blur(8px);
            pointer-events: none;
        }

        .lifetime-hero .row {
            position: relative;
            z-index: 1;
        }

        .lifetime-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .lifetime-plan-card {
            height: 100%;
            border: 1px solid #dbe4f0;
            border-radius: 22px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            cursor: pointer;
            overflow: hidden;
            position: relative;
            background: #fff;
        }

        .lifetime-plan-card .card-body {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 0 !important;
        }

        .lifetime-plan-top {
            padding: 24px 24px 18px;
            border-bottom: 1px solid #e8eef6;
        }

        .lifetime-plan-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
        }

        .lifetime-plan-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
        }

        .lifetime-plan-tier {
            flex-shrink: 0;
            line-height: 1;
            font-size: 18px;
            color: #344054;
        }

        .lifetime-plan-price {
            font-size: 28px;
            line-height: 1.1;
            font-weight: 700;
            color: #243b5a;
            margin-bottom: 8px;
        }

        .lifetime-plan-subtitle {
            color: #667085;
            margin-bottom: 0;
        }

        .lifetime-plan-content {
            padding: 22px 24px 24px;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
        }

        .lifetime-plan-description {
            color: #475467;
            margin-bottom: 18px;
            min-height: 58px;
        }

        .lifetime-plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 20px;
        }

        .lifetime-plan-features li {
            padding: 7px 0;
            border-bottom: 1px solid #f1f5f9;
            color: #344054;
        }

        .lifetime-plan-features li:last-child {
            border-bottom: 0;
        }

        .lifetime-plan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .lifetime-plan-card.is-selected {
            border-color: #0d6efd;
            box-shadow: 0 18px 42px rgba(13, 110, 253, 0.18);
        }

        .lifetime-plan-card.is-selected::before {
            content: "";
            position: absolute;
            inset: 0;
            border-top: 4px solid #0d6efd;
        }

        .lifetime-featured-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
        }

        .select-plan-button {
            margin-top: auto !important;
            border-radius: 10px;
            min-height: 46px;
            font-weight: 600;
        }

        .lifetime-form-card {
            border-radius: 22px;
            border: 1px solid #dbe4f0;
            background: #fff;
        }

        .lifetime-summary {
            border: 1px solid #cfe2ff;
            background: #eef5ff;
            border-radius: 16px;
        }
    </style>

    <div class="page-body">
        <div class="container-fluid py-4">
            <div class="lifetime-shell">
                <div class="lifetime-hero p-4 p-lg-5 mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="lifetime-badge">Lifetime Checkout</span>
                            <h2 class="mt-3 mb-2">Choose your lifetime plan</h2>
                            <p class="mb-0">
                                Date of birth: <strong>{{ \Carbon\Carbon::parse($date_of_birth)->format('d M Y') }}</strong>
                                | Age: <strong>{{ $age }}</strong>
                                @if(isset($is_upgrade) && $is_upgrade)
                                    | Type: <strong>Account upgrade</strong>
                                @endif
                            </p>
                        </div>
                        <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
                            <a href="{{ $backUrl }}" class="btn btn-light px-4">Back</a>
                        </div>
                    </div>
                </div>

                @if ($errors->lifetime->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->lifetime->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row g-4 mb-4">
                    @foreach($plans as $plan)
                        <div class="col-xl-4">
                            <div
                                class="lifetime-plan-card {{ old('plan_tier') === $plan['tier'] ? 'is-selected' : '' }} {{ $plan['tier'] === 'standard' ? 'is-featured' : '' }}"
                                data-tier="{{ $plan['tier'] }}"
                                data-label="{{ $plan['label'] }}"
                                data-amount="{{ $plan['amount'] }}"
                                data-currency="{{ $plan['currency'] }}"
                                data-price-id="{{ $plan['price_id'] }}"
                            >
                                <div class="card-body p-4">
                                    <div class="lifetime-plan-top">
                                        <div class="lifetime-plan-header">
                                            <div class="lifetime-plan-title">
                                                <h4 class="mb-1">{{ $plan['label'] }}</h4>
                                                <p class="text-muted mb-0">One-time payment</p>
                                            </div>
                                            <div class="lifetime-plan-meta">
                                                @if($plan['tier'] === 'standard')
                                                    <span class="lifetime-featured-badge">Most Popular</span>
                                                @endif
                                                <div class="lifetime-plan-tier">
                                                    @if($plan['tier'] === 'basic')
                                                        <span>Base</span>
                                                    @elseif($plan['tier'] === 'standard')
                                                        <span>Plus</span>
                                                    @else
                                                        <span>Max</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="lifetime-plan-price">{{ $plan['currency'] }} {{ number_format($plan['amount'] * (1 + $vatRate), 2) }}</div>
                                        <p class="lifetime-plan-subtitle mb-1">Includes UK VAT ({{ (int) ($vatRate * 100) }}%) for UK customers</p>
                                        <p class="text-muted small mb-0">Ex VAT: {{ $plan['currency'] }} {{ number_format($plan['amount'], 2) }}</p>
                                    </div>

                                    <div class="lifetime-plan-content">
                                        @if($plan['tier'] === 'basic')
                                            <p class="lifetime-plan-description">Essential storage for key documents, assets, and liabilities.</p>
                                            <ul class="lifetime-plan-features">
                                                <li>Core customer dashboard access</li>
                                                <li>Executor assignment</li>
                                                <li>Assets and liabilities record</li>
                                            </ul>
                                        @elseif($plan['tier'] === 'standard')
                                            <p class="lifetime-plan-description">The strongest all-round package for most customers.</p>
                                            <ul class="lifetime-plan-features">
                                                <li>Everything in Basic</li>
                                                <li>Adviser collaboration and reminders</li>
                                                <li>Optional couple partner invite</li>
                                            </ul>
                                        @else
                                            <p class="lifetime-plan-description">Full feature access for wishes, legacy, and personal planning.</p>
                                            <ul class="lifetime-plan-features">
                                                <li>Everything in Standard</li>
                                                <li>Wishes, messages, and legacy tools</li>
                                                <li>Highest level of coverage</li>
                                            </ul>
                                        @endif

                                        <button type="button" class="btn btn-outline-primary w-100 mt-4 select-plan-button">
                                            Select {{ ucfirst($plan['tier']) }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="selectedPlanSummary" class="lifetime-summary p-3 mb-4" style="display:none;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <div class="fw-semibold">Selected plan</div>
                            <div id="selectedPlanLabel" class="fs-5"></div>
                        </div>
                        <div class="text-md-end">
                            <div class="text-muted small">Total due now</div>
                            <div id="selectedPlanPrice" class="fs-4 fw-bold"></div>
                        </div>
                    </div>
                </div>

                <div id="checkoutForm" class="lifetime-form-card p-4 p-lg-5" style="display:none;">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                        <div>
                            <h3 class="mb-1">
                                @if(isset($is_upgrade) && $is_upgrade)
                                    Complete your upgrade
                                @else
                                    Complete your checkout
                                @endif
                            </h3>
                            <p class="text-muted mb-0">
                                Fill in the remaining details and continue to secure Stripe checkout.
                            </p>
                        </div>
                        @if(isset($is_upgrade) && $is_upgrade)
                            <div class="alert alert-info mb-0 py-2 px-3">
                                Existing customer details have been pre-filled.
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('stripe.lifetime') }}" class="row g-3 needs-validation" novalidate>
                        @csrf

                        <input type="hidden" name="date_of_birth" id="formDateOfBirth" value="{{ $date_of_birth }}">
                        <input type="hidden" name="plan_tier" id="formPlanTier" value="{{ old('plan_tier', '') }}" required>
                        <input type="hidden" name="price_id" id="formPriceId" value="">

                        <div class="col-md-6">
                            <label for="lifetimeName" class="form-label">Full Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="lifetimeName"
                                name="name"
                                value="{{ old('name', isset($user) ? $user->name : '') }}"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimeEmail" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="lifetimeEmail"
                                name="email"
                                value="{{ old('email', isset($user) ? $user->email : '') }}"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimePassword" class="form-label">
                                Password
                                @if(isset($is_upgrade) && $is_upgrade)
                                    <small class="text-muted">(leave blank to keep current password)</small>
                                @endif
                            </label>
                            <input type="password" class="form-control" id="lifetimePassword" name="password">
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimeCoupon" class="form-label">
                                Coupon Code
                                <span class="text-danger" id="couponRequired" style="display:none;">*</span>
                            </label>
                            <input type="text" class="form-control" id="lifetimeCoupon" name="coupon_code" value="{{ old('coupon_code') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimeAddress" class="form-label">Address</label>
                            <input
                                type="text"
                                class="form-control"
                                id="lifetimeAddress"
                                name="address"
                                value="{{ old('address', isset($user) ? ($user->address ?? '') : '') }}"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimeCity" class="form-label">City</label>
                            <input
                                type="text"
                                class="form-control"
                                id="lifetimeCity"
                                name="city"
                                value="{{ old('city', isset($user) ? ($user->city ?? '') : '') }}"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimePostalCode" class="form-label">Postal Code</label>
                            <input
                                type="text"
                                class="form-control"
                                id="lifetimePostalCode"
                                name="postal_code"
                                value="{{ old('postal_code', isset($user) ? ($user->postal_code ?? '') : '') }}"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimeCountry" class="form-label">Country</label>
                            <input
                                type="text"
                                class="form-control"
                                id="lifetimeCountry"
                                name="country"
                                value="{{ old('country', isset($user) ? ($user->country ?? '') : '') }}"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="lifetimeHearAboutUs" class="form-label">Where did you hear about us?</label>
                            <select class="form-select" id="lifetimeHearAboutUs" name="hear_about_us">
                                <option value="">Select an option</option>
                                @foreach($hearAboutOptions as $option)
                                    <option value="{{ $option }}" {{ $selectedHearAbout === $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6" id="lifetimeHearAboutOtherWrapper" style="display: {{ old('hear_about_us') === 'Other' ? 'block' : 'none' }};">
                            <label for="lifetimeHearAboutOther" class="form-label">Please specify</label>
                            <input type="text" class="form-control" id="lifetimeHearAboutOther" name="other_hear_about_us" value="{{ old('other_hear_about_us', isset($user) ? ($user->other_hear_about_us ?? '') : '') }}">
                        </div>

                        <div class="col-12" id="partnerSection" style="display:none;">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="addPartnerCheckbox">Add Couple Partner?</label>
                                    <select class="form-select" name="addCouplePartner" id="addPartnerCheckbox">
                                        <option value="No" {{ old('addCouplePartner') === 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Yes" {{ old('addCouplePartner') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <small class="text-muted">Available on the Standard plan. Your partner receives an email invite to register with the discounted flow.</small>
                                </div>

                                <div id="partnerFields" style="display: {{ old('addCouplePartner') === 'Yes' ? 'flex' : 'none' }}; flex-wrap:wrap;">
                                    <div class="col-md-6">
                                        <label class="form-label" for="partnerName">Partner Name</label>
                                        <input type="text" class="form-control" id="partnerName" name="partner_name" value="{{ old('partner_name') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="partnerEmail">Partner Email</label>
                                        <input type="email" class="form-control" id="partnerEmail" name="partner_email" value="{{ old('partner_email') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-light border mb-0">
                                Use forever, with future updates included. Secure access, adviser continuity, and no monthly renewal pressure.
                            </div>
                        </div>

                        <div class="col-12 d-flex flex-column flex-sm-row gap-3 justify-content-end pt-2">
                            <a href="{{ $backUrl }}" class="btn btn-outline-secondary px-4">Back</a>
                            <button type="submit" class="btn btn-primary px-4">Proceed to Secure Checkout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePartnerFields() {
            const partnerSection = document.getElementById('partnerSection');
            const selector = document.getElementById('addPartnerCheckbox');
            const partnerFields = document.getElementById('partnerFields');
            const partnerName = document.getElementById('partnerName');
            const partnerEmail = document.getElementById('partnerEmail');

            if (!partnerSection || !selector || !partnerFields || !partnerName || !partnerEmail) {
                return;
            }

            if (partnerSection.style.display !== 'none' && selector.value === 'Yes') {
                partnerFields.style.display = 'flex';
                partnerName.setAttribute('required', 'required');
                partnerEmail.setAttribute('required', 'required');
            } else {
                partnerFields.style.display = 'none';
                partnerName.removeAttribute('required');
                partnerEmail.removeAttribute('required');
            }
        }

        function selectPlan(tier, label, amount, currency, priceId) {
            document.getElementById('formPlanTier').value = tier;
            document.getElementById('formPriceId').value = priceId;

            document.getElementById('selectedPlanLabel').textContent = label;
            document.getElementById('selectedPlanPrice').textContent = currency + ' ' + amount.toFixed(2);
            document.getElementById('selectedPlanSummary').style.display = 'block';

            document.querySelectorAll('.lifetime-plan-card').forEach(card => {
                card.classList.remove('is-selected');
            });

            const selectedCard = document.querySelector('.lifetime-plan-card[data-tier="' + tier + '"]');
            if (selectedCard) {
                selectedCard.classList.add('is-selected');
            }

            const partnerSection = document.getElementById('partnerSection');
            const addPartnerCheckbox = document.getElementById('addPartnerCheckbox');
            const partnerName = document.getElementById('partnerName');
            const partnerEmail = document.getElementById('partnerEmail');

            if (tier === 'standard') {
                partnerSection.style.display = 'block';
            } else {
                partnerSection.style.display = 'none';
                addPartnerCheckbox.value = 'No';
                partnerName.value = '';
                partnerEmail.value = '';
            }

            togglePartnerFields();

            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.style.display = 'block';
            checkoutForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.lifetime-plan-card, .select-plan-button').forEach(function (element) {
                element.addEventListener('click', function (event) {
                    const card = event.currentTarget.classList.contains('lifetime-plan-card')
                        ? event.currentTarget
                        : event.currentTarget.closest('.lifetime-plan-card');

                    if (!card) {
                        return;
                    }

                    selectPlan(
                        card.dataset.tier,
                        card.dataset.label,
                        parseFloat(card.dataset.amount),
                        card.dataset.currency,
                        card.dataset.priceId
                    );
                });
            });

            const hearAboutSelect = document.getElementById('lifetimeHearAboutUs');
            const otherWrapper = document.getElementById('lifetimeHearAboutOtherWrapper');
            const couponInput = document.getElementById('lifetimeCoupon');
            const couponRequired = document.getElementById('couponRequired');

            function updateHearAboutState() {
                const selectedValue = hearAboutSelect.value;
                otherWrapper.style.display = selectedValue === 'Other' ? 'block' : 'none';

                if (selectedValue === 'My adviser recommended me') {
                    couponInput.setAttribute('required', 'required');
                    couponRequired.style.display = 'inline';
                } else {
                    couponInput.removeAttribute('required');
                    couponRequired.style.display = 'none';
                }
            }

            updateHearAboutState();
            hearAboutSelect.addEventListener('change', updateHearAboutState);

            const addPartnerCheckbox = document.getElementById('addPartnerCheckbox');
            if (addPartnerCheckbox) {
                addPartnerCheckbox.addEventListener('change', togglePartnerFields);
            }

            const form = document.querySelector('form[action="{{ route('stripe.lifetime') }}"]');
            if (form) {
                form.addEventListener('submit', function (e) {
                    if (!document.getElementById('formPlanTier').value) {
                        e.preventDefault();
                        alert('Please select a lifetime plan before continuing.');
                    }
                });
            }

            @if(old('plan_tier'))
                selectPlan(
                    '{{ old('plan_tier') }}',
                    '{{ $plans[old('plan_tier')]['label'] ?? '' }}',
                    {{ isset($plans[old('plan_tier')]['amount']) ? $plans[old('plan_tier')]['amount'] : 0 }},
                    '{{ $plans[old('plan_tier')]['currency'] ?? '' }}',
                    '{{ $plans[old('plan_tier')]['price_id'] ?? '' }}'
                );
            @endif
        });
    </script>
@endsection
