<?= $this->extend('Admin/layouts/layoutAdmin') ?>
<?= $this->section('content') ?>

<h4>Manage Categories 🌱</h4>

<!-- ADD CATEGORY -->
<div class="card p-3 mb-3">
    <form method="post" action="<?= base_url('admin/categories/store') ?>">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="name" class="form-control"
                       placeholder="Enter category (Plants, Seeds, Tools)" required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success w-100">Add</button>
            </div>
        </div>
    </form>
</div>

<!-- CATEGORY TABLE -->
<div class="card p-3">
    <table class="table table-bordered align-middle">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($categories as $i => $c): ?>
        <tr>

            <form method="post" action="<?= base_url('admin/categories/update/'.$c['id']) ?>">
                <?= csrf_field() ?>

                <td><?= $i + 1 ?></td>

                <!-- EDIT FIELD -->
                <td>
                    <input type="text" name="name"
                           value="<?= esc($c['name']) ?>"
                           class="form-control">
                </td>

                <!-- STATUS -->
                <td>
                    <?php if ($c['is_active']): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inactive</span>
                    <?php endif; ?>
                </td>

                <!-- ACTIONS -->
                <td>

                    <button class="btn btn-primary btn-sm">
                        Update
                    </button>
            </form>

                    <!-- TOGGLE ACTIVE (separate form) -->
                    <form method="post"
                          action="<?= base_url('admin/categories/toggle/'.$c['id']) ?>"
                          style="display:inline;">
                        <?= csrf_field() ?>

                        <button class="btn btn-warning btn-sm">
                            <?= $c['is_active'] ? 'Disable' : 'Enable' ?>
                        </button>
                    </form>

                </td>

        </tr>
        <?php endforeach; ?>

    </table>
</div>

<?= $this->endSection() ?>