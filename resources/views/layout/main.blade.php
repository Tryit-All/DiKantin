<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DiKantin | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('img/logo-kotak.png') }}">
    {{-- databale --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <!-- third party css -->
    <link href="{{ URL::asset('assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- App css -->
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ URL::asset('css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> --}}

    {{-- @vite('resources/css/app.css') --}}

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}',
    style="background: #D0E3ED">

    <!--   Begin page -->
    <div class="wrapper">
        @include('sweetalert::alert')
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">
            <!-- LOGO -->
            <a href="/dashboard" class="logo text-center logo-light">
                <span class="logo-lg" style="background-color: white">
                    <img src="{{ URL::asset('img/logo-gab1.png') }}" alt="" width="200">
                </span>
                <span class="logo-sm" style="background-color: white">
                    <img src="{{ URL::asset('img/logo-kotak.png') }}" alt="" width="63">
                </span>

            </a>
            <div class="sidebar text-white h-100" id="leftside-menu-container" data-simplebar=""
                style="background-color: #51AADD">

                <!--- Sidemenu -->
                @if ((auth()->user()->id_role == 1))
                    <ul class="side-nav">
                        <li class="side-nav-title side-nav-item text-white">Menu</li>
                        <li class="side-nav-item text-white">
                            <a href="/dashboard" class="side-nav-link text-white fw-bold">
                                <i class="uil uil-home"></i>
                                <span> Dashboard</span>
                            </a>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/kasir" class="side-nav-link text-white fw-bold">
                                <i class="uil-receipt-alt"></i>
                                <span> Kasir </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
                                aria-controls="sidebarEcommerce" class="side-nav-link text-white fw-bold">
                                <i class="uil-store"></i>
                                <span> Order</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarEcommerce">
                                <ul class="side-nav-second-level text-white">

                                    <li>
                                        <a href="{{ url('/allOrder') }}" class="text-white fw-semibold">Daftar
                                            Tunggu</a>
                                    </li>
                                    <li>
                                        <a href="/success" class="text-white fw-semibold">Sukses</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false"
                                aria-controls="sidebarEmail" class="side-nav-link text-white fw-bold">
                                <i class="uil-database"></i>
                                <span> Data </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarEmail">
                                <ul class="side-nav-second-level text-white">
                                    <li>
                                        <a href="/transaksi" class="text-white fw-semibold">Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="/menuAll" class="text-white fw-semibold">Menu</a>
                                    </li>
                                    <li>
                                        <a href="/pelanggan" class="text-white fw-semibold">Customer</a>
                                    </li>
                                    <li>
                                        <a href="/penjualan" class="text-white fw-semibold">Penjualan</a>
                                    </li>
                                    <li>
                                        <a href="/detailpenjualan" class="text-white fw-semibold">Detail Penjualan</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/laporan" class="side-nav-link text-white fw-bold">
                                <i class="uil-chart"></i>
                                <span> Laporan </span>
                            </a>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/rekapitulasi" class="side-nav-link text-white fw-bold">
                                <i class="uil-file"></i>
                                <span> Rekapitulasi</span>
                            </a>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/kurirr" class="side-nav-link text-white fw-bold">
                                <i class="uil-receipt-alt"></i>
                                <span> Rekap Kurir </span>
                            </a>
                        </li>
                        <li class="side-nav-title side-nav-item text-white">User Akses</li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="false"
                                aria-controls="sidebarUser" class="side-nav-link text-white fw-bold">
                                <i class="uil-user"></i>
                                <span> User </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarUser">
                                <ul class="side-nav-second-level text-white">
                                    <li>
                                        <a href="{{ route('users.index') }}" class="text-white fw-semibold">Tambah
                                            User
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('roles.index') }}" class="text-white fw-semibold">Tambah
                                            Role</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item text-red">

                            <a class="side-nav-link fw-bold text-red" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                        Swal.fire({
                            title: '<span>Apakah Ingin Logout?</span>',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'YA',
                            cancelButtonText: 'BATAL',
                            width:'400px'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                
                @elseif(auth()->user()->id_role == 4)
                    <ul class="side-nav">
                        <li class="side-nav-title side-nav-item text-white">Menu</li>
                        <li class="side-nav-item text-white">
                            <a href="/dashboard" class="side-nav-link text-white fw-bold">
                                <i class="uil uil-home"></i>
                                <span> Dashboard</span>
                            </a>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/kasir" class="side-nav-link text-white fw-bold">
                                <i class="uil-receipt-alt"></i>
                                <span> Kasir </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
                                aria-controls="sidebarEcommerce" class="side-nav-link text-white fw-bold">
                                <i class="uil-store"></i>
                                <span> Order</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarEcommerce">
                                <ul class="side-nav-second-level text-white">
                                    <li>
                                        <a href="/success" class="text-white fw-semibold">Sukses</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item text-red">

                            <a class="side-nav-link fw-bold text-red" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                        Swal.fire({
                            title: '<span>Apakah Ingin Logout?</span>',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'YA',
                            cancelButtonText: 'BATAL',
                            width:'400px'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                @elseif((auth()->user()->id_role == 5)||(auth()->user()->id_role == 2))
                
                    <ul class="side-nav">
                        <li class="side-nav-item text-white">
                            <a href="/dashboard" class="side-nav-link text-white fw-bold">
                                <i class="uil uil-home"></i>
                                <span> Dashboard</span>
                            </a>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/laporan" class="side-nav-link text-white fw-bold">
                                <i class="uil-chart"></i>
                                <span> Laporan </span>
                            </a>
                        </li>
                        <li class="side-nav-item text-white">
                            <a href="/rekapitulasi" class="side-nav-link text-white fw-bold">
                                <i class="uil-file"></i>
                                <span> Rekapitulasi</span>
                            </a>
                        </li>
                          <li class="side-nav-item text-white">
                            <a href="/kurirr" class="side-nav-link text-white fw-bold">
                                <i class="uil-receipt-alt"></i>
                                <span> Rekap Kurir </span>
                            </a>
                        </li>

                        <li class="side-nav-item text-red">

                            <a class="side-nav-link fw-bold text-red" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                        Swal.fire({
                            title: '<span>Apakah Ingin Logout?</span>',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'YA',
                            cancelButtonText: 'BATAL',
                            width:'400px'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                @endif
              
               

                <!-- End Sidebar -->
            </div>

            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list d-lg-none">

                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">

                                    <img src="{{ url('/').'/profile/'.auth()->user()->foto }}" alt="" class="rounded-circle"
                                        style="width: 30px; height: 30px; object-fit:cover;">
                                </span>
                                <span>
                                    <span class="account-user-name">
                                        {{ auth()->user()->username }}
                                    </span>
                                    <span class="account-position">{{ auth()->user()->email }}</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Selamat Datang !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('users.edit', auth()->user()->id_role) }}"
                                    class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>Akun Saya</span>
                                </a>


                                <a class="dropdown-item notify-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                Swal.fire({
                                    title: '<span>Apakah Ingin Logout?</span>',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'YA',
                                    cancelButtonText: 'BATAL',
                                    width:'400px'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('logout-form').submit();
                                    }
                                });">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>


                </div>
                <!-- end Topbar -->

                <!-- Start Content-->

                @yield('content')
            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Dikantin
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>

    <!-- /End-bar -->

    <!-- bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ URL::asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ URL::asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- third party js ends -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- demo app -->
    <script src="{{ URL::asset('assets/js/pages/demo.dashboard.js') }}"></script>
    <!-- end demo js-->

    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- Include library SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    {{-- <script src="path/to/sweetalert2.min.js"></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('635466c2765ece12d468', {
            cluster: 'ap1',
        });

        var channel = pusher.subscribe("{{ auth()->user()->id }}");
        channel.bind('pusher:subscription_succeeded', function(members) {
            console.log('successfully subscribed!');
        });

        channel.bind('App\\Events\\OrderNotification', function(data) {
            console.log("test" + data);
        });
        // channel.bind('OrderNotification', function(data) {})
    </script>
    @stack('script');

    @yield('footer')

</body>

</html>


</html>
