<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>

<?= $this->section('content') ?>
<div class="row">
    <?php
    $shopStatus = session('status');
    ?>
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Quick Action</h6>

            <a href="<?= base_url('shop_owner/create-shop') ?>" class="btn btn-primary btn-sm mt-2">
                Create Shop
            </a>
        </div>
    </div>
</div>
<hr>
<div class="card shadow-sm p-3">
    <h4>My Shops</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($shops as $shop): ?>
                <tr>
                    <td><?= $shop['id'] ?></td>
                    <td><?= $shop['shop_name'] ?></td>
                    <td>
                        <?php if ($shop['status'] == 1): ?>
                            <span class="badge bg-success">Approved</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('shop_owner/edit-shop/' . $shop['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<?= $this->endSection() ?>