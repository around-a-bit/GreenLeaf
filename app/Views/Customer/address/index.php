<?= $this->extend('Customer/layouts/layoutCustomer') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>My Addresses</h4>
    <a href="<?= base_url('customer/address/create') ?>" class="btn btn-primary">
        <i class="fa fa-plus"></i> Add Address
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="row">
    <?php if (!empty($addresses)): ?>
        <?php foreach ($addresses as $a): ?>
            <div class="col-md-4">
                <div class="card shadow-sm mb-3 position-relative">

                    <?php if ($a['is_default']): ?>
                        <span class="badge bg-success position-absolute top-0 end-0 m-2">
                            Default
                        </span>
                    <?php endif; ?>

                    <div class="card-body">

                        <h6 class="text-uppercase text-muted"><?= esc($a['type']) ?></h6>

                        <strong><?= esc($a['full_name'] ?? 'N/A') ?></strong><br>
                        <small><?= esc($a['phone'] ?? '') ?></small>

                        <p class="mt-2 mb-1">
                            <?= esc($a['address_line1']) ?><br>
                            <?= esc($a['address_line2']) ?><br>
                            <?= esc($a['landmark']) ?>
                        </p>

                        <p class="mb-1">
                            <?= esc($a['city']) ?>, <?= esc($a['state']) ?>
                        </p>

                        <p><strong><?= esc($a['pincode']) ?></strong></p>

                        <div class="d-flex gap-2 flex-wrap mt-2">
                            <a href="<?= base_url('customer/address/edit/'.$a['id']) ?>" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <a href="<?= base_url('customer/address/delete/'.$a['id']) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this address?')">
                                Delete
                            </a>

                            <?php if (!$a['is_default']): ?>
                                <a href="<?= base_url('customer/address/set-default/'.$a['id']) ?>"
                                   class="btn btn-sm btn-info">
                                    Set Default
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No addresses found.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>