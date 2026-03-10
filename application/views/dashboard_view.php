<div class="page-wrapper">
    <div class="page-content">
        <style>
            .dashboard-shell { max-width: 1180px; }
            .dashboard-card { border: 1px solid #e2e8f0; box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08); }
            .dashboard-hero { background: linear-gradient(135deg, #eff6ff, #ffffff 58%, #ecfeff); }
            .dashboard-kicker { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.45rem 0.8rem; border-radius: 999px; background: #dbeafe; color: #1d4ed8; font-size: 0.85rem; font-weight: 600; }
            .dashboard-hero-title { font-size: 2.15rem; font-weight: 700; color: #0f172a; }
            .dashboard-hero-copy { color: #64748b; max-width: 620px; }
            .dashboard-stat-card { height: 100%; background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%); }
            .dashboard-stat-icon { width: 58px; height: 58px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; }
            .dashboard-stat-value { font-size: 2.4rem; font-weight: 700; color: #0f172a; line-height: 1; }
            .dashboard-stat-label { color: #64748b; font-weight: 600; }
            .dashboard-action-link { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.1rem; border: 1px solid #e2e8f0; border-radius: 16px; color: #1e293b; text-decoration: none; font-weight: 600; transition: all 0.2s ease; }
            .dashboard-action-link:hover { border-color: #bfdbfe; background: #eff6ff; color: #1d4ed8; }
        </style>

        <div class="row g-4 dashboard-shell">
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

            <div class="col-12 col-md-6">
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

            <div class="col-12 col-md-6">
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
                                <a href="<?= base_url('profile') ?>" class="dashboard-action-link">
                                    <span>Open Profile</span>
                                    <i class='bx bx-right-arrow-alt fs-4'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
