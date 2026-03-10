<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        (function() {
            try {
                var savedTheme = localStorage.getItem('app_theme');
                if (savedTheme) {
                    document.documentElement.setAttribute('data-bs-theme', savedTheme);
                }
            } catch (e) {}
        })();
    </script>
    <link href="<?= base_url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/simplebar/css/simplebar.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet">
    <?php
    $routerClass = $this->router->class ?? '';
    $routerMethod = $this->router->method ?? '';
    $isDashboardPage = ($routerClass === 'dashboard' && $routerMethod === 'index');
    ?>
    <?php if ($isDashboardPage): ?>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts" defer></script>
    <?php endif; ?>
    <link href="<?= base_url('assets/css/pace.min.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/js/pace.min.js') ?>"></script>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/bootstrap-extended.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/sass/app.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/sass/dark-theme.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/sass/semi-dark.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/sass/bordered-theme.css') ?>">
    <style>
        .sidebar-brand-wrap {
            padding: 0.25rem 0;
        }

        .sidebar-brand-kicker {
            font-size: 0.68rem;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 0.15rem;
        }

        .sidebar-brand-img {
            display: block;
            max-width: 170px;
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.2;
            color: #0f172a;
            word-break: break-word;
        }

        .top-menu .dropdown-menu {
            display: none;
        }

        .top-menu .dropdown.show>.dropdown-menu {
            display: block;
        }

        body.sidebar-preload .sidebar-wrapper,
        body.sidebar-preload .page-wrapper,
        body.sidebar-preload .topbar,
        body.sidebar-preload .metismenu ul {
            transition: none !important;
            animation: none !important;
        }

        #menu>li>ul {
            display: none;
        }

        #menu>li>ul.mm-show {
            display: block;
        }

        .topbar .navbar {
            flex-wrap: nowrap;
        }

        .user-box .user-info {
            min-width: 0;
        }

        .user-box .user-name,
        .user-box .designattion {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-box .user-name {
            font-weight: 700;
            color: #1e293b;
        }

        .user-box .designattion {
            color: #64748b;
            font-size: 0.9rem;
        }

        .sidebar-wrapper {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border-right: 1px solid #e5edf7;
        }

        .sidebar-header {
            min-height: 88px;
            padding: 1.2rem 1.25rem;
            border-bottom: 1px solid #edf2f7;
        }

        #menu {
            padding: 1rem 0.85rem;
        }

        #menu>li {
            margin-bottom: 0.35rem;
        }

        #menu>li>a {
            border-radius: 16px;
            padding: 0.95rem 1rem;
            color: #334155;
            transition: all 0.2s ease;
        }

        #menu>li>a:hover,
        #menu>li>a.is-active {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1d4ed8;
            box-shadow: inset 0 0 0 1px #bfdbfe;
        }

        #menu>li>a .parent-icon {
            min-width: 32px;
            color: inherit;
        }

        #menu>li>a .menu-title {
            font-weight: 600;
        }

        .mobile-sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 998;
        }

        body.mobile-sidebar-open .mobile-sidebar-backdrop {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 991.98px) {
            .sidebar-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 280px;
                max-width: calc(100vw - 32px);
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                z-index: 999;
            }

            body.mobile-sidebar-open .sidebar-wrapper {
                transform: translateX(0);
            }

            .page-wrapper,
            .topbar {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .page-content {
                padding: 1rem !important;
            }

            .topbar .navbar {
                padding-inline: 0.75rem;
            }

            .user-box {
                padding-inline: 0.5rem !important;
            }

            .user-box .user-name,
            .user-box .designattion {
                max-width: 110px;
            }

            .sidebar-header {
                padding-right: 3.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .dashboard-shell,
            .category-shell,
            .product-shell,
            .product-form-shell {
                max-width: 100% !important;
            }

            .card-body {
                padding: 1rem !important;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .category-action-group,
            .d-flex.gap-2,
            .d-flex.gap-3 {
                flex-wrap: wrap;
            }

            .user-box .user-info {
                display: none;
            }
        }
    </style>
    <?php
    $titleBusinessName = trim((string) ($businessName ?? (($this->session->userdata('admin')['business_name'] ?? ''))));
    $titleAppName = $titleBusinessName !== '' ? $titleBusinessName : 'Bills Book';
    $titlePage = trim((string) ($pageTitle ?? ''));
    $titleText = $titlePage !== '' ? $titlePage . ' | ' . $titleAppName : $titleAppName;
    ?>
    <title><?= htmlspecialchars($titleText) ?></title>
</head>

<body class="sidebar-preload">
    <?php
    $adminSession = (array) ($this->session->userdata('admin') ?? []);
    $roleValue = $role ?? ($adminSession['role'] ?? 'admin');
    $role = ((string) $roleValue === '1' || $roleValue === 1 || $roleValue === 'admin') ? 'admin' : (string) $roleValue;
    $userName = $userName ?? ($adminSession['user_name'] ?? ($adminSession['name'] ?? 'Admin'));
    $userEmail = $userEmail ?? ($adminSession['email'] ?? '');
    $businessName = trim((string) ($businessName ?? ($adminSession['business_name'] ?? '')));
    $appName = $businessName !== '' ? $businessName : 'Bills Book';
    $sidebarBrand = $businessName !== '' ? $businessName : 'Bills Book';
    $currentPath = trim((string) $this->uri->uri_string(), '/');
    $pageTitle = trim((string) ($pageTitle ?? ''));
    $documentTitle = $pageTitle !== '' ? $pageTitle . ' | ' . $appName : $appName;
    $profileUrl = $profileUrl ?? base_url('profile');
    $profileSource = $profileImage ?? ($adminSession['profile_image'] ?? '');

    if (empty($profileSource)) {
        $profileImage = base_url('assets/images/Default.jpg');
    } elseif (preg_match('#^https?://#i', $profileSource)) {
        $profileImage = $profileSource;
    } elseif (strpos($profileSource, 'uploads/') === 0 || strpos($profileSource, 'assets/') === 0) {
        $profileImage = base_url($profileSource);
    } else {
        $profileImage = base_url('uploads/profile/' . ltrim($profileSource, '/'));
    }
    ?>
    <div class="wrapper">
        <div class="mobile-sidebar-backdrop"></div>
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div></div>
                <div class="sidebar-brand-wrap">
                    <div class="sidebar-brand-kicker">Business</div>
                    <div class="sidebar-brand-img"><?= htmlspecialchars($sidebarBrand) ?></div>
                </div>
                <div class="mobile-toggle-icon ms-auto"><i class='bx bx-x'></i></div>
            </div>
            <ul class="metismenu" id="menu">
                <?php if ($role === 'admin'): ?>
                    <li>
                        <a href="<?= base_url('dashboard'); ?>" class="<?= $currentPath === 'dashboard' ? 'is-active' : '' ?>">
                            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('category'); ?>" class="<?= $currentPath === 'category' || strpos($currentPath, 'category/') === 0 ? 'is-active' : '' ?>">
                            <div class="parent-icon"><i class='bx bx-category'></i></div>
                            <div class="menu-title">Category</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('product'); ?>" class="<?= $currentPath === 'product' || strpos($currentPath, 'product/') === 0 ? 'is-active' : '' ?>">
                            <div class="parent-icon"><i class='bx bx-box'></i></div>
                            <div class="menu-title">Product</div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <header>
            <div class="topbar">
                <nav class="navbar navbar-expand gap-2 align-items-center">
                    <div class="mobile-toggle-menu d-flex"><i class="bx bx-menu"></i></div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex"></li>
                        </ul>
                    </div>
                    <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="<?= $profileImage ?>" class="user-img" alt="user avatar" onerror="this.src='<?= base_url('assets/images/Default.jpg') ?>'">
                            <div class="user-info">
                                <p class="user-name mb-0"><?= htmlspecialchars($userName) ?></p>
                                <p class="designattion mb-0"><?= htmlspecialchars($businessName !== '' ? $businessName : 'Bills Book') ?></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?= $profileUrl ?>">
                                    <i class="bx bx-user fs-5"></i><span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout'); ?>">
                                    <i class="bx bx-log-out-circle fs-5"></i><span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
