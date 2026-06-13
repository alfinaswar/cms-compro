<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Fixed Sidebar</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('') }}assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>



            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item d-flex align-items-center">
                    <span class="mr-3 font-weight-semibold"
                        style="font-size: 1rem;">{{ now()->translatedFormat('l, d F Y H:i') }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="margin-bottom: 0;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm"
                            style="background-color: #dc3545; border-color: #dc3545;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>

                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link bg-white">
                <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
                    alt="{{ $websiteSettings->NamaPerusahaan ?? 'Logo' }}" width="230px">
                {{-- <span class="brand-text font-weight-light">{{ $websiteSettings->NamaPerusahaan ?? 'Jasuindo' }}</span> --}}
            </a>



            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('') }}assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $websiteSettings->NamaPerusahaan ?? '-' }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('') }}assets/index.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard v1</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('') }}assets/index2.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard v2</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('') }}assets/index3.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard v3</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Widgets
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Blog / Berita</li>
                        <li class="nav-item">
                            <a href="{{ route('berita.index') }}"
                                class="nav-link {{ request()->segment(1) == 'berita' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Blog / Berita
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Karir dan Rekrutmen</li>
                        <li class="nav-item">
                            <a href="{{ route('karir.index') }}"
                                class="nav-link {{ request()->segment(1) == 'karir-dan-rekrutmen' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>
                                    Karir dan Rekrutmen
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Manajemen Akun</li>
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'manajemen-akun' ? 'menu-open' : '' }}">

                            <a href="#"
                                class="nav-link {{ request()->segment(1) == 'manajemen-akun' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Manajemen Akun
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link {{ request()->segment(2) == 'users' ? 'active' : '' }}">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link {{ request()->segment(2) == 'roles' ? 'active' : '' }}">
                                        <i class="fas fa-user-shield nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-header">Data Master</li>
                        <li class="nav-item has-treeview menu-open">
                            <a href="#"
                                class="nav-link {{ request()->segment(1) == 'data-master' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Data Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('kategori-berita.index') }}"
                                        class="nav-link {{ request()->segment(2) == 'kategori-berita' ? 'active' : '' }}">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Kategori Berita</p>
                                    </a>
                                </li>
                                <!-- Tambahkan data master lain di sini jika ada -->
                            </ul>
                        </li>

                        <li class="nav-header">Pengaturan Website</li>
                        <li class="nav-item">
                            <a href="{{ route('pengaturan-website.edit') }}"
                                class="nav-link {{ request()->segment(2) == 'pengaturan-website' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Pengaturan Website
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'menu' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(1) == 'menu' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>
                                    Menu
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('menu.index') }}"
                                        class="nav-link {{ request()->segment(1) == 'menu' && request()->segment(2) == null ? 'active' : '' }}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Menu List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('menu.create') }}"
                                        class="nav-link {{ request()->segment(1) == 'menu' && request()->segment(2) == 'create' ? 'active' : '' }}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Tambah Menu</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('log.index') }}"
                                class="nav-link {{ request()->segment(2) == 'activity-log' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Log Aktifitas
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>


        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            </div>
            <strong>Copyright &copy; {{ date('Y') }} {{ $websiteSettings->NamaPerusahaan }}.</strong>

            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('') }}assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('') }}assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('') }}assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('') }}assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('') }}assets/dist/js/demo.js"></script>
    <!-- DataTables -->
    <script src="{{ asset('') }}assets/plugins/datatables/jquery.dataTables.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('') }}assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
