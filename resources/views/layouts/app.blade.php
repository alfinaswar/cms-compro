<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $websiteSettings->NamaPerusahaan ?? 'Admin' }}</title>
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
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . ($websiteSettings->PathFavicon ?? '-')) }}"
        title="{{ $websiteSettings->NamaPerusahaan ?? 'Admin' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    <style>
        /* Modern Sidebar Styling */
        .main-sidebar {
            background: linear-gradient(180deg, #1a202c 0%, #2d3748 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-sidebar .nav-header {
            padding: 0.75rem 1rem 0.5rem;
            font-weight: 700;
            color: #a0aec0 !important;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-sidebar .nav-link {
            border-radius: 8px;
            margin: 2px 8px;
            padding: 10px 12px;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            color: #cbd5e0;
        }

        .nav-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            border-left: 3px solid #4299e1;
            transform: translateX(3px);
            color: #fff;
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(90deg, #4299e1 0%, #3182ce 100%);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
            border-left: 3px solid #fff;
        }

        .nav-sidebar .nav-link.active i.nav-icon {
            color: #fff !important;
        }

        .nav-sidebar .nav-treeview .nav-link {
            margin: 2px 8px 2px 20px;
            font-size: 14px;
            border-left: 3px solid transparent;
            color: #a0aec0;
        }

        .nav-sidebar .nav-treeview .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 3px solid #4299e1;
            color: #fff;
        }

        .nav-sidebar .nav-treeview .nav-link.active {
            background: rgba(66, 153, 225, 0.15);
            color: #4299e1 !important;
            border-left: 3px solid #4299e1;
            box-shadow: none;
        }

        .nav-sidebar .nav-treeview .nav-link.active i.nav-icon {
            color: #4299e1 !important;
        }

        .nav-sidebar .nav-icon {
            width: 24px;
            text-align: center;
            font-size: 16px;
        }

        .nav-sidebar .nav-treeview .nav-icon {
            font-size: 10px;
        }

        .nav-sidebar .badge {
            font-size: 10px;
            padding: 3px 6px;
        }

        /* Brand Logo */
        .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 16px;
        }

        /* User Panel */
        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-panel .info a {
            color: #fff;
            font-weight: 600;
        }

        /* Scrollbar Custom */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Treeview Animation */
        .nav-treeview {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
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

        @include('layouts.sidebar-main')
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
