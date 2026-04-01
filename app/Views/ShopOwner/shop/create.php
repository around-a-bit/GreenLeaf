<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm p-4">
    <h4>Create Your Shop</h4>

    <form method="post" action="<?= base_url('shop_owner/store-shop') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Shop Name</label>
            <input type="text" name="shop_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tagline</label>
            <input type="text" name="tagline" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Latitude</label>
                <input type="text" name="lat" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Longitude</label>
                <input type="text" name="lng" class="form-control">
            </div>
        </div>

        <div class="mt-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
        </div>

        <div class="mt-3">
    <label>Select Location on Map</label>
    <div id="map" style="height: 400px; border-radius:10px;"></div>
</div>

        <button class="btn btn-success mt-3">Submit</button>
    </form>
</div>

<script>
    let map = L.map('map').setView([22.5726, 88.3639], 13); // Default: Kolkata

    // 🌍 OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    let marker;

    // 🧠 Update lat/lng inputs
    function updateInputs(lat, lng) {
        document.querySelector('input[name="lat"]').value = lat;
        document.querySelector('input[name="lng"]').value = lng;
    }

    // 🔁 Reverse Geocoding → get address from lat/lng
    function getAddress(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    document.querySelector('input[name="address"]').value = data.display_name;
                }
            })
            .catch(err => console.log(err));
    }

    // 📍 Get user live location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;

            map.setView([lat, lng], 15);

            marker = L.marker([lat, lng], { draggable: true }).addTo(map);

            updateInputs(lat, lng);
            getAddress(lat, lng);

            marker.on('dragend', function() {
                let pos = marker.getLatLng();
                updateInputs(pos.lat, pos.lng);
                getAddress(pos.lat, pos.lng);
            });
        });
    }

    // 🖱 Click on map to set location
    map.on('click', function(e) {
        let lat = e.latlng.lat;
        let lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng, { draggable: true }).addTo(map);

            marker.on('dragend', function() {
                let pos = marker.getLatLng();
                updateInputs(pos.lat, pos.lng);
                getAddress(pos.lat, pos.lng);
            });
        }

        updateInputs(lat, lng);
        getAddress(lat, lng);
    });

    // 🔍 Search with geocoder (PRO version)
    let geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {

        let latlng = e.geocode.center;

        map.setView(latlng, 15);

        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng, { draggable: true }).addTo(map);

            marker.on('dragend', function() {
                let pos = marker.getLatLng();
                updateInputs(pos.lat, pos.lng);
                getAddress(pos.lat, pos.lng);
            });
        }

        updateInputs(latlng.lat, latlng.lng);
        getAddress(latlng.lat, latlng.lng);

    }).addTo(map);
</script>

<?= $this->endSection() ?>