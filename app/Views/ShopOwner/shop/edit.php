<?= $this->extend('ShopOwner/layouts/layoutShopOwner') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm p-4">
    <h4>Edit Shop</h4>

    <form method="post" action="<?= base_url('shop_owner/update-shop/'.$shop['id']) ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Shop Name</label>
            <input type="text" name="shop_name" value="<?= $shop['shop_name'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tagline</label>
            <input type="text" name="tagline" value="<?= $shop['tagline'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $shop['description'] ?></textarea>
        </div>

        <!-- 📍 Lat/Lng -->
        <div class="row">
            <div class="col-md-6">
                <label>Latitude</label>
                <input type="text" name="lat" value="<?= $shop['lat'] ?>" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Longitude</label>
                <input type="text" name="lng" value="<?= $shop['lng'] ?>" class="form-control">
            </div>
        </div>

        <!-- 📍 Address -->
        <div class="mt-3">
            <label>Address</label>
            <input type="text" name="address" value="<?= $shop['address'] ?>" class="form-control">
        </div>

        <!-- 🗺 Map -->
        <div class="mt-3">
            <label>Update Location on Map</label>
            <div id="map" style="height: 400px; border-radius:10px;"></div>
        </div>

        <button class="btn btn-primary mt-3">Update</button>
    </form>
</div>

<script>
    // 🧠 Existing data from DB
    let existingLat = <?= $shop['lat'] ?? 22.5726 ?>;
    let existingLng = <?= $shop['lng'] ?? 88.3639 ?>;

    let map = L.map('map').setView([existingLat, existingLng], 15);

    // 🌍 Tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // 📍 Marker with existing location
    let marker = L.marker([existingLat, existingLng], { draggable: true }).addTo(map);

    // 🧠 Update inputs
    function updateInputs(lat, lng) {
        document.querySelector('input[name="lat"]').value = lat;
        document.querySelector('input[name="lng"]').value = lng;
    }

    // 🔁 Reverse geocode
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

    // 🎯 Drag marker
    marker.on('dragend', function() {
        let pos = marker.getLatLng();
        updateInputs(pos.lat, pos.lng);
        getAddress(pos.lat, pos.lng);
    });

    // 🖱 Click map
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);

        updateInputs(e.latlng.lat, e.latlng.lng);
        getAddress(e.latlng.lat, e.latlng.lng);
    });

    // 🔍 Search
    let geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {

        let latlng = e.geocode.center;

        map.setView(latlng, 15);
        marker.setLatLng(latlng);

        updateInputs(latlng.lat, latlng.lng);
        getAddress(latlng.lat, latlng.lng);

    }).addTo(map);
</script>

<?= $this->endSection() ?>