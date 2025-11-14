<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')

    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; background:#f7f7f7; }
        .container { min-height: calc(100vh - 130px); margin: 20px auto; background:#fff; padding:20px; box-shadow:0 0 8px rgba(0,0,0,0.05); }
        header, footer { background:#333; color:#fff; padding: 3px 20px; height: 45px;}
        a { color: #1a73e8; }
        table { width:100%; border-collapse:collapse; }
        table th, table td { border:1px solid #ddd; padding:8px; text-align:left; }
    </style>
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
