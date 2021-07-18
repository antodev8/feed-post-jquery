<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body class="font-sans antialiased">
<nav class="navbar">
    <div class="navbar__inner">
        <a href="{{route('feed-posts.index')}}">Feed Post</a>



    <div class="flex flex-row items-end">

        <a href="{{route('login.index')}}" class="_evt-login-selected pointer-events-none opacity-50 mr-4">Login</a>



    </div>
</div>
</nav>
<div class="min-h-screen theme-background-color">

    <!-- Page Content -->
    <main>
        @yield('content')

    </main>
</div>
</body>
</html>
