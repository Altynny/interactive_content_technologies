<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header>
        @include('partials.header')
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>
</body>
</html>
