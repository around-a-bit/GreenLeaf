<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>My Products</h4>
    <a href="<?= base_url('shop_owner/products/create') ?>" class="btn btn-primary">
        + Add Product
    </a>
</div>

<!-- 🔥 SHOP FILTER -->
<?php if (!empty($shops)): ?>
    <form method="get" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="shop_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Select Shop</option>
                    <?php foreach ($shops as $s): ?>
                        <option value="<?= $s['id'] ?>"
                            <?= $selectedShop == $s['id'] ? 'selected' : '' ?>>
                            <?= esc($s['shop_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>
<?php else: ?>
    <div class="alert alert-warning">
        No shops found. Please create a shop first.
    </div>
<?php endif; ?>

<hr>

<!-- 🔥 PRODUCTS TABLE -->
<div class="card shadow-sm p-3">

    <?php if (!empty($products)): ?>

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image_path'])): ?>
                                <img src="<?= base_url($p['image_path']) ?>" width="60">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>

                        <td><?= esc($p['name']) ?></td>
                        <td>₹<?= esc($p['price']) ?></td>

                        <td>
                            <?php if ($p['status'] == 0): ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif ($p['status'] == 1): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <!-- 🔥 EMPTY STATE -->
        <div class="text-center py-4">
            <p class="text-muted">No products found for this shop.</p>
            <a href="<?= base_url('shop_owner/products/create') ?>" class="btn btn-primary">
                Add Your First Product
            </a>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>