<div class="page-wrapper">
    <div class="page-content">
        <style>
            .sale-form-shell {
                width: 100%;
                max-width: 1080px;
            }

            .sale-card {
                border: 1px solid #e2e8f0;
                box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
                background: #fff;
                overflow: hidden;
            }

            .sale-header {
                border: 1px solid #dbe7f5;
                border-radius: 28px;
                background: linear-gradient(135deg, #eff6ff 0%, #ffffff 58%, #ecfeff 100%);
                padding: 1.6rem;
            }

            .sale-inline-note {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.4rem 0.7rem;
                border-radius: 999px;
                background: #e8fff2;
                color: #15803d;
                font-size: 0.82rem;
                font-weight: 700;
            }

            .sale-layout {
                display: grid;
                grid-template-columns: minmax(0, 1fr) 320px;
                gap: 1.5rem;
                align-items: start;
            }

            .sale-main {
                display: grid;
                gap: 1.25rem;
            }

            .sale-customer-grid {
                row-gap: 1rem;
            }

            .sale-aside {
                position: sticky;
                top: 92px;
                display: grid;
                gap: 1rem;
            }

            .sale-section,
            .sale-aside-card {
                border: 1px solid #e2e8f0;
                border-radius: 24px;
                padding: 1.35rem;
                background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
                overflow: hidden;
            }

            .sale-section h4,
            .sale-aside-title {
                font-size: 1.08rem;
                font-weight: 800;
                color: #0f172a;
                margin-bottom: 1rem;
            }

            .sale-field label {
                font-weight: 600;
                color: #334155;
                margin-bottom: 0.45rem;
            }

            .sale-field .form-control,
            .sale-field .form-select {
                min-height: 54px;
                border-radius: 14px;
                border-color: #dbe3ef;
                background: #fff;
            }

            .sale-status-box {
                min-height: 54px;
                display: flex;
                align-items: center;
                border: 1px solid #dbe3ef;
                border-radius: 14px;
                background: #fff;
                padding: 0 1rem;
                color: #475569;
            }

            .sale-items-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .sale-items-table td,
            .sale-items-table th {
                vertical-align: middle;
            }

            .sale-items-table thead th {
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #64748b;
                border-bottom-width: 1px;
            }

            .sale-items-table tbody td {
                padding-top: 0.9rem;
                padding-bottom: 0.9rem;
            }

            .sale-items-table .form-control,
            .sale-items-table .form-select {
                min-width: 84px;
            }

            .sale-product-preview {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                object-fit: cover;
                border: 1px solid #dbe4f0;
                background: #fff;
            }

            .sale-stock-badge {
                display: inline-flex;
                padding: 0.35rem 0.75rem;
                border-radius: 999px;
                background: #eff6ff;
                color: #1d4ed8;
                font-size: 0.8rem;
                font-weight: 700;
            }

            .sale-summary-card {
                border: 1px solid #dbe4f0;
                border-radius: 20px;
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
                padding: 1rem 1.25rem;
            }

            .sale-summary-row {
                display: flex;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.65rem 0;
                color: #334155;
                border-bottom: 1px dashed #e2e8f0;
            }

            .sale-summary-row:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .sale-summary-total strong {
                font-size: 1.15rem;
                color: #0f172a;
            }

            .sale-action-stack {
                display: grid;
                gap: 0.75rem;
            }

            .sale-action-stack .btn {
                width: 100%;
            }

            .sale-muted-box {
                border: 1px dashed #dbe4f0;
                border-radius: 16px;
                padding: 0.9rem 1rem;
                background: #f8fafc;
                color: #64748b;
                font-size: 0.92rem;
                line-height: 1.6;
            }

            @media (max-width: 1439.98px) {
                .sale-layout {
                    grid-template-columns: 1fr;
                }

                .sale-aside {
                    position: static;
                }

                .sale-customer-grid>.sale-field {
                    flex: 0 0 100%;
                    width: 100%;
                }
            }

            @media (max-width: 991.98px) {
                .sale-form-shell {
                    max-width: 100%;
                }

                .sale-header {
                    padding: 1.15rem;
                    border-radius: 22px;
                }

                .sale-layout {
                    grid-template-columns: 1fr;
                }

                .sale-aside {
                    position: static;
                }

                .sale-section,
                .sale-aside-card {
                    padding: 1.1rem;
                    border-radius: 20px;
                }

                .sale-items-toolbar {
                    align-items: stretch;
                }

                .sale-items-toolbar .btn {
                    width: 100%;
                }
            }

            @media (max-width: 767.98px) {
                .sale-header {
                    gap: 0.85rem !important;
                }

                .sale-header .btn {
                    width: 100%;
                }

                .sale-section h4,
                .sale-aside-title {
                    font-size: 1rem;
                }

                .sale-summary-card {
                    padding: 0.9rem 1rem;
                }

                .sale-summary-row {
                    font-size: 0.95rem;
                }

                .sale-items-table thead th {
                    font-size: 0.72rem;
                }

                .sale-items-table tbody td {
                    padding-top: 0.75rem;
                    padding-bottom: 0.75rem;
                }

                .sale-product-preview {
                    width: 42px;
                    height: 42px;
                }

                .sale-stock-badge {
                    padding: 0.3rem 0.6rem;
                    font-size: 0.75rem;
                }
            }
        </style>

        <div class="sale-form-shell mx-auto">
            <div class="card rounded-4 sale-card">
                <div class="card-body p-4 p-xl-5">
                    <div class="sale-header d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                        <div>
                            <h2 class="mb-2">Create Sale</h2>
                            <p class="text-muted mb-2">Enter customer details, add products, check totals, and save the invoice in one clean flow.</p>
                            <div class="sale-inline-note"><i class='bx bx-check-circle'></i> Customer phone auto-fills existing records</div>
                        </div>
                        <a href="<?= base_url('sales') ?>" class="btn btn-outline-secondary px-4">Back to Sales</a>
                    </div>

                    <?php if (!empty($saleError)): ?>
                        <div class="alert alert-danger"><?= $saleError ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('sales/store') ?>" id="saleForm">
                        <div class="sale-layout">
                            <div class="sale-main">
                                <div class="sale-section">
                                    <h4>Customer Details</h4>
                                    <div class="row g-3 sale-customer-grid">
                                        <div class="col-xl-6 col-12 sale-field">
                                            <label class="form-label">Customer Phone</label>
                                            <input type="text" name="customer_phone" id="customer_phone" value="<?= set_value('customer_phone') ?>" class="form-control" placeholder="Enter phone number">
                                            <?= form_error('customer_phone') ?>
                                            <small class="text-muted d-block mt-2" id="customerLookupMessage">If the customer already exists, details will fill automatically.</small>
                                        </div>
                                        <div class="col-xl-6 col-12 sale-field">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" name="customer_name" id="customer_name" value="<?= set_value('customer_name') ?>" class="form-control" placeholder="Enter customer name">
                                            <?= form_error('customer_name') ?>
                                        </div>
                                        <div class="col-xl-6 col-12 sale-field">
                                            <label class="form-label">Customer Email</label>
                                            <input type="email" name="customer_email" id="customer_email" value="<?= set_value('customer_email') ?>" class="form-control" placeholder="Enter email (optional)">
                                        </div>
                                        <div class="col-xl-6 col-12 sale-field">
                                            <label class="form-label">Sale Discount (%)</label>
                                            <input type="number" min="0" max="100" step="0.01" name="sale_discount" id="sale_discount" value="<?= set_value('sale_discount', '0') ?>" class="form-control" placeholder="0">
                                            <?= form_error('sale_discount') ?>
                                        </div>
                                        <div class="col-12 sale-field">
                                            <label class="form-label">Customer Address</label>
                                            <textarea name="customer_address" id="customer_address" class="form-control" style="min-height: 110px;" placeholder="Enter address (optional)"><?= set_value('customer_address') ?></textarea>
                                        </div>
                                        <div class="col-xl-6 col-12 sale-field">
                                            <label class="form-label">Status</label>
                                            <div class="sale-status-box">Auto-save with invoice generation</div>
                                        </div>
                                        <div class="col-12 sale-field">
                                            <label class="form-label">Notes</label>
                                            <textarea name="notes" class="form-control" style="min-height: 110px;" placeholder="Optional notes for invoice"><?= set_value('notes') ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="sale-section">
                                    <div class="sale-items-toolbar mb-3">
                                        <h4 class="mb-0">Sale Items</h4>
                                        <button type="button" class="btn btn-primary btn-sm" id="addSaleRow">Add Item</button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table sale-items-table align-middle" id="saleItemsTable">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 260px;">Product</th>
                                                    <th style="min-width: 110px;">Image</th>
                                                    <th style="min-width: 130px;">Stock</th>
                                                    <th style="min-width: 110px;">Price</th>
                                                    <th style="min-width: 100px;">Qty</th>
                                                    <th style="min-width: 120px;">Discount %</th>
                                                    <th style="min-width: 120px;">Total</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="sale-aside">
                                <div class="sale-aside-card">
                                    <div class="sale-aside-title">Bill Summary</div>
                                    <div class="sale-summary-card">
                                        <div class="sale-summary-row">
                                            <span>Subtotal</span>
                                            <strong id="saleSubtotal">Rs. 0.00</strong>
                                        </div>
                                        <div class="sale-summary-row">
                                            <span>Total Discount</span>
                                            <strong id="saleDiscountTotal">Rs. 0.00</strong>
                                        </div>
                                        <div class="sale-summary-row sale-summary-total">
                                            <span>Grand Total</span>
                                            <strong id="saleGrandTotal">Rs. 0.00</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="sale-aside-card">
                                    <div class="sale-aside-title">Actions</div>
                                    <div class="sale-action-stack">
                                        <button type="submit" class="btn btn-success px-4">Save Sale & Generate Invoice</button>
                                        <a href="<?= base_url('sales') ?>" class="btn btn-outline-secondary px-4">Cancel</a>
                                    </div>
                                </div>

                                <div class="sale-aside-card">
                                    <div class="sale-aside-title">How It Works</div>
                                    <div class="sale-muted-box">
                                        Enter the customer phone, choose products, add quantity and discount, then save. Stock reduces automatically and invoice sharing opens next.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var products = <?= json_encode($products, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        var tableBody = document.querySelector('#saleItemsTable tbody');
        var addRowButton = document.getElementById('addSaleRow');
        var customerPhoneInput = document.getElementById('customer_phone');
        var customerNameInput = document.getElementById('customer_name');
        var customerEmailInput = document.getElementById('customer_email');
        var customerAddressInput = document.getElementById('customer_address');
        var lookupMessage = document.getElementById('customerLookupMessage');
        var saleDiscountInput = document.getElementById('sale_discount');

        function formatCurrency(value) {
            return 'Rs. ' + Number(value || 0).toFixed(2);
        }

        function getProductById(productId) {
            for (var i = 0; i < products.length; i++) {
                if (String(products[i].id) === String(productId)) {
                    return products[i];
                }
            }

            return null;
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function createProductOptions() {
            var options = ['<option value="">Select product</option>'];
            products.forEach(function(product) {
                var label = product.name + ' (Stock: ' + product.quantity + ')';
                options.push('<option value="' + product.id + '">' + escapeHtml(label) + '</option>');
            });
            return options.join('');
        }

        function updateSummary() {
            var subtotal = 0;
            var discountTotal = 0;

            tableBody.querySelectorAll('tr').forEach(function(row) {
                var product = getProductById(row.querySelector('.sale-product-select').value);
                var qtyInput = row.querySelector('.sale-qty-input');
                var discountInput = row.querySelector('.sale-item-discount');
                var qty = Number(qtyInput.value || 0);
                var lineDiscountPercent = Number(discountInput.value || 0);
                var lineBase = 0;
                var lineDiscount = 0;
                var lineTotal = 0;

                if (product && qty > 0) {
                    lineBase = Number(product.price) * qty;
                    if (lineDiscountPercent > 100) {
                        lineDiscountPercent = 100;
                        discountInput.value = lineDiscountPercent.toFixed(2);
                    }
                    lineDiscount = (lineBase * lineDiscountPercent) / 100;
                    lineTotal = lineBase - lineDiscount;
                }

                subtotal += lineBase;
                discountTotal += lineDiscount;
                row.querySelector('.sale-line-total').textContent = formatCurrency(lineTotal);
            });

            var saleDiscountPercent = Number(saleDiscountInput.value || 0);
            var totalAfterItems = subtotal - discountTotal;
            if (saleDiscountPercent > 100) {
                saleDiscountPercent = 100;
                saleDiscountInput.value = saleDiscountPercent.toFixed(2);
            }
            var saleDiscount = (totalAfterItems * saleDiscountPercent) / 100;

            document.getElementById('saleSubtotal').textContent = formatCurrency(subtotal);
            document.getElementById('saleDiscountTotal').textContent = formatCurrency(discountTotal + saleDiscount);
            document.getElementById('saleGrandTotal').textContent = formatCurrency(totalAfterItems - saleDiscount);
        }

        function refreshRow(row) {
            var select = row.querySelector('.sale-product-select');
            var product = getProductById(select.value);
            var preview = row.querySelector('.sale-product-preview');
            var stockBadge = row.querySelector('.sale-stock-badge');
            var unitPrice = row.querySelector('.sale-unit-price');
            var qtyInput = row.querySelector('.sale-qty-input');

            if (!product) {
                preview.src = '<?= base_url('assets/images/Product_Default.png') ?>';
                stockBadge.textContent = 'No stock';
                unitPrice.textContent = formatCurrency(0);
                qtyInput.max = '';
                updateSummary();
                return;
            }

            preview.src = product.image_url;
            stockBadge.textContent = 'Stock: ' + product.quantity;
            unitPrice.textContent = formatCurrency(product.price);
            qtyInput.max = product.quantity;

            if (Number(qtyInput.value || 0) > Number(product.quantity)) {
                qtyInput.value = product.quantity;
            }

            updateSummary();
        }

        function addRow() {
            var row = document.createElement('tr');
            row.innerHTML = ''
                + '<td><select name="product_id[]" class="form-select sale-product-select">' + createProductOptions() + '</select></td>'
                + '<td><img src="<?= base_url('assets/images/Product_Default.png') ?>" class="sale-product-preview" alt="Preview"></td>'
                + '<td><span class="sale-stock-badge">No stock</span></td>'
                + '<td><div class="fw-semibold sale-unit-price">Rs. 0.00</div></td>'
                + '<td><input type="number" min="1" name="item_quantity[]" class="form-control sale-qty-input" value="1"></td>'
                + '<td><input type="number" min="0" max="100" step="0.01" name="item_discount[]" class="form-control sale-item-discount" value="0"></td>'
                + '<td><strong class="sale-line-total">Rs. 0.00</strong></td>'
                + '<td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger sale-remove-row">Remove</button></td>';

            tableBody.appendChild(row);

            row.querySelector('.sale-product-select').addEventListener('change', function() {
                refreshRow(row);
            });
            row.querySelector('.sale-qty-input').addEventListener('input', function() {
                refreshRow(row);
            });
            row.querySelector('.sale-item-discount').addEventListener('input', updateSummary);
            row.querySelector('.sale-remove-row').addEventListener('click', function() {
                row.remove();
                if (!tableBody.querySelector('tr')) {
                    addRow();
                }
                updateSummary();
            });

            refreshRow(row);
        }

        customerPhoneInput.addEventListener('input', function() {
            var phone = this.value.replace(/\D+/g, '');

            if (phone.length < 10) {
                lookupMessage.textContent = 'If the customer already exists, details will fill automatically.';
                return;
            }

            $.get(site_url + 'sales/customer-lookup', { phone: phone })
                .done(function(response) {
                    if (response && response.status === 'found' && response.customer) {
                        customerNameInput.value = response.customer.name || '';
                        customerEmailInput.value = response.customer.email || '';
                        customerAddressInput.value = response.customer.address || '';
                        lookupMessage.textContent = 'Existing customer found. Details filled automatically.';
                    } else {
                        lookupMessage.textContent = 'No existing customer found. A new customer will be created on save.';
                    }
                })
                .fail(function() {
                    lookupMessage.textContent = 'Customer lookup failed. You can still continue manually.';
                });
        });

        addRowButton.addEventListener('click', addRow);
        saleDiscountInput.addEventListener('input', updateSummary);

        addRow();
    });
</script>
