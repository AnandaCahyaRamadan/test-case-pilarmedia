<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Job Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    #map { height: 400px; width: 100%; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3>Detail Job Order: {{ $order->order_number }}</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mapModal">Track Via Map</button>
        </div>

         <table class="table table-bordered mt-3">
        <tr>
          <th>Order Number</th>
          <td>{{ $order->order_number }}</td>
        </tr>
        <tr>
          <th>Origin City</th>
          <td>{{ $order->origin_city_name }} (ID: {{ $order->origin_city_id }})</td>
        </tr>
        <tr>
          <th>Destination City</th>
          <td>{{ $order->destination_city_name }} (ID: {{ $order->destination_city_id }})</td>
        </tr>
        <tr>
          <th>Cost</th>
          <td>Rp {{ number_format($order->cost,0,',','.') }}</td>
        </tr>
        <tr>
          <th>Distance</th>
          <td>{{ $order->distance }} km</td>
        </tr>
        <tr>
          <th>Estimate</th>
          <td>{{ $order->estimate }}</td>
        </tr>
        <tr>
          <th>Driver Name</th>
          <td>{{ $order->driver_name }}</td>
        </tr>
        <tr>
          <th>Vehicle</th>
          <td>{{ $order->vehicle_number }} ({{ $order->vehicle_type }})</td>
        </tr>
        <tr>
          <th>Contact</th>
          <td>{{ $order->contact_number }}</td>
        </tr>
        <tr>
          <th>Status</th>
          <td>{{ ucfirst($order->status) }}</td>
        </tr>
        <tr>
          <th>Created At</th>
          <td>{{ $order->created_at }}</td>
        </tr>
        <tr>
          <th>Updated At</th>
          <td>{{ $order->updated_at }}</td>
        </tr>
      </table>

      <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>

      <!-- Modal -->
      <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="mapModalLabel">Track Job Order: {{ $order->order_number }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="map"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let mapInitialized = false;

        const mapModal = document.getElementById('mapModal');
        mapModal.addEventListener('shown.bs.modal', function () {
            if (mapInitialized) return;

            const originCity = "{{ $order->origin_city_name }}";
            const destinationCity = "{{ $order->destination_city_name }}";

            function geocode(city) {
                return fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(city)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data[0]) {
                            return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                        } else {
                            throw new Error("Koordinat tidak ditemukan untuk " + city);
                        }
                    });
            }

            Promise.all([geocode(originCity), geocode(destinationCity)])
                .then(([originLatLng, destinationLatLng]) => {
                    const map = L.map('map').setView(originLatLng, 6);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    const originMarker = L.marker(originLatLng).addTo(map)
                        .bindPopup("<b>Origin:</b> " + originCity)
                        .openPopup();

                    const destMarker = L.marker(destinationLatLng).addTo(map)
                        .bindPopup("<b>Destination:</b> " + destinationCity);

                    L.polyline([originLatLng, destinationLatLng], {color: 'red'}).addTo(map);

                    const group = new L.featureGroup([originMarker, destMarker]);
                    map.fitBounds(group.getBounds().pad(0.5));

                    mapInitialized = true;
                })
                .catch(err => alert(err));
        });
    });
</script>

</body>
</html>
