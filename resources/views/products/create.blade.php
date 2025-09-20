@extends('layout')
@section('title','Tambah Product')

@section('content')

@if ($errors->any())
  <div class="alert alert-danger">
    <div class="fw-bold mb-1">Terjadi kesalahan:</div>
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('products.store') }}" class="row g-3">
  @csrf

  <div class="col-md-4">
    <label class="form-label">Kode (auto)</label>
    <input name="product_code" class="form-control"
            value="{{ old('product_code', $autocode ?? '') }}" readonly>
    <div class="form-text">Kode dibuat otomatis saat tambah.</div>
    </div>

  <div class="col-md-8">
    <label class="form-label">Nama</label>
    <input name="product_name" class="form-control" required maxlength="200"
           value="{{ old('product_name') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Harga</label>
    <input type="number" step="0.01" name="price" class="form-control" required
           value="{{ old('price', 0) }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Stok</label>
    <input type="number" name="stock_quantity" class="form-control" required
           value="{{ old('stock_quantity', 0) }}">
  </div>

  <div class="col-md-4 form-check mt-4">
    <input class="form-check-input" type="checkbox" name="is_active" id="active"
           {{ old('is_active', true) ? 'checked' : '' }}>
    <label class="form-check-label" for="active">Aktif</label>
  </div>

  <div class="col-12">
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    <button class="btn btn-primary">Simpan</button>
  </div>
</form>
@endsection
