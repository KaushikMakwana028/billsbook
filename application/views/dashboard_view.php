<div class="page-wrapper">
    <div class="page-content">
        <style>
            .dashboard-shell {
                width: 100%;
                max-width: 1080px;
            }

            .dashboard-card {
                border: 1px solid #e2e8f0;
                box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
                overflow: hidden;
            }

            .dashboard-hero {
                background: linear-gradient(135deg, #eff6ff, #ffffff 58%, #ecfeff);
            }

            .dashboard-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.45rem 0.8rem;
                border-radius: 999px;
                background: #dbeafe;
                color: #1d4ed8;
                font-size: 0.85rem;
                font-weight: 600;
                max-width: 100%;
            }

            .dashboard-hero-title {
                font-size: 2.15rem;
                font-weight: 700;
                color: #0f172a;
            }

            .dashboard-hero-copy {
                color: #64748b;
                max-width: 620px;
            }

            .dashboard-stat-card {
                height: 100%;
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            }

            .dashboard-stat-icon {
                width: 58px;
                height: 58px;
                border-radius: 18px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                flex: 0 0 auto;
            }

            .dashboard-stat-value {
                font-size: 2.4rem;
                font-weight: 700;
                color: #0f172a;
                line-height: 1;
                word-break: break-word;
            }

            .dashboard-stat-label {
                color: #64748b;
                font-weight: 600;
            }

            .dashboard-action-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 0.75rem;
                padding: 1rem 1.1rem;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                color: #1e293b;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .dashboard-action-link:hover {
                border-color: #bfdbfe;
                background: #eff6ff;
                color: #1d4ed8;
            }

            .dashboard-list-card {
                height: 100%;
            }

            .dashboard-list-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
                padding: 0.9rem 0;
                border-bottom: 1px solid #edf2f7;
            }

            .dashboard-list-row:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .dashboard-mini-label {
                font-size: 0.82rem;
                color: #64748b;
            }

            .dashboard-stock-pill {
                display: inline-flex;
                align-items: center;
                padding: 0.28rem 0.7rem;
                border-radius: 999px;
                background: #fff7ed;
                color: #c2410c;
                font-size: 0.8rem;
                font-weight: 700;
                flex: 0 0 auto;
            }

            /* Privacy Mode Styles */
            .privacy-banner {
                position: sticky;
                top: var(--admin-topbar-height);
                z-index: 1020;
                width: 100%;
                margin-top: 0;
            }

            .privacy-overlay {
                position: fixed;
                top: var(--admin-topbar-height);
                left: var(--admin-sidebar-width);
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.97);
                backdrop-filter: blur(8px);
                z-index: 1049;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            body.sidebar-collapsed .privacy-overlay {
                left: var(--admin-sidebar-collapsed-width);
            }

            /* Privacy blur effect */
            body.privacy-mode-active .page-content {
                filter: blur(6px);
                pointer-events: none;
                user-select: none;
            }

            /* Center privacy message */
            .privacy-center-message {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
                text-align: center;
            }

            .privacy-box {
                background: rgba(0, 0, 0, 0.75);
                color: #fff;
                padding: 20px 28px;
                border-radius: 8px;
                font-size: 15px;
            }

            .privacy-eye {
                font-size: 50px;
                margin-bottom: 10px;
            }

            .privacy-overlay-content {
                text-align: center;
                padding: 2rem;
                max-width: 400px;
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            }

            #privacySwitch {
                cursor: pointer;
                width: 40px;
                height: 20px;
            }

            #privacySwitch:checked {
                background-color: #667eea;
                border-color: #667eea;
            }

            .dropdown-item#privacyModeToggle {
                cursor: default;
            }

            .dropdown-item#privacyModeToggle:hover {
                background-color: transparent;
            }

            /* Dark theme support */
            [data-bs-theme="dark"] .privacy-overlay {
                background: rgba(0, 0, 0, 0.95);
            }

            [data-bs-theme="dark"] .privacy-overlay-content {
                background: #1e293b;
                color: white;
            }

            [data-bs-theme="dark"] .privacy-overlay-content .text-muted {
                color: #94a3b8 !important;
            }


            /* Force hide any ApexCharts elements */
            .apexcharts-canvas,
            .apexcharts-inner,
            .apexcharts-legend,
            [class*="apexcharts"] {
                display: none !important;
            }

            /* Ensure Chart.js is visible */
            #salesChart {
                width: 100% !important;
                height: 350px !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                z-index: 1000 !important;
                position: relative !important;
                background: #ffffff !important;
            }

            .canvas-container {
                position: relative !important;
                width: 100% !important;
                height: 350px !important;
                background: #ffffff !important;
                z-index: 100 !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 8px !important;
                padding: 10px !important;
            }

            @media (max-width: 991.98px) {
                .privacy-overlay {
                    left: 0 !important;
                }
            }

            @media (max-width: 991.98px) {
                .dashboard-shell {
                    max-width: 100%;
                }

                .dashboard-hero-title {
                    font-size: 1.8rem;
                }
            }

            @media (max-width: 767.98px) {
                .dashboard-shell {
                    gap: 1rem !important;
                }

                .dashboard-hero-title {
                    font-size: 1.55rem;
                }

                .dashboard-kicker {
                    font-size: 0.78rem;
                }

                .dashboard-stat-value {
                    font-size: 1.9rem;
                }

                .dashboard-list-row {
                    flex-direction: column;
                    align-items: stretch;
                }

                .dashboard-action-link {
                    padding: 0.9rem 1rem;
                }
            }
        </style>

        <!-- Main Dashboard Content -->
        <div id="dashboardMainContent">
            <div class="row g-4 dashboard-shell mx-auto">
                <div class="col-12">
                    <div class="card rounded-4 dashboard-card dashboard-hero">
                        <div class="card-body p-4 p-xl-5">
                            <div class="dashboard-kicker mb-3">
                                <i class='bx bx-store-alt'></i>
                                <span><?= htmlspecialchars($businessName ?? 'Bills Book') ?></span>
                            </div>
                            <div class="dashboard-hero-title mb-2">Dashboard Overview</div>
                            <p class="dashboard-hero-copy mb-0">These counts only include categories and products created by the currently logged-in admin.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card rounded-4 dashboard-card dashboard-stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="dashboard-stat-icon bg-light-success text-success">
                                    <i class='bx bx-category'></i>
                                </div>
                                <a href="<?= base_url('category') ?>" class="text-decoration-none fw-semibold">Manage</a>
                            </div>
                            <div class="dashboard-stat-value"><?= (int) ($categoryCount ?? 0) ?></div>
                            <p class="dashboard-stat-label mb-0 mt-2">Active Categories</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card rounded-4 dashboard-card dashboard-stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="dashboard-stat-icon bg-light-primary text-primary">
                                    <i class='bx bx-box'></i>
                                </div>
                                <a href="<?= base_url('product') ?>" class="text-decoration-none fw-semibold">Manage</a>
                            </div>
                            <div class="dashboard-stat-value"><?= (int) ($productCount ?? 0) ?></div>
                            <p class="dashboard-stat-label mb-0 mt-2">Active Products</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card rounded-4 dashboard-card dashboard-stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="dashboard-stat-icon bg-light-warning text-warning">
                                    <i class='bx bx-user'></i>
                                </div>
                                <a href="<?= base_url('sales') ?>" class="text-decoration-none fw-semibold">View</a>
                            </div>
                            <div class="dashboard-stat-value"><?= (int) ($customerCount ?? 0) ?></div>
                            <p class="dashboard-stat-label mb-0 mt-2">Customers</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card rounded-4 dashboard-card dashboard-stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="dashboard-stat-icon bg-light-info text-info">
                                    <i class='bx bx-receipt'></i>
                                </div>
                                <a href="<?= base_url('sales') ?>" class="text-decoration-none fw-semibold">View</a>
                            </div>
                            <div class="dashboard-stat-value"><?= (int) ($salesCount ?? 0) ?></div>
                            <p class="dashboard-stat-label mb-0 mt-2">Sales</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card rounded-4 dashboard-card dashboard-stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="dashboard-stat-icon bg-light-danger text-danger">
                                    <i class='bx bx-error-circle'></i>
                                </div>
                                <a href="<?= base_url('product') ?>" class="text-decoration-none fw-semibold">Check</a>
                            </div>
                            <div class="dashboard-stat-value"><?= (int) ($lowStockCount ?? 0) ?></div>
                            <p class="dashboard-stat-label mb-0 mt-2">Low Stock</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card rounded-4 dashboard-card dashboard-stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="dashboard-stat-icon bg-light-primary text-primary">
                                    <i class='bx bx-wallet'></i>
                                </div>
                                <span class="text-muted fw-semibold">Revenue</span>
                            </div>
                            <div class="dashboard-stat-value" style="font-size:2rem;">Rs. <?= number_format((float) ($salesRevenue ?? 0), 2) ?></div>
                            <p class="dashboard-stat-label mb-0 mt-2">Total Sales Amount</p>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card rounded-4 dashboard-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                <div>
                                    <h4 class="mb-1">Sales Analytics</h4>
                                    <p class="text-muted mb-0">Sales performance overview</p>
                                </div>
                                <select id="salesFilter" class="form-select w-auto">
                                    <option value="day">Today</option>
                                    <option value="week" selected>Last 7 Days</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                            </div>

                            <!-- Canvas container with explicit dimensions -->
                            <div class="canvas-container" style="position: relative; width: 100%; height: 350px; background: #fff; border-radius: 8px; padding: 10px;">
                                <canvas id="salesChart" style="width: 100%; height: 100%; display: block;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card rounded-4 dashboard-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                <div>
                                    <h4 class="mb-1">Quick Actions</h4>
                                    <p class="text-muted mb-0">Shortcuts for the most common admin tasks.</p>
                                </div>
                                <div class="text-muted small">Admin: <?= htmlspecialchars($userName ?? 'Admin') ?></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <a href="<?= base_url('category') ?>" class="dashboard-action-link">
                                        <span>Open Categories</span>
                                        <i class='bx bx-right-arrow-alt fs-4'></i>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a href="<?= base_url('product') ?>" class="dashboard-action-link">
                                        <span>Open Products</span>
                                        <i class='bx bx-right-arrow-alt fs-4'></i>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a href="<?= base_url('sales') ?>" class="dashboard-action-link">
                                        <span>Open Sales</span>
                                        <i class='bx bx-right-arrow-alt fs-4'></i>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a href="<?= base_url('profile') ?>" class="dashboard-action-link">
                                        <span>Open Profile</span>
                                        <i class='bx bx-right-arrow-alt fs-4'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="card rounded-4 dashboard-card dashboard-list-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-1">Low Stock Products</h4>
                                    <p class="text-muted mb-0">Products with quantity 5 or below.</p>
                                </div>
                                <a href="<?= base_url('product') ?>" class="text-decoration-none fw-semibold">Manage</a>
                            </div>
                            <?php if (!empty($lowStockProducts)): ?>
                                <?php foreach ($lowStockProducts as $product): ?>
                                    <div class="dashboard-list-row">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($product['name']) ?></div>
                                            <div class="dashboard-mini-label">Rs. <?= number_format((float) ($product['price'] ?? 0), 2) ?></div>
                                        </div>
                                        <span class="dashboard-stock-pill"><?= (int) $product['quantity'] ?> left</span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-muted">No low stock products right now.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="card rounded-4 dashboard-card dashboard-list-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-1">Recent Sales</h4>
                                    <p class="text-muted mb-0">Latest saved invoices.</p>
                                </div>
                                <a href="<?= base_url('sales') ?>" class="text-decoration-none fw-semibold">View all</a>
                            </div>
                            <?php if (!empty($recentSales)): ?>
                                <?php foreach ($recentSales as $sale): ?>
                                    <div class="dashboard-list-row">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($sale['invoice_number']) ?></div>
                                            <div class="dashboard-mini-label"><?= htmlspecialchars($sale['customer_name'] ?: 'Walk-in Customer') ?> • <?= htmlspecialchars($sale['sale_date']) ?></div>
                                        </div>
                                        <div class="fw-bold text-success">Rs. <?= number_format((float) $sale['grand_total'], 2) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-muted">No sales added yet.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Mode Banner (Shown when enabled) -->
<div id="privacyBanner" class="privacy-banner" style="display: none;">
    <div class="container-fluid">
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-0 rounded-0 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="d-flex align-items-center">
                <i class='bx bxs-lock-alt fs-4 me-2'></i>
                <span><strong>Privacy Mode enabled.</strong> Please toggle the Privacy button to view your Dashboard.</span>
            </div>
            <button type="button" class="btn-close btn-close-white" id="closePrivacyBanner"></button>
        </div>
    </div>
</div>

<!-- Privacy Mode Overlay for Dashboard Content -->
<div id="privacyMessage" class="privacy-center-message" style="display:none;">
    <div class="privacy-eye">
        <i class='bx bx-show'></i>
    </div>

    <div class="privacy-box">
        Privacy Mode enabled.
        Please toggle the Privacy button to view your Dashboard.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Privacy Mode Script Loaded');

        const privacySwitch = document.getElementById('privacySwitch');
        privacySwitch.addEventListener("click", function(e) {
            e.stopPropagation();
        });
        const privacyBanner = document.getElementById('privacyBanner');
        const privacyOverlay = document.getElementById('privacyOverlay');
        const closeBannerBtn = document.getElementById('closePrivacyBanner');
        const quickToggleBtn = document.getElementById('quickTogglePrivacy');

        if (!privacySwitch) {
            console.error('Privacy switch not found! Make sure it exists in header.php');
            return;
        }

        console.log('Privacy switch found:', privacySwitch);

        // Get initial state from server (via PHP)
        const serverMode = <?= isset($privacyModeEnabled) && $privacyModeEnabled ? 'true' : 'false' ?> === true;
        console.log('Server mode:', serverMode);

        // Check localStorage for saved preference
        let privacyMode = localStorage.getItem('privacyMode');
        console.log('LocalStorage value:', privacyMode);

        if (privacyMode === null) {
            // No localStorage value, use server value
            privacyMode = serverMode;
        } else {
            // Convert string to boolean
            privacyMode = privacyMode === 'true';
        }

        console.log('Initial privacy mode:', privacyMode);

        // Set switch state
        privacySwitch.checked = privacyMode;

        // Update UI based on initial state
        updatePrivacyUI(privacyMode);

        // Toggle privacy mode
        privacySwitch.addEventListener('click', function(e) {
            e.stopPropagation();

            privacyMode = this.checked;

            console.log("Privacy toggle clicked:", privacyMode);

            localStorage.setItem('privacyMode', privacyMode ? 'true' : 'false');

            updatePrivacyUI(privacyMode);

            savePrivacyPreference(privacyMode);
        });

        // Close banner
        if (closeBannerBtn) {
            closeBannerBtn.addEventListener('click', function() {
                privacyBanner.style.display = 'none';
            });
        }

        // Quick toggle from overlay
        if (quickToggleBtn) {
            quickToggleBtn.addEventListener('click', function() {
                console.log('Quick toggle clicked');
                privacyMode = false;
                privacySwitch.checked = false;
                localStorage.setItem('privacyMode', false);
                updatePrivacyUI(false);
                savePrivacyPreference(false);
            });
        }

        // Prevent dropdown from closing when clicking on privacy toggle
        const privacyToggleItem = document.getElementById('privacyModeToggle');
        if (privacyToggleItem) {
            privacyToggleItem.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        }

        function updatePrivacyUI(enabled) {

            const message = document.getElementById("privacyMessage");

            if (enabled) {
                document.body.classList.add("privacy-mode-active");
                message.style.display = "block";
            } else {
                document.body.classList.remove("privacy-mode-active");
                message.style.display = "none";
            }
        }

        function savePrivacyPreference(enabled) {
            console.log('Saving preference to server:', enabled);

            // AJAX call to save preference to database
            fetch('<?= base_url("dashboard/save_privacy_preference") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        privacy_mode: enabled
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Server response:', data);
                    if (data.success) {
                        console.log('Privacy preference saved successfully');
                    } else {
                        console.error('Server error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error saving preference:', error);
                });
        }
    });
    // Completely disable any ApexCharts auto-initialization
    if (window.Apex) {
        window.Apex = undefined;
    }

    document.addEventListener('DOMContentLoaded', function() {
        'use strict';

        console.log('DOM loaded, initializing chart...');

        const canvas = document.getElementById('salesChart');
        const filterSelect = document.getElementById('salesFilter');

        if (!canvas || !filterSelect) {
            console.error('Chart elements not found');
            return;
        }

        // Prevent any other library from interfering
        canvas.style.display = 'block';
        canvas.style.visibility = 'visible';
        canvas.style.opacity = '1';

        let salesChart = null;

        // Force canvas dimensions
        function setupCanvas() {
            const container = canvas.parentElement;
            if (!container) return;

            // Get container dimensions
            const containerWidth = container.clientWidth || 800;
            const containerHeight = 350;

            // Set canvas dimensions
            canvas.style.width = containerWidth + 'px';
            canvas.style.height = containerHeight + 'px';
            canvas.width = containerWidth;
            canvas.height = containerHeight;

            console.log('Canvas dimensions:', canvas.width, 'x', canvas.height);
        }

        // Initial setup
        setupCanvas();

        function drawChart(data) {
            if (!data || !data.labels || !data.values) {
                console.error('Invalid data:', data);
                return;
            }

            console.log('Drawing chart with:', data);

            try {
                // Ensure canvas is ready
                setupCanvas();

                // Get context and clear
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Destroy existing chart
                if (salesChart) {
                    salesChart.destroy();
                    salesChart = null;
                }

                // Convert values to numbers
                const values = data.values.map(v => parseFloat(v) || 0);

                // Calculate if there's any data > 0
                const hasData = values.some(v => v > 0);

                if (!hasData) {
                    // Draw "No Data" message
                    ctx.font = 'bold 16px Arial';
                    ctx.fillStyle = '#64748b';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText('No sales data available', canvas.width / 2, canvas.height / 2);
                    return;
                }

                // Determine color
                const borderColor = '#3b82f6'; // Default blue
                const bgColor = borderColor + '20';

                // Create new chart with minimal configuration
                salesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Sales (Rs)',
                            data: values,
                            borderColor: borderColor,
                            backgroundColor: bgColor,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3,
                            pointRadius: 6,
                            pointHoverRadius: 10,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: borderColor,
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 800
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                enabled: true,
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rs ' + context.parsed.y.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rs ' + value;
                                    }
                                }
                            }
                        }
                    }
                });

                console.log('Chart created successfully');

            } catch (error) {
                console.error('Error drawing chart:', error);

                // Draw error on canvas
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.font = '14px Arial';
                ctx.fillStyle = '#ef4444';
                ctx.textAlign = 'center';
                ctx.fillText('Error: ' + error.message, canvas.width / 2, canvas.height / 2);
            }
        }

        function loadSalesChart(filter = 'week') {
            console.log('Loading filter:', filter);

            // Show loading
            canvas.style.opacity = '0.5';

            // Setup canvas before fetch
            setupCanvas();

            // Clear any existing content
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = '14px Arial';
            ctx.fillStyle = '#64748b';
            ctx.textAlign = 'center';
            ctx.fillText('Loading...', canvas.width / 2, canvas.height / 2);

            fetch("<?= base_url('dashboard/getSalesChart') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: "filter=" + encodeURIComponent(filter)
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('HTTP error ' + res.status);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Data received:', data);

                    // Validate data
                    if (!data.labels || !data.values) {
                        throw new Error('Invalid data format');
                    }

                    // Draw chart
                    drawChart(data);
                    canvas.style.opacity = '1';
                })
                .catch(err => {
                    console.error('Error:', err);
                    canvas.style.opacity = '1';

                    // Show error
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.font = '14px Arial';
                    ctx.fillStyle = '#ef4444';
                    ctx.textAlign = 'center';
                    ctx.fillText('Error loading data', canvas.width / 2, canvas.height / 2);
                });
        }

        // Handle filter change
        filterSelect.addEventListener('change', function() {
            loadSalesChart(this.value);
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (salesChart) {
                setupCanvas();
                salesChart.resize();
            }
        });

        // Initial load
        setTimeout(() => {
            loadSalesChart(filterSelect.value || 'week');
        }, 500);
    });
</script>