<?= $this->extend('Customer/layouts/layoutCustomer') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Add New Address</h4>
        <a href="<?= base_url('customer/address') ?>" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <!-- 🌍 Leaflet CSS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

            <form method="post" action="<?= base_url('customer/address/store') ?>">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                <div class="row g-3">

                    <!-- TYPE -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Address Type</label>
                        <select name="type" class="form-select">
                            <option value="home">🏠 Home</option>
                            <option value="office">🏢 Office</option>
                            <option value="other">📍 Other</option>
                        </select>
                    </div>

                    <!-- NAME -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="full_name" class="form-control" >
                    </div>

                    <!-- PHONE -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control" >
                    </div>

                    <!-- PINCODE -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pincode</label>
                        <input type="text" name="pincode" class="form-control" required>
                    </div>

                    <!-- ADDRESS 1 -->
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Address Line 1</label>
                        <input type="text" name="address_line1" class="form-control" required>
                    </div>

                    <!-- ADDRESS 2 -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control">
                    </div>

                    <!-- LANDMARK -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Landmark</label>
                        <input type="text" name="landmark" class="form-control">
                    </div>

                    <!-- CITY -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>

                    <!-- STATE -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">State</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>

                    <!-- MAP -->
                    <div class="col-12 mt-4">
                        <label class="form-label fw-semibold">📍 Select Location</label>
                        <div id="map" class="rounded-4 border" style="height:350px;"></div>
                    </div>

                    <!-- LAT LNG -->
                    <div class="col-md-6">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" id="lat" class="form-control bg-light" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" id="lng" class="form-control bg-light" readonly>
                    </div>

                    <!-- DEFAULT -->
                    <div class="col-12 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_default" value="1">
                            <label class="form-check-label">
                                Set as default address
                            </label>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="col-12 mt-4">
                        <button class="btn btn-success px-4 py-2 rounded-3">
                            <i class="fa fa-save"></i> Save Address
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>

<!-- 🌍 Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
let map = L.map('map').setView([22.5726, 88.3639], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

let marker = L.marker([22.5726, 88.3639], { draggable: true }).addTo(map);

function updateInputs(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    reverseGeocode(lat, lng);
}

function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            let a = data.address || {};

            document.querySelector('[name="address_line1"]').value =
                (a.road || '') + ' ' + (a.suburb || '');

            document.querySelector('[name="city"]').value =
                a.city || a.town || a.village || '';

            document.querySelector('[name="state"]').value =
                a.state || '';

            document.querySelector('[name="pincode"]').value =
                a.postcode || '';

            document.querySelector('[name="landmark"]').value =
                a.neighbourhood || a.suburb || '';
        });
}

marker.on('dragend', () => {
    let pos = marker.getLatLng();
    updateInputs(pos.lat, pos.lng);
});

map.on('click', (e) => {
    marker.setLatLng(e.latlng);
    updateInputs(e.latlng.lat, e.latlng.lng);
});

L.Control.geocoder({ defaultMarkGeocode: false })
.on('markgeocode', function(e) {
    let c = e.geocode.center;
    map.setView(c, 15);
    marker.setLatLng(c);
    updateInputs(c.lat, c.lng);
})
.addTo(map);

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        let lat = pos.coords.latitude;
        let lng = pos.coords.longitude;
        map.setView([lat, lng], 15);
        marker.setLatLng([lat, lng]);
        updateInputs(lat, lng);
    });
}
</script>

<?= $this->endSection() ?>