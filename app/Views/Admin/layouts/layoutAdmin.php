<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
</head>

<body>

    <div class="layout">

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h4 class="logo">⚡ Admin</h4>

            <?php
            $role = session('role');
            $menus = session('menus') ?? [];
            $allMenus = config('Menu')->menus;
            ?>

            <?php foreach ($allMenus as $key => $menu): ?>

                <?php if ($role === 'super_admin' || in_array($key, $menus)): ?>

                    <a href="<?= base_url('admin/' . $menu['route']) ?>" class="menu-item">
                        <i class="fa <?= $menu['icon'] ?>"></i>
                        <?= $menu['label'] ?>
                    </a>

                <?php endif; ?>

            <?php endforeach; ?>
        </div>

        <!-- Main -->
        <div class="main">

            <!-- Topbar -->
            <div class="topbar">
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

                <input type="text" placeholder="Search..." class="search">

                <div class="user">
                    <span><?= session('admin_id') ?></span>

            <form action="<?= base_url('admin/logout') ?>" method="post" style="display:inline;">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                <button type="submit" class="btn btn-danger btn-sm ms-2">
                    Logout
                </button>
            </form>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <?= $this->renderSection('content') ?>
            </div>

        </div>

    </div>

    <script src="<?= base_url('assets/js/admin.js') ?>"></script>

</body>

</html>