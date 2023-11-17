<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    {{-- datable --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="/css/admin.css" />


    <title>{{ $title }}</title>
</head>

<body>
    <div class="d-flex" id="wrapper" style="background: #D0E3ED">
        <!-- Sidebar -->
        <div class="bg-sidebar" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 fs-4 fw-bold text-uppercase border-bottom text-white"><a
                    href="" class="text-white text-decoration-none"><i
                        class="fas fa-user-secret me-2"></i>DIKANTIN</a></div>
            <div class="list-group list-group-flush my-3">
                <div class="efek">
                    <a href="/dashboard" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class='bx bxs-dashboard me-2 fw-bold'></i>Dashboard</a>

                </div>
                <div class="efek">
                    <a href="/kasir" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class='bx bxs-edit me-2 fw-bold'></i>Kasir</a>
                </div>
                <div class="efek">
                    <a href="/waiting" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class='bx bx-time me-2 fw-bold'></i>Waiting List</a>
                </div>
                <div class="efek">
                    <a href="/succes" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class="fa-sharp fa-solid fa-check me-2"></i>Success</a>
                </div>
                <div class="efek">
                    <a href="/menu" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class='bx bx-food-menu fw-bold me-2'></i>Menu</a>
                </div>
                <div class="efek">
                    <a href="/customer" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class="fas fa-solid fa-users fw-bold me-2"></i>Customer</a>
                </div>
                <div class="efek">
                    <a href="/penjualan" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class="fas fa-solid fa-users fw-bold me-2"></i>Penjualan</a>
                </div>
                <div class="efek">
                    <a href="/detail_penjualan" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                            class="fas fa-solid fa-users fw-bold me-2"></i>Detail Penjualan</a>
                </div>
                <div class="efek align-items-end">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action bg-transparent fw-bold"><i
                                class="fas fa-power-off me-2"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>
        @yield('content')

        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        {{-- <script src={{ url('vendor/jquery-ui-1') }}></script> --}}
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        @stack('script')

        <script src="{{ url('script/search.js') }}"></script>
</body>

</html>
