<?= $this->extend('customer/layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="auth-box">
    <h3 class="mb-3 text-center">Welcome Back 👋</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('customer/login') ?>">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Login</button>
    </form>

    <p class="text-center mt-3">
        Don't have an account?
        <a href="<?= base_url('customer/register') ?>">Register</a>
    </p>
</div>

<?= $this->endSection() ?>