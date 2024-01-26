<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet" />

    <!-- Style Sheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary" id="app-Nav">
            <div class="container">
                <button type="button" class="bg-transparent" data-bs-toggle="offcanvas" href="#sideDrawer" role="button" style="border: none; margin-right: 16px">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if( auth()->user()->hasRole('admin') )
                                <a class="dropdown-item" href="/admin" target="_blank">
                                    Admin Panel
                                </a>
                                <a class="dropdown-item" href="/search" target="_blank">
                                    Search
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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

        <div class="offcanvas offcanvas-start" tabindex="-1" id="sideDrawer" aria-labelledby="sideDrawer">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">AZIZI ARF</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="list-group" id="sideDrawerList">
                    <a href="/" class="list-group-item list-group-item-action drawer-li active" aria-current="true" id="sideDrawerListItem1">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Home</h5>
                        <small><i class="fa fa-home"></i></small>
                        </div>
                        <p class="mb-1">Navigate to Home Screen</p>
                        <p>Go to Home Page</p>
                    </a>
                    <a href="/admin" class="list-group-item drawer-li list-group-item-action" id="sideDrawerListItem2">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Admin Panel</h5>
                        <small> <i class="fa fa-cube"></i>  </small>
                        </div>
                        <p class="mb-1">Open Admin Panel Controls</p>
                        <p>Open Controls of Admin Panel</p>
                    </a>
                    <a href="/upload-assets" class="list-group-item drawer-li list-group-item-action" id="sideDrawerListItem3">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Upload Assets</h5>
                        <small><i class="fa fa-upload"></i></small>
                        </div>
                        <p class="mb-1">Open Upload Asset</p>
                        <p>Upoad Assets to the Asset System</p>
                    </a>
                    <a href="/search" class="list-group-item drawer-li list-group-item-action" id="sideDrawerListItem4">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Search</h5>
                        <small><i class="fa fa-search"></i></small>
                        </div>
                        <p class="mb-1">Search Assets in System</p>
                        <p>Open Search App</p>
                    </a>
                </div>
            </div>
        </div>

        <main class="py-4">
            <div class="spinner-border text-primary position-fixed top-50 start-50 d-none" id="site-loader" style="z-index: 10000" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('javascript')
</body>

</html>