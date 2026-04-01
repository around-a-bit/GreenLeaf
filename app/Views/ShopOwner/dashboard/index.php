<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>

<?= $this->section('content') ?>

<div class="row">

    <!-- Stats Cards -->
    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h6>Total Shops</h6>
            <h3><?= isset($shop) ? 1 : 0 ?></h3>
        </div>
    </div>
<?php
$shopStatus = session('status'); 
?>

    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h6>Status</h6>
            <h4>
                <?php if ($shopStatus == 0): ?>
                    <span class="text-warning">Pending</span>
                    
                <?php elseif ($shopStatus == 1): ?>
                    <span class="text-success">Approved</span>
                <?php else: ?>
                    <span class="text-danger">Not Created</span>
                <?php endif; ?>
            </h4>
        </div>
    </div>
</div>

<hr>

<?= $this->endSection() ?>