@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Data Produk</h2>
        </div>
        
        <div class="card-body">
            <!-- Show entries dropdown and Search -->
            <div class="row mb-3">
                <div class="col-md-6">
                    Show 
                    <select class="form-select d-inline w-auto" id="perPage" onchange="updatePerPage(this.value)">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    entries
                </div>
                <div class="col-md-6">
                    <form action="{{ route('dataproduk.index') }}" method="GET" id="searchForm">
                        <div class="float-end">
                            Search: 
                            <input type="search" name="search" class="form-control d-inline w-auto" 
                                   value="{{ request('search') }}" onkeyup="searchTable(this.value)">
                            <input type="hidden" name="perPage" id="perPageInput" value="{{ request('perPage', 10) }}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Product Button -->
            <a href="{{ route('dataproduk.create') }}" class="btn btn-success mb-3">Tambah Produk</a>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Berat</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Alamat</th>
                            <th>Detail</th> <!-- New Detail Column -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $index => $produk)
                            <tr>
                                <td>{{ ($produks->currentPage() - 1) * $produks->perPage() + $index + 1 }}</td>
                                <td><img src="{{ $produk->foto }}" width="50" alt="Foto Produk"></td>
                                <td>{{ $produk->nama }}</td>
                                <td>{{ $produk->berat }} gram</td>
                                <td>{{ $produk->stok }}</td>
                                <td>Rp {{ number_format($produk->harga, 0) }}</td>
                                <td>{{ $produk->alamat }}</td>
                                <td>{{ Str::limit($produk->detail, 50) }}</td> <!-- Show the first 50 characters of the detail -->
                                <td>
                                    <a href="{{ route('dataproduk.edit', $produk->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('dataproduk.destroy', $produk->id) }}" method="POST" style="display:inline;">
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
                    Showing {{ $produks->firstItem() ?? 0 }} to {{ $produks->lastItem() ?? 0 }} of {{ $produks->total() }} entries
                </div>
                <div class="col-md-6">
                    <div class="float-end">
                        {{ $produks->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let searchTimer;

    function searchTable(value) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);
    }

    function updatePerPage(value) {
        document.getElementById('perPageInput').value = value;
        document.getElementById('searchForm').submit();
    }
</script>
@endpush

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
    .img-thumbnail {
        max-width: 50px;
        height: auto;
    }
</style>

@endsection
