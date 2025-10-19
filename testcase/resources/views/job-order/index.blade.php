@extends('layouts.main')

@section('content')

<div class="container mt-4">
  <div class="card mb-4">
    <div class="card-body">
      <h4>Selamat datang, {{ Auth::user()->name }}</h4>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-5">
        <h3>List Job Order</h3>
        <a href="{{ route('job-orders.create') }}" class="btn btn-success">Create</a>
      </div>
      <table id="jobOrdersTable" class="table table-striped table-bordered">
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
            <td>Rp. {{ number_format($order->cost,0,',','.') }}</td>
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
    
@endsection