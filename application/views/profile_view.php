<div class="page-wrapper">
    <div class="page-content">
        <style>
            .profile-shell {
                max-width: 1180px;
            }

            .profile-card {
                border: 1px solid #e2e8f0;
                box-shadow: 0 22px 60px rgba(15, 23, 42, 0.08);
            }

            .profile-summary {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
            }

            .profile-avatar-wrap {
                position: relative;
                width: 132px;
                margin: 0 auto;
            }

            .profile-avatar {
                width: 132px;
                height: 132px;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid #fff;
                box-shadow: 0 14px 30px rgba(37, 99, 235, 0.18);
                background: #fff;
            }

            .profile-camera-btn {
                position: absolute;
                right: 2px;
                bottom: 6px;
                width: 38px;
                height: 38px;
                border: 0;
                border-radius: 50%;
                background: linear-gradient(135deg, #2563eb, #0ea5e9);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 20px rgba(37, 99, 235, 0.28);
                cursor: pointer;
            }

            .profile-camera-btn:hover {
                transform: translateY(-1px);
            }

            .profile-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.45rem 0.8rem;
                background: #eff6ff;
                color: #2563eb;
                border-radius: 999px;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .profile-panel-title {
                font-size: 2rem;
                font-weight: 700;
                color: #0f172a;
            }

            .profile-panel-copy {
                color: #64748b;
                max-width: 520px;
            }

            .profile-field label {
                font-weight: 600;
                color: #334155;
                margin-bottom: 0.45rem;
            }

            .profile-field .form-control {
                min-height: 54px;
                border-radius: 14px;
                border-color: #dbe3ef;
            }

            .profile-field .form-control:focus {
                border-color: #60a5fa;
                box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.18);
            }

            .profile-save-btn {
                min-height: 50px;
                padding: 0 1.4rem;
                border-radius: 14px;
                font-weight: 600;
            }
        </style>
        <div class="row g-4 profile-shell">
            <div class="col-12 col-lg-4">
                <div class="card rounded-4 profile-card profile-summary h-100">
                    <div class="card-body p-4 p-xl-5 text-center d-flex flex-column justify-content-center">
                        <div class="profile-avatar-wrap mb-4">
                            <img src="<?= htmlspecialchars($profileImage) ?>" class="profile-avatar" alt="Profile image" onerror="this.src='<?= base_url('assets/images/Default.jpg') ?>'">
                            <label for="profile_image" class="profile-camera-btn" title="Change profile image">
                                <i class='bx bx-camera fs-5'></i>
                            </label>
                        </div>
                        <div class="profile-badge mx-auto mb-3">
                            <i class='bx bx-buildings'></i>
                            <span><?= htmlspecialchars($businessName ?? 'Bills Book') ?></span>
                        </div>
                        <h3 class="mb-1"><?= htmlspecialchars($user['name'] ?? 'Admin') ?></h3>
                        <p class="text-muted mb-3"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        <!-- <p class="mb-0 text-secondary">Use the camera button on the profile photo to update your image instantly before saving.</p> -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card rounded-4 profile-card">
                    <div class="card-body p-4 p-xl-5">
                        <div class="mb-4">
                            <div class="profile-panel-title mb-2">Profile Settings</div>
                            <p class="profile-panel-copy mb-0">Keep your admin profile and business details up to date. The image upload is attached directly to the avatar for a cleaner workflow.</p>
                        </div>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>

                        <?php if (!empty($profileError)): ?>
                            <div class="alert alert-danger"><?= $profileError ?></div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('profile/update') ?>" enctype="multipart/form-data">
                            <div class="row g-3">
                                <input type="file" name="profile_image" id="profile_image" class="d-none" accept=".jpg,.jpeg,.png,.webp">
                                <div class="col-md-6 profile-field">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" value="<?= set_value('full_name', $user['name'] ?? '') ?>" class="form-control" placeholder="Enter full name">
                                    <?= form_error('full_name') ?>
                                </div>
                                <div class="col-md-6 profile-field">
                                    <label class="form-label">Business Name</label>
                                    <input type="text" name="business_name" value="<?= set_value('business_name', $user['business_name'] ?? '') ?>" class="form-control" placeholder="Enter business name">
                                    <?= form_error('business_name') ?>
                                </div>
                                <div class="col-md-6 profile-field">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="<?= set_value('email', $user['email'] ?? '') ?>" class="form-control" placeholder="Enter email">
                                    <?= form_error('email') ?>
                                </div>
                                <div class="col-md-6 profile-field">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" name="mobile" value="<?= set_value('mobile', $user['mobile'] ?? '') ?>" class="form-control" placeholder="Enter mobile number">
                                    <?= form_error('mobile') ?>
                                </div>
                                <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-3 pt-2">
                                    <!-- <small class="text-muted">Allowed image types: JPG, JPEG, PNG, WEBP. Max size 2MB.</small> -->
                                    <button type="submit" class="btn btn-primary profile-save-btn">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('profile_image');
        var avatar = document.querySelector('.profile-avatar');

        if (!input || !avatar) {
            return;
        }

        input.addEventListener('change', function(event) {
            var file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            var objectUrl = URL.createObjectURL(file);
            avatar.src = objectUrl;
        });
    });
</script>