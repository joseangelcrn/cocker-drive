<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cocker Drive - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Icono App -->
    <link rel="shortcut icon" href="{{url('storage/sistema/cocker.jpg')}}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        {{-- Confirm dialog vue component --}}
        <vue-confirm-dialog></vue-confirm-dialog>

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Cocker Drive
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right my-0 py-0"  aria-labelledby="navbarDropdown">
                                    {{--  --}}
                                    <a  class="nav-link bg-secondary text-center text-white rounded-top" href="{{route('fichero.mis-ficheros')}}">
                                        <b>Listar archivos</b>
                                    </a>
                                    <a  class="nav-link bg-success text-center" href="{{route('fichero.create')}}">
                                        <b>Subir archivos</b>
                                    </a>
                                    <a  class="nav-link bg-info text-center" href="{{route('log.index')}}">
                                        <b>Log</b>
                                    </a>
                                    {{--  --}}
                                    <a class="nav-link bg-info text-center text-white bg-dark rounded-bottom" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>


                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @auth
                <div class="container mb-3">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 text-center">
                            <a href="{{route('home')}}">
                                <img class="img-fluid img-thumbnail" id="img_perro_home" src="{{url('storage/sistema/cocker.jpg')}}" alt="Imagen Cocker">
                            </a>
                        </div>
                    </div>
                </div>
            @endauth
            @if (\Session::has('error'))
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <strong class="h4">Oops! </strong> {{\Session::get('error')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <script>
        // document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</body>
</html>
