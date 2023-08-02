<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Laporan Pemeliharaan</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('theme/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('theme/dist/js/adminlte.js') }}"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('theme/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('theme/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <!-- <script src="{{ asset('theme/plugins/chart.js/Chart.min.js') }}"></script> -->

    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{ asset('theme/dist/js/demo.js') }}"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('theme/dist/js/pages/dashboard2.js') }}"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    

</head>
<body>
    <div id="app">
        @php
            $route = Route::current();
            $name = $route->getName();
            $split = explode(".", $name);
            $routeSelected = $split[0];
            $auth_user = auth()->user();
            $role = $auth_user->role;
        @endphp

        <script>
            var role = "{{ $role }}";
        </script>

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('theme/dist/img/pln.png') }}" alt="AdminLTELogo" height="170" width="150">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" role="button" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard.index') }}" class="brand-link">
            <img class="animation__wobble" src="{{ asset('theme/dist/img/pln.png') }}" alt="AdminLTELogo" height="60" width="40">
            <span class="brand-text font-weight-light">Laporan Pemeliharaan</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                <a href="#" class="d-block"><b>User Login </b> {{ $auth_user->name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if ($role=='1');
                    <li class="nav-item menu-open">
                        <a href="{{ route('dashboard.index') }}" class="nav-link {{ ($routeSelected == 'dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-file-chart-line"></i>
                            </p>
                        </a>
                    </li>
                @endif
                @if ($role=='2');
                    <li class="nav-item menu-open">
                        <a href="{{ route('dashboard.index') }}" class="nav-link {{ ($routeSelected == 'dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-file-chart-line"></i>
                            </p>
                        </a>
                    </li>
                @endif
                @if ($role=='3');
                    <li class="nav-item menu-open">
                        <a href="{{ route('dashboard.index') }}" class="nav-link {{ ($routeSelected == 'dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-file-chart-line"></i>
                            </p>
                        </a>
                    </li>
                @endif
                @if ($role=='1');
                    <li class="nav-header">MASTER DATA</li>
                    <li class="nav-item">
                        <a href="{{ route('role.index') }}" class="nav-link {{ ($routeSelected == 'role') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dice"></i>
                        <p>
                            Management Role
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('merekperalatan.index') }}" class="nav-link {{ ($routeSelected == 'merekperalatan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-marker"></i>
                        <p>
                            Merek Peralatan
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipeperalatan.index') }}" class="nav-link {{ ($routeSelected == 'tipeperalatan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-keyboard"></i>
                        <p>
                            Tipe Peralatan
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('garduinduk.index') }}" class="nav-link {{ ($routeSelected == 'garduinduk') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bolt"></i>
                        <p>
                            Gardu Induk
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peralatan.index') }}" class="nav-link {{ ($routeSelected == 'peralatan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Peralatan
                        </p>
                        </a>
                    </li>
                    <li class="nav-header">PEMELIHARAAN</li>
                    <li class="nav-item">
                        <a href="{{ route('personil.index') }}" class="nav-link {{ ($routeSelected == 'personil') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Personil
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}" class="nav-link {{ ($routeSelected == 'laporan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Laporan
                        </p>
                        </a>
                    </li>
                @endif
                @if ($role=='3');
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}" class="nav-link {{ ($routeSelected == 'laporan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Laporan
                        </p>
                        </a>
                    </li>
                @endif
                @if ($role=='2');
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}" class="nav-link {{ ($routeSelected == 'laporan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Laporan
                        </p>
                        </a>
                    </li>
                @endif  
                    <!-- <li class="nav-header">ADMIN</li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link {{ ($routeSelected == 'register') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Register
                        </p>
                        </a>
                    </li> -->
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
           <!-- <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                <div class="col-sm-12">
                    <h1 class="m-0">Sistem Laporan Pemeliharaan</h1>
                </div>
                </div>
            </div>
            </div> -->

            <section class="content">
                <div class="container-fluid">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
            </section>

            <script>
                $(document).ready(function(){

                    var role = "{{ $role }}";

                    $('.datepicker').datepicker({
                        autoclose: true,
                        format: "yyyy-mm-dd",
                        todayBtn: true,
                        todayHighlight: true
                    });
                    
                })
            </script>

        </div>
    </div>

</body>
</html>
