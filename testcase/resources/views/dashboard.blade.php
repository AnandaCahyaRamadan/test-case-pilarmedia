<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- DataTables CSS --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Dashboard</a>
    <div class="d-flex">
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-light btn-sm">Logout</button>
      </form>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="card mb-4">
    <div class="card-body">
      <h4>Selamat datang, {{ Auth::user()->name }}</h4>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h3>List Job Order</h3>
      <table id="jobOrdersTable" class="table table-striped">
        <thead>
          <tr>
            <th>Order Number</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Cost</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jobOrders as $order)
          <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->origin_city_name }}</td>
            <td>{{ $order->destination_city_name }}</td>
            <td>Rp {{ number_format($order->cost,0,',','.') }}</td>
            <td>
                <a href="{{ route('job-orders.show', $order->id) }}" class="btn btn-info btn-sm">Detail</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#jobOrdersTable').DataTable({
        "pageLength": 10
    });
});
</script>
</body>
</html>
