<!DOCTYPE html>
<html lang="en">
<head>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
    /* Previous styles remain the same */
    .floating-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        animation: slideIn 0.5s ease-out;
    }

    .floating-card {
        animation: fadeIn 0.5s ease-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .checkout-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .info-item label {
        font-weight: bold;
        color: #495057;
    }

    .info-item span {
        color: #212529;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Updated header styles */
    .header-container {
        background-color: #1f2937;
        padding: 1rem;
    }

    .nav-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-brand img {
        width: 32px;
        height: 32px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .nav-link {
        color: white;
        text-decoration: none;
        transition: color 0.2s;
    }

    .nav-link:hover {
        color: #9ca3af;
    }

    .auth-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dropdown-menu {
        background-color: white;
        border-radius: 0.375rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        min-width: 10rem;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        color: #1f2937;
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
    }
    </style>
</head>
<body>
    <header class="header-container">
        <div class="nav-wrapper">
            <div class="nav-brand">
                <a href="{{ url('/home') }}" class="nav-link">
                    <img src="https://cdn-icons-png.freepik.com/256/6755/6755904.png" alt="Ebook Store">
                </a>
                <div class="nav-links">
                    <a href="{{ route('produk.book') }}" class="nav-link">Produk</a>
                    <a href="{{ url('/cekongkos') }}" class="nav-link">Cek Ongkir</a>
                </div>
            </div>

            <div class="auth-section">
                @guest
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endif
                @else
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profil</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Rest of the content remains the same -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show floating-alert" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card floating-card">
                    <div class="card-header">Detail Checkout</div>
                    <div class="card-body">
                        <div class="checkout-info">
                            <div class="info-item">
                                <label>Produk:</label>
                                <span>{{ $produk->nama }}</span>
                            </div>
                            <div class="info-item">
                                <label>Harga Satuan:</label>
                                <span>Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <label>Berat:</label>
                                <span>{{ $produk->berat }} kg</span>
                            </div>
                            <div class="info-item">
                                <label>Pengiriman:</label>
                                <span>{{ $alamat_pengiriman ?? 'Belum ditentukan' }}</span>
                            </div>
                            <div class="info-item">
                                <label>Tanggal Pesanan:</label>
                                <span>{{ now()->format('d-m-Y') }}</span>
                            </div>
                            <div class="info-item">
                                <label>Jumlah Pesanan:</label>
                                <span>{{ $jumlah_pesanan ?? 1 }}</span>
                            </div>
                            <div class="info-item">
                                <label>Total Harga:</label>
                                <span>Rp {{ number_format(($produk->harga ?? 0) * ($jumlah_pesanan ?? 1), 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <label>Pemesan:</label>
                                <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    </script>
</body>
</html>