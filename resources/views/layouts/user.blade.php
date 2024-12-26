<!DOCTYPE html>
<html lang="{{ str_replace('_', '_', app()->getLocale()) }}">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csfr-token" content="widht-device-width, initial-scale=1">

    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        /* Custom font styles */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body{
            font-family: Poppins!important;
        }
    </style>

    <!-- Asset compilation (using Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Application container -->
    <div id="app">
        <main>
            <!-- Content section (to be filled by child views) -->
            @yield('content')
        </main>
    </div>
</body>
</html>
