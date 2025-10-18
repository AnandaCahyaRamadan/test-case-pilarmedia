<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="card">
      <div class="card-body">
        <h4>Selamat datang, {{ Auth::user()->name }}</h4>
        <p class="mb-0 text-muted">Anda berhasil login ke sistem.</p>
      </div>
    </div>
  </div>
</body>
</html>
