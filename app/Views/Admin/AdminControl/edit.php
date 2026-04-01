<?= $this->extend('Admin/layouts/layoutAdmin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card-ui">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Edit Admin</h4>
            <a href="<?= base_url('admin/list-admin') ?>" class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>

        <form method="post" action="<?= base_url('admin/update-admin/' . $admin['id']) ?>">

            <!-- CSRF -->
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

            <div class="row">

                <!-- Left Side -->
                <div class="col-md-6">

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" class="form-control"
                            value="<?= esc($admin['name']) ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="<?= esc($admin['email']) ?>" required>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="sub_admin" <?= $admin['role'] == 'sub_admin' ? 'selected' : '' ?>>
                                Sub Admin
                            </option>
                            <option value="super_admin" <?= $admin['role'] == 'super_admin' ? 'selected' : '' ?>>
                                Super Admin
                            </option>
                        </select>
                    </div>

                </div>

                <!-- Right Side (Permissions) -->
                <div class="col-md-6">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-semibold">Update Permissions</label>

                        <!-- Select All -->
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleAll()">
                            Select All
                        </button>
                    </div>

                    <div class="permission-box p-3">

                        <?php foreach ($menus as $key => $menu): ?>

                            <div class="form-check mb-2">
                                <input class="form-check-input menu-checkbox"
                                    type="checkbox"
                                    name="menus[]"
                                    value="<?= is_array($menu) ? $key : $menu ?>"
                                    id="<?= $key ?>"
                                    <?= in_array(is_array($menu) ? $key : $menu, $assignedMenus) ? 'checked' : '' ?>>

                                <label class="form-check-label" for="<?= $key ?>">
                                    <?= is_array($menu) ? $menu['label'] : ucfirst($menu) ?>
                                </label>
                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

            <!-- Submit -->
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    Update Admin
                </button>
            </div>

        </form>

    </div>

</div>

<!-- JS -->
<script>
function toggleAll() {
    let checkboxes = document.querySelectorAll('.menu-checkbox');
    let allChecked = [...checkboxes].every(cb => cb.checked);

    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>

<?= $this->endSection() ?>