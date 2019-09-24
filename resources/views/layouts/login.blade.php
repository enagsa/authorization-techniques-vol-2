<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>@yield('meta-title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/favicon.ico') }}">
    <link href="{{ asset('/css/fuentes.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/estilos.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/scripts.js') }}"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('/safari-pinned-tab.svg') }}" color="#00ae88">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="login-page">
    <section class="background-shadow">
        <main>
            <img src="{{ asset('/medios/logo.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}"/>
            @yield('content')
        </main>
    </section>
</body>
</html>