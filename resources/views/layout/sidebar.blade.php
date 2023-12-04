{{-- bg hitam --}}
<div class="w-screen h-screen bg-black fixed z-[98] opacity-50 hidden transition ease-in delay-300" id="bg-sidebar"></div>

{{-- sidebar --}}
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
                            <a href="{{ url('/allOrder') }}" class="text-white fw-semibold">Daftar Tunggu</a>
                        </li>
                        <li>
                            <a href="/success" class="text-white fw-semibold">Sukses</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail"
                    class="side-nav-link text-white fw-bold">
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
            <li class="side-nav-title side-nav-item text-white">User Akses</li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="false" aria-controls="sidebarUser"
                    class="side-nav-link text-white fw-bold">
                    <i class="uil-user"></i>
                    <span> User </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUser">
                    <ul class="side-nav-second-level text-white">
                        <li>
                            <a href="{{ route('users.index') }}" class="text-white fw-semibold">Tambah User
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

        <!-- End Sidebar -->
    </div>

    <!-- Sidebar -left -->

</div>
