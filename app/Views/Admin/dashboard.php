<?= $this->extend('Admin/layouts/layoutAdmin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Dashboard</h4>

        <div>
            <a href="<?= base_url('admin/list-admin') ?>" class="btn btn-outline-primary btn-sm">
                Manage Employees
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card-ui text-center">
                <h5>$34,343</h5>
                <small class="text-muted">Total Sales</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui text-center">
                <h5>$4.5k</h5>
                <small class="text-muted">Website Sales</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui text-center">
                <h5>$2.8k</h5>
                <small class="text-muted">Mobile Sales</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui text-center">
                <h5>$1.7k</h5>
                <small class="text-muted">Agent Sales</small>
            </div>
        </div>

    </div>

    <!-- Main Content -->
    <div class="row g-3">

        <!-- Left -->
        <div class="col-md-8">
            <div class="card-ui">
                <h5 class="mb-3">Welcome Back 👋</h5>
                <p class="text-muted">
                    This is your admin dashboard. Manage users, track system activity, and control access.
                </p>

                <hr>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('admin/create-admin') ?>" class="btn btn-dark btn-sm">
                        + Create Admin
                    </a>

                    <a href="<?= base_url('admin/list-admin') ?>" class="btn btn-outline-secondary btn-sm">
                        View Admins
                    </a>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div class="col-md-4">
            <div class="card-ui">
                <h6 class="mb-3">Quick Info</h6>

                <ul class="list-unstyled mb-0">
                    <li class="mb-2">👤 Logged in ID: <strong><?= session('admin_id') ?></strong></li>
                    <li class="mb-2">🔐 Role: <strong><?= session('role') ?></strong></li>
                    <li>📅 Status: <span class="text-success">Active</span></li>
                </ul>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>