
<!DOCTYPE html>
<html>
<head>
    <title>Shop Owner Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card p-4" style="width:350px;">
    <h4 class="text-center mb-3">🌱 Shop Owner Login</h4>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('shopOwner/login') ?>">
        <?= csrf_field() ?>

        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <button class="btn btn-success w-100">Login</button>
    </form>

    <p class="mt-3 text-center">
        No account? <a href="<?= base_url('shopOwner/register') ?>">Register</a>
    </p>
</div>

</body>
</html>
