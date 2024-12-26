@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pengguna</h2>
    <form action="{{ route('datauser.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
        </div>
        <div class="form-group">
            <label for="gender">Jenis Kelamin</label>
            <select name="gender" class="form-control" required>
                <option value="Laki-Laki" {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Alamat</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <div class="form-group">
            <label for="phone">Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
