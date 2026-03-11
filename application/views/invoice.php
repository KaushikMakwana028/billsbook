<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice — Bills Book</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0d0d12;
            --ink-soft: #3a3a4a;
            --ink-muted: #8888a0;
            --rule: #e8e8f0;
            --accent: #c8a96e;
            --accent-light: #f7f0e3;
            --surface: #ffffff;
            --bg: #f4f3f0;
            --red: #c0392b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            background-image:
                radial-gradient(circle at 10% 10%, rgba(200, 169, 110, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 90% 90%, rgba(200, 169, 110, 0.04) 0%, transparent 50%);
            min-height: 100vh;
            padding: 48px 24px;
            color: var(--ink);
        }

        .invoice-wrap {
            max-width: 900px;
            margin: 0 auto;
            animation: rise 0.6s cubic-bezier(.22, .68, 0, 1.2) both;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── HEADER BAND ── */
        .invoice-header {
            background: var(--ink);
            border-radius: 24px 24px 0 0;
            padding: 40px 48px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 32px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
        }

        .invoice-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 40px,
                    rgba(255, 255, 255, 0.012) 40px,
                    rgba(255, 255, 255, 0.012) 41px);
        }

        .header-left {
            position: relative;
        }

        .brand-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 10px;
        }

        .brand-name span {
            color: var(--accent);
        }

        .invoice-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .invoice-meta .label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-muted);
        }

        .invoice-meta .value {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        .invoice-badge {
            position: relative;
            text-align: right;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(200, 169, 110, 0.18);
            border: 1px solid rgba(200, 169, 110, 0.35);
            color: var(--accent);
            padding: 7px 18px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .status-pill::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
        }

        .invoice-number-big {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.06em;
        }

        /* ── CUSTOMER + BODY ── */
        .invoice-body {
            background: var(--surface);
            padding: 0 48px 40px;
            border: 1px solid var(--rule);
            border-top: none;
        }

        /* Customer strip */
        .customer-strip {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0;
            border-bottom: 1px solid var(--rule);
        }

        .cstrip-cell {
            padding: 28px 0;
            padding-right: 32px;
        }

        .cstrip-cell:not(:last-child) {
            border-right: 1px solid var(--rule);
            margin-right: 32px;
        }

        .cstrip-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-muted);
            margin-bottom: 8px;
        }

        .cstrip-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.4;
        }

        .cstrip-sub {
            font-size: 12px;
            color: var(--ink-muted);
            margin-top: 3px;
            line-height: 1.5;
        }

        /* ── TABLE ── */
        .table-section {
            padding-top: 36px;
        }

        .section-eyebrow {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 2px solid var(--ink);
        }

        thead th {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-muted);
            padding: 0 12px 14px;
            text-align: left;
        }

        thead th:first-child {
            padding-left: 0;
        }

        thead th:last-child {
            text-align: right;
        }

        tbody tr {
            border-bottom: 1px solid var(--rule);
            transition: background 0.15s;
        }

        tbody tr:hover {
            background: var(--accent-light);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody td {
            padding: 18px 12px;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody td:first-child {
            padding-left: 0;
        }

        tbody td:last-child {
            text-align: right;
            font-family: 'DM Mono', monospace;
            font-weight: 500;
        }

        .row-num {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: var(--ink-muted);
            width: 24px;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid var(--rule);
            background: var(--bg);
            flex-shrink: 0;
        }

        .product-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--ink);
        }

        .product-sku {
            font-size: 11px;
            color: var(--ink-muted);
            font-family: 'DM Mono', monospace;
            margin-top: 2px;
        }

        .qty-badge {
            display: inline-block;
            background: var(--bg);
            border: 1px solid var(--rule);
            border-radius: 8px;
            padding: 4px 12px;
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            font-weight: 500;
        }

        .price-col {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
        }

        .discount-col {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            color: var(--red);
        }

        /* ── TOTALS + FOOTER ── */
        .bottom-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            margin-top: 36px;
            flex-wrap: wrap;
        }

        .notes-box {
            flex: 1;
            min-width: 220px;
        }

        .notes-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-muted);
            margin-bottom: 10px;
        }

        .notes-content {
            font-size: 13px;
            color: var(--ink-soft);
            line-height: 1.7;
            border-left: 3px solid var(--accent);
            padding-left: 14px;
        }

        .totals-card {
            background: var(--ink);
            border-radius: 20px;
            padding: 28px 32px;
            min-width: 280px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .totals-row:last-child {
            border-bottom: none;
            padding-top: 16px;
            margin-top: 4px;
        }

        .totals-row .t-label {
            color: rgba(255, 255, 255, 0.5);
            font-weight: 400;
        }

        .totals-row .t-value {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
        }

        .totals-row.grand .t-label {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }

        .totals-row.grand .t-value {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--accent);
        }

        .discount-val {
            color: #ff7c7c !important;
        }

        /* ── FOOTER STRIP ── */
        .invoice-footer {
            background: var(--ink);
            border-radius: 0 0 24px 24px;
            padding: 20px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 0.02em;
        }

        .footer-brand span {
            color: var(--accent);
        }

        .footer-tagline {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        @media (max-width: 640px) {
            body {
                padding: 16px;
            }

            .invoice-header,
            .invoice-body,
            .invoice-footer {
                padding-left: 24px;
                padding-right: 24px;
            }

            .customer-strip {
                grid-template-columns: 1fr;
            }

            .cstrip-cell:not(:last-child) {
                border-right: none;
                border-bottom: 1px solid var(--rule);
                margin-right: 0;
                padding-bottom: 20px;
            }

            .bottom-section {
                flex-direction: column;
            }

            .totals-card {
                width: 100%;
            }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .invoice-wrap {
                animation: none;
            }
        }
    </style>
</head>

<body>

    <?php
    $customerName = htmlspecialchars((string) (($customer['name'] ?? '') !== '' ? $customer['name'] : 'Walk-in Customer'));
    $customerPhone = htmlspecialchars((string) ($customer['phone'] ?? ''));
    $customerEmail = htmlspecialchars((string) ($customer['email'] ?? ''));
    $customerAddress = nl2br(htmlspecialchars((string) ($customer['address'] ?? '')));
    $saleDate = htmlspecialchars((string) ($totals['sale_date'] ?? ''));
    $invoiceNum = htmlspecialchars((string) ($invoiceNumber ?? ''));
    $notes = trim((string) ($totals['notes'] ?? ''));
    $biz = htmlspecialchars((string) ($businessName ?? 'Bills Book'));
    ?>

    <div class="invoice-wrap">

        <!-- HEADER -->
        <div class="invoice-header">
            <div class="header-left">
                <div class="brand-name"><?= $biz ?><span>.</span></div>
                <div class="invoice-meta">
                    <span class="label">Invoice No.</span>
                    <span class="value"><?= $invoiceNum ?></span>
                </div>
            </div>
            <div class="invoice-badge">
                <div><span class="status-pill">Tax Invoice</span></div>
                <div class="invoice-number-big">Date: <?= $saleDate ?></div>
            </div>
        </div>

        <!-- BODY -->
        <div class="invoice-body">

            <!-- Customer Strip -->
            <div class="customer-strip">
                <div class="cstrip-cell">
                    <div class="cstrip-label">Bill To</div>
                    <div class="cstrip-value"><?= $customerName ?></div>
                    <?php if ($customerAddress !== ''): ?>
                        <div class="cstrip-sub"><?= $customerAddress ?></div>
                    <?php endif; ?>
                </div>
                <div class="cstrip-cell">
                    <div class="cstrip-label">Contact</div>
                    <div class="cstrip-value"><?= $customerPhone !== '' ? $customerPhone : '—' ?></div>
                    <div class="cstrip-sub"><?= $customerEmail !== '' ? $customerEmail : '' ?></div>
                </div>
                <div class="cstrip-cell">
                    <div class="cstrip-label">Sale Date</div>
                    <div class="cstrip-value"><?= $saleDate ?></div>
                    <div class="cstrip-sub">Ref: <?= $invoiceNum ?></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-section">
                <div class="section-eyebrow">Line Items</div>
                <table>
                    <thead>
                        <tr>
                            <th style="width:28px">#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $index => $item): ?>
                            <?php
                            $product = $item['product'];
                            $imageSource = !empty($product['image'])
                                ? base_url('uploads/product/' . ltrim((string) $product['image'], '/'))
                                : base_url('assets/images/Product_Default.png');
                            ?>
                            <tr>
                                <td class="row-num"><?= $index + 1 ?></td>
                                <td>
                                    <div class="product-cell">
                                        <img class="product-thumb" src="<?= htmlspecialchars($imageSource) ?>" alt="">
                                        <div>
                                            <div class="product-name"><?= htmlspecialchars((string) ($product['name'] ?? '')) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="qty-badge"><?= (int) ($item['quantity'] ?? 0) ?></span></td>
                                <td class="price-col">Rs.&nbsp;<?= number_format((float) ($item['unit_price'] ?? 0), 2) ?></td>
                                <td class="discount-col">−&nbsp;Rs.&nbsp;<?= number_format((float) ($item['discount_amount'] ?? 0), 2) ?></td>
                                <td>Rs.&nbsp;<?= number_format((float) ($item['line_total'] ?? 0), 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bottom: notes + totals -->
            <div class="bottom-section">
                <div class="notes-box">
                    <div class="notes-label">Notes</div>
                    <div class="notes-content">
                        <?= $notes !== '' ? nl2br(htmlspecialchars($notes)) : 'No additional notes.' ?>
                    </div>
                </div>

                <div class="totals-card">
                    <div class="totals-row">
                        <span class="t-label">Subtotal</span>
                        <span class="t-value">Rs. <?= number_format((float) ($totals['subtotal'] ?? 0), 2) ?></span>
                    </div>
                    <div class="totals-row">
                        <span class="t-label">Item Discounts</span>
                        <span class="t-value discount-val">−&nbsp;Rs. <?= number_format((float) ($totals['line_discount_total'] ?? 0), 2) ?></span>
                    </div>
                    <div class="totals-row">
                        <span class="t-label">Sale Discount</span>
                        <span class="t-value discount-val">−&nbsp;Rs. <?= number_format((float) ($totals['sale_discount'] ?? 0), 2) ?></span>
                    </div>
                    <div class="totals-row grand">
                        <span class="t-label">Grand Total</span>
                        <span class="t-value">- Rs. <?= number_format((float) ($totals['grand_total'] ?? 0), 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="invoice-footer">
            <div class="footer-brand"><?= $biz ?><span>.</span></div>
            <div class="footer-tagline">Thank you for your business</div>
        </div>

    </div>
</body>

</html>