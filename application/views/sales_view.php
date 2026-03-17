<div class="page-wrapper">
    <div class="page-content">
        <style>
            /* ── Base ── */
            .sales-shell {
                max-width: 1280px;
                margin: 0 auto;
            }

            .sales-card {
                border: none;
                border-radius: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04),
                    0 20px 50px -12px rgba(15, 23, 42, 0.1);
                background: #ffffff;
                overflow: hidden;
            }

            .sales-card .card-body {
                padding: 2rem 2.25rem !important;
            }

            /* ── Header ── */
            .sales-header {
                position: relative;
                padding-bottom: 1.5rem;
                margin-bottom: 1.5rem;
                border-bottom: 1px solid #f1f5f9;
            }

            .sales-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.4rem 0.9rem;
                border-radius: 999px;
                background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%);
                color: #2563eb;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.03em;
                text-transform: uppercase;
            }

            .sales-header h3 {
                font-size: 1.55rem;
                font-weight: 800;
                color: #0f172a;
                letter-spacing: -0.02em;
            }

            .sales-header p {
                color: #64748b;
                font-size: 0.92rem;
            }

            .sales-header p code {
                background: #f1f5f9;
                padding: 0.15em 0.45em;
                border-radius: 6px;
                font-size: 0.85em;
                color: #6366f1;
                font-weight: 600;
            }

            .btn-create-sale {
                background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
                border: none;
                color: #fff;
                padding: 0.6rem 1.5rem;
                border-radius: 14px;
                font-weight: 600;
                font-size: 0.92rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.25s ease;
                box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            }

            .btn-create-sale:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(37, 99, 235, 0.35);
                background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
                color: #fff;
            }

            /* ── Alerts ── */
            .sales-alert {
                border: none;
                border-radius: 16px;
                padding: 0.85rem 1.15rem;
                font-size: 0.9rem;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.6rem;
            }

            .sales-alert-success {
                background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
                color: #15803d;
                border-left: 4px solid #22c55e;
            }

            .sales-alert-danger {
                background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
                color: #dc2626;
                border-left: 4px solid #ef4444;
            }

            /* ── Post-save banner ── */
            .sales-post-save {
                border: 1px solid #bfdbfe;
                background: linear-gradient(135deg, #eff6ff 0%, #ffffff 50%, #f0fdf4 100%);
                border-radius: 18px;
                padding: 1.15rem 1.35rem;
                margin-bottom: 1.25rem;
                position: relative;
                overflow: hidden;
            }

            .sales-post-save::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, #2563eb, #22c55e);
                border-radius: 4px 0 0 4px;
            }

            .sales-post-save h5 {
                font-weight: 700;
                font-size: 1rem;
                color: #1e293b;
            }

            .sales-post-save p {
                font-size: 0.88rem;
            }

            /* ── Filter card ── */
            .sales-filter-card {
                border: 1px solid #e2e8f0;
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                border-radius: 18px;
                padding: 1rem 1.25rem;
                margin-bottom: 1.25rem;
            }

            .sales-filter-card .form-label {
                font-size: 0.78rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: #475569;
                margin-bottom: 0.3rem;
            }

            .sales-filter-card .form-control {
                border-radius: 12px;
                border: 1px solid #cbd5e1;
                padding: 0.5rem 0.85rem;
                font-size: 0.88rem;
                transition: all 0.2s ease;
                background: #fff;
            }

            .sales-filter-card .form-control:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
            }

            .btn-filter {
                background: #2563eb;
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                font-size: 0.88rem;
                transition: all 0.2s ease;
            }

            .btn-filter:hover {
                background: #1d4ed8;
                color: #fff;
                transform: translateY(-1px);
            }

            .btn-filter-reset {
                background: transparent;
                color: #64748b;
                border: 1px solid #cbd5e1;
                border-radius: 12px;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                font-size: 0.88rem;
                transition: all 0.2s ease;
            }

            .btn-filter-reset:hover {
                background: #f1f5f9;
                color: #334155;
                border-color: #94a3b8;
            }

            .btn-export {
                background: linear-gradient(135deg, #059669 0%, #10b981 100%);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                font-size: 0.88rem;
                transition: all 0.2s ease;
                box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
            }

            .btn-export:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
                color: #fff;
            }

            /* ── Table ── */
            .sales-table-wrap {
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
            }

            .sales-table {
                margin-bottom: 0;
            }

            .sales-table thead {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            }

            .sales-table thead th {
                font-weight: 700;
                font-size: 0.76rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #475569;
                padding: 0.85rem 1rem !important;
                border-bottom: 2px solid #e2e8f0;
                white-space: nowrap;
            }

            .sales-table tbody td {
                padding: 0.75rem 1rem !important;
                font-size: 0.88rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
            }

            .sales-table tbody tr {
                transition: all 0.15s ease;
            }

            .sales-table tbody tr:hover {
                background: #f8fafc;
            }

            .sales-table tbody tr:last-child td {
                border-bottom: none;
            }

            /* Row number badge */
            .row-num {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 28px;
                height: 28px;
                border-radius: 10px;
                background: #f1f5f9;
                color: #64748b;
                font-weight: 700;
                font-size: 0.78rem;
            }

            /* Customer cell */
            .customer-name {
                font-weight: 600;
                color: #1e293b;
            }

            .customer-walkin {
                color: #94a3b8;
                font-style: italic;
                font-weight: 500;
            }

            /* Phone cell */
            .phone-cell {
                font-family: 'SF Mono', 'Fira Code', monospace;
                font-size: 0.84rem;
                color: #475569;
            }

            /* Address cell */
            .address-cell {
                max-width: 180px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                color: #64748b;
                font-size: 0.85rem;
            }

            /* Total badge */
            .sales-total-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.2rem;
                padding: 0.3rem 0.7rem;
                border-radius: 10px;
                background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
                color: #15803d;
                font-weight: 700;
                font-size: 0.85rem;
                white-space: nowrap;
            }

            /* Action buttons */
            .btn-action-download {
                display: inline-flex;
                align-items: center;
                gap: 0.3rem;
                padding: 0.35rem 0.75rem;
                border-radius: 10px;
                font-size: 0.8rem;
                font-weight: 600;
                border: 1px solid #bfdbfe;
                background: #eff6ff;
                color: #2563eb;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .btn-action-download:hover {
                background: #2563eb;
                color: #fff;
                border-color: #2563eb;
                transform: translateY(-1px);
                box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);
            }

            .btn-action-whatsapp {
                display: inline-flex;
                align-items: center;
                gap: 0.3rem;
                padding: 0.35rem 0.75rem;
                border-radius: 10px;
                font-size: 0.8rem;
                font-weight: 600;
                border: 1px solid #bbf7d0;
                background: #f0fdf4;
                color: #16a34a;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .btn-action-whatsapp:hover {
                background: #16a34a;
                color: #fff;
                border-color: #16a34a;
                transform: translateY(-1px);
                box-shadow: 0 3px 10px rgba(22, 163, 74, 0.25);
            }

            /* Empty state */
            .sales-empty-state {
                padding: 3rem 2rem;
                text-align: center;
            }

            .sales-empty-icon {
                width: 72px;
                height: 72px;
                border-radius: 20px;
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }

            .sales-empty-icon i {
                font-size: 1.8rem;
                color: #94a3b8;
            }

            .sales-empty-state h6 {
                font-weight: 700;
                color: #475569;
                margin-bottom: 0.3rem;
            }

            .sales-empty-state p {
                color: #94a3b8;
                font-size: 0.9rem;
            }

            /* ── Stats row (top of table) ── */
            .sales-stats {
                display: flex;
                gap: 0.75rem;
                margin-bottom: 1.25rem;
                flex-wrap: wrap;
            }

            .sales-stat-chip {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.45rem 0.95rem;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                font-size: 0.84rem;
                color: #475569;
                font-weight: 500;
            }

            .sales-stat-chip strong {
                color: #0f172a;
                font-weight: 700;
            }

            .stat-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                display: inline-block;
            }

            .stat-dot-blue {
                background: #3b82f6;
            }

            .stat-dot-green {
                background: #22c55e;
            }

            /* ── Post-save action buttons ── */
            .btn-post-download {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.5rem 1.1rem;
                border-radius: 12px;
                font-size: 0.85rem;
                font-weight: 600;
                border: 1px solid #bfdbfe;
                background: #fff;
                color: #2563eb;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .btn-post-download:hover {
                background: #2563eb;
                color: #fff;
                border-color: #2563eb;
            }

            .btn-post-whatsapp {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.5rem 1.1rem;
                border-radius: 12px;
                font-size: 0.85rem;
                font-weight: 600;
                border: 1px solid #bbf7d0;
                background: #fff;
                color: #16a34a;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .btn-post-whatsapp:hover {
                background: #16a34a;
                color: #fff;
                border-color: #16a34a;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .sales-card .card-body {
                    padding: 1.25rem !important;
                }

                .sales-header h3 {
                    font-size: 1.25rem;
                }

                .sales-filter-card .row>div {
                    margin-bottom: 0.5rem;
                }
            }
        </style>

        <div class="row sales-shell">
            <div class="col-12">
                <div class="card sales-card">
                    <div class="card-body">

                        <!-- ── Header ── -->
                        <div class="sales-header d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <div class="sales-kicker mb-2">
                                    <i class='bx bx-receipt'></i>
                                    <span>Sales</span>
                                </div>
                                <h3 class="mb-1">Saved Sales &amp; Invoices</h3>
                                <p class="mb-0">Every sale automatically generates an <code>Invoice</code>.</p>
                            </div>
                            <a href="<?= base_url('sales/add') ?>" class="btn-create-sale">
                                <i class='bx bx-plus'></i> Create Sale
                            </a>
                        </div>

                        <!-- ── Flash messages ── -->
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="sales-alert sales-alert-success mb-3">
                                <i class='bx bx-check-circle' style="font-size:1.2rem"></i>
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="sales-alert sales-alert-danger mb-3">
                                <i class='bx bx-error-circle' style="font-size:1.2rem"></i>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- ── WhatsApp auto-open ── -->
                        <?php $latestSaleActions = $this->session->flashdata('latest_sale_actions'); ?>
                        <?php if (!empty($latestSaleActions['whatsapp_url'])): ?>
                            <script>
                                window.onload = function() {
                                    window.open("<?= $latestSaleActions['whatsapp_url'] ?>", "_blank");
                                };
                            </script>
                        <?php endif; ?>

                        <!-- ── Post-save banner ── -->
                        <?php if (!empty($latestSaleActions)): ?>
                            <div class="sales-post-save">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <div>
                                        <h5><i class='bx bx-check-shield' style="color:#22c55e;margin-right:0.3rem"></i> Latest Sale Ready</h5>
                                        <p class="text-muted mb-0">
                                            Invoice <strong><?= htmlspecialchars($latestSaleActions['invoice_number'] ?? '') ?></strong>
                                            for <strong><?= htmlspecialchars(($latestSaleActions['customer_name'] ?? '') !== '' ? $latestSaleActions['customer_name'] : 'Customer') ?></strong>
                                            is saved.
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="<?= base_url('sales/download/' . (int) ($latestSaleActions['sale_id'] ?? 0)) ?>" class="btn-post-download">
                                            <i class="fa-solid fa-download"></i> Download Invoice
                                        </a>
                                        <a href="<?= htmlspecialchars($latestSaleActions['whatsapp_url'] ?? '#') ?>" target="_blank" rel="noopener" class="btn-post-whatsapp">
                                            <i class="fa-brands fa-whatsapp"></i> Send WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- ── Filter bar ── -->
                        <form method="get" action="<?= base_url('sales') ?>" class="sales-filter-card">
                            <div class="row g-2 align-items-end">
                                <div class="col-lg-4">
                                    <label class="form-label">Search</label>
                                    <input type="text" name="search"
                                        value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                                        class="form-control"
                                        placeholder="Invoice, customer, phone, email…">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label">From</label>
                                    <input type="date" name="date_from"
                                        value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>"
                                        class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label">To</label>
                                    <input type="date" name="date_to"
                                        value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>"
                                        class="form-control">
                                </div>
                                <div class="col-lg-4 d-flex gap-2 flex-wrap">
                                    <button type="submit" class="btn-filter">
                                        <i class='bx bx-search' style="font-size:1rem;vertical-align:middle"></i> Filter
                                    </button>
                                    <a href="<?= base_url('sales') ?>" class="btn-filter-reset">
                                        Reset
                                    </a>
                                    <a href="<?= base_url('sales/export?date_from=' . ($filters['date_from'] ?? '') . '&date_to=' . ($filters['date_to'] ?? '')) ?>"
                                        class="btn-export">
                                        <i class="fa fa-file-excel"></i> Export
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- ── Stats chips ── -->
                        <?php if (!empty($sales)): ?>
                            <div class="sales-stats">
                                <div class="sales-stat-chip">
                                    <span class="stat-dot stat-dot-blue"></span>
                                    Total Records: <strong><?= count($sales) ?></strong>
                                </div>
                                <div class="sales-stat-chip">
                                    <span class="stat-dot stat-dot-green"></span>
                                    Total Revenue: <strong>Rs. <?= number_format(array_sum(array_column($sales, 'grand_total')), 2) ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- ── Table ── -->
                        <div class="sales-table-wrap">
                            <table class="table sales-table">
                                <thead>
                                    <tr>
                                        <th style="width:50px">#</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($sales)): ?>
                                        <?php foreach ($sales as $index => $sale): ?>
                                            <tr>
                                                <td><span class="row-num"><?= $index + 1 ?></span></td>

                                                <td>
                                                    <?php if (!empty($sale['customer_name'])): ?>
                                                        <span class="customer-name"><?= htmlspecialchars($sale['customer_name']) ?></span>
                                                    <?php else: ?>
                                                        <span class="customer-walkin">Walk-in Customer</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <span class="phone-cell"><?= htmlspecialchars($sale['customer_phone'] ?? '-') ?></span>
                                                </td>

                                                <td>
                                                    <span class="address-cell" title="<?= htmlspecialchars($sale['customer_address'] ?: '-') ?>">
                                                        <?= htmlspecialchars($sale['customer_address'] ?: '-') ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="sales-total-badge">
                                                        Rs.&nbsp;<?= number_format((float) $sale['grand_total'], 2) ?>
                                                    </span>
                                                </td>

                                                <td class="text-end">
                                                    <?php if (!empty($sale['invoice_file'])): ?>
                                                        <a href="<?= base_url('sales/download/' . (int) $sale['id']) ?>"
                                                            class="btn-action-download"
                                                            title="Download Invoice">
                                                            <i class="fa-solid fa-download"></i> Download
                                                        </a>
                                                        <a href="<?= htmlspecialchars($sale['whatsapp_url'] ?? '#') ?>"
                                                            target="_blank"
                                                            class="btn-action-whatsapp"
                                                            title="Send WhatsApp">
                                                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size:0.82rem;font-style:italic">No invoice</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">
                                                <div class="sales-empty-state">
                                                    <div class="sales-empty-icon">
                                                        <i class='bx bx-receipt'></i>
                                                    </div>
                                                    <h6>No sales found</h6>
                                                    <p class="mb-0">Create your first sale to see it here.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>