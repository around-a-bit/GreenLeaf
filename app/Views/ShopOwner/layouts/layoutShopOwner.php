<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shop Owner Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body { margin:0; font-family:'Segoe UI'; background:#f5f6fa; }
        .layout { display:flex; }
        .sidebar { width:240px; height:100vh; background:#111827; color:#fff; position:fixed; }
        .logo { padding:20px; text-align:center; background:#1f2937; }
        .menu-item { display:block; padding:12px 20px; color:#d1d5db; text-decoration:none; }
        .menu-item:hover { background:#374151; color:#fff; }
        .main { margin-left:240px; width:100%; }
        .topbar { background:#fff; padding:12px 20px; display:flex; justify-content:space-between; }
        .content { padding:20px; }
    </style>
</head>

<body>

<?php
$shopStatus = session('status'); 
$shopMenus  = config('ShopOwnerMenu')->menus;
?>

<div class="layout">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="logo">🌱 Shop Panel</h4>

        <?php foreach ($shopMenus as $key => $menu): ?>

            <?php if ($shopStatus == 1): ?>
                <!-- Approved -->
                <a href="<?= base_url('shop_owner/'.$menu['route']) ?>" class="menu-item">
                    <i class="fa <?= $menu['icon'] ?>"></i> <?= $menu['label'] ?>
                </a>

            <?php elseif ($key === 'dashboard'): ?>
                <!-- Only dashboard -->
                <a href="<?= base_url('shop_owner/dashboard') ?>" class="menu-item">
                    <i class="fa <?= $menu['icon'] ?>"></i> <?= $menu['label'] ?>
                </a>

            <?php endif; ?>

        <?php endforeach; ?>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">

            <span>ID: <?= session('user_id') ?></span>

            <div>
                <?php if ($shopStatus == 0): ?>
                    <span class="badge bg-warning">Pending</span>
                <?php elseif ($shopStatus == 1): ?>
                    <span class="badge bg-success">Approved</span>
                <?php elseif ($shopStatus == 2): ?>
                    <span class="badge bg-danger">Rejected</span>
                <?php endif; ?>

                <form action="<?= base_url('shop_owner/logout') ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>

        </div>

        <!-- Content -->
        <div class="content">

            <!-- 🔥 STATUS ALERT -->
            <?php if ($shopStatus == 0): ?>
                <div class="alert alert-warning">
                    ⏳ Your account is under review by admin
                </div>
            <?php elseif ($shopStatus == 2): ?>
                <div class="alert alert-danger">
                    ❌ Your account was rejected. Contact admin.
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>

    </div>

</div>

</body>
</html>