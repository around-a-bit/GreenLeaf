<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>
<?= $this->section('content') ?>



<h4>Add Product</h4>

<form method="post" action="<?= base_url('shop_owner/products/store') ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

<?php if (!empty($shops) && count($shops) == 1): ?>
    <input type="hidden" name="shop_id" value="<?= $shops[0]['id'] ?>">
    
    <div class="col-md-6 mb-3">
        <label>Shop</label>
        <input type="text" class="form-control"
               value="<?= esc($shops[0]['shop_name']) ?>" disabled>
    </div>
<?php else: ?>
    <div class="col-md-6 mb-3">
        <label>Select Shop</label>
        <select name="shop_id" class="form-control" required>
            <option value="">Select Shop</option>
            <?php foreach ($shops as $s): ?>
                <option value="<?= $s['id'] ?>">
                    <?= esc($s['shop_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>

        <div class="col-md-12 mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="col-md-4 mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Discount Price</label>
            <input type="number" step="0.01" name="discount_price" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="col-md-12 mb-3">
            <label>Product Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

    </div>

    <button class="btn btn-success">Save Product</button>
    <a href="<?= base_url('shop_owner/products') ?>" class="btn btn-secondary">Back</a>
</form>

<?= $this->endSection() ?>