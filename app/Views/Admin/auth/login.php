<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card p-4">
                <h4 class="text-center">Admin Login</h4>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('admin/login') ?>">
                    
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">Login</button>
                </form>

            </div>

        </div>
    </div>
</div>

</body>
</html>