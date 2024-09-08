<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>        
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        
            <!-- CSRF Token -->
            <meta name="csrf-token" content="{{ csrf_token() }}">
        
            <title>{{ config('app.name', 'Магазин для хобби и творчества') }}</title>
        
            <!-- Fonts -->
            <link rel="dns-prefetch" href="//fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

            <style type="text/css">
                #myfooter a {
                color: gray;
                font-family: helvetica;
                text-decoration: none;
                text-transform: uppercase;
                }
                #myfooter a:hover {
                text-decoration: underline;
                }
                #myHeader a {
                color: gray;
                font-family: helvetica;
                text-decoration: none;
                text-transform: uppercase;
                }
                #myHeader a:hover {
                text-decoration: underline;
                }
            </style>

            <!-- Scripts -->
            @vite(['resources/sass/app.scss', 'resources/js/app.js'])        
    </head>
    <body style="background: rgb(252,249,190);
                background: radial-gradient(circle, rgba(252,249,190,1) 0%, rgba(252,251,249,1) 29%);
                height: 100vh;
                ">
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/images/mainicon.ico" alt="" width="30" height="30" class="d-inline-block align-text-top">
                        Магазин для хобби и творчества
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
                                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                                    </li>
                                @endif
    
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">Зарегистрироваться</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
    
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        @can('admin-show', Auth::user())
                                        <a class="dropdown-item" href="/admin">Администрирование</a>
                                        @endcan
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Выйти
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
            <div class="container">                
                    {{ $slot }} 
            </div>             
        </div>               
    </body> 
</html>
