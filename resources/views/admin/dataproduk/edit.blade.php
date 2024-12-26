@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Produk</h2>
    <form action="{{ route('dataproduk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Produk</label>
            <input type="file" name="foto" class="form-control">
            @if($produk->foto)
                <img src="{{ asset('storage/images/' . $produk->foto) }}" width="100" alt="Foto Produk">
            @endif
        </div>
        
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="berat" class="form-label">Berat (Gram)</label>
            <input type="number" name="berat" class="form-control" value="{{ old('berat', $produk->berat) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $produk->alamat) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="detail" class="form-label">Detail</label>
            <textarea name="detail" id="detail" class="form-control" rows="4">{{ old('detail', $produk->detail) }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
