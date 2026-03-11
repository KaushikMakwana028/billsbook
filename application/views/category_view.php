<div class="page-wrapper">
    <div class="page-content">
        <style>
            .category-shell {
                width: 100%;
                max-width: 1080px;
            }

            .category-card {
                border: 1px solid #e2e8f0;
                box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
                overflow: hidden;
            }

            .category-form-card {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
            }

            .category-title {
                font-size: 1.9rem;
                font-weight: 700;
                color: #0f172a;
            }

            .category-copy {
                color: #64748b;
                max-width: 560px;
            }

            .category-hero {
                border: 1px solid #dbe7f5;
                border-radius: 28px;
                background: linear-gradient(135deg, #eff6ff 0%, #ffffff 58%, #ecfeff 100%);
                padding: 1.5rem;
            }

            .category-field label {
                font-weight: 600;
                color: #334155;
                margin-bottom: 0.45rem;
            }

            .category-field .form-control {
                min-height: 54px;
                border-radius: 14px;
                border-color: #dbe3ef;
            }

            .category-field .form-control:focus {
                border-color: #60a5fa;
                box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.18);
            }

            .category-chip {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.45rem 0.8rem;
                border-radius: 999px;
                background: #eff6ff;
                color: #2563eb;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .category-table thead th {
                font-size: 0.82rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #64748b;
                border-bottom-width: 1px;
            }

            .category-table tbody td {
                vertical-align: middle;
            }

            .category-name {
                font-weight: 700;
                color: #0f172a;
            }

            .category-meta {
                color: #64748b;
                font-size: 0.88rem;
            }

            .category-empty {
                padding: 2rem;
                text-align: center;
                color: #64748b;
            }

            .category-row-title {
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 0;
            }

            .category-table tbody tr:hover {
                background: #f8fbff;
            }

            .category-action-group {
                display: inline-flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                justify-content: flex-end;
            }

            .category-stat {
                min-height: 126px;
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            }

            .category-stat-value {
                font-size: 2rem;
                font-weight: 800;
                color: #0f172a;
                line-height: 1;
            }

            .category-stat-label {
                color: #64748b;
                font-weight: 600;
            }

            @media (max-width: 991.98px) {
                .category-shell {
                    max-width: 100%;
                }
            }

            @media (max-width: 767.98px) {
                .category-hero {
                    padding: 1.1rem;
                    border-radius: 22px;
                }

                .category-title {
                    font-size: 1.55rem;
                }

                .category-table thead th {
                    font-size: 0.74rem;
                }

                .category-action-group {
                    width: 100%;
                    justify-content: flex-start;
                }
            }
        </style>

        <div class="category-shell mx-auto">
            <div class="category-hero mb-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <div class="category-chip mb-3">
                            <i class='bx bx-user-pin'></i>
                            <span>Admin: <?= htmlspecialchars($adminName ?? 'Admin') ?></span>
                        </div>
                        <div class="category-title mb-2">Category Manager</div>
                        <p class="category-copy mb-0">Create, update, and organize your product categories from one clean screen.</p>
                    </div>
                    <div class="category-chip">
                        <i class='bx bx-collection'></i>
                        <span><?= count($categories) ?> Active</span>
                    </div>
                </div>
            </div>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="card rounded-4 category-card category-form-card h-100">
                    <div class="card-body p-4 p-xl-5">
                        <div class="category-title mb-2"><?= !empty($editCategory) ? 'Edit Category' : 'Add Category' ?></div>
                        <p class="category-copy mb-4">Categories are linked to the logged-in admin account only.</p>

                        <form method="post" action="<?= !empty($editCategory) ? base_url('category/update/' . (int) $editCategory['id']) : base_url('category/store') ?>">
                            <div class="category-field mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" value="<?= set_value('name', $editCategory['name'] ?? '') ?>" class="form-control" placeholder="Enter category name">
                                <?= form_error('name') ?>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary px-4"><?= !empty($editCategory) ? 'Update Category' : 'Add Category' ?></button>
                                <?php if (!empty($editCategory)): ?>
                                    <a href="<?= base_url('category') ?>" class="btn btn-outline-secondary px-4">Cancel</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="row g-4 mb-1">
                    <div class="col-12 col-md-6">
                        <div class="card rounded-4 category-card category-stat">
                            <div class="card-body p-4">
                                <div class="category-stat-value"><?= count($categories) ?></div>
                                <p class="category-stat-label mb-0 mt-2">Total Active Categories</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card rounded-4 category-card category-stat">
                            <div class="card-body p-4">
                                <div class="category-stat-value"><?= !empty($editCategory) ? 'Edit' : 'Ready' ?></div>
                                <p class="category-stat-label mb-0 mt-2"><?= !empty($editCategory) ? 'You are updating an existing category' : 'Create a new category from the form' ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-4 category-card">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                            <div>
                                <h3 class="mb-1">Your Categories</h3>
                                <p class="text-muted mb-0">Manage your category list with quick edit and delete actions.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle category-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Created On</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $index => $category): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <div class="category-row-title"><?= htmlspecialchars($category['name']) ?></div>
                                                </td>
                                                <td><?= htmlspecialchars($category['created_on']) ?></td>
                                                <td class="text-end">
                                                    <div class="category-action-group">
                                                        <a href="<?= base_url('category/edit/' . (int) $category['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                        <a href="<?= base_url('category/delete/' . (int) $category['id']) ?>" class="btn btn-sm btn-outline-danger js-swal-delete" data-swal-title="Delete category?" data-swal-text="This category will be removed from your active list.">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="category-empty text-danger fw-bold">No categories found for this admin yet.</td>
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
</div>
