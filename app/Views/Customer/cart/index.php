<?= $this->extend('Customer/layouts/layoutCustomer') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <h4 class="mb-4">🛒 Your Cart</h4>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info">Cart is empty</div>
    <?php else: ?>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $grand = 0; ?>
                        <?php foreach ($cart as $c):
                            $total = $c['price'] * $c['quantity'];
                            $grand += $total;
                        ?>
                            <tr>
                                <td><?= esc($c['name']) ?></td>
                                <td>₹<?= $c['price'] ?></td>
                                <td>
                                    <input type="number"
                                        value="<?= $c['quantity'] ?>"
                                        min="1"
                                        class="form-control form-control-sm cart-qty"
                                        data-id="<?= $c['id'] ?>">
                                </td>
                                <td>₹<?= $total ?></td>
                                <td>
                                    <a href="<?= base_url('customer/cart/remove/' . $c['id']) ?>"
                                        class="btn btn-sm btn-danger">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h5 class="text-end">Total: ₹<?= $grand ?></h5>

                <div class="text-end mt-3">
                    <a href="<?= base_url('customer/address') ?>" class="btn btn-success">
                        Proceed to Checkout
                    </a>
                </div>

            </div>
        </div>

    <?php endif; ?>

</div>

<script>
document.addEventListener('change', function(e){

    if(e.target.classList.contains('cart-qty')){

        let id = e.target.dataset.id;
        let qty = e.target.value;

        let formData = new FormData();
        formData.append('id', id);
        formData.append('quantity', qty);
        formData.append(csrfName, csrfToken);

        fetch("<?= base_url('customer/cart/update') ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.csrfToken) {
                csrfToken = data.csrfToken;
                document.querySelector('meta[name="csrf-token"]').content = data.csrfToken;
            }

            location.reload();
        });

    }

});
</script>

<?= $this->endSection() ?>