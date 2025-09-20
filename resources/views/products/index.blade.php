@extends('layout')
@section('title','Master Product')
@section('subtitle','Kelola data produk (soft delete aktif)')

@section('page-actions')
  <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
@endsection

@section('content')

  {{-- Filter/Search responsif --}}
  <form method="GET" class="row g-2 mb-3">
    <div class="col-12 col-md-6 col-lg-4">
      <input type="text" name="q" value="{{ request('q') }}" class="form-control"
             placeholder="Cari kode / nama…">
    </div>
    <div class="col-12 col-md-auto d-flex gap-2">
      <button class="btn btn-outline-primary">Cari</button>
      @if(request()->filled('q'))
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
      @endif
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-hover align-middle table-mobile">
      <thead class="table-light">
        <tr>
          <th style="width:80px">ID</th>
          <th>Kode</th>
          <th>Nama</th>
          <th class="text-end">Harga</th>
          <th class="text-end">Stok</th>
          <th>Status</th>
          <th style="width:160px">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse ($products as $p)
        <tr>
          <td data-label="ID">{{ $p->product_id }}</td>
          <td data-label="Kode" class="fw-semibold">{{ $p->product_code }}</td>
          <td data-label="Nama">{{ $p->product_name }}</td>
          <td data-label="Harga" class="text-end">{{ number_format($p->price,2) }}</td>
          <td data-label="Stok" class="text-end">{{ $p->stock_quantity }}</td>
          <td data-label="Status">
            @if($p->is_active)
              <span class="badge text-bg-success">Aktif</span>
            @else
              <span class="badge text-bg-secondary">Nonaktif</span>
            @endif
          </td>
          <td data-label="Aksi">
            <div class="d-flex flex-wrap gap-2">
              <a href="{{ route('products.edit',$p->product_id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('products.destroy',$p->product_id) }}" method="POST"
                onsubmit="return confirm('Hapus permanen produk ini? Tindakan tidak bisa dibatalkan.')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
            </form>

            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center text-muted py-4">Belum ada data</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists($products,'links'))
    <div class="mt-3">
      {{ $products->withQueryString()->links() }}
    </div>
  @endif

@endsection
