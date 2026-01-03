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

        .owner-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-top: 25px;
            text-align: center;
        }

        .owner-section h2 {
            color: white;
            margin-bottom: 25px;
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

        .owner-info-note {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid rgba(255, 255, 255, 0.5);
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 14px;
            color: white;
            text-align: left;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="edit-profile">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Commission Calculator</h4>
                            </div>
                            <div class="card-body">
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
                                                partners' sales. When a recruited partner makes a sale: the recruited partner earns 30%, you (the main partner) earn 20% as override, and Executor Hub earns 50%.
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

                                <!-- SECTION 6: Owner Earnings -->
                                <div class="total-section" id="ownerIncome" style="display: none;">
                                    <h2><span class="section-number">6</span> Executor Hub Earnings</h2>
                                    <div class="total-grid">
                                        <div class="total-item">
                                            <h3>EXECUTOR HUB MONTHLY INCOME</h3>
                                            <div class="value" id="ownerMonthlyTotal">£0.00</div>
                                        </div>
                                        <div class="total-item">
                                            <h3>EXECUTOR HUB ANNUAL INCOME</h3>
                                            <div class="value" id="ownerAnnualTotal">£0.00</div>
                                        </div>
                                    </div>
                                    <div class="owner-info-note">
                                        <strong>Breakdown:</strong><br>
                                        • Executor Hub earns 70% from partner's direct sales (Partner gets 30%)<br>
                                        • Executor Hub earns 50% from recruited partners' sales (Recruited partner gets 30%, Main partner gets 20% as override)
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
        const OVERRIDE_COMMISSION = 0.20; // Main partner gets 20% override from recruited partners' sales
        const RECRUITED_PARTNER_COMMISSION = 0.30; // Recruited partner gets 30% from their own sales
        const OWNER_DIRECT_RATE = 0.70; // Owner gets 70% from partner's direct sales
        const OWNER_TEAM_RATE = 0.50; // Owner gets 50% from team sales (recruited partner gets 30%, main partner gets 20% override)

        let christmasEnabled = false;
        let vatEnabled = false;

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
            document.getElementById('ownerIncome').style.display = 'block';
            document.getElementById('ownerIncome').scrollIntoView({ behavior: 'smooth' });
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
            document.getElementById('pricePaid').textContent = `£${totalPrice.toFixed(2)}`;
            document.getElementById('valueReceived').textContent = `£${valueReceived.toFixed(2)}`;
            document.getElementById('savings').textContent = `£${savings.toFixed(2)}`;
            document.getElementById('vatAmount').textContent = `£${vatAmount.toFixed(2)}`;

            // Calculate Section 3: Partner Earnings (commission on price before VAT)
            const commissionBase = priceBeforeVAT;
            const commissionPerSale = commissionBase * PARTNER_COMMISSION;
            const monthlyEarnings = commissionPerSale * salesPerMonth;
            const annualEarnings = monthlyEarnings * 12;

            document.getElementById('commissionPerSale').textContent = `£${commissionPerSale.toFixed(2)}`;
            document.getElementById('monthlyEarnings').textContent = `£${monthlyEarnings.toFixed(2)}`;
            document.getElementById('annualEarnings').textContent = `£${annualEarnings.toFixed(2)}`;

            // Calculate Section 4: Override Earnings
            const overridePerSale = commissionBase * OVERRIDE_COMMISSION;
            const totalTeamSales = recruitedPartners * avgSalesPerPartner;
            const monthlyOverride = overridePerSale * totalTeamSales;
            const annualOverride = monthlyOverride * 12;

            document.getElementById('overridePerSale').textContent = `£${overridePerSale.toFixed(2)}`;
            document.getElementById('monthlyOverride').textContent = `£${monthlyOverride.toFixed(2)}`;
            document.getElementById('annualOverride').textContent = `£${annualOverride.toFixed(2)}`;

            // Calculate Section 5: Total Partner Income
            const monthlyTotal = monthlyEarnings + monthlyOverride;
            const annualTotal = annualEarnings + annualOverride;

            document.getElementById('monthlyTotal').textContent = `£${monthlyTotal.toFixed(2)}`;
            document.getElementById('annualTotal').textContent = `£${annualTotal.toFixed(2)}`;

            // Calculate Section 6: Owner Earnings
            // Owner gets 70% from partner's direct sales
            const ownerDirectEarnings = (commissionBase * OWNER_DIRECT_RATE) * salesPerMonth;
            
            // Owner gets 50% from team sales (recruited partner gets 30%, main partner gets 20% as override)
            const ownerTeamEarnings = (commissionBase * OWNER_TEAM_RATE) * totalTeamSales;
            
            const ownerMonthlyTotal = ownerDirectEarnings + ownerTeamEarnings;
            const ownerAnnualTotal = ownerMonthlyTotal * 12;

            document.getElementById('ownerMonthlyTotal').textContent = `£${ownerMonthlyTotal.toFixed(2)}`;
            document.getElementById('ownerAnnualTotal').textContent = `£${ownerAnnualTotal.toFixed(2)}`;
        }

        // Initial calculation
        calculate();
    </script>
@endsection