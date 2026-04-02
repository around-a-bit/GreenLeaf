<?= $this->extend('Customer/layouts/layoutCustomer') ?>
<?= $this->section('content') ?>


<div class="container-fluid">

    <h4>Hey <?= esc($user['name']) ?> 👋</h4>

    <!-- Map -->
    <div id="map" style="height:400px; width:100%; border-radius:10px;"></div>

    <!-- Products -->
    <div class="row mt-4" id="products"></div>

</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let csrfName = document.querySelector('meta[name="csrf-name"]').content;
    document.addEventListener("DOMContentLoaded", function() {

        let map = L.map('map').setView([22.57, 88.36], 13);
        let markers = [];
        let userMarker = null;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        setTimeout(() => map.invalidateSize(), 300);



        // 🔍 SEARCH CONTROL
        L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                let lat = e.geocode.center.lat;
                let lng = e.geocode.center.lng;

                updateLocation(lat, lng);
            })
            .addTo(map);

        // 📍 INITIAL LOCATION (ONLY ONCE)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                updateLocation(pos.coords.latitude, pos.coords.longitude);
            });
        }

        // 🔥 MAIN LOCATION HANDLER
        function updateLocation(lat, lng) {

            map.setView([lat, lng], 13);

            // update user marker (no duplicate)
            if (userMarker) {
                userMarker.setLatLng([lat, lng]);
            } else {
                userMarker = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup("You are here")
                    .openPopup();
            }

            saveLocation(lat, lng);
            loadProducts(lat, lng);
        }

        // 💾 SAVE LOCATION
        function saveLocation(lat, lng) {

            let formData = new FormData();
            formData.append('lat', lat);
            formData.append('lng', lng);
            formData.append('address', 'Selected Location');
            formData.append(csrfName, csrfToken);
            console.log("CSRF:", csrfName, csrfToken);
            fetch("<?= base_url('customer/address/update-location') ?>", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Saved:', data);

                    if (data.csrfToken) {
                        csrfToken = data.csrfToken;
                        document.querySelector('meta[name="csrf-token"]').content = data.csrfToken;
                    }
                })
                .catch(err => console.error(err));


        }



        // 🛒 LOAD PRODUCTS
        function loadProducts(lat, lng) {

            fetch(`<?= base_url('customer/address/products-nearby') ?>?lat=${lat}&lng=${lng}`)
                .then(res => res.json())
                .then(data => {


                    clearMarkers();

                    let html = '';

                    if (data.length === 0) {
                        html = `<div class="col-12 text-center text-muted">No products found nearby 😢</div>`;
                    }

                    data.forEach(p => {

                        let marker = L.marker([p.shop_lat, p.shop_lng])
                            .addTo(map)
                            .bindPopup(`<b>${p.shop_name}</b>`);

                        markers.push(marker);

                        html += `
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">

<img src="<?= base_url() ?>/${p.image ? p.image : 'uploads/default.png'}"
             class="card-img-top"
             style="height:150px; object-fit:cover;"
             onerror="this.src='<?= base_url() ?>/uploads/default.png'">

                        <div class="card-body">
                            <h6>${p.name}</h6>
                            <p class="mb-1 text-success fw-bold">₹${p.price}</p>
                            <small class="text-muted">${p.shop_name}</small>
                        </div>

                        <div class="d-flex gap-2">
    <input type="number"
           min="1"
           value="1"
           class="form-control form-control-sm qty-input">

    <button class="btn btn-sm btn-primary add-to-cart"
        data-id="${p.id}"
        data-price="${p.price}">
        Add
    </button>
</div>
                        </div>

                    </div>
                </div>
                `;
                    });

                    document.getElementById('products').innerHTML = html;

                })
                .catch(err => console.error(err));
        }

        function clearMarkers() {
            markers.forEach(m => map.removeLayer(m));
            markers = [];
        }

        // 🧭 DRAG MAP → ONLY LOAD PRODUCTS (NO setView)
        map.on('moveend', function() {
            let center = map.getCenter();
            loadProducts(center.lat, center.lng); // ✅ no recursion
        });

    });


document.addEventListener('click', function(e) {

    if (e.target.classList.contains('add-to-cart')) {

        let card = e.target.closest('.card');
        let qty = card.querySelector('.qty-input').value;

        let productId = e.target.dataset.id;
        let price = e.target.dataset.price;

        let formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', qty); // ✅ correct
        formData.append('price', price);
        formData.append(csrfName, csrfToken);

        console.log("CSRF:", csrfName, csrfToken);

        fetch("<?= base_url('customer/cart/add') ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.csrfToken) {
                csrfToken = data.csrfToken;
                document.querySelector('meta[name="csrf-token"]').content = data.csrfToken;
            }

            if (data.status === 'success') {
                alert("🛒 Added!");
            }

        })
        .catch(err => console.error(err));
    }

});
</script>

<?= $this->endSection() ?>