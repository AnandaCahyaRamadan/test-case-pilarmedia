<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Dashboard</a>
    <div class="d-flex">
      <form action="{{ route('logout') }}" method="POST" class="mb-0">
          @csrf
          <button type="submit" class="btn btn-light btn-sm">Logout</button>
      </form>
    </div>
  </div>
</nav>