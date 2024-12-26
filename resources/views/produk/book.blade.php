<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ebook Store</title>
    <!-- Tailwind CSS (optional) -->
    <script src="https://cdn.tailwindcss.com"></script>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.pexels.com/photos/2908984/pexels-photo-2908984.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .floating-books {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 50px 20px;
        }
        .book-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 200px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-10px);
        }
        .book-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .book-card h3 {
            font-size: 1.1rem;
            margin: 10px 0;
        }
        .buy-button {
            background: #2563eb;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>
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


    <!-- Product Listing Section -->
    <section class="floating-books">
        @foreach ($produks as $produk)
        <div class="book-card">
            <!-- Assuming $produk->foto contains the filename like 'product_image.jpg' -->
            <img src="{{ $produk->foto }}" width="50" alt="Foto Produk">
            <h3>{{ $produk->nama }}</h3>
            <p>Rp {{ number_format($produk->harga, 0) }}</p>
            <p>{{ $produk->berat }} gram</p>
            <p>{{ $produk->stok }} tersedia</p>
            <a href="{{ route('produk.detail', ['id' => $produk->id]) }}" class="buy-button">Buy Now</a>
        </div>
        @endforeach
    </section>
    
</body>
</html>
