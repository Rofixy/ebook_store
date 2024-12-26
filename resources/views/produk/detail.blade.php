<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Produk</title>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header Section -->
    <header class="bg-gray-800 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <!-- Logo Ebook Store -->
                <h2 class="text-2xl font-bold">
                    <a href="{{ url('/home') }}" class="text-white hover:text-gray-400 flex items-center space-x-2">
                        <!-- Anda bisa mengganti gambar di sini untuk logo -->
                        <img src="https://cdn-icons-png.freepik.com/256/6755/6755904.png?ga=GA1.1.86402026.1709632989&semt=ais_hybrid" alt="Ebook Store" class="w-8 h-8">
                    </a>
                </h2>
            
                <!-- Navigasi produk dan cek ongkir -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('produk.book') }}" class="text-white hover:text-gray-400">Produk</a>
                    <a href="{{ url('/cekongkos') }}" class="text-white hover:text-gray-400">Cek Ongkir</a>
                </div>
            </div>
            
            @if (Route::has('login'))
            <nav class="flex space-x-4">
                @auth
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                </a>
                            </li>
                        @endif
                
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> {{ __('Register') }}
                                </a>
                            </li>
                        @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profil</a>
                            </li>
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
                    </li>
                    
                    @endguest
                </ul>                
                @else
                    <a href="{{ url('login') }}" class="hover:text-gray-400"><i class="fas fa-sign-in-alt"></i> Login</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hover:text-gray-400"><i class="fas fa-user-plus"></i> Register</a>
                    @endif
                @endauth
            </nav>
            @endif
        </div>
    </header>


    <div class="container mx-auto p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex flex-col lg:flex-row">
                <!-- Gambar Produk -->
                <div class="flex-shrink-0">
                    <img src="{{ $produk->foto }}" alt="{{ $produk->nama }}" class="w-12 h-12 object-cover rounded-lg">
                </div>            
                <!-- Detail Produk -->
                <div class="lg:ml-8 mt-6 lg:mt-0">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $produk->nama }}</h1>
                    <p class="text-gray-600 mt-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p class="text-gray-600 mt-2">Berat: {{ $produk->berat }} gram</p>
                    <p class="text-gray-600 mt-2">Stok: {{ $produk->stok }} tersedia</p>
                    <p class="text-gray-600 mt-4">{{ $produk->deskripsi }}</p>

                    <!-- Tombol Checkout -->
                    <button id="checkoutButton" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Checkout
                    </button>
                    <a href="{{ route('produk.book') }}" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 inline-block">
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-up Checkout -->
    <div id="checkoutModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4">Checkout</h2>
            <form action="{{ route('checkout.store', $produk->id) }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="produk" value="{{ $produk->nama }}">
                <input type="hidden" name="harga" value="{{ $produk->harga }}">
                <input type="hidden" name="berat" value="{{ $produk->berat }}">

                <div class="flex flex-col space-y-4">
                    <label for="asal" class="text-gray-600">Alamat Asal:</label>
                    <input type="text" id="asal" name="asal" required class="p-2 border rounded">

                    <label for="tujuan" class="text-gray-600">Alamat Tujuan:</label>
                    <input type="text" id="tujuan" name="tujuan" required class="p-2 border rounded">

                    <label for="jumlah_pesanan" class="text-gray-600">Jumlah:</label>
                    <input type="number" id="jumlah_pesanan" name="jumlah_pesanan" value="1" min="1" max="{{ $produk->stok }}" class="p-2 border rounded" oninput="updateTotalPrice()">

                    <input type="hidden" name="tanggal_pesanan" value="{{ now() }}">
                    <input type="hidden" id="jumlah_harga" name="jumlah_harga" value="{{ $produk->harga * 1 }}">

                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Confirm Checkout
                    </button>
                </div>
            </form>
            <button id="closeModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Close
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkoutButton = document.getElementById('checkoutButton');
            const checkoutModal = document.getElementById('checkoutModal');
            const closeModal = document.getElementById('closeModal');
            
            // Show the modal
            checkoutButton.addEventListener('click', () => {
                checkoutModal.classList.remove('hidden');
            });

            // Hide the modal
            closeModal.addEventListener('click', () => {
                checkoutModal.classList.add('hidden');
            });

            // Close the modal when clicking outside of it
            checkoutModal.addEventListener('click', (e) => {
                if (e.target === checkoutModal) {
                    checkoutModal.classList.add('hidden');
                }
            });
        });

        function updateTotalPrice() {
            const quantity = document.getElementById('jumlah_pesanan').value;
            const pricePerItem = {{ $produk->harga }};
            const totalPrice = quantity * pricePerItem;
            document.getElementById('jumlah_harga').value = totalPrice;
        }
    </script>
</body>
</html>
