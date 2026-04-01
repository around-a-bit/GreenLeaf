<?= $this->extend('Admin/layouts/layoutAdmin') ?>
<?= $this->section('content') ?>

<h4>Shop Owners Management</h4>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($owners as $owner): ?>
        <tr>
            <td><?= $owner['id'] ?></td>
            <td><?= $owner['name'] ?></td>
            <td><?= $owner['email'] ?></td>

            <td>
                <?php
                    $status = $owner['status'];
                    $badge = $status == 1 ? 'success' : ($status == 2 ? 'danger' : 'warning');
                    $label = $status == 1 ? 'Approved' : ($status == 2 ? 'Rejected' : 'Pending');
                ?>
                <span class="badge bg-<?= $badge ?>"><?= $label ?></span>
            </td>

            <td>
                <!-- ✅ APPROVE -->
                <form method="post" action="<?= base_url('admin/shops/update-status') ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $owner['id'] ?>">
                    <input type="hidden" name="status" value="1">

                    <button class="btn btn-success btn-sm">Approve</button>
                </form>

                <!-- ❌ REJECT -->
                <form method="post" action="<?= base_url('admin/shops/update-status') ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $owner['id'] ?>">
                    <input type="hidden" name="status" value="2">

                    <input type="text" name="reason" placeholder="Reason"
                           class="form-control form-control-sm mt-1">

                    <button class="btn btn-danger btn-sm mt-1">Reject</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>