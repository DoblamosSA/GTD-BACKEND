<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>DOBLAMOS S.A</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <!-- Moment-->
    <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <script>
    var currentRol = '{{ App\Models\User::find(Auth::user()->id)->getRol() }}';
    var accion = "";
    </script>

    <!-- datatables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>


</head>

<style>
.modulosst {
    background-color: #005BAA;
}

.sidebar {
    background-color: thite;
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #fff">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"
                            style="color: rgba(0,0,0,.5)"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">

                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown" tyle="color: #818a91">

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>


                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">

                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-th-large"></i>
                        <span class="hidden-md-down"><b>{{ Auth::user()->name }}</b></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                        <a href="{{ route('profile_user.data_profile') }}" class="dropdown-item">
                            Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile_user.change_password') }}" class="dropdown-item">
                            Cambiar password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            Salir
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('informe-partes-magneticas.index') }}" class="brand-link"
                style="background-color: #005BAA">
                <img src="https://www.doblamos.com/wp-content/uploads/2019/10/simbolo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light" style="font-size: small;">DOBLAMOS S.A</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://www.doblamos.com/wp-content/uploads/2019/10/simbolo.png"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">

                        <span style="color: white">{{ Auth::user()->name }}</span>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false" style="color: white">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>

                                <p>
                                    Usuarios
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="modulosst">

                                    @can('admin.list_users',Model::class)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.list_users') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado Usuarios</p>
                                        </a>
                                    </li>
                                    @endcan
                            </ul>
                        </li>
                        <li class="nav-item" class="nav nav-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Calidad
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    <li class="nav-item">
                                    <li class="nav-item">
                                        @can('informe-partes-magneticas.index',Model::class)
                                        <a href="{{route('informe-partes-magneticas.index')}}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Partes Magneticas
                                                </i>
                                            </p>
                                        </a>
                                        @endcan

                                        @can('informe-liquidos-penetrante.index',Model::class)
                                        <a href="{{ route('informe-liquidos-penetrante.index') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Liquidos penetrantes
                                                </i>
                                            </p>
                                        </a>
                                        @endcan

                                        @can('informe-ultrasonido.index',Model::class)
                                        <a href="{{ route('informe-ultrasonido.index') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Ultrasonido
                                                </i>
                                            </p>
                                        </a>
                                        @endcan

                                        @can('informe-vert-metalica.index',Model::class)
                                        <a href="{{ route('informe-vert-metalica.index') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Vert Metalica
                                                </i>
                                            </p>
                                        </a>
                                        @endcan

                                    </li>

                        </li>
            </div>
            </ul>
            </li>

            </li>
            <li class="nav-item" class="nav nav-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Formaletas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <div class="modulosst">
                        <li class="nav-item">
                        <li class="nav-item">

                            @can('cotizacion.index',Model::class)
                            <a href="{{route('cotizacion.index')}}" class="nav-link">
                                </i>
                                <p>
                                    Seguimiento Cotizacion
                                    </i>
                                </p>
                            </a>
                            @endcan


                        </li>

                </ul>

            </li>

            <li class="nav-item" class="nav nav-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Vortex
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <div class="modulosst">
                        <li class="nav-item">
                        <li class="nav-item">

                            @can('vortexDoblamos.index',Model::class)
                            <a href="{{route('vortexDoblamos.index')}}" class="nav-link">
                                </i>
                                <p>
                                    Seguimiento Cotizacion
                                    </i>
                                </p>
                            </a>
                            @endcan



                        </li>

                </ul>

            </li>
            
            <li class="nav-item" class="nav nav-treeview">
            @can('estructurasMetalicas.index',Model::class)
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                       EstructurasMetalicas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
            @endcan
                <ul class="nav nav-treeview">
                    <div class="modulosst">
                        <li class="nav-item">
                        <li class="nav-item">

                          
                            <a href="{{route('estructurasMetalicas.index')}}" class="nav-link">
                                </i>
                                <p>
                                    Seguimiento Cotizacion
                                    </i>
                                </p>
                            </a>
                          



                        </li>

                </ul>

            </li>
            </nav>
            <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">

            <b>Version</b> 3.2.0
        </div>
        <strong>
            Sistema Gestion Doblamos S.A © - <?php echo date('Y'); ?>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/utilidades.js') }}"></script>
    <script src="{{ asset('js/control-roles-js') }}"></script>
    <script>
    $(function() {
        $('#datatableinfo').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    </script>

    @yield('scripts')
    <script src="{{ asset('js/utilidadesAggrid.js') }}"></script>
    <script src="{{ asset('js/drawing.js') }}"></script>
    <script src="{{ asset('js/drawinglipenetrantes.js.js') }}"></script>
    <script src="{{ asset('js/utilidadesAggrid.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>