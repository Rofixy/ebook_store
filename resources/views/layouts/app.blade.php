<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    Ebook Store
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="d-flex bg-light" style="height: 150vh">
            @auth
            @if(auth()->check() && auth()->user()->role == 'admin')
            <div class="col-md-2 d-flex flex-column flex-shrink-0 p-3 bg-danger" style="width: 200px; height:calc(100%)">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : 'link-dark' }}" aria-current="{{ request()->is('admin') ? 'page' : '' }}">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Dashboard
                        </a>
                    </li>
            
                    <li class="nav-item">
                        <a href="{{ url('datauser') }}" class="nav-link {{ request()->is('datauser') ? 'active' : 'link-dark' }}" aria-current="{{ request()->is('datauser') ? 'page' : '' }}">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Data Pengguna
                        </a>
                    </li>
            
                    <li class="nav-item">
                        <a href="{{ url('dataproduk') }}" class="nav-link {{ request()->is('dataproduk') ? 'active' : 'link-dark' }}" aria-current="{{ request()->is('dataproduk') ? 'page' : '' }}">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Data Produk
                        </a>
                    </li>
            
                    <li class="nav-item">
                        <a href="{{ url('/datapesanan') }}" class="nav-link {{ request()->is('datapesanan*') ? 'active' : 'link-dark' }}" aria-current="{{ request()->is('datapesanan*') ? 'page' : '' }}">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Data Pesanan
                        </a>
                    </li>
            
                    <li class="nav-item">
                        <a href="{{ url('/cekongkir') }}" class="nav-link {{ request()->is('cekongkir*') ? 'active' : 'link-dark' }}" aria-current="{{ request()->is('cekongkir*') ? 'page' : '' }}">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Ongkir
                        </a>        
                    </li>                           
                </ul>
            </div>
            
            @endif
            @endauth

            <div class="mt-3 col-md-10">@yield('content')</div>

        </main>
    </div>
    
</body>
</html>
