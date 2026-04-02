<!DOCTYPE html>
<html>

<head>
    <title>Customer Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<meta name="csrf-name" content="<?= csrf_token() ?>">
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
<?php
$allMenus = config('CustomerMenu')->menus;
?>

<div class="sidebar" id="sidebar">
    <h4 class="logo">🛍️ Customer</h4>

<?php
$menus = session('menus') ?? [];
$allMenus = config('CustomerMenu')->menus;
?>

<?php foreach ($allMenus as $key => $menu): ?>

    <?php if (empty($menus) || in_array($key, $menus)): ?>

        <a href="<?= base_url('customer/' . $menu['route']) ?>" class="menu-item">
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

            <input type="text" placeholder="Search products..." class="search">

            <div class="user">
                <span><?= session('name') ?></span>

                <form action="<?= base_url('customer/logout') ?>" method="post" style="display:inline;">
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

<script src="<?= base_url('assets/js/customer.js') ?>"></script>

</body>
</html>


