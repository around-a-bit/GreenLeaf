
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

    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
        }

        .layout {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #111827;
            color: #fff;
            position: fixed;
            transition: 0.3s;
        }

        .logo {
            padding: 20px;
            text-align: center;
            font-weight: bold;
            background: #1f2937;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #d1d5db;
            text-decoration: none;
            transition: 0.2s;
        }

        .menu-item:hover {
            background: #374151;
            color: #fff;
        }

        .menu-item i {
            margin-right: 10px;
        }

        /* Main */
        .main {
            margin-left: 240px;
            width: 100%;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .search {
            width: 300px;
            padding: 6px 10px;
        }

        .user {
            display: flex;
            align-items: center;
        }

        /* Content */
        .content {
            padding: 20px;
        }

        /* Mobile */
        @media(max-width:768px) {
            .sidebar {
                left: -240px;
                position: fixed;
            }

            .sidebar.active {
                left: 0;
            }

            .main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

<?php
$shopStatus = $shopStatus ?? null;
$shopMenus = $menus ?? [];
?>

<div class="layout">

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="logo">🌱 Shop Panel</h4>

        <?php foreach ($shopMenus as $key => $menu): ?>

            <?php if ($shopStatus == 1): ?>
                <a href="<?= base_url('shop/' . $menu['route']) ?>" class="menu-item">
                    <i class="fa <?= $menu['icon'] ?>"></i>
                    <?= $menu['label'] ?>
                </a>

            <?php else: ?>
                <?php if ($key === 'dashboard'): ?>
                    <a href="<?= base_url('shop/dashboard') ?>" class="menu-item">
                        <i class="fa <?= $menu['icon'] ?>"></i>
                        <?= $menu['label'] ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">
            <button class="btn btn-dark btn-sm" onclick="toggleSidebar()">☰</button>

            <input type="text" class="form-control search" placeholder="Search...">

            <div class="user">
                <span>ID: <?= session('user_id') ?></span>

                <?php if ($shopStatus === 0): ?>
                    <span class="badge bg-warning ms-2">Pending</span>
                <?php elseif ($shopStatus === 1): ?>
                    <span class="badge bg-success ms-2">Approved</span>
                <?php elseif ($shopStatus === 2): ?>
                    <span class="badge bg-danger ms-2">Rejected</span>
                <?php endif; ?>

                <form action="<?= base_url('shopOwner/logout') ?>" method="post" class="ms-2">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>

    </div>

</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}
</script>

</body>
</html>
