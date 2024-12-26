@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Data Pengguna</h2>
        </div>
        
        <div class="card-body">
            <!-- Show entries dropdown -->
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-center">
                    Show 
                    <select class="form-select d-inline w-auto mx-2">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    entries
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <form method="GET" action="{{ route('datauser.index') }}" class="mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Search:</span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="" value="{{ request('search') }}" style="max-width: 300px;">
                        </div>
                    </form>
                </div>
            </div>
            

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <a href="{{ route('datauser.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('datauser.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-md-6">
                    Showing 1 to {{ count($users) }} of {{ count($users) }} entries
                </div>
                <div class="col-md-6">
                    <nav class="float-end">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add CSS to match the design -->
<style>
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .table td {
        vertical-align: middle;
    }
    .form-select, .form-control {
        border: 1px solid #dee2e6;
    }
</style>
@endsection