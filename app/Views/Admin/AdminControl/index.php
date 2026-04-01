<?= $this->extend('Admin/layouts/layoutAdmin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card-ui">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Admins</h4>

            <a href="<?= base_url('admin/create-admin') ?>" class="btn btn-dark btn-sm">
                + Create Admin
            </a>
        </div>

        <!-- Table -->
        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($admins)): ?>
                        <?php foreach ($admins as $admin): ?>
                            <tr>

                                <td><?= esc($admin['id']) ?></td>
                                <td><?= esc($admin['name']) ?></td>
                                <td><?= esc($admin['email']) ?></td>

                                <td>
                                    <a href="<?= base_url('admin/edit-admin/' . $admin['id']) ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No admins found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection() ?>