<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
    <!-- My CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('css')

    <title>@yield('title')</title>
  </head>
  <body>

    <!-- navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('home') }}">TDWR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav text-center">
                    @if(Auth::user()->role == 'admin')
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">Dashboard</a>
                    @endif
                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('home') }}">Home</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a class="btn btn-sm btn-primary" href="{{ url('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- content -->
    <div class="container" style="margin-top:80px;">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>
    <!-- jquery -->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <!-- vue -->
    <script src="{{ asset('assets/js/vue.js') }}"></script>
    <!-- axios -->
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            iconColor: 'green',
            background: 'rgb(91, 255, 96)'
        })
    </script>

    @stack('js')
  </body>
</html>
