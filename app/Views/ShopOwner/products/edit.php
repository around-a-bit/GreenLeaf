<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>
<?= $this->section('content') ?>

<h4>Edit Product</h4>

<form method="post" action="<?= base_url('shop_owner/products/update/' . $product['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= $product['name'] ?>" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"
                        <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= $c['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
        </div>

        <div class="col-md-4 mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Discount Price</label>
            <input type="number" step="0.01" name="discount_price" value="<?= $product['discount_price'] ?>" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" class="form-control">
        </div>

        <!-- 🔥 Existing Images -->
        <div class="col-md-12 mb-3">
            <label>Existing Images</label><br>

            <?php foreach ($images as $img): ?>
                <div style="display:inline-block; margin:5px;">
                    <img src="<?= base_url($img['image_path']) ?>" width="80" class="border">
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 🔥 Upload New Images -->
        <div class="col-md-12 mb-3">
            <label>Add More Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

    </div>

    <button class="btn btn-primary">Update Product</button>
    <a href="<?= base_url('shop_owner/products') ?>" class="btn btn-secondary">Back</a>
</form>

<?= $this->endSection() ?>