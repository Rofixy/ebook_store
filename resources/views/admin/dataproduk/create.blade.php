@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Produk</h2>
    <form action="{{ route('dataproduk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Produk</label>
            <input type="file" name="foto" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label for="berat" class="form-label">Berat (Gram)</label>
            <input type="number" name="berat" class="form-control" value="{{ old('berat') }}" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
        </div>
        <div class="mb-3">
            <label for="detail" class="form-label">Detail</label>
            <textarea name="detail" id="detail" class="form-control" rows="4">{{ old('detail') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
