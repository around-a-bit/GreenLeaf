<?= $this->extend('Admin/layouts/layoutAdmin') ?>
<?= $this->section('content') ?>

<h3>Product Approval</h3>


<?php if (session()->getFlashdata('msg')): ?>
    <div class="alert alert-success"><?= session('msg') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<table class="table table-bordered align-middle">




<thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
<?php $i = 1; ?>
<?php foreach ($products as $p): ?>
<tr>
    <td><?= $i++ ?></td>

    <td><?= esc($p['name']) ?></td>
    <td><?= esc($p['category_name'] ?? 'N/A') ?></td>
    <td>₹<?= esc($p['price']) ?></td>
    <td><?= esc($p['stock']) ?></td>

    <td>
        <?php if ($p['status'] == 0): ?>
            <span class="badge bg-warning">Pending</span>
        <?php elseif ($p['status'] == 1): ?>
            <span class="badge bg-success">Approved</span>
        <?php else: ?>
            <span class="badge bg-danger">Rejected</span>
        <?php endif; ?>
    </td>

    <td>
        <?php if (!empty($p['images'])): ?>
            <img src="<?= base_url($p['images'][0]['image_path']) ?>" width="60">
        <?php else: ?>
            N/A
        <?php endif; ?>
    </td>

    <td>
        <form method="post" action="<?= base_url('admin/products/update-status') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $p['id'] ?>">

            <button name="status" value="1"
                class="btn btn-success btn-sm"
                <?= $p['status'] == 1 ? 'disabled' : '' ?>>
                Approve
            </button>

            <button name="status" value="2"
                class="btn btn-danger btn-sm"
                <?= $p['status'] == 2 ? 'disabled' : '' ?>>
                Reject
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>


</table>

<?= $this->endSection() ?>