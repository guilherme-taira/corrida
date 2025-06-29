<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ForLife') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap + seus estilos -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/forlife.css') }}" rel="stylesheet"> <!-- Se tiver CSS próprio -->

 <style>

    .main-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 40px; /* mais espaçamento lateral */
        background: #444444;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .main-nav .logo {
        margin-left: 40px; /* força a logo a ir mais para a direita */
    }

    .main-nav .logo img.logomarca {
        height: 60px;
    }

    .main-nav .nav {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 30px;
    }

    .main-nav .nav li a {
        text-decoration: none;
        color: #ffffff;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 4px;
        transition: background 0.3s, color 0.3s;
    }

    .main-nav .nav li a:hover {
        background: #ffffff;
        color: #444444;
    }

    .menu-trigger {
        display: none;
    }
</style>
</head>
<body>

    <!-- NAV customizado da ForLife -->
    <nav class="main-nav">
        <!-- ***** Logo Start ***** -->
        <a href="https://forlifesports.com.br" class="logo">
            <img src="https://forlifesports.com.br/images/logo.png" class="logomarca" alt="ForLife Sports">
        </a>
        <!-- ***** Logo End ***** -->

        <!-- ***** Menu Start ***** -->
        <ul class="nav">
            <li class="scroll-to-section"><a href="">Resultados</a></li>
            <li class="scroll-to-section d-none"><a href="#about">Sobre Nós</a></li>
        </ul>

        <a class="menu-trigger">
            <span>Menu</span>
        </a>
        <!-- ***** Menu End ***** -->
    </nav>

    <!-- Vue monta aqui -->
    <div id="app">
        @yield('content')
    </div>

    @vite('resources/js/app.js')
</body>
</html>
