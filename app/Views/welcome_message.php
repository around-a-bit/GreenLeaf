<!DOCTYPE html>
<html>
<head>
    <title>Greenleaf</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="text-center mt-5">

    <h2>Welcome to Greenleaf 🌱</h2>

    <div class="mt-4">
        <a href="<?= base_url('admin/login') ?>" class="btn btn-dark m-2">Admin</a>
        <a href="<?= base_url('customer/login') ?>" class="btn btn-success m-2">Customer</a>
        <a href="<?= base_url('shopOwner/login') ?>" class="btn btn-warning m-2">Shop Owner</a>
        <a href="<?= base_url('delivery/login') ?>" class="btn btn-info m-2">Delivery</a>
    </div>

</body>
</html>