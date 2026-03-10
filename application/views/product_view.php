<div class="page-wrapper">
    <div class="page-content">
        <style>
            .product-shell {
                max-width: 1200px;
            }

            .product-card {
                border: 1px solid #e2e8f0;
                box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
            }

            .product-kicker {
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

            .product-thumb {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                object-fit: cover;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .product-name {
                font-weight: 700;
                color: #0f172a;
            }

            .product-meta {
                color: #64748b;
                font-size: 0.88rem;
                max-width: 340px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .product-price {
                font-weight: 700;
                color: #16a34a;
            }

            .product-empty {
                padding: 2.5rem;
                text-align: center;
                color: #64748b;
            }
        </style>

        <div class="row product-shell">
            <div class="col-12">
                <div class="card rounded-4 product-card">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                            <div>
                                <div class="product-kicker mb-3">
                                    <i class='bx bx-box'></i>
                                    <span>Products</span>
                                </div>
                                <h3 class="mb-1">Your Product List</h3>
                                <!-- <p class="text-muted mb-0">Only products created by the logged-in admin are shown here.</p> -->
                            </div>
                            <a href="<?= base_url('product/add') ?>" class="btn btn-primary px-4">Add Product</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Created On</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $index => $product): ?>
                                            <?php $imageSource = !empty($product['image']) ? base_url('uploads/product/' . ltrim($product['image'], '/')) : base_url('assets/images/Default.jpg'); ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="<?= htmlspecialchars($imageSource) ?>" class="product-thumb" alt="Product image" onerror="this.src='<?= base_url('assets/images/Default.jpg') ?>'">
                                                        <div>
                                                            <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                                                            <div class="product-meta"><?= htmlspecialchars($product['description'] !== '' ? $product['description'] : 'No description added') ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?></td>
                                                <td class="product-price">Rs. <?= number_format((float) $product['price'], 2) ?></td>
                                                <td><?= htmlspecialchars($product['created_on']) ?></td>
                                                <td class="text-end">
                                                    <a href="<?= base_url('product/edit/' . (int) $product['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                    <a href="<?= base_url('product/delete/' . (int) $product['id']) ?>" class="btn btn-sm btn-outline-danger js-swal-delete" data-swal-title="Delete product?" data-swal-text="This product will be removed from your active list.">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="product-empty text-danger fw-bold">No products found for this admin yet.</td>
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