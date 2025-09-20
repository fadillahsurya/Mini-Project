<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title','Master Product') · Mini Project</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    .navbar-brand { font-weight: 700; letter-spacing: .2px; }
    .app-shell { min-height: 100dvh; display: flex; flex-direction: column; }
    .app-main  { flex: 1 1 auto; }
    .card-elev { border: 0; box-shadow: 0 6px 18px rgba(16,24,40,.06); }

    /* Tabel jadi kartu di layar kecil */
    @media (max-width: 576px) {
      .table-mobile thead { display: none; }
      .table-mobile tbody tr {
        display: block;
        margin-bottom: .75rem;
        border: 1px solid rgba(0,0,0,.075);
        border-radius: .65rem;
        overflow: hidden;
      }
      .table-mobile tbody tr td {
        display: flex;
        justify-content: space-between;
        gap: .75rem;
        padding: .6rem .9rem;
        border-bottom: 1px dashed #eee;
      }
      .table-mobile tbody tr td:last-child { border-bottom: 0; }
      .table-mobile tbody tr td::before {
        content: attr(data-label);
        font-weight: 600;
      }
    }
  </style>
</head>
<body class="bg-slate-50 app-shell">

  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">Master Product</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="topnav" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
               href="{{ route('products.index') }}">Daftar Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}"
               href="{{ route('products.create') }}">Tambah</a>
          </li>
        </ul>

        {{-- tempatkan search global/aksi kanan di sini kalau perlu --}}
        @yield('topbar-right')
      </div>
    </div>
  </nav>

  {{-- MAIN --}}
  <main class="app-main py-4">
    <div class="container">

      {{-- FLASH / ERROR --}}
      @includeWhen(View::exists('partials.flash'), 'partials.flash')

      {{-- HEADER HALAMAN --}}
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3 gap-2">
        <div>
          <h4 class="mb-0">@yield('title','Master Product')</h4>
          @hasSection('subtitle')
            <div class="text-muted small">@yield('subtitle')</div>
          @endif
        </div>
        <div class="d-flex gap-2">
          @yield('page-actions')
        </div>
      </div>

      {{-- KONTEN --}}
      <div class="card card-elev">
        <div class="card-body">
          @yield('content')
        </div>
      </div>
    </div>
  </main>

  {{-- FOOTER --}}
  <footer class="py-4">
    <div class="container text-center text-muted small">
      © {{ date('Y') }} Mini Project · CRUD Master Product
    </div>
  </footer>
</body>
</html>
