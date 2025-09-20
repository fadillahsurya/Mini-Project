@extends('layout')
@section('title','Edit Product')

@section('content')
<form method="POST" action="{{ route('products.update',$product->product_id) }}" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-4">
    <label class="form-label">Kode</label>
    <input name="product_code" class="form-control" required maxlength="20" value="{{ $product->product_code }}">
  </div>
  <div class="col-md-8">
    <label class="form-label">Nama</label>
    <input name="product_name" class="form-control" required maxlength="200" value="{{ $product->product_name }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Harga</label>
    <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Stok</label>
    <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
  </div>
  <div class="col-md-4 form-check mt-4">
    <input class="form-check-input" type="checkbox" name="is_active" id="active"
           {{ $product->is_active ? 'checked' : '' }}>
    <label class="form-check-label" for="active">Aktif</label>
  </div>
  <div class="col-12">
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    <button class="btn btn-primary">Update</button>
  </div>
</form>
@endsection
