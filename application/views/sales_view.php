<div class="page-wrapper">
    <div class="page-content">
        <style>
            .sales-shell {
                max-width: 1250px;
            }

            .sales-card {
                border: 1px solid #e2e8f0;
                box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
            }

            .sales-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.45rem 0.85rem;
                border-radius: 999px;
                background: #eff6ff;
                color: #2563eb;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .sales-total {
                font-weight: 700;
                color: #16a34a;
            }

            .sales-empty {
                padding: 2.5rem;
                text-align: center;
                color: #64748b;
            }

            .sales-filter-card {
                border: 1px solid #e2e8f0;
                background: #f8fbff;
                border-radius: 22px;
                padding: 1rem;
                margin-bottom: 1.25rem;
            }

            .sales-post-save {
                border: 1px solid #dbe7f5;
                background: linear-gradient(135deg, #eff6ff 0%, #ffffff 65%, #ecfeff 100%);
                border-radius: 22px;
                padding: 1.1rem 1.25rem;
                margin-bottom: 1.25rem;
            }
        </style>

        <div class="row sales-shell">
            <div class="col-12">
                <div class="card rounded-4 sales-card">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                            <div>
                                <div class="sales-kicker mb-3">
                                    <i class='bx bx-receipt'></i>
                                    <span>Sales</span>
                                </div>
                                <h3 class="mb-1">Saved Sales & Invoices</h3>
                                <p class="text-muted mb-0">Every sale automatically generates an <code>Invoice</code>.</p>
                            </div>
                            <a href="<?= base_url('sales/add') ?>" class="btn btn-primary px-4">Create Sale</a>
                        </div>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>

                        <?php $latestSaleActions = $this->session->flashdata('latest_sale_actions'); ?>
                        <?php if (!empty($latestSaleActions['whatsapp_url'])): ?>

                            <script>
                                window.onload = function() {
                                    window.open("<?= $latestSaleActions['whatsapp_url'] ?>", "_blank");
                                };
                            </script>

                        <?php endif; ?>
                        <?php if (!empty($latestSaleActions)): ?>
                            <div class="sales-post-save">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <div>
                                        <h5 class="mb-1">Latest Sale Ready</h5>
                                        <p class="text-muted mb-0">
                                            Invoice <?= htmlspecialchars($latestSaleActions['invoice_number'] ?? '') ?>
                                            for <?= htmlspecialchars(($latestSaleActions['customer_name'] ?? '') !== '' ? $latestSaleActions['customer_name'] : 'Customer') ?>
                                            is saved.
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="<?= base_url('sales/download/' . (int) ($latestSaleActions['sale_id'] ?? 0)) ?>" class="btn btn-outline-primary">Download Invoice</a>
                                        <a href="<?= htmlspecialchars($latestSaleActions['whatsapp_url'] ?? '#') ?>" target="_blank" rel="noopener" class="btn btn-outline-success">Send WhatsApp</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form method="get" action="<?= base_url('sales') ?>" class="sales-filter-card">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-5">
                                    <label class="form-label fw-semibold">Search</label>
                                    <input type="text" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="form-control" placeholder="Search by invoice, customer, phone, email">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label fw-semibold">From</label>
                                    <input type="date" name="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label fw-semibold">To</label>
                                    <input type="date" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>" class="form-control">
                                </div>
                                <div class="col-lg-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                                    <a href="<?= base_url('sales') ?>" class="btn btn-outline-secondary px-4">Reset</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($sales)): ?>
                                        <?php foreach ($sales as $index => $sale): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($sale['invoice_number']) ?></td>
                                                <td><?= htmlspecialchars($sale['customer_name'] ?: 'Walk-in Customer') ?></td>
                                                <td><?= htmlspecialchars($sale['customer_phone'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($sale['customer_email'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($sale['customer_address'] ?: '-') ?></td>
                                                <td class="sales-total">Rs. <?= number_format((float) $sale['grand_total'], 2) ?></td>
                                                <td class="text-end">
                                                    <?php if (!empty($sale['invoice_file'])): ?>
                                                        <a href="<?= base_url('sales/download/' . (int) $sale['id']) ?>" class="btn btn-sm btn-outline-primary">Download Invoice</a>
                                                        <a href="<?= htmlspecialchars($sale['whatsapp_url'] ?? '#') ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-success">WhatsApp</a>
                                                    <?php else: ?>
                                                        <span class="text-muted small">No invoice file</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="sales-empty text-danger fw-bold">No sales saved yet.</td>
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