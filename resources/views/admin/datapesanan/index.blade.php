@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Data Pesanan</h2>
        </div>
        
        <div class="card-body">
            <!-- Add Search and Show Entries Dropdown -->
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
                    <form action="{{ route('datapesanan.index') }}" method="GET" id="searchForm">
                        <div class="float-end">
                            Search: 
                            <input type="search" name="search" class="form-control d-inline w-auto" 
                                   value="{{ request('search') }}" onkeyup="searchTable(this.value)">
                            <input type="hidden" name="perPage" id="perPageInput" value="{{ request('perPage', 10) }}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Produk</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Berat</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Jumlah Pesanan</th>
                            <th>Jumlah Harga</th>
                            <th>Pemesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanans as $index => $pesanan)
                            <tr>
                                <td>{{ ($pesanans->currentPage() - 1) * $pesanans->perPage() + $index + 1 }}</td>
                                <td>{{ $pesanan->produk_id }}</td>
                                <td>{{ $pesanan->produk }}</td>
                                <td>Rp {{ number_format($pesanan->harga, 0) }}</td>
                                <td>{{ $pesanan->berat }} gram</td>
                                <td>{{ $pesanan->asal }}</td>
                                <td>{{ $pesanan->tujuan }}</td>
                                <td>{{ $pesanan->tanggal_pesanan }}</td>
                                <td>{{ $pesanan->jumlah_pesanan }}</td>
                                <td>Rp {{ number_format($pesanan->jumlah_harga, 0) }}</td>
                                <td>{{ $pesanan->pemesan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-md-6">
                    Showing {{ $pesanans->firstItem() ?? 0 }} to {{ $pesanans->lastItem() ?? 0 }} of {{ $pesanans->total() }} entries
                </div>
                <div class="col-md-6">
                    <div class="float-end">
                        {{ $pesanans->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
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

@endsection
