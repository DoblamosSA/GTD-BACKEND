<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>GTD-DOBLAMOS</title>

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <link rel="icon" href="{{asset('images\Fondo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('images\Fondo.png')}}" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
    ;
    </script>

    <!-- datatables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

</head>

<style>
.modulosst {
    background-color: #005BAA;
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: rgba(0,0,0,.5)"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">


                <li class="nav-item dropdown">

                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i>
                        <span class="hidden-md-down"><b>{{ Auth::user()->Nombre_Empleado }}</b></span>
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
                        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
                            Salir
                        </a>
                    </div>
                </li>
            </ul>


        </nav>

        <aside class="main-sidebar  elevation-4" >
             <a href="#" class="brand-link">
                <img src="data:image/jpeg;base64,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" alt="GTD Financiero Logo" class="brand-image img-circle">
                <span class="brand-text font-weight-light" style="color:black"><b>GTD DOBLAMOS</b></span>
            </a>
            <!-- Línea horizontal personalizada -->
            <hr class="mt-0 mb-3" style="border-color: BLACK; border-width: 2px; border-style: solid;">


            <br><br>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{url('/home')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>



                        <li class="nav-item">

                            @if(auth()->user()->can('Modulo_Usuarios'))
                            <a href="#" class="nav-link">
                                <b>
                                    <i class="nav-icon fas fa-user"></i>
                                </b>
                                <p>
                                    Usuarios
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    @if(auth()->user()->can('Listado_usuarios'))
                                    <li class="nav-item">
                                        <a href="{{ url('Usuarios') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado Usuarios</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(auth()->user()->can('Vista_Roles'))
                                    <a href="{{url('Roles') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('Vista_Permisos'))
                                    <a href="{{url('Permisos')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permisos</p>
                                    </a>
                                    @endif
                                </div>
                            </ul>


                            @endif
                        </li>

                        <!-- Menú de Modulo Calidad -->
                        <li class="nav-item">
                            @if(auth()->user()->can('Modulo_Calidad'))
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-gem"></i>
                                <p>
                                    Modulo Calidad
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    @if(auth()->user()->can('Vista_Costos_calidad'))
                                    <li class="nav-item">
                                        <a href="{{route('Costo-No-Calidad.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Costos doblamos</p>
                                        </a>
                                    </li>
                                    @endif
                                    <!-- Otros elementos del submenú de Modulo Calidad aquí -->
                                </div>
                            </ul>
                            @endif
                        </li>

                        <!-- Menú de Modulo Producción -->
                        <li class="nav-item">
                            @if(auth()->user()->can('Modulo_Produccion'))
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-gem"></i>
                                <p>
                                    Modulo Producción
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    @if(auth()->user()->can('Modulo_clientes'))
                                    <li class="nav-item">
                                        <a href="{{route('ClientesSap.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Clientes</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(auth()->user()->can('Vista_Formaletas'))
                                    <li class="nav-item">
                                        <a href="{{route('cotizaciones-formaletas.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Formaletas</p>
                                        </a>
                                    </li>
                                    @endif

                                    @if(auth()->user()->can('Modulo_Estructuras'))
                                    <a href="{{route('estructurasMetalicas.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Estructuras Metalicas
                                            </i>
                                        </p>
                                    </a>
                                    @endif


                                    @if(auth()->user()->can('Modulo_fachadas'))
                                    <a href="{{route('vortexDoblamos.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Fachadas
                                            </i>
                                        </p>
                                    </a>
                                    @endif
                                </div>

                            </ul>

                            @endif
                        </li>
                      

                        <li class="nav-item">
                            @if(auth()->user()->can('Modulo_Finanzas'))
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-gem"></i>
                                <p>
                                    Módulo Contable
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    <a href="{{ url('Modulo-finanzas') }}" class="nav-link">
                                        <i class="nav-icon fas fa-file-invoice"></i>
                                        <p>
                                            Facture
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <!-- Agrega las opciones específicas de "Facture" aquí -->
                                         <li class="nav-item">
                                            <a href="{{ url('Ordenes-Compra-SAP') }}" class="nav-link">
                                                <i class="nav-icon fas fa-credit-card"></i>
                                                <p>
                                                Ordenes-Compra SAP
                                                </p>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="modulosst">
                                    <a href="{{ url('Modulo-cartera') }}" class="nav-link">
                                        <i class="nav-icon fas fa-credit-card"></i>
                                        <p>
                                            Cartera Doblamos
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('Gestion-Cartera') }}" class="nav-link">
                                                <i class="nav-icon fas fa-credit-card"></i>
                                                <p>
                                                    Gestión Cartera
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Informes-doblamos-cartera') }}" class="nav-link">
                                                <i class="nav-icon fas fa-credit-card"></i>
                                                <p>
                                                    Informes Cartera
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Solicitudes-creditos') }}" class="nav-link">
                                                <i class="nav-icon fas fa-circle"></i>
                                                <p>
                                                    Creditos nuevos
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Solicitudes-creditos-rechazadas') }}" class="nav-link">
                                                <i class="nav-icon fas fa-circle"></i>
                                                <p>
                                                    Creditos Rechazados
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Solicitudes-creditos-aprobadas') }}" class="nav-link">
                                                <i class="nav-icon fas fa-circle"></i>
                                                <p>
                                                    Creditos Aprobados
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                            @endif
                        </li>
                        <!-- Otros menús y submenús -->

                        <li class="nav-item">

                            @if(auth()->user()->can('Modulo_Logistica'))
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-gem"></i>
                                <p>
                                    Modulo Logistica
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            @endif
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    @if(auth()->user()->can('Logistica_Vista_costeo_Art'))
                                    <li class="nav-item">
                                        <a href="{{ url('Logistica') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Costeo de artículos
                                            </p>
                                        </a>
                                    </li>
                                    @endif

                                    @if(auth()->user()->can('Logistica_Log_revalorizacion'))
                                    <li class="nav-item">
                                        <a href="{{ url('Log_revalorizaciones_sap') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Log Revalorizaciones
                                            </p>
                                        </a>
                                    </li>
                                    @endif

 				                    <li class="nav-item">
                                        <a href="{{ url('Abastecimiento_MRP_SAP') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                   MRP Matria Prima
                                            </p>
                                        </a>
                                    </li>
                                        <li class="nav-item">
                                        <a href="{{ url('Abastecimiento_MRP_SAP_ALMACEN') }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                MRP Almacen
                                            </p>
                                        </a>
                                    </li>


                                </div>
                            </ul>

                        </li>
						<li class="nav-item">

                          
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-gem"></i>
                                <p>
                                    Modulo Compras
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                  
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                @if(auth()->user()->can('Vista_Aprobaciones'))
                                    <li class="nav-item">
                                        <a href="{{url('Solicitudes-compra-aprobar')}}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Aprobaciones
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                    @if(auth()->user()->can('vista_solicitudes_compra'))
                                    <li class="nav-item">
                                        <a href="{{url('Solicitud-Compras-aplicativo')}}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Solicitud de compra
                                            </p>
                                        </a>
                                    </li>
                                    @endif

                                    





                                </div>
                            </ul>

                        </li>
                        <li class="nav-item">

                            @if(auth()->user()->can('Modulo_Maestros'))
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Configuración
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            @endif
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                    @if(auth()->user()->can('Vista_Materiales'))
                                    <a href="{{route('Materiales.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Materiales
                                            </i>
                                        </p>
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('Vista_calibres'))
                                    <a href="{{route('Calibres.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Calibres
                                            </i>
                                        </p>
                                    </a>
                                    @endif
                                    @if(auth()->user()->can('Vista_Laminas'))
                                    <a href="{{route('Laminas.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Laminas
                                            </i>
                                        </p>
                                    </a>
                                    @endif
                                    @if(auth()->user()->can('Vista_Recursos'))
                                    <a href="{{url('Recursos')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Recursos
                                            </i>
                                        </p>
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('Vista_Areas'))
                                    <a href="{{route('Areas.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Areas
                                            </i>
                                        </p>
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('Vista_Asesores'))
                                    <a href="{{route('Asesores.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Asesores
                                            </i>
                                        </p>
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('Vista_Transportes'))
                                    <a href="{{route('Transaporte.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Trasporte Logistica
                                            </i>
                                        </p>
                                    </a>
                                    @endif

                                </div>
                            </ul>

                        </li>

                        <li class="nav-item">

                            @if(auth()->user()->can('Modulo_TI'))
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                   Modulo T.I
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            @endif
                            <ul class="nav nav-treeview">
                                <div class="modulosst">
                                   
                                    <a href="{{url('checkList')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Tareas
                                            </i>
                                        </p>
                                    </a>
                                   
                                    <a href="{{url('Inventario-TI')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Inventario
                                            </i>
                                        </p>
                                    </a>
                                    <a href="{{url('Licencias')}}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Licencias
                                            </i>
                                        </p>
                                    </a>


                                 
                                </div>
                            </ul>

                        </li>

                    </ul>

                </nav>
            </div>

        </aside>
        <!-- Contenido principal -->
        <div class="content-wrapper">
            <section class="container-fluid">
                @yield('content')
            </section>
            
        </div>
        <br><br> <br>


        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <footer class="main-footer" style="background-color:#000000a8">
            <div class="container">
                <div class="float-right">
                    <b>Versión</b> 3.1.0
                </div>
                <strong>GTD Doblamos &copy; 2023</strong> <a href="http://www.doblamos.com"
                    target="_blank">doblamos.com</a>


            </div>
        </footer>

    </div>






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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
            "language": {
                "search": "",
                "searchPlaceholder": "Buscar...",
            },
            "dom": '<"top"f>rt<"bottom"lip>',
        });
    });
    </script>


    <script>
    $(document).ready(function() {
        $('#clientes_ids').select2();
    });
    </script>

    @yield('scripts')
    <script src="{{ asset('js/utilidadesAggrid.js') }}"></script>
    <script src="{{ asset('js/drawing.js') }}"></script>
    <script src="{{ asset('js/drawinglipenetrantes.js.js') }}"></script>
    <script src="{{ asset('js/utilidadesAggrid.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

    @yield('js')
</body>

</html>


<style>
/* Estilos globales */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.wrapper {
    position: relative;
    min-height: 100vh;
}

.container {
    max-width: 1800px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Estilos para la barra de navegación */
.main-header {
    background-color: #fff;
    /* Cambia el color de fondo */
    color: #fff;
    padding: 20px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.main-header h1 {
    margin: 0;
    font-size: 36px;
}

.navbar-nav .nav-item {
    margin-right: 20px;
}

.navbar-nav .nav-link {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
}

/* Estilos para la barra lateral */
.main-sidebar {
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    /* Agrega una sombra */
}

.main-sidebar .brand-link img {
    opacity: .8;
}

/* Añade un efecto de transición suave */
.nav-sidebar .nav-item .nav-link {
    transition: background-color 0.3s, color 0.3s;
}

/* Cambia el color de fondo y el color del texto al pasar el cursor */
.nav-sidebar .nav-item .nav-link:hover {
    background-color: #333;
    /* Cambia el color de fondo al pasar el cursor */
    color: #fff;
    /* Cambia el color del texto al pasar el cursor */
}

/* Ajustes de estilo para el contenido principal */
.content-wrapper {
    padding: 20px;
}

/* Estilos para el pie de página */
.main-footer {
    background-color: #1c2a48;
    /* Cambia el color de fondo */
    color: #fff;
    padding: 10px 0;
}

.float-right {
    float: right;
}

/* Ajustes de estilo para botones y otros elementos */
.btn {
    margin: 0;
}

/* Ajustes de estilo para tablas */
.table {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.table th,
.table td {
    padding: 15px;
    text-align: left;
}

.table th {
    background-color: #1c2a48;
    /* Cambia el color de fondo de las cabeceras de tabla */
    color: #fff;
}

.table tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}

/* Ajustes de estilo para íconos */
.nav-icon {
    font-size: 16px;
}

/* Estilo para los elementos de la barra de navegación al pasar el cursor */
.navbar-nav .nav-item:hover .nav-link {
    background-color: #ddd;
    /* Cambia el color de fondo al pasar el cursor */
    color: #333;
    /* Cambia el color del texto al pasar el cursor */
}

.modulosst {
    background-color: #131487;
}

/* Estilos personalizados para el campo de búsqueda con icono */
.dataTables_filter input {
    position: relative;
    padding-left: 30px;
}

.dataTables_filter:before {
    content: "\f002";
    font-family: "Font Awesome 5 Free";
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
}

.dataTables_filter input {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    box-shadow: none;
    background-color: #f5f5f5;
    font-size: 14px;
    width: 300px;
}

.dataTables_filter label {
    font-weight: bold;
    font-size: 16px;
}
</style>