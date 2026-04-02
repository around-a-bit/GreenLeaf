<?= $this->extend('Customer/layouts/layoutCustomer') ?>

<?= $this->section('content') ?>

<h4>Edit Address</h4>

<form method="post" action="<?= base_url('customer/address/update/'.$address['id']) ?>">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

    <div class="row">

        <div class="col-md-6 mb-2">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="home" <?= $address['type']=='home'?'selected':'' ?>>Home</option>
                <option value="office" <?= $address['type']=='office'?'selected':'' ?>>Office</option>
                <option value="other" <?= $address['type']=='other'?'selected':'' ?>>Other</option>
            </select>
        </div>

        <div class="col-md-6 mb-2">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= esc($address['full_name']) ?>" class="form-control">
        </div>

        <div class="col-md-6 mb-2">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= esc($address['phone']) ?>" class="form-control">
        </div>

        <div class="col-md-6 mb-2">
            <label>Pincode</label>
            <input type="text" name="pincode" value="<?= esc($address['pincode']) ?>" class="form-control">
        </div>

        <div class="col-md-12 mb-2">
            <label>Address Line 1</label>
            <input type="text" name="address_line1" value="<?= esc($address['address_line1']) ?>" class="form-control">
        </div>

        <div class="col-md-12 mb-2">
            <label>Address Line 2</label>
            <input type="text" name="address_line2" value="<?= esc($address['address_line2']) ?>" class="form-control">
        </div>

        <div class="col-md-12 mb-2">
            <label>Landmark</label>
            <input type="text" name="landmark" value="<?= esc($address['landmark']) ?>" class="form-control">
        </div>

        <div class="col-md-6 mb-2">
            <label>City</label>
            <input type="text" name="city" value="<?= esc($address['city']) ?>" class="form-control">
        </div>

        <div class="col-md-6 mb-2">
            <label>State</label>
            <input type="text" name="state" value="<?= esc($address['state']) ?>" class="form-control">
        </div>

        <div class="col-md-12 mt-2">
            <label>
                <input type="checkbox" name="is_default" value="1"
                    <?= $address['is_default'] ? 'checked' : '' ?>>
                Set as Default
            </label>
        </div>

        <div class="col-md-12 mt-3">
            <button class="btn btn-primary">Update Address</button>
        </div>

    </div>
</form>

<?= $this->endSection() ?>