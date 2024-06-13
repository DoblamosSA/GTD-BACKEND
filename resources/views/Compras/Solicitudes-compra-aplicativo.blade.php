@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/SolicitudesCompra/SolicitudesCompra.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: #1c2a48;">

                    <div class="container">
                        <header class="py-2" style="text-align: center; ">
                            <h4><b style="color: #fff;">Solicitudes de compras</b></h4>
                        </header>

                    </div>

                </div>


                <div class="container mt-4">
                    <ul class="nav nav-tabs" id="myTabs">
                        <div class="container mt-4">
                            <ul class="nav nav-tabs" id="myTabs">

                                <li class="nav-item">
                                    <a class="nav-link" id="solicitudesAprobadas-tab" data-toggle="modal" data-target="#solicitudesModal" href="#">
                                        <i class="fas fa-list"></i> Mis Solicitudes
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="solicitudesAprobadas-tab" data-toggle="modal" data-target="#proveedorModal" href="#">
                                        <i class="fas fa-cloud-upload-alt"></i> Importar Proveedores
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link"  id="importarProyectosBtn" onclick="ImportarproyectosSAP()">
                                        <i class="fas fa-cloud-upload-alt"></i> Importar Proyectos
                                    </button>
                                </li>


                            </ul>


                        </div>

                        <table id="resultadoTabla" border="1" style="background-color: #1c2a48;">
                            <thead>
                                <tr>
                                    <th style="background-color: #fff;">NIT</th>
                                    <th style="background-color: #fff;">CLIENTE</th>
                                    <th style="background-color: #fff;">TOTAL ORDEN</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <table id="resultadoTablas" border="1">

                            <tbody>

                            </tbody>
                        </table>
                        <div class="modal fade" id="solicitudesModal" tabindex="-1" role="dialog" aria-labelledby="solicitudesModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #1c2a48;">
                                        <h5 class="modal-title" id="solicitudesModalLabel" style="color:#ffffff">Mis solicitudes de compra</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFff;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div id="loading-overlaysestados" class="loading-overlay">
                                        <div class="loading-spinner">
                                            <i class="fas fa-spinner fa-pulse"></i>
                                            <span>Procesando....</span>
                                        </div>
                                    </div>



                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <form id="formularioConsultassoliccompras" action="{{ url('api/Consultar-solicitud-comprasap') }}" method="get" class="form-inline">
                                                    @csrf
                                                    <div class="form-row align-items-center">

                                                        <span class="input-group-text" id="basic-addon1">Consultar estado</span>
                                                        <select type="text" name="estado" class="form-control">
                                                            <option value=""> </option>
                                                            <option value="Aprobada">Aprobada</option>
                                                            <option value="Pendiente">Pendiente</option>
                                                            <option value="Rechazada">Rechazada</option>
                                                            <option value="No_requiere_apr">Sin aprobacion</option>


                                                        </select>

                                                        <div class="col-md-3">
                                                            <button type="submmit" class="btn btn-secondary">Consultar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 x-scroll">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-size: 9px;">#SOLICITUD</th>
                                                            <th style="font-size: 9px;">FECHA SOLICITUD</th>
                                                            <th style="font-size: 9px;">ESTADO SOLICITUD</th>
                                                            <th style="font-size: 9px;">NUMERO DOCUMENTO SAP</th>
                                                            <th style="font-size: 9px;">COMENTARIOS APROBADOR</th>
                                                            <th style="font-size: 9px;">ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tablaSolicitudes"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="solicitudescompraSubmodal" tabindex="-1" role="dialog" aria-labelledby="solicitudescompraSubmodalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #1c2a48;">
                                        <h5 class="modal-title" id="solicitudescompraSubmodalLabel" style="color:#ffffff">Detalle solicitud de compra</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFff;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div id="loading-overlaysestados" class="loading-overlay">
                                        <div class="loading-spinner">
                                            <i class="fas fa-spinner fa-pulse"></i>
                                            <span>Procesando....</span>
                                        </div>
                                    </div>


                                    <div class="x-scroll container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered x-scroll">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-size: 9px;">ID</th>
                                                            <th style="font-size: 9px;">DESCRIPCIÓN</th>
                                                            <th style="font-size: 9px;">TEXTO LIBRE</th>
                                                            <th style="font-size: 9px;">CANTIDAD</th>
                                                            <th style="font-size: 9px;">PROYECTO</th>
                                                            <th style="font-size: 9px;">ALMACEN</th>
                                                            <th style="font-size: 9px;">CENTRO OPERACIONES</th>
                                                            <th style="font-size: 9px;">CENTRO COSTOS</th>
                                                            <th style="font-size: 9px;">DEPARTAMENTOS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tablaDetalleSolicitudCompra"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                </div>
                <div class="modal fade" id="proveedorModal" tabindex="-1" role="dialog" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #1c2a48;">
                                <h5 class="modal-title" id="solicitudesModalLabel" style="color:#ffffff">Importar Proveedor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFff;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="loading-overlaysproveedor" class="loading-overlay">
                                <div class="loading-spinner">
                                    <i class="fas fa-spinner fa-pulse"></i>
                                    <span>Procesando....</span>
                                </div>
                            </div>





                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="buscarClienteForm" class="form-inline mb-3">
                                            <div class="form-group mr-2">
                                                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Codigo/Nombre ">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Buscar</button>
                                        </form>
                                    </div>

                                </div>
                            </div>


                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="tablaResultados">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 9px;">CODIGO</th>
                                                    <th style="font-size: 9px;">NOMBRE PROVEEDOR</th>
                                                    <th style="font-size: 9px;">TELEFONO</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tablaSolicitudes"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="loading-overlays" class="loading-overlay">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-pulse"></i>
                        <span> Procesando solicitud</span>
                    </div>
                </div>

                </ul>



                <section class="container-fluid">


                    <section class="inventory-section">
                        <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <div class="col-md-4">

                                <div class="input-group has-validation">
                                    <span class="input-group-text">Fecha Necesaria</span>
                                    <input type="date" class="form-control" id="RequriedDate" name="RequriedDate">
                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="input-group has-validation">
                                    <span class="input-group-text">Nombre Solicitante</span>
                                    <input type="text" class="form-control" id="RequesterName" name="RequesterName" required>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="input-group has-validation">
                                    <span class="input-group-text">Requiere aprobación</span>
                                    <select class="form-control" name="U_HBT_AproComp" id="U_HBT_AproComp">
                                        <option></option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="input-group has-validation">
                                    <span class="input-group-text">Numero Orden Venta</span>
                                    <input type="number" class="form-control" id="RefDocNumOrder" name="RefDocNumOrder" placeholder="Opcional">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="col-md-4">


                                </div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adjuntarAnexosModal">
                                    Adjuntar Anexos
                                </button>

                    </section>


                    <div class="table-responsive" class="container-fluid">
                        <table id="solicitudesTable" class="table" style="width: 100%;">


                            <thead>
                                <tr>
                                    <th style="font-size: 10px;">ARTICULO</th>
                                    <th style="font-size: 10px;">DESCRIPCION</th>
                                    <th style="font-size: 10px; width: 10%;">TEXTO LIBRE</th>
                                    <th style="font-size: 10px; width: 10%;">CANTIDAD NECESARIA</th>
                                    <th style="font-size: 10px; width: 10%;">PRECIO</th> <!-- Nueva columna para el precio -->
                                    <th style="font-size: 10px; width: 10%;">INDICADOR DE IMPUESTO</th> <!-- Nueva columna para el precio -->
                                    <th style="font-size: 10px; width: 10%;">PROYECTO</th>
                                    <th style="font-size: 10px; width: 10%;">ALMACEN</th>
                                    <th style="font-size: 10px; width: 10%;">CENTRO OPERACIONES</th>
                                    <th style="font-size: 10px; width: 10%;">CENTRO COSTOS</th>
                                    <th style="font-size: 10px; width: 10%;">DEPARTAMENTOS</th>
                                    <th style="font-size: 10px; width: 10%;">DESCRIPCION ADICIONAL</th>
                                    <th style="font-size: 10px; width: 10%;">PROVEEDOR</th>
                                    <th style="font-size: 10px; width: 10%;">AGREGAR</th>
                                </tr>
                            </thead>


                            <tbody>

                                <tr>

                                    <td style="width: 5%">
                                        <select class="form-control select2art" name="itemCodes[]" style="width:250px;" onchange="actualizarDescripcion(this, this.parentNode.parentNode.rowIndex)">
                                            @foreach($materialesselect as $material)
                                            <option value="{{ $material->ItemCode }}" data-id="{{ $material->id }}" title="{{ $material->ItemName }} ">{{ $material->ItemCode }} - {{ $material->ItemName }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="font-size: 10px;"></td>




                                    <td class="align-middle text-center">
                                        <textarea rows="2" cols="5" class="form-control" name="FreeText[]" id="FreeText" style="width: 200px;"></textarea>
                                    </td>


                                    <td class=" align-middle text-center" style="font-size: 10px; width:120px;">
                                        <input type="number" class="form-control" name="UnitsOfMeasurment[]" id="UnitsOfMeasurment" style="width: 65px;" />
                                    </td>
                                    <td class="align-middle" style="font-size: 10px;">
                                        <input type="number" class="form-control" name="Price[]" id="Price" placeholder="Opcional" style="width: 110px;" />
                                    </td>
                                    <td class="align-middle" style="font-size: 10px;">
                                        <select class="form-control" name="TaxCode[]" id="TaxCode" style="width:140px">
                                            <option value=""></option>
                                            <option value="IVA_AFD">IVA PAGADO ADQUISICION DE MAQUINARIA</option>
                                            <option value="IVA_HBT">IVA LEGALIZACIONES</option>
                                            <option value="IVA_TRA">IVA DESCONTABLE TRANSITORIO</option>
                                            <option value="IVAAF08">IVA MAYOR VALOR AF</option>
                                            <option value="IVAAF09">IVA EXENTO COMPRAS ACTIVOS FIJOS</option>
                                            <option value="IVAD01">IVA DESCONTABLE 19%</option>
                                            <option value="IVAD02">IVA DESCONTABLE 5 %</option>
                                            <option value="IVAD03">IMPUESTO DESCONTABLE IMPORTACIONES 19%</option>
                                            <option value="IVAD04">IVA DESCONTABLE DEVOLUCION COMPRAS 5%</option>
                                            <option value="IVAD05">IVA DESCONTABLE DEVOLUCION COMPRAS 19%</option>
                                            <option value="IVADC07">IVA EXCENTO COMPRAS</option>
                                            <option value="IVADE06">IVA EXCLUIDO Y NO GRABADO COMPRAS</option>
                                        </select>
                                    </td>

                                    <td class="align-middle" style="font-size: 10px;">
                                        <select class="form-control" name="ProjectCode[]" id="ProjectCode" style="width:140px">
                                            <option value=""></option>
                                            @foreach ($projectSAP as $proyecto)
                                            <option value="{{ $proyecto->Code }}">{{ $proyecto->Name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle" style="font-size: 10px;">

                                        <select class="form-control" name="WarehouseCode[]" id="WarehouseCode" style="width:140px">
                                            <option value=""></option>
                                            <option value="01">Medellin</option>

                                        </select>
                                    </td>
                                    <td class="align-middle" style="font-size: 10px;">
                                        <select class="form-control" name="CostingCode[]" id="CostingCode" style="width:180px">
                                            <option value=""></option>
                                            <option value="BEL">BEL- Sede Belén</option>
                                            <option value="COP">COP- Sede Copacabana</option>
                                            <option value="EMED">EMED- Estructuras Medellin</option>
                                            <option value="FMLT">FMLT- Linea Formaleteria</option>
                                            <option value="HOME">HOME- Doblamos Home</option>
                                            <option value="LA33">LA33- Sede la 33</option>
                                            <option value="LFAC">LFAC- Linea Fachadas</option>
                                            <option value="MED">MED- Sede Medellin</option>
                                            <option value="RIO">RIO- Sede Rionegro</option>
                                            <option value="SAB">SAB- Sede Sabaneta</option>
                                            <option value="SAE"> SAE- Sabaneta Estructuras</option>
                                        </select>
                                    </td>
                                    <td class="align-middle" style="font-size: 10px;">
                                        <select class="form-control" name="CostingCode3[]" id="CostingCode3" style="width:180px">
                                            <option value=""></option>
                                            <option value="ADM">ADMINISTRACION</option>
                                            <option value="ALM">ALMACEN</option>
                                            <option value="BOD">BODEGA Y DESPACHOS</option>
                                            <option value="CAL">CALL CENTER</option>
                                            <option value="CDS">CONTRATO DE SERVICIOS</option>
                                            <option value="CIF">CIF</option>
                                            <option value="CIL">CILINDRADORA</option>
                                            <option value="CIZ">CIZALLA</option>
                                            <option value="CLD">CALIDAD</option>
                                            <option value="CMP">CONSUMO MATERIA PRIMA</option>
                                            <option value="CMS">CONSUMO MATERIALES Y SUMINSTROS</option>
                                            <option value="CPG">CURVADORA DE PERFILES GRANDE</option>
                                            <option value="CPP">CURVADORA DE PERFILES PEQUEÑA</option>
                                            <option value="CTG">CORTADORA GRANDE</option>
                                            <option value="CTP">CORTADORA PEQUEÑA</option>
                                            <option value="DBG">DOBLADORA GRANDE</option>
                                            <option value="DBP">DOBLADORA PEQUEÑA</option>
                                            <option value="DYD">DISEÑO Y DIBUJO</option>
                                            <option value="FRM">FORMALETERIA</option>
                                            <option value="HOM">HOME</option>
                                            <option value="LFA">LINEA FACHADAS LFA</option>
                                            <option value="LNF">LINEA FACHADAS</option>
                                            <option value="MCP">MESA DE CORTE PANTOGRAFO TECOI</option>
                                            <option value="MEL">MESA LASER</option>
                                            <option value="MME">MANTENIMIENTO MECANICO Y ELECT</option>
                                            <option value="MOD">MANO DE OBRA DIRECTA</option>
                                            <option value="MQG">MAQUINA GRANALLADORA</option>
                                            <option value="MTC">MONTACARGAS</option>
                                            <option value="MTJ">MONTAJES</option>
                                            <option value="PDS">PRODUCTO ESTANDAR</option>
                                            <option value="PGR">PUENTES GRUAS</option>
                                            <option value="PLM">PLASMA</option>
                                            <option value="PNT">PLANTA</option>
                                            <option value="PNZ">PUNZONADORA</option>
                                            <option value="PRH">PRENSA HIDRAHULICA</option>
                                            <option value="PTG">PANTOGRAFOS</option>
                                            <option value="PTR">PINTURA</option>
                                            <option value="RPJ">REPUJADORA</option>
                                            <option value="SLD">SOLDADURA</option>
                                            <option value="SST">SEGURIDAD Y SALUD EN EL TRABAJO</option>
                                            <option value="STT">SIERRA TALADRO Y SISTEMA DE TR</option>
                                            <option value="TLR">TALADRO RADIAL</option>
                                            <option value="TRU">TRUMP 3000</option>
                                            <option value="VHC">VEHICULOS</option>
                                            <option value="VOR">VTAS VORTEX FACHADAS FUNCIONAL</option>
                                            <option value="VTA">VENTSA</option>
                                            <option value="VTP">VENTAS POBLACIONALES</option>

                                        </select>
                                    </td>
                                    <td class="align-middle" style="font-size: 10px; width:15px;">
                                        <select class="form-control" name="CostingCode4[]" id="CostingCode4" style="width:180px">
                                            <option></option>
                                            <option value="ALGE">DTO ALTA GERENCIA</option>
                                            <option value="ALMA">DTO ALMACEN</option>
                                            <option value="BELE">DTO SEDE BELEN</option>
                                            <option value="BILA">DTO BIENESTAR LABORAL</option>
                                            <option value="CAFA">DTO CAJA Y FACTURACION</option>
                                            <option value="CALI">DTO CALIDAD</option>
                                            <option value="COFI">DTO CONTABILIDAD Y FINANZAS</option>
                                            <option value="COME">DTO COMERCIAL</option>
                                            <option value="COMP">DTO COMPRAS</option>
                                            <option value="COPA">DTO COPACABANA</option>
                                            <option value="CREC">DTO CREDITO Y CARTERA</option>
                                            <option value="ESTR">DTO ESTRUCTURAS</option>
                                            <option value="FACH">DTO FACHADAS</option>
                                            <option value="FORM">DTO FORMALETERIA</option>
                                            <option value="GEAM">DTO GESTION AMBIENTAL</option>
                                            <option value="INVE">DTO INVENTARIO</option>
                                            <option value="LOGI">DTO LOGISTICA</option>
                                            <option value="MANT">DTO MANTENIMIENTO</option>
                                            <option value="MECO">DTO MERCADEO Y COMUNICACIONES</option>
                                            <option value="MEDE">DTO MEDELLIN</option>
                                            <option value="PROS">DTO PRODUCCION Y SERVICIOS</option>
                                            <option value="RION">DTO RIONEGRO</option>
                                            <option value="RRHH">DTO GESTION HUMANA</option>
                                            <option value="SABA">DTO SABANETA</option>
                                            <option value="SD33">DTO LA 33</option>
                                            <option value="SEGE">DTO DE SERVICIOS GENERALES</option>
                                            <option value="SSTT">DTO SEGURIDAD Y SALUD EN EL TRABAJO</option>
                                            <option value="TEIN">DTO TECNOLOGIA E INFORMACION</option>
                                            <option value="TEPA">DTO DE TESORERIA Y PAGOS</option>
                                            <option value="TRAN">DTO TRANSPORTE</option>

                                        </select>


                                    </td>
                                    <td class="align-middle" style="font-size: 10px;">

                                        <textarea class="form-control" name="U_DOB_DescripcionAdicional[]" id="U_DOB_DescripcionAdicional" placeholder="Opcional" style="width: 200px;"></textarea>

                                    </td>

                                    <td class="align-middle" style="font-size: 10px; width:15px;">
                                        <select class="form-control" name="LineVendor[]" id="LineVendor" style="width:180px;">
                                            <option></option>
                                            @foreach($proveedoresSAP as $proveedores)

                                            <option value="{{$proveedores->CardCode}}">{{ $proveedores->CardCode }} - {{ $proveedores->CardName }}</option>
                                            @endforeach
                                        </select>


                                    </td>
                                    <td class="align-middle" style="font-size: 10px;">
                                        <button type="button" class="btn btn-primary" onclick="agregarFila()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="eliminarFila(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>


                            </tbody>

                        </table>

                        <div class="modal fade" id="adjuntarAnexosModal" tabindex="-1" role="dialog" aria-labelledby="adjuntarAnexosModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #1c2a48;">
                                        <h5 class="modal-title" id="adjuntarAnexosModalLabel" style="color: #ffffff;">Adjuntar Anexos</h5>

                                    </div>


                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label for="archivos" class="form-label">Seleccionar Archivos</label>
                                            <input type="file" name="archivos[]" multiple class="form-control">
                                        </div>

                                        <div class="progress mb-3">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <ul id="listaArchivos" class="list-group">

                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <!-- Botón para subir documentos -->
                                        <!-- <button type="button" class="btn btn-primary" onclick="subirDocumentos()">Subir Documentos</button> -->
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            <button class="btn btn-primary" type="button" onclick="enviarSolicitudCompra()">Generar solicitud compra</button>

                        </div>
                        <br>
                        </form>
                    </div>
                </section>
                <br><br>
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            $('#LineVendor').select2();
        });
    </script>
    <script>
        function eliminarFila(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function agregarFila() {
            var table = document.getElementById("solicitudesTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);

            // Inserta celdas en la nueva fila
            for (var i = 0; i < 14; i++) {
                newRow.insertCell(i);
            }

            // Agrega contenido a las celdas (puedes personalizar esto según tus necesidades)
            var selectHtml = '<select class="form-control select2" name="itemCodes[]" id="" style="width:250px;" onchange="actualizarDescripcion(this, ' + newRow.rowIndex + ')">';

            @foreach($materialesselect as $material)
            selectHtml += '<option value="{{ $material->ItemCode }}" data-id="{{ $material->id }}">{{ $material->ItemName }}</option>';
            @endforeach

            selectHtml += '</select>';

            newRow.cells[0].innerHTML = selectHtml;

            newRow.cells[1].style.fontSize = '10px';

            newRow.cells[2].innerHTML = '<textarea rows="2" cols="5" class="form-control" name="FreeText[]" id="FreeText" style="width: 200px;"></textarea>';
            newRow.cells[3].innerHTML = '<input type="text" class="form-control" name="UnitsOfMeasurment[]" id="UnitsOfMeasurment" style="width:65px;" />';
            newRow.cells[4].innerHTML = '<input class="form-control" type="number" name="Price[]" id="Price" placeholder="Opcional"></input>';
            newRow.cells[5].innerHTML = '<select class="form-control" name="TaxCode[]" id="TaxCode" style="width:140px">' +
                '<option value=""></option>' +
                '<option value="IVA_AFD">IVA PAGADO ADQUISICION DE MAQUINARIA</option>' +
                '<option value="IVA_HBT">IVA LEGALIZACIONES</option>' +
                '<option value="IVA_TRA">IVA DESCONTABLE TRANSITORIO</option>' +
                '<option value="IVAAF08">IVA MAYOR VALOR AF</option>' +
                '<option value="IVAAF09">IVA EXENTO COMPRAS ACTIVOS FIJOS</option>' +
                '<option value="IVAD01">IVA DESCONTABLE 19%</option>' +
                '<option value="IVAD02">IVA DESCONTABLE 5 %</option>' +
                '<option value="IVAD03">IMPUESTO DESCONTABLE IMPORTACIONES 19%</option>' +
                '<option value="IVAD04">IVA DESCONTABLE DEVOLUCION COMPRAS 5%</option>' +
                '<option value="IVAD05">IVA DESCONTABLE DEVOLUCION COMPRAS 19%</option>' +
                '<option value="IVADC07">IVA EXCENTO COMPRAS</option>' +
                '<option value="IVADE06">IVA EXCLUIDO Y NO GRABADO COMPRAS</option>' +
                '</select>';

            var projectCodeSelect = '<select class="form-control" name="ProjectCode[]" id="ProjectCode">' +
                '<option value=""></option>';
            @foreach($projectSAP as $proyecto)
            projectCodeSelect += '<option value="{{ $proyecto->Code }}">{{ $proyecto->Name }}</option>';
            @endforeach
            projectCodeSelect += '</select>';
            newRow.cells[6].innerHTML = projectCodeSelect;
            newRow.cells[7].innerHTML = '<select class="form-control" name="WarehouseCode[]" id="WarehouseCode"><option value=""></option><option value="01">Medellin</option></select>';
            newRow.cells[8].innerHTML = '<select class="form-control" name="CostingCode[]" id="CostingCode" style="width:180px">' +
                '<option value=""></option>' +
                '<option value="BEL">BEL- Sede Belén</option>' +
                '<option value="COP">COP- Sede Copacabana</option>' +
                '<option value="EMED">EMED- Estructuras Medellin</option>' +
                '<option value="FMLT">FMLT- Linea Formaleteria</option>' +
                '<option value="HOME">HOME- Doblamos Home</option>' +
                '<option value="LA33">LA33- Sede la 33</option>' +
                '<option value="LFAC">LFAC- Linea Fachadas</option>' +
                '<option value="MED">MED- Sede Medellin</option>' +
                '<option value="RIO">RIO- Sede Rionegro</option>' +
                '<option value="SAB">SAB- Sede Sabaneta</option>' +
                '<option value="SAE"> SAE- Sabaneta Estructuras</option>' +
                '</select>';
            newRow.cells[9].innerHTML = newRow.cells[9].innerHTML = '<select class="form-control" name="CostingCode3[]" id="CostingCode3" style="width:180px">' +
                '<option value=""></option>' +
                '<option value="ADM">ADMINISTRACION</option>' +
                '<option value="ALM">ALMACEN</option>' +
                '<option value="BOD">BODEGA Y DESPACHOS</option>' +
                '<option value="CAL">CALL CENTER</option>' +
                '<option value="CDS">CONTRATO DE SERVICIOS</option>' +
                '<option value="CIF">CIF</option>' +
                '<option value="CIL">CILINDRADORA</option>' +
                '<option value="CIZ">CIZALLA</option>' +
                '<option value="CLD">CALIDAD</option>' +
                '<option value="CMP">CONSUMO MATERIA PRIMA</option>' +
                '<option value="CMS">CONSUMO MATERIALES Y SUMINSTROS</option>' +
                '<option value="CPG">CURVADORA DE PERFILES GRANDE</option>' +
                '<option value="CPP">CURVADORA DE PERFILES PEQUEÑA</option>' +
                '<option value="CTG">CORTADORA GRANDE</option>' +
                '<option value="CTP">CORTADORA PEQUEÑA</option>' +
                '<option value="DBG">DOBLADORA GRANDE</option>' +
                '<option value="DBP">DOBLADORA PEQUEÑA</option>' +
                '<option value="DYD">DISEÑO Y DIBUJO</option>' +
                '<option value="FRM">FORMALETERIA</option>' +
                '<option value="HOM">HOME</option>' +
                '<option value="LFA">LINEA FACHADAS LFA</option>' +
                '<option value="LNF">LINEA FACHADAS</option>' +
                '<option value="MCP">MESA DE CORTE PANTOGRAFO TECOI</option>' +
                '<option value="MEL">MESA LASER</option>' +
                '<option value="MME">MANTENIMIENTO MECANICO Y ELECT</option>' +
                '<option value="MOD">MANO DE OBRA DIRECTA</option>' +
                '<option value="MQG">MAQUINA GRANALLADORA</option>' +
                '<option value="MTC">MONTACARGAS</option>' +
                '<option value="MTJ">MONTAJES</option>' +
                '<option value="PDS">PRODUCTO ESTANDAR</option>' +
                '<option value="PGR">PUENTES GRUAS</option>' +
                '<option value="PLM">PLASMA</option>' +
                '<option value="PNT">PLANTA</option>' +
                '<option value="PNZ">PUNZONADORA</option>' +
                '<option value="PRH">PRENSA HIDRAHULICA</option>' +
                '<option value="PTG">PANTOGRAFOS</option>' +
                '<option value="PTR">PINTURA</option>' +
                '<option value="RPJ">REPUJADORA</option>' +
                '<option value="SLD">SOLDADURA</option>' +
                '<option value="SST">SEGURIDAD Y SALUD EN EL TRABAJO</option>' +
                '<option value="STT">SIERRA TALADRO Y SISTEMA DE TR</option>' +
                '<option value="TLR">TALADRO RADIAL</option>' +
                '<option value="TRU">TRUMP 3000</option>' +
                '<option value="VHC">VEHICULOS</option>' +
                '<option value="VOR">VTAS VORTEX FACHADAS FUNCIONAL</option>' +
                '<option value="VTA">VENTSA</option>' +
                '<option value="VTP">VENTAS POBLACIONALES</option>' +
                '</select>';

            newRow.cells[10].innerHTML = '<select class="form-control" name="CostingCode4[]" id="CostingCode4">' +
                '<option value=""></option>' +
                '<option value="ALGE">DTO ALTA GERENCIA</option>' +
                '<option value="ALMA">DTO ALMACEN</option>' +
                '<option value="BELE">DTO SEDE BELEN</option>' +
                '<option value="BILA">DTO BIENESTAR LABORAL</option>' +
                '<option value="CAFA">DTO CAJA Y FACTURACION</option>' +
                '<option value="CALI">DTO CALIDAD</option>' +
                '<option value="COFI">DTO CONTABILIDAD Y FINANZAS</option>' +
                '<option value="COME">DTO COMERCIAL</option>' +
                '<option value="COMP">DTO COMPRAS</option>' +
                '<option value="COPA">DTO COPACABANA</option>' +
                '<option value="CREC">DTO CREDITO Y CARTERA</option>' +
                '<option value="ESTR">DTO ESTRUCTURAS</option>' +
                '<option value="FACH">DTO FACHADAS</option>' +
                '<option value="FORM">DTO FORMALETERIA</option>' +
                '<option value="GEAM">DTO GESTION AMBIENTAL</option>' +
                '<option value="INVE">DTO INVENTARIO</option>' +
                '<option value="LOGI">DTO LOGISTICA</option>' +
                '<option value="MANT">DTO MANTENIMIENTO</option>' +
                '<option value="MECO">DTO MERCADEO Y COMUNICACIONES</option>' +
                '<option value="MEDE">DTO MEDELLIN</option>' +
                '<option value="PROS">DTO PRODUCCION Y SERVICIOS</option>' +
                '<option value="RION">DTO RIONEGRO</option>' +
                '<option value="RRHH">DTO GESTION HUMANA</option>' +
                '<option value="SABA">DTO SABANETA</option>' +
                '<option value="SD33">DTO LA 33</option>' +
                '<option value="SEGE">DTO DE SERVICIOS GENERALES</option>' +
                '<option value="SSTT">DTO SEGURIDAD Y SALUD EN EL TRABAJO</option>' +
                '<option value="TEIN">DTO TECNOLOGIA E INFORMACION</option>' +
                '<option value="TEPA">DTO DE TESORERIA Y PAGOS</option>' +
                '<option value="TRAN">DTO TRANSPORTE</option>' +
                '</select>';

            newRow.cells[11].innerHTML = '<textarea class="form-control" name="U_DOB_DescripcionAdicional[]" id="U_DOB_DescripcionAdicional" placeholder="Opcional"></textarea>';
            newRow.cells[12].innerHTML = '<select class="form-control" name="LineVendor[]" id="LineVendor" style="width:180px;">' +
                '<option></option>' +
                '@foreach($proveedoresSAP as $proveedores)' +
                '<option value="{{ $proveedores->CardCode }}">{{ $proveedores->CardCode }} - {{ $proveedores->CardName }}</option>' +
                '@endforeach' +
                '</select>';

            newRow.cells[13].innerHTML = '<button type="button" class="btn btn-primary" onclick="agregarFila()"><i class="fas fa-plus"></i></button>' +
                '<button type="button" class="btn btn-danger" onclick="eliminarFila(this)"><i class="fas fa-trash"></i></button>';

            // Inicializa Select2 para el nuevo select
            var select = newRow.cells[0].querySelector('select.select2');
            $(select).select2();

             // Inicializa Select2 para el nuevo select del proveedor
             var selectVendor = newRow.cells[12].querySelector('select');
            $(selectVendor).select2();
        }

        function actualizarDescripcion(select, rowIndex) {
            // Obtén el valor seleccionado
            var selectedValue = select.value;

            // Realiza la solicitud AJAX
            $.ajax({
                url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/obtener-nombre-articulo/' + selectedValue,
                method: 'GET',
                success: function(response) {
                    // Actualiza la celda de descripción con la respuesta obtenida
                    document.getElementById("solicitudesTable").rows[rowIndex].cells[1].innerHTML = response.descripcion;
                },
                error: function() {
                    // Maneja errores si es necesario
                    console.log('Error al obtener la descripción del artículo.');
                }
            });
        }
    </script>

    <script>
        function mostrarDivDeCargaestados() {
            $('#loading-overlaysestados').show();
        }

        // Función para ocultar el div de carga
        function ocultarDivDeCargaestados() {
            $('#loading-overlaysestados').hide();
        }
    </script>

    <script>
        function mostrarDivDeCarga() {
            $('#loading-overlays').show();
        }

        function ocultarDivDeCarga() {
            $('#loading-overlays').hide();
        }

        function enviarSolicitudCompra() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas generar la solicitud de compra en SAP?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, estoy seguro',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    mostrarDivDeCarga();

                    var formData = new FormData();

                    formData.append('RequriedDate', document.getElementById('RequriedDate').value);
                    formData.append('RequesterName', document.getElementById('RequesterName').value);
                    formData.append('U_HBT_AproComp', document.getElementById('U_HBT_AproComp').value);
                    formData.append('RefDocNumOrder', document.getElementById('RefDocNumOrder').value);

                    var itemCodes = document.querySelectorAll('select[name="itemCodes[]"]');
                    var freeText = document.querySelectorAll('textarea[name="FreeText[]"]');
                    var unitsOfMeasurment = document.querySelectorAll('input[name="UnitsOfMeasurment[]"]');
                    var projectCode = document.querySelectorAll('select[name="ProjectCode[]"]');
                    var warehouseCode = document.querySelectorAll('select[name="WarehouseCode[]"]');
                    var costingCode = document.querySelectorAll('select[name="CostingCode[]"]');
                    var costingCode3 = document.querySelectorAll('select[name="CostingCode3[]"]');
                    var costingCode4 = document.querySelectorAll('select[name="CostingCode4[]"]');
                    var uDOBDescripcionAdicional = document.querySelectorAll('textarea[name="U_DOB_DescripcionAdicional[]"]');
                    var Price = document.querySelectorAll('input[name="Price[]"]');
                    var TaxCode = document.querySelectorAll('select[name="TaxCode[]"]');
                    var LineVendor = document.querySelectorAll('select[name="LineVendor[]"]');



                    var archivosInput = document.querySelector('input[name="archivos[]"]');
                    var archivos = archivosInput.files;

                    for (var i = 0; i < archivos.length; i++) {
                        formData.append('archivos[]', archivos[i]);
                    }

                    itemCodes.forEach(function(itemCodeElement, index) {
                        var selectedOption = itemCodeElement.options[itemCodeElement.selectedIndex];
                        var materialId = selectedOption ? selectedOption.getAttribute('data-id') : null;

                        formData.append('itemCodes[]', materialId);
                        formData.append('itemDescription[]', document.getElementById("solicitudesTable").rows[index + 1].cells[1].innerHTML);
                        formData.append('FreeText[]', freeText[index].value);
                        formData.append('UnitsOfMeasurment[]', unitsOfMeasurment[index].value);
                        formData.append('ProjectCode[]', projectCode[index].value);
                        formData.append('WarehouseCode[]', warehouseCode[index].value);
                        formData.append('CostingCode[]', costingCode[index].value);
                        formData.append('CostingCode3[]', costingCode3[index].value);
                        formData.append('CostingCode4[]', costingCode4[index].value);
                        formData.append('U_DOB_DescripcionAdicional[]', uDOBDescripcionAdicional[index].value);
                        formData.append('Price[]', Price[index].value);
                        formData.append('TaxCode[]', TaxCode[index].value);
                        formData.append('LineVendor[]', LineVendor[index].value);


                    });

                    $.ajax({
                            url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/generarSolicitudCompraAplicativo',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                            }
                        })
                        .done(function(response) {
                            ocultarDivDeCarga();

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Solicitud Generada Exitosamente',
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                var errorMessage = 'Error en la solicitud a la API';

                                if (response.message) {
                                    errorMessage = response.message;
                                } else if (response.errors) {
                                    errorMessage += '<br><strong>Errores:</strong>';
                                    $.each(response.errors, function(key, value) {
                                        errorMessage += '<br>' + key + ': ' + value[0];
                                    });
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    html: errorMessage,
                                });
                            }
                        })
                        .fail(function(error) {
                            ocultarDivDeCarga();

                            try {
                                var responseData = JSON.parse(error.responseText);

                                if (responseData && responseData.success === false) {
                                    var errorMessage = responseData.message || 'Error en la solicitud a la API';

                                    if (responseData.errors) {
                                        errorMessage += '<br><strong>Errores de validación:</strong>';
                                        $.each(responseData.errors, function(key, value) {
                                            errorMessage += '<br>' + key + ': ' + value[0];
                                        });
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        html: errorMessage,
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error en la solicitud a la API',
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al procesar la respuesta del servidor',
                                });
                            }

                            console.log('Error completo:', error);
                        });
                }
            });
        }
    </script>


    <script>
        // Espera a que el documento esté listo
        $(document).ready(function() {
            // Inicializa Select2 en tu select con la clase 'select2'
            $('.select2art').select2();
        });
    </script>

    <!-- Agrega esto al final de tu archivo HTML antes de cerrar el cuerpo </body> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtén el enlace por su ID
            var enlace = document.getElementById('solicitudesAprobadas-tab');

            // Agrega un evento de clic al enlace
            enlace.addEventListener('click', function() {
                // Muestra el modal utilizando Bootstrap
                $('#miModal').modal('show');
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            // Escuchar el evento submit del formulario
            $('#formularioConsultassoliccompras').on('submit', function(event) {
                // Prevenir el envío por defecto del formulario
                event.preventDefault();

                // Realizar la solicitud Ajax
                $.ajax({
                    url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/Solicitudes-compra-consultar',
                    type: 'GET',
                    dataType: 'json',
                    data: $(this).serialize(), // Enviar los datos del formulario
                    success: function(response) {
                        // Manejar la respuesta exitosa
                        if (response.solicitudesCompra) {
                            // Limpiar la tabla antes de agregar nuevas filas
                            $('#tablaSolicitudes').empty();

                            // Recorrer las solicitudes y agregar filas a la tabla
                            $.each(response.solicitudesCompra, function(index, solicitud) {
                                // Agrega la clase 'text-success' si el estado es 'Aprobada'
                                var estadoClass = solicitud.estado === 'Aprobada' ? 'text-success' : '';

                                // Muestra "No generado en SAP" si DocNum o DocEntry son nulos, de lo contrario, muestra los valores
                                var docNumValue = solicitud.DocNum ?? 'Pendiente en SAP';
                                var docEntryValue = solicitud.DocEntry ?? 'Pendiente en SAP';
                                var sapButton = '';
                                // Convierte el ID en un enlace (link)
                                var idLink = '<a href="#">' + solicitud.id + '</a>';

                                // Agrega un botón adicional con el icono de Font Awesome solo si DocNum o DocEntry son nulos
                                if (solicitud.estado !== 'Rechazado') {
                                    sapButton = (solicitud.DocNum === null || solicitud.DocEntry === null) ?
                                        '<button type="button" class="btn btn-info btn-sm" onclick="abrirSAPModal(' + solicitud.id + ')"><i class="fas fa-database"></i> SSAP</button>' :
                                        '';
                                } else {
                                    // Si el estado es "Rechazado", no generamos el botón
                                    sapButton = '';
                                }

                                $('#tablaSolicitudes').append('<tr><td onclick="abrirSubmodalSolicitudCompra(' + solicitud.id + ');" data-toggle="modal" data-target="#solicitudescompraSubmodal" style="font-size: 11px;">' + idLink + '</td><td style="font-size: 11px;">' + solicitud.RequriedDate + '</td><td style="font-size: 11px;" class="' + estadoClass + '">' + solicitud.estado + '</td><td style="font-size: 11px;">' + docNumValue + '<td style="font-size: 11px;">' + (solicitud.Comments ? solicitud.Comments : 'Sin comentarios') + '</td><td style="font-size: 11px;">' + sapButton + '</td></tr>');
                            });
                        } else {
                            console.error('No se encontraron solicitudes de compra.');
                        }
                    },
                    error: function(error) {
                        // Manejar errores en la solicitud Ajax
                        console.error('Error al consultar las solicitudes de compra.');
                    }
                });
            });

            // Manejar clic en el enlace de "Solicitudes"
            $('#solicitudesAprobadas-tab').on('click', function() {
                // Simular el envío del formulario al hacer clic en el enlace
                $('#formularioConsultassoliccompras').submit();
            });

            // Función para abrir el modal de SAP
            // Función para mostrar el div de carga
            function mostrarDivDeCarga() {
                // Muestra el div de carga
                $('#loading-overlays').css('display', 'flex');
            }

            // Función para ocultar el div de carga
            function ocultarDivDeCarga() {
                // Oculta el div de carga
                $('#loading-overlays').css('display', 'none');
            }

            // Función para abrir el modal de SAP
            window.abrirSAPModal = function(id) {
                // Lógica para abrir el modal de SAP
                console.log('Abrir modal de SAP para la solicitud con ID: ' + id);
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Realizar la solicitud Ajax para enviar el ID a la ruta correspondiente
                // Muestra el div de carga mientras se realiza la solicitud
                mostrarDivDeCargaestados();

                // Realizar la solicitud Ajax para enviar el ID a la ruta correspondiente
                $.ajax({
                    url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/generarSolicitudCompradesdeAplicativo/' + id,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        // Oculta el div de carga al finalizar la solicitud
                        ocultarDivDeCarga();

                        // Maneja la respuesta de la API
                        if (response.success) {
                            // Muestra SweetAlert2 con el número de documento y recarga la página
                            Swal.fire({
                                icon: 'success',
                                title: 'Solicitud Generada con Éxito',
                                text: 'Número de solicitud: ' + response.DocNum,
                            }).then(function() {
                                // Recarga la página después de cerrar la alerta
                                location.reload();
                            });
                        } else {
                            // Muestra SweetAlert2 con el mensaje de error y detalles si disponibles
                            var errorMessage = 'Error en la solicitud a la API';

                            if (response.error) {
                                errorMessage = response.error;
                            }

                            // Verifica si hay detalles en la respuesta
                            if (response.details) {
                                errorMessage += '<br><strong>Detalles:</strong> ' + JSON.stringify(response.details, null, 2);
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: errorMessage,
                            });
                        }
                    },
                    error: function(error) {
                        // Oculta el div de carga al finalizar la solicitud
                        ocultarDivDeCargaestados();

                        // Maneja los errores de la API
                        console.error('Error en la solicitud a la API:', error);

                        // Muestra SweetAlert2 con un mensaje de error genérico
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Respuesta SAP: ' + error.responseJSON.error,
                        });

                        // Accede a los detalles del error proporcionados por el controlador
                        if (error.responseJSON && error.responseJSON.error) {
                            console.log('Mensaje de error:', error.responseJSON.error);
                        }
                        if (error.responseJSON && error.responseJSON.details) {
                            console.log('Detalles del error:', error.responseJSON.details);
                        }
                    }
                });
            };

        });
    </script>

    <script>
        // Función para abrir el modal de SAP
        $(document).ready(function() {
            window.abrirSubmodalSolicitudCompra = function(id) {
                // REVISAR ESTE
                // Lógica para abrir el modal de SAP
                    console.log('ACA:Abrir modal de SAP para la solicitud con ID: ' + id);
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Realizar la solicitud Ajax para enviar el ID a la ruta correspondiente
                    // Muestra el div de carga mientras se realiza la solicitud
                    mostrarDivDeCargaestados();

                    // Realizar la solicitud Ajax para enviar el ID a la ruta correspondiente
                    $.ajax({
                        url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/detalle-solicitud-compra-seleccionado/' + id,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            // Oculta el div de carga al finalizar la solicitud
                            ocultarDivDeCargaestados();

                            // Maneja la respuesta de la API
                            $('#tablaDetalleSolicitudCompra').empty();

                            response = response['success'];
                            response.forEach(function(item) {
                                $('#tablaDetalleSolicitudCompra').append('<tr><td style="font-size: 11px;">' + item['id'] + '</td><td style="font-size: 11px;">' + item['Descripcion'] + '</td><td style="font-size: 11px;">' + item['TextoLibre'] + '</td><td style="font-size: 11px;">' + item['Cantidad'] + '</td><td style="font-size: 11px;">' + item['Proyecto'] + '</td><td style="font-size: 11px;">' + item['Almacen'] + '</td><td style="font-size: 11px;">' + item['CentroOperaciones'] + '</td><td style="font-size: 11px;">' + item['CentroCostos'] + '</td><td style="font-size: 11px;">' + item['Departamento'] + '</td></tr>');
                            });

                            
                                // // Muestra SweetAlert2 con el mensaje de error y detalles si disponibles
                                // var errorMessage = 'Error en la solicitud a la API';

                                // if (response.error) {
                                //     errorMessage = response.error;
                                // }

                                // // Verifica si hay detalles en la respuesta
                                // if (response.details) {
                                //     errorMessage += '<br><strong>Detalles:</strong> ' + JSON.stringify(response.details, null, 2);
                                // }

                                // Swal.fire({
                                //     icon: 'error',
                                //     title: 'Error',
                                //     html: errorMessage,
                                // });
                            
                        },
                        error: function(error) {
                            $('#tablaDetalleSolicitudCompra').empty();

                            ocultarDivDeCargaestados();

                            // Maneja los errores de la API
                            console.error('Error en la solicitud a la API:', error);

                            // Muestra SweetAlert2 con un mensaje de error genérico
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Respuesta SAP: ' + error.responseJSON.error,
                            });
                            $('#solicitudescompraSubmodal').modal('hide');


                            // Accede a los detalles del error proporcionados por el controlador
                            if (error.responseJSON && error.responseJSON.error) {
                                console.log('Mensaje de error:', error.responseJSON.error);
                            }
                            if (error.responseJSON && error.responseJSON.details) {
                                console.log('Detalles del error:', error.responseJSON.details);
                            }
                        }
                    });
                };
            });
    </script>


    <script>
        $(document).ready(function() {
            var timer; // Variable para almacenar el temporizador

            $('#RefDocNumOrder').on('input', function() {
                // Borra el temporizador existente, si hay uno
                clearTimeout(timer);

                // Inicia un nuevo temporizador
                timer = setTimeout(function() {
                    // Obtén el valor del campo de entrada
                    var ordenVentaRelacionada = $('#RefDocNumOrder').val();

                    // Verifica si el campo está vacío
                    if (!ordenVentaRelacionada) {
                        // Si está vacío, oculta las tablas y termina la función
                        $('#resultadoTabla, #resultadoTablas').hide();
                        return;
                    }

                    // Muestra el overlay de carga
                    mostrarDivDeCarga()

                    // Realiza la solicitud Ajax
                    $.ajax({
                        url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/consultarDocEntryordenesVSAP/' + ordenVentaRelacionada,
                        type: 'GET',
                        // Antes de enviar la petición
                        beforeSend: function() {
                            // Muestra el overlay de carga
                            mostrarDivDeCarga()
                        },
                        // Después de recibir la respuesta con éxito
                        success: function(response) {
                            // Oculta el overlay de carga
                            ocultarDivDeCarga()

                            // Muestra las tablas después de obtener la respuesta
                            $('#resultadoTabla, #resultadoTablas').show();

                            // Limpia la tabla antes de agregar nuevas filas
                            $('#resultadoTabla tbody').empty();

                            // Verifica si hay datos en la respuesta
                            if (response && response.ventas !== undefined) {
                                // Aplica formato numérico al valor de DocTotal
                                var formattedDocTotal = parseFloat(response.ventas.DocTotal).toLocaleString();

                                // Agrega una fila a la tabla con los valores de DocEntry, CardCode, CardName y DocTotal formateado
                                $('#resultadoTabla tbody').append(
                                    '<tr>' +
                                    '<td style="color:#fff"> ' + response.ventas.CardCode + '</td>' +
                                    '<td style="color:#fff"> ' + response.ventas.CardName + '</td>' +
                                    '<td style="color:#fff">$' + formattedDocTotal + '</td>' +
                                    '</tr>'
                                );

                                // Agrega una fila para cada línea
                                $.each(response.ventas.LineItems, function(index, lineItem) {
                                    $('#resultadoTablas tbody').append(
                                        '<tr>' +
                                        '<td>' + lineItem.ItemCode + '</td>' +
                                        '<td>' + lineItem.ItemDescription + '</td>' +
                                        '<td>' + parseFloat(lineItem.UnitPrice).toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }) + '</td>' +
                                        '</tr>'
                                    );
                                });


                            } else {
                                // Muestra una alerta si no hay datos
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Información',
                                    text: 'No se encontraron resultados'
                                });
                            }
                        },
                        // En caso de error
                        error: function(error) {
                            // Oculta el overlay de carga
                            ocultarDivDeCarga()

                            // Muestra una alerta de error
                            Swal.fire({
                                icon: 'info',
                                title: 'Error',
                                text: 'Hubo un error en la solicitud: ' + error.responseJSON.error
                            });

                            // Maneja el error, por ejemplo, imprime en la consola
                            console.error(error.responseJSON);

                            // Limpia la tabla en caso de error
                            $('#resultadoTabla tbody').empty();
                        },
                        // Después de completar la petición (ya sea éxito o error)
                        complete: function() {
                            // Oculta el overlay de carga al finalizar la petición
                            ocultarDivDeCarga()
                        }
                    });
                }, 600);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#buscarClienteForm').on('submit', function(e) {
                e.preventDefault();
                var cliente = $('#cliente').val();

                // Show loading spinner
                showLoadingSpinner();

                buscarCliente(cliente);
            });

            function buscarCliente(cliente) {
                $.ajax({
                    url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/buscar-proveedor-SAP',
                    type: 'GET',
                    data: {
                        cliente: cliente
                    },
                    success: function(response) {
                        // Hide loading spinner
                        hideLoadingSpinner();

                        console.log(response);

                        // Check if there is a success message
                        if (response.hasOwnProperty('message')) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }

                        actualizarTablaResultados(response);
                    },
                    error: function(xhr) {
                        // Hide loading spinner
                        hideLoadingSpinner();

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'info',
                            title: 'Error',
                            text: xhr.responseText,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

            function actualizarTablaResultados(clientes) {
                var tablaResultados = $('#tablaResultados');
                tablaResultados.find('tbody').empty();

                // Verificar si se obtuvo un cliente válido
                if (clientes.hasOwnProperty('error')) {
                    // No se encontró un cliente válido en SAP
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: clientes.error,
                        confirmButtonText: 'OK',
                        timer: 4000,
                        timerProgressBar: true
                    });
                } else if (clientes.hasOwnProperty('cliente')) {
                    var cliente = clientes.cliente;
                    var clienteId = clientes.clienteId;

                    var fila = '<tr>' +
                        '<td>' + cliente.CardCode + '</td>' +
                        '<td>' + cliente.CardName + '</td>' +
                        '<td>' + cliente.Phone1 + '</td>' +
                        '</tr>';

                    tablaResultados.find('tbody').append(fila);

                    // Agregar el ID del cliente al input clientes_id
                    $('#clientes_id').val(clienteId);
                } else {
                    // No se encontró ningún cliente en SAP
                    console.log(clientes);
                }
            }

            function showLoadingSpinner() {
                // Show your loading spinner here
                $('#loading-overlaysproveedor').show();
            }

            function hideLoadingSpinner() {
                // Hide your loading spinner here
                $('#loading-overlaysproveedor').hide();
            }
        });
    </script>



    <script>
        function ImportarproyectosSAP() {
            // Muestra el spinner
            console.log('Iniciando ImportarproyectosSAP');
            document.getElementById('loading-overlays').style.display = 'block';

            // Realiza la llamada a la API
            $.ajax({
                url: 'api/ImportarProjectSAP', // La URL de tu API
                type: 'GET',
                success: function(response) {
                    // Oculta el spinner cuando la llamada es exitosa
                    document.getElementById('loading-overlays').style.display = 'none';

                    // Muestra una alerta utilizando SweetAlert2 con el mensaje del servidor
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                    });
                },
                error: function(error) {
                    // Oculta el spinner en caso de error
                    document.getElementById('loading-overlays').style.display = 'none';

                    // Muestra una alerta de error utilizando SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.responseJSON.error,
                    });
                }
            });
        }
    </script>

    @endsection


















    <style>
        .x-scroll{
            max-width: 100%;
            overflow-x: auto;
        }

        #resultadoTabla,
        #resultadoTablas {
            display: none;
        }

        .btn-estado {
            width: 150px;

        }


        .navbar {
            background-color: #34495e;
        }

        .navbar-toggler-icon {
            background-color: #ecf0f1;
        }

        .navbar-brand {
            color: #ecf0f1;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #ecf0f1;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #f39c12;
        }

        .navbar-nav .nav-item.active .nav-link {
            color: #f39c12;
        }

        .navbar-nav .dropdown-menu {
            background-color: #2c3e50;
            border: none;
            border-radius: 0;
        }

        .navbar-nav .dropdown-item {
            color: #ecf0f1;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .dropdown-item:hover {
            background-color: #f39c12;
            color: #fff;
        }


        #ventas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #ventas-table th,
        #ventas-table td {
            border: 1px solid #ced4da;
            padding: 8px;
            text-align: center;
        }

        #ventas-table th {
            background-color: #007bff;
            color: #fff;
        }

        #ventas-table tr:hover {
            background-color: #f1f1f1;
        }

        .indicador {
            background-color: white;
        }
    </style>

    <style>
        .select2-container--select2-height-auto .select2-selection--single {
            height: 40px;
            /* Ajusta la altura según tus necesidades */
        }
    </style>