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
        input, textarea { box-shadow:0 0 8px rgba(0, 0, 0, 0.25); }
        button { background: gray; }
        button:hover { color: white; background: green; cursor: pointer}
        header, footer { background:#333; color:#fff; padding: 3px 20px; height: 45px;}
        a { color: #1a73e8; }
        .flash-success { background:#e6ffed; border:1px solid #b6f0c6; padding:10px; margin-bottom:15px; }
        .errors { background:#ffe6e6; border:1px solid #f0b6b6; padding:10px; margin-bottom:15px; }
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        td.col-message {
            max-width: 40ch;
            white-space: normal;
        }

        td.col-name { max-width: 18ch; }
        td.col-email { max-width: 28ch; }
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
