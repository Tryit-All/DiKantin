{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are a admin') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <!-- bootstrap 5 css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous" />

    {{-- meta data  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- databale --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">


    <!-- custom css -->
    <link rel="stylesheet" href="/css/style.css" />
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <style>
        li {
            list-style: none;
            margin: 20px 0 20px 0;
        }

        a {
            text-decoration: none;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            margin-left: -300px;
            transition: 0.4s;
        }

        .active-main-content {
            margin-left: 250px;
        }

        .active-sidebar {
            margin-left: 0;
        }

        #main-content {
            transition: 0.4s;
        }
    </style>
    {{-- <title>{{ $title }}</title> --}}
</head>

<body style=" background: #D0E3ED;">
    <div>
        <div class="sidebar p-4" id="sidebar" style="background: #51AADD">
            <h4 class="text-white">DiKantin</h4>
            <hr class="text-white">

            <li>
                <a class="text-white text-decoration-none" href="/dashboard">
                    <i class="bi bi-house mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="/kasir">
                    <i class="bi bi-fire mr-2"></i>
                    Kasir
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="/waitinglist">
                    <i class="bi bi-newspaper mr-2"></i>
                    Waiting List
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="/success">
                    <i class="bi bi-bicycle mr-2"></i>
                    Success
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="/menu">
                    <i class="bi bi-boombox mr-2"></i>
                    Menu
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="/customer">
                    <i class="bi bi-film mr-2"></i>
                    Customer
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="#">
                    <i class="bi bi-bookmark mr-2"></i>
                    Penjualan
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="#">
                    <i class="bi bi-bookmark mr-2"></i>
                    Detail Penjualan
                </a>
            </li>
            <li>
                <a class="text-white text-decoration-none" href="/user">
                    <i class="bi bi-bookmark mr-2"></i>
                    Tambah User
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </div>
    </div>
    <div class="p-4" id="main-content">
        {{-- <div class="d-flex justify-content-between"> --}}
        <button class="btn text-white" id="button-toggle" style="background: #51AADD">
            <i class="bi bi-list"></i>
        </button>
        <!-- Example single danger button -->
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{-- {{ Auth::user()->name }} --}}
            </button>
            <ul class="dropdown-menu">
                <li> <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{-- {{ Auth::user()->name }} --}}
                    </a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
    </div>

    <div class="card mt-2" style="border: none; outline: none;background: #D0E3ED;">
        <div class="card-body" style="border: none; outline: none;">
            @yield('content')
        </div>
    </div>
    </div>

    <script>
        // event will be executed when the toggle-button is clicked
        document.getElementById("button-toggle").addEventListener("click", () => {

            // when the button-toggle is clicked, it will add/remove the active-sidebar class
            document.getElementById("sidebar").classList.toggle("active-sidebar");

            // when the button-toggle is clicked, it will add/remove the active-main-content class
            document.getElementById("main-content").classList.toggle("active-main-content");
        });
    </script>


    {{-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> --}}
    {{-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    @stack('script');

</body>

</html>
