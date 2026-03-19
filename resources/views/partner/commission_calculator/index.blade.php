@extends('layouts.master')

@section('content')
    <style>
        h1 {
            text-align: center;
            color: #667eea;
            margin-bottom: 40px;
            font-size: 2.5em;
        }

        .section {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .section h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-number {
            background: #667eea;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            font-weight: bold;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        select,
        input[type="number"] {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        select:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
        }

        .toggle-group {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            background: white;
            border-radius: 8px;
        }

        .toggle-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle {
            position: relative;
            width: 60px;
            height: 30px;
            background: #ccc;
            border-radius: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .toggle.active {
            background: #667eea;
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .toggle.active .toggle-slider {
            transform: translateX(30px);
        }

        .results-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 25px;
            border-radius: 12px;
            margin-top: 10px;
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .result-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .result-label {
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .result-value {
            color: #333;
            font-size: 20px;
            font-weight: 700;
        }

        .total-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-top: 25px;
            text-align: center;
        }

        .total-section h2 {
            color: white;
            margin-bottom: 25px;
        }

        .total-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .total-item {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .total-item h3 {
            font-size: 14px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .total-item .value {
            font-size: 32px;
            font-weight: 700;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 20px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .savings-badge {
            background: #4caf50;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 5px;
        }

        .info-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 14px;
            color: #856404;
        }

        .simulator-shell {
            display: grid;
            gap: 25px;
        }

        .scenario-grid,
        .insight-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
        }

        .scenario-card,
        .insight-card {
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.08);
        }

        .scenario-card h3,
        .insight-card h3 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #243b53;
        }

        .scenario-card p,
        .insight-card p {
            margin-bottom: 0;
            color: #52606d;
            font-size: 13px;
        }

        .scenario-card strong,
        .insight-card strong {
            display: block;
            margin-top: 12px;
            color: #183153;
            font-size: 28px;
        }

        .graph-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.08);
        }

        .graph-bars {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            align-items: end;
            min-height: 240px;
            margin-top: 18px;
        }

        .graph-bar {
            display: flex;
            flex-direction: column;
            justify-content: end;
            gap: 10px;
            min-height: 240px;
        }

        .graph-fill {
            min-height: 32px;
            border-radius: 14px 14px 6px 6px;
            background: linear-gradient(180deg, #3caea3 0%, #2b7a78 100%);
        }

        .graph-value {
            font-weight: 700;
            color: #183153;
            text-align: center;
        }

        .graph-label {
            text-align: center;
            color: #52606d;
            font-weight: 600;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="edit-profile">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">How You Earn</h4>
                                <p class="mb-0 mt-2 text-muted">Partner earnings simulator</p>
                            </div>
                            <div class="card-body">
                                <div class="simulator-shell">
                                <form id="calculatorForm">
                                    <!-- SECTION 1: Client Selection -->
                                    <div class="section">
                                        <h2><span class="section-number">1</span> Client Selection</h2>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Client Type</label>
                                                <select id="clientType" required>
                                                    <option value="individual">Individual</option>
                                                    <option value="couple">Couple</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Age Band</label>
                                                <select id="ageBand" required>
                                                    <option value="under50">Under 50</option>
                                                    <option value="50-65">50-65</option>
                                                    <option value="65plus">65+</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Plan</label>
                                                <select id="plan" required>
                                                    <option value="basic">Basic</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="toggle-group">
                                            <div class="toggle-container">
                                                <label style="margin: 0;">Christmas Bonus</label>
                                                <div class="toggle" id="christmasToggle">
                                                    <div class="toggle-slider"></div>
                                                </div>
                                            </div>
                                            <div class="toggle-container">
                                                <label style="margin: 0;">Include VAT</label>
                                                <div class="toggle" id="vatToggle">
                                                    <div class="toggle-slider"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SECTION 2: Customer Pricing -->
                                    <div class="section">
                                        <h2><span class="section-number">2</span> Customer Pricing</h2>
                                        <div class="results-section" id="customerPricing">
                                            <div class="result-grid">
                                                <div class="result-item">
                                                    <div class="result-label">Price Paid</div>
                                                    <div class="result-value" id="pricePaid">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">Value Received</div>
                                                    <div class="result-value" id="valueReceived">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">Savings</div>
                                                    <div class="result-value" id="savings">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">VAT Amount</div>
                                                    <div class="result-value" id="vatAmount">£0.00</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SECTION 3: Partner Earnings -->
                                    <div class="section">
                                        <h2><span class="section-number">3</span> Partner Earnings (Direct Sales)</h2>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Number of Sales per Month</label>
                                                <input type="number" id="salesPerMonth" min="0" value="1" required>
                                            </div>
                                        </div>

                                        <div class="results-section">
                                            <div class="result-grid">
                                                <div class="result-item">
                                                    <div class="result-label">Commission per Sale (30%)</div>
                                                    <div class="result-value" id="commissionPerSale">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">Monthly Earnings</div>
                                                    <div class="result-value" id="monthlyEarnings">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">Annual Earnings</div>
                                                    <div class="result-value" id="annualEarnings">£0.00</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SECTION 4: Override Earnings -->
                                    <div class="section">
                                        <h2><span class="section-number">4</span> Override Earnings (Team Commissions)</h2>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Number of Recruited Partners</label>
                                                <input type="number" id="recruitedPartners" min="0" value="0" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Average Sales per Recruited Partner (Monthly)</label>
                                                <input type="number" id="avgSalesPerPartner" min="0" value="0" required>
                                            </div>
                                        </div>

                                        <div class="results-section">
                                            <div class="result-grid">
                                                <div class="result-item">
                                                    <div class="result-label">Override per Sale (20%)</div>
                                                    <div class="result-value" id="overridePerSale">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">Monthly Override</div>
                                                    <div class="result-value" id="monthlyOverride">£0.00</div>
                                                </div>
                                                <div class="result-item">
                                                    <div class="result-label">Annual Override</div>
                                                    <div class="result-value" id="annualOverride">£0.00</div>
                                                </div>
                                            </div>
                                            <div class="info-note">
                                                <strong>Note:</strong> Override earnings are calculated from your recruited
                                                partners' sales. You earn 20% of each sale made by partners you recruit.
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="calculateBtn">Calculate Total Income</button>
                                </form>

                                <!-- SECTION 5: Total Partner Income -->
                                <div class="total-section" id="totalIncome" style="display: none;">
                                    <h2><span class="section-number">5</span> Total Partner Income</h2>
                                    <div class="total-grid">
                                        <div class="total-item">
                                            <h3>MONTHLY TOTAL</h3>
                                            <div class="value" id="monthlyTotal">£0.00</div>
                                        </div>
                                        <div class="total-item">
                                            <h3>ANNUAL TOTAL</h3>
                                            <div class="value" id="annualTotal">£0.00</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <h2><span class="section-number">6</span> Income Paths At A Glance</h2>
                                    <div class="scenario-grid">
                                        <div class="scenario-card">
                                            <h3>Sell One Today</h3>
                                            <p>Direct commission from one customer on your selected plan.</p>
                                            <strong id="scenarioOneSale">£0.00</strong>
                                        </div>
                                        <div class="scenario-card">
                                            <h3>Sell Five This Month</h3>
                                            <p>A simple monthly benchmark for a steady outreach rhythm.</p>
                                            <strong id="scenarioFiveSales">£0.00</strong>
                                        </div>
                                        <div class="scenario-card">
                                            <h3>Current Team Scenario</h3>
                                            <p>Your selected partner count and sales assumptions combined.</p>
                                            <strong id="scenarioCurrentTeam">£0.00</strong>
                                        </div>
                                        <div class="scenario-card">
                                            <h3>Large Network Scenario</h3>
                                            <p>A 10-partner team with 5 monthly sales each to show scale.</p>
                                            <strong id="scenarioLargeNetwork">£0.00</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <h2><span class="section-number">7</span> Lifetime Value Snapshot</h2>
                                    <div class="insight-grid">
                                        <div class="insight-card">
                                            <h3>One Customer Over 12 Months</h3>
                                            <p>Projected direct commission from one retained customer over a year.</p>
                                            <strong id="lifetimeSingleCustomer">£0.00</strong>
                                        </div>
                                        <div class="insight-card">
                                            <h3>Three Partners Over 12 Months</h3>
                                            <p>Projected override income from 3 partners each making 5 sales per month.</p>
                                            <strong id="lifetimeThreePartners">£0.00</strong>
                                        </div>
                                        <div class="insight-card">
                                            <h3>Your Current Plan Over 12 Months</h3>
                                            <p>Your current monthly inputs annualised into a full-year view.</p>
                                            <strong id="lifetimeCurrentPlan">£0.00</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <h2><span class="section-number">8</span> Growth Projection</h2>
                                    <p class="mb-0 text-muted">A visual projection of cumulative income if your current monthly plan stays consistent.</p>
                                    <div class="graph-card">
                                        <div class="graph-bars">
                                            <div class="graph-bar">
                                                <div class="graph-fill" id="growthBar1"></div>
                                                <div class="graph-value" id="growthValue1">£0.00</div>
                                                <div class="graph-label">Month 1</div>
                                            </div>
                                            <div class="graph-bar">
                                                <div class="graph-fill" id="growthBar3"></div>
                                                <div class="graph-value" id="growthValue3">£0.00</div>
                                                <div class="graph-label">Month 3</div>
                                            </div>
                                            <div class="graph-bar">
                                                <div class="graph-fill" id="growthBar6"></div>
                                                <div class="graph-value" id="growthValue6">£0.00</div>
                                                <div class="graph-label">Month 6</div>
                                            </div>
                                            <div class="graph-bar">
                                                <div class="graph-fill" id="growthBar12"></div>
                                                <div class="graph-value" id="growthValue12">£0.00</div>
                                                <div class="graph-label">Month 12</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const prices = {
            basic: { under50: 495, '50-65': 395, '65plus': 295 },
            standard: { under50: 695, '50-65': 595, '65plus': 495 },
            premium: { under50: 895, '50-65': 795, '65plus': 695 }
        };

        const VAT_RATE = 0.20;
        const CHRISTMAS_DISCOUNT = 0.10;
        const COUPLE_DISCOUNT = 0.30;
        const PARTNER_COMMISSION = 0.30;
        const OVERRIDE_COMMISSION = 0.20;

        let christmasEnabled = false;
        let vatEnabled = false;

        function formatCurrency(value) {
            return `£${value.toFixed(2)}`;
        }

        // Toggle handlers
        document.getElementById('christmasToggle').addEventListener('click', function () {
            christmasEnabled = !christmasEnabled;
            this.classList.toggle('active');
            calculate();
        });

        document.getElementById('vatToggle').addEventListener('click', function () {
            vatEnabled = !vatEnabled;
            this.classList.toggle('active');
            calculate();
        });

        // Handle client type change to restrict plan options
        document.getElementById('clientType').addEventListener('change', function () {
            const planSelect = document.getElementById('plan');
            if (this.value === 'couple') {
                planSelect.innerHTML = '<option value="standard">Standard</option>';
                planSelect.value = 'standard';
            } else {
                planSelect.innerHTML = `
                            <option value="basic">Basic</option>
                            <option value="standard">Standard</option>
                            <option value="premium">Premium</option>
                        `;
            }
            calculate();
        });

        // Auto-calculate on any input change
        document.querySelectorAll('select, input').forEach(element => {
            element.addEventListener('change', calculate);
            element.addEventListener('input', calculate);
        });

        document.getElementById('calculateBtn').addEventListener('click', function () {
            calculate();
            document.getElementById('totalIncome').style.display = 'block';
            document.getElementById('totalIncome').scrollIntoView({ behavior: 'smooth' });
        });

        function calculate() {
            const clientType = document.getElementById('clientType').value;
            const ageBand = document.getElementById('ageBand').value;
            const plan = document.getElementById('plan').value;
            const salesPerMonth = parseFloat(document.getElementById('salesPerMonth').value) || 0;
            const recruitedPartners = parseFloat(document.getElementById('recruitedPartners').value) || 0;
            const avgSalesPerPartner = parseFloat(document.getElementById('avgSalesPerPartner').value) || 0;

            // Calculate base price
            let basePrice = prices[plan][ageBand];
            let totalPrice = basePrice;
            let valueReceived = basePrice;

            // Apply couple discount
            if (clientType === 'couple') {
                const secondPersonPrice = basePrice * (1 - COUPLE_DISCOUNT);
                totalPrice = basePrice + secondPersonPrice;
                valueReceived = basePrice * 2;
            }

            // Apply Christmas bonus
            if (christmasEnabled) {
                totalPrice = totalPrice * (1 - CHRISTMAS_DISCOUNT);
            }

            const savings = valueReceived - totalPrice;
            const priceBeforeVAT = totalPrice;

            // Apply VAT
            let vatAmount = 0;
            if (vatEnabled) {
                vatAmount = totalPrice * VAT_RATE;
                totalPrice = totalPrice * (1 + VAT_RATE);
            }

            // Update Section 2: Customer Pricing
            document.getElementById('pricePaid').textContent = formatCurrency(totalPrice);
            document.getElementById('valueReceived').textContent = formatCurrency(valueReceived);
            document.getElementById('savings').textContent = formatCurrency(savings);
            document.getElementById('vatAmount').textContent = formatCurrency(vatAmount);

            // Calculate Section 3: Partner Earnings (commission on price before VAT)
            const commissionBase = priceBeforeVAT;
            const commissionPerSale = commissionBase * PARTNER_COMMISSION;
            const monthlyEarnings = commissionPerSale * salesPerMonth;
            const annualEarnings = monthlyEarnings * 12;

            document.getElementById('commissionPerSale').textContent = formatCurrency(commissionPerSale);
            document.getElementById('monthlyEarnings').textContent = formatCurrency(monthlyEarnings);
            document.getElementById('annualEarnings').textContent = formatCurrency(annualEarnings);

            // Calculate Section 4: Override Earnings
            const overridePerSale = commissionBase * OVERRIDE_COMMISSION;
            const totalTeamSales = recruitedPartners * avgSalesPerPartner;
            const monthlyOverride = overridePerSale * totalTeamSales;
            const annualOverride = monthlyOverride * 12;

            document.getElementById('overridePerSale').textContent = formatCurrency(overridePerSale);
            document.getElementById('monthlyOverride').textContent = formatCurrency(monthlyOverride);
            document.getElementById('annualOverride').textContent = formatCurrency(annualOverride);

            // Calculate Section 5: Total Income
            const monthlyTotal = monthlyEarnings + monthlyOverride;
            const annualTotal = annualEarnings + annualOverride;

            document.getElementById('monthlyTotal').textContent = formatCurrency(monthlyTotal);
            document.getElementById('annualTotal').textContent = formatCurrency(annualTotal);

            const fiveSalesScenario = commissionPerSale * 5;
            const currentTeamScenario = monthlyTotal;
            const largeNetworkScenario = commissionPerSale * 5 + (overridePerSale * 10 * 5);

            document.getElementById('scenarioOneSale').textContent = formatCurrency(commissionPerSale);
            document.getElementById('scenarioFiveSales').textContent = formatCurrency(fiveSalesScenario);
            document.getElementById('scenarioCurrentTeam').textContent = formatCurrency(currentTeamScenario);
            document.getElementById('scenarioLargeNetwork').textContent = formatCurrency(largeNetworkScenario);

            const singleCustomerLifetime = commissionPerSale * 12;
            const threePartnerLifetime = overridePerSale * 3 * 5 * 12;

            document.getElementById('lifetimeSingleCustomer').textContent = formatCurrency(singleCustomerLifetime);
            document.getElementById('lifetimeThreePartners').textContent = formatCurrency(threePartnerLifetime);
            document.getElementById('lifetimeCurrentPlan').textContent = formatCurrency(annualTotal);

            const growthPoints = {
                1: monthlyTotal,
                3: monthlyTotal * 3,
                6: monthlyTotal * 6,
                12: monthlyTotal * 12
            };
            const maxGrowth = Math.max(...Object.values(growthPoints), 1);

            Object.entries(growthPoints).forEach(([month, value]) => {
                const bar = document.getElementById(`growthBar${month}`);
                const label = document.getElementById(`growthValue${month}`);
                const height = Math.max((value / maxGrowth) * 180, value > 0 ? 32 : 12);

                if (bar) {
                    bar.style.height = `${height}px`;
                }

                if (label) {
                    label.textContent = formatCurrency(value);
                }
            });
        }

        // Initial calculation
        calculate();
    </script>
@endsection
