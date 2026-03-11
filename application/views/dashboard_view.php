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
