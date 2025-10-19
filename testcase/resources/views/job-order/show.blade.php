
@extends('layouts.main')

@section('content')
  <div class="container mt-4">
    <div class="card mb-4">
      <div class="card-body">
        <h4>Selamat datang, {{ Auth::user()->name }}</h4>
      </div>
    </div>
    <div class="card mb-4">
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
            <td>Rp. {{ number_format($order->cost,0,',','.') }}</td>
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
        </table>

        <a href="{{ route('job-orders.index') }}" class="btn btn-secondary">Kembali</a>

        {{-- modal --}}
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
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let mapInitialized = false;

    const mapModal = document.getElementById('mapModal');

    mapModal.addEventListener('shown.bs.modal', async function () {
        if (mapInitialized) return;

        const originCity = "{{ $order->origin_city_name }}";
        const destinationCity = "{{ $order->destination_city_name }}";

        async function geocode(city) {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(city)}`);
            const data = await response.json();

            if (data && data[0]) {
                return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
            } else {
                throw new Error("Koordinat tidak ditemukan untuk " + city);
            }
        }

        try {
            const [originLatLng, destinationLatLng] = await Promise.all([
                geocode(originCity),
                geocode(destinationCity)
            ]);

            const map = L.map('map').setView(originLatLng, 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const originMarker = L.marker(originLatLng).addTo(map)
                .bindPopup("<b>Origin :</b> " + originCity)
                .openPopup();

            const destMarker = L.marker(destinationLatLng).addTo(map)
                .bindPopup("<b>Destination :</b> " + destinationCity);

            L.polyline([originLatLng, destinationLatLng], { color: 'red' }).addTo(map);

            const group = new L.featureGroup([originMarker, destMarker]);
            map.fitBounds(group.getBounds().pad(0.5));

            mapInitialized = true;

        } catch (err) {
            alert(err.message);
        }
    });
  });
</script>

