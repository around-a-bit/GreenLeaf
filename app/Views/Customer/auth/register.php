<?= $this->extend('customer/layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="auth-box">
    <h3 class="mb-3 text-center">Create Account 🚀</h3>

    <form method="post" action="<?= base_url('customer/register') ?>">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <p class="text-center mt-3">
        Already have an account?
        <a href="<?= base_url('customer/login') ?>">Login</a>
    </p>
</div>

<?= $this->endSection() ?>