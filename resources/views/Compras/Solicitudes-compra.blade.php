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
                                    <a class="nav-link active" data-toggle="modal" data-target="#consultarSolicitudModal">Consultar Solicitud</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="solicitudesAprobadas-tab" data-toggle="tab" href="#solicitudesAprobadas">Solicitudes Pendientes </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="solicitudesAprobadas-tab" data-toggle="tab" href="#solicitudesAprobadas">Solicitudes Aprobadas </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="solicitudesAprobadas-tab" data-toggle="tab" href="#solicitudesAprobadas">Solicitudes Rechazadas </a>
                                </li>
                            </ul>


                        </div>
                        <div class="modal fade" id="consultarSolicitudModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #1c2a48;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:#fff">Consultar Solicitud</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
                                                            <div class="container" style="background-color: #FFF;">
                                                                <div class="collapse navbar-collapse" id="navbarNav">
                                                                    <form action="{{ url('api/Consultar-solicitud-comprasap') }}" method="get" class="form-inline">
                                                                        @csrf
                                                                        <div class="form-row align-items-center">
                                                                            <div class="col-md-3 mb-2">
                                                                                <label for="start_date" class="sr-only">Fecha de inicio</label>
                                                                                <input type="date" name="start_date" class="form-control" placeholder="Fecha de inicio">
                                                                            </div>
                                                                            <div class="col-md-3 mb-2">
                                                                                <label for="end_date" class="sr-only">Fecha de fin</label>
                                                                                <input type="date" name="end_date" class="form-control" placeholder="Fecha de fin">
                                                                            </div>
                                                                            <div class="col-md-4 mb-2">
                                                                                <label for="docnum" class="sr-only">Documento</label>
                                                                                <input type="text" name="docnum" class="form-control" placeholder="Número de documento">
                                                                            </div>
                                                                            <div class="col-md-2 mb-2">
                                                                                <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div>

                                                            </div>
                                                        </nav>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <table class="table table-bordered" id="ventas-table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: 10px;">SOLICITUD</th>

                                                                                        <th style="font-size: 10px;">FECHA CONTABILIZACIÓN</th>
                                                                                        <th style="font-size: 10px;">CODIGO PROVEEDOR</th>
                                                                                        <th style="font-size: 10px;">NOMBRE PROVEEDOR</th>
                                                                                        <th style="font-size: 10px;">TOTAL DOCUMENTO</th>
                                                                                        <th style="font-size: 10px;">DIRECCIÓN </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="encabezados-body">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>


                                                                        <div class="col-md-12">
                                                                            <table class="table-bordered">
                                                                                <thead>
                                                                                    <tr>

                                                                                        <th style="font-size: 10px;">CODIGO</th>
                                                                                        <th style="font-size: 10px;">DESCRIPCION</th>
                                                                                        <th style="font-size: 10px;">CENTRO OPERACIONES</th>
                                                                                        <th style="font-size: 10px;">DEPARTAMENTO</th>

                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="lineas-body">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </ul>

                    <div id="loading-overlays" class="loading-overlay">
                        <div class="loading-spinner">
                            <i class="fas fa-spinner fa-pulse"></i>
                            <span>Generando solicitud de compra SAP...</span>
                        </div>
                    </div>

                    <section class="container-fluid">


                        <section class="inventory-section">
                            <form class="row g-3 needs-validation" novalidate>
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
                                            <option value="M">Montajes</option>
                                        </select>
                                    </div>
                                </div>
                        </section>
                        <div class="table-responsive" class="container-fluid">
                            <table id="solicitudesTable" class="table" style="width: 100%;">


                                <thead>
                                    <tr>
                                        <th style="font-size: 10px;">ARTICULO</th>
                                        <th style="font-size: 10px;">DESCRIPCION</th>
                                        <th style="font-size: 10px; width: 10%;">TEXTO LIBRE</th>
                                        <th style="font-size: 10px; width: 10%;">CANTIDAD NECESARIA</th>
                                        <th style="font-size: 10px; width: 10%;">PROYECTO</th>
                                        <th style="font-size: 10px; width: 10%;">ALMACEN</th>
                                        <th style="font-size: 10px; width: 10%;">CENTRO OPERACIONES</th>
                                        <th style="font-size: 10px; width: 10%;">CENTRO COSTOS</th>
                                        <th style="font-size: 10px; width: 10%;">DEPARTAMENTOS</th>
                                        <th style="font-size: 10px; width: 10%;">AGREGAR</th>
                                    </tr>
                                </thead>



                                <tbody>

                                    <tr>

                                        <td style="width: 15%">
                                            <select class="form-control select2art" name="itemCodes[]" id="" style="width:100%;" onchange="actualizarDescripcion(this, this.parentNode.parentNode.rowIndex)">
                                                @foreach($materialesselect as $material)
                                                <option value="{{ $material->ItemCode }}">{{ $material->ItemCode }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td style="font-size: 10px;"></td>




                                        <td class="align-middle text-center">
                                            <textarea rows="2" cols="5" class="form-control" name="FreeText[]" id="FreeText" style="width: 200px;"></textarea>
                                        </td>


                                        <td class=" align-middle text-center" style="font-size: 10px; width:120px;">
                                            <input type="number" class="form-control" name="UnitsOfMeasurment[]" id="UnitsOfMeasurment" style="width: 100px;" />
                                        </td>

                                        <td class="align-middle" style="font-size: 10px;">

                                            <select class="form-control" name="ProjectCode[]" id="ProjectCode">
                                                <option value=""></option>
                                                <option value="BEL">Sede Belen</option>
                                                <option value="SAB">Sabaneta</option>
                                                <option value="MED">Medellin</option>
                                                <option value="RIO">Rio</option>
                                                <option value="COP">Copacabana</option>
                                            </select>
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">

                                            <select class="form-control" name="WarehouseCode[]" id="WarehouseCode">
                                                <option value=""></option>
                                                <option value="01">Medellin</option>
                                                <option value="08">Rionegro</option>
                                                <option value="08">Sabaneta</option>
                                                <option value="04">Copacabana</option>
                                                <option value="31">Belen</option>
                                            </select>
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            <select class="form-control" name="CostingCode[]" id="CostingCode">
                                                <option value=""></option>
                                                <option value="BEL">BEL- Sede Belén</option>
                                                <option value="COP">COP- Sede Copacabana</option>
                                                <option value="EMED">EMED- Estructuras Medellin</option>
                                                <option value="FMLT">FMLT- Linea Formaleteria</option>
                                                <option value="HOME">HOME- Doblamos Home</option>
                                                <option value="LA33">LA33- Sede la 33</option>
                                                <option value="ÑFAC">ÑFAC- Linea Fachadas</option>
                                                <option value="MED">MED- Sede Medellin</option>
                                                <option value="RIO">RIO- Sede Rionegro</option>
                                                <option value="SAB">SAB- Sede Sabaneta</option>
                                                <option value="SAE"> SAE- Sabaneta Estructuras</option>
                                            </select>
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            <select class="form-control" name="CostingCode3[]" id="CostingCode3">
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
                                            <select class="form-control" name="CostingCode4[]" id="CostingCode4">
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
                                                <option value="MDE">DTO MEDELLIN</option>
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
                            <div class="col-12">
                                <button class="btn btn-primary" type="button" onclick="enviarSolicitudCompra()">Generar solicitud compra</button>

                            </div>
                            </form>
                        </div>
                    </section>
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
            function eliminarFila(button) {
                var row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }
            function agregarFila() {
                var table = document.getElementById("solicitudesTable").getElementsByTagName('tbody')[0];
                var newRow = table.insertRow(table.rows.length);

                // Inserta celdas en la nueva fila
                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);
                var cell3 = newRow.insertCell(2);
                var cell4 = newRow.insertCell(3);
                var cell5 = newRow.insertCell(4);
                var cell6 = newRow.insertCell(5);
                var cell7 = newRow.insertCell(6);
                var cell8 = newRow.insertCell(7);
                var cell9 = newRow.insertCell(8);
                var cell10 = newRow.insertCell(9);

                // Agrega contenido a las celdas (puedes personalizar esto según tus necesidades)
                var selectHtml = '<select class="form-control select2" name="itemCodes[]" id="" style="width:100%;" onchange="actualizarDescripcion(this, ' + newRow.rowIndex + ')">';

                @foreach($materialesselect as $material)
                selectHtml += '<option value="{{ $material->ItemCode }}">{{ $material->ItemCode }}</option>';
                @endforeach
                selectHtml += '</select>';

                cell1.innerHTML = selectHtml;
                cell2.style.fontSize = '10px';
                cell3.innerHTML = '<textarea rows="2" cols="5" class="form-control" name="FreeText[]" id="FreeText" style="width: 200px;"></textarea>';
                cell4.innerHTML = '<input type="text" class="form-control" name="UnitsOfMeasurment[]" id="UnitsOfMeasurment" style="width: 80px;" />';
                cell5.innerHTML = '<select class="form-control" name="ProjectCode[]" id="ProjectCode"><option value=""></option><option value="BEL">Sede Belen</option><option value="SAB">Sabaneta</option><option value="MED">Medellin</option><option value="Rio">Rio</option><option value="COP">Copacabana</option></select>';
                cell6.innerHTML = '<select class="form-control" name="WarehouseCode[]" id="WarehouseCode"><option value=""></option><option value="01">Medellin</option><option value="08">Rionegro</option><option value="08">Sabaneta</option><option value="04">Copacabana</option><option value="31">Belen</option></select>';
                cell7.innerHTML = '<select class="form-control" name="CostingCode[]" id="CostingCode"><option value=""></option><option value="BEL">BEL- Sede Belén</option><option value="COP">COP- Sede Copacabana</option><option value="EMED">EMED- Estructuras Medellin</option><option value="FMLT">FMLT- Linea Formaleteria</option><option value="HOME">HOME- Doblamos Home</option><option value="LA33">LA33- Sede la 33</option><option value="ÑFAC">ÑFAC- Linea Fachadas</option><option value="MED">MED- Sede Medellin</option><option value="RIO">RIO- Sede Rionegro</option><option value="SAB">SAB- Sede Sabaneta</option><option value="SAE">SAE- Sabaneta Estructuras</option></select>';
                cell8.innerHTML = '<select class="form-control" name="CostingCode3[]" id="CostingCode3">' +
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
                cell9.innerHTML = '<select class="form-control" name="CostingCode4[]" id="CostingCode4">' +
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
                    '<option value="MDE">DTO MEDELLIN</option>' +
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




                cell10.innerHTML = '<button type="button" class="btn btn-primary" onclick="agregarFila()"><i class="fas fa-plus"></i></button>' +
                    '<button type="button" class="btn btn-danger" onclick="eliminarFila(this)"><i class="fas fa-trash"></i></button>';

                // Inicializa Select2 para el nuevo select
                var select = newRow.cells[0].querySelector('select.select2');
                $(select).select2();
            }

            function actualizarDescripcion(select, rowIndex) {
                // Obtén el valor seleccionado
                var selectedValue = select.value;

                // Realiza la solicitud AJAX
                $.ajax({
                    url: 'api/obtener-nombre-articulo/' + selectedValue,
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
            // Función para mostrar el div de carga
            function mostrarDivDeCarga() {
                $('#loading-overlays').show();
            }

            // Función para ocultar el div de carga
            function ocultarDivDeCarga() {
                $('#loading-overlays').hide();
            }

            function enviarSolicitudCompra() {
                // Muestra una alerta de confirmación
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
                    // Si el usuario confirma, realiza la solicitud AJAX
                    if (result.isConfirmed) {
                        // Muestra el div de carga al iniciar la solicitud
                        mostrarDivDeCarga();

                        // Obtén los valores del formulario
                        var fechaRequerida = document.getElementById('RequriedDate').value;
                        var nombresolicitante = document.getElementById('RequesterName').value;
                        var requiereaprobacion = document.getElementById('U_HBT_AproComp').value;

                        // Obtén los valores adicionales
                        var itemCodes = document.getElementsByName('itemCodes[]');
                        var freeText = document.getElementsByName('FreeText[]');
                        var unitsOfMeasurment = document.getElementsByName('UnitsOfMeasurment[]');
                        var projectCode = document.getElementsByName('ProjectCode[]');
                        var warehouseCode = document.getElementsByName('WarehouseCode[]');
                        var costingCode = document.getElementsByName('CostingCode[]');
                        var costingCode3 = document.getElementsByName('CostingCode3[]');
                        var costingCode4 = document.getElementsByName('CostingCode4[]');

                        // Construye el objeto de datos
                        var requestData = {
                            RequriedDate: fechaRequerida,
                            RequesterName: nombresolicitante,
                            U_HBT_AproComp: requiereaprobacion,
                            // Otros campos de datos pueden ser añadidos aquí según sea necesario
                            itemCodes: [],
                            FreeText: [],
                            UnitsOfMeasurment: [],
                            ProjectCode: [],
                            WarehouseCode: [],
                            CostingCode: [],
                            CostingCode3: [],
                            CostingCode4: []
                        };

                        // Agrega los valores adicionales al objeto de datos
                        for (var i = 0; i < itemCodes.length; i++) {
                            requestData.itemCodes.push(itemCodes[i].value);
                            requestData.FreeText.push(freeText[i].value);
                            requestData.UnitsOfMeasurment.push(unitsOfMeasurment[i].value);
                            requestData.ProjectCode.push(projectCode[i].value);
                            requestData.WarehouseCode.push(warehouseCode[i].value);
                            requestData.CostingCode.push(costingCode[i].value);
                            requestData.CostingCode3.push(costingCode3[i].value);
                            requestData.CostingCode4.push(costingCode4[i].value);
                        }

                        // Realiza la solicitud AJAX a la API
                        $.ajax({
                            url: 'api/generarSolicitudCompraAPIalmacen',
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            contentType: 'application/json',
                            data: JSON.stringify(requestData),
                            success: function(response) {
                                // Oculta el div de carga al finalizar la solicitud
                                ocultarDivDeCarga();

                                // Maneja la respuesta de la API
                                if (response.success) {
                                    // Muestra SweetAlert2 con el número de documento y recarga la página
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Solicitud Generada con Éxito',
                                        text: 'Número de solicitud: ' + response.DocNum + 'DocEntry:' + response.DocEntry,
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
                                ocultarDivDeCarga();

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

        <script>
            $(document).ready(function() {
                $('form').submit(function(event) {
                    event.preventDefault();

                    const startDate = $('input[name="start_date"]').val();
                    const endDate = $('input[name="end_date"]').val();
                    const docnum = $('input[name="docnum"]').val();

                    if (!startDate && !endDate && !docnum) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin Criterios de Búsqueda',
                            text: 'Por favor ingrese al menos un criterio de búsqueda.',
                        });
                        return;
                    }

                    // Obtén el token de autenticación desde el elemento meta en tu página (debes incluirlo en tu página)
                    const token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: '{{ url("api/Consultar-solicitud-comprasap") }}',
                        type: 'GET',
                        data: {
                            start_date: startDate,
                            end_date: endDate,
                            docnum: docnum,
                        },
                        beforeSend: function(xhr) {
                            // Agrega el token al encabezado de la solicitud
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            $('#indicador').removeClass('d-none');
                        },
                        success: function(data) {
                            $('#indicador').addClass('d-none');
                            const encabezadosBody = $('#encabezados-body');
                            const lineasBody = $('#lineas-body');
                            encabezadosBody.empty();
                            lineasBody.empty();

                            if (Array.isArray(data) && data.length === 0) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Sin Resultados',
                                    text: 'No se encontraron pedidos en SAP.',
                                });
                                return;
                            }

                            if (typeof data === 'object' && data.hasOwnProperty('DocNum')) {
                                const venta = data;
                                const lines = venta.LineItems;

                                // Llenar tabla de encabezados
                                const encabezadosRow = `
                            <tr>
                                <td style="font-size: 10px;">${venta.DocNum}</td>
                                <td style="font-size: 10px;">${venta.DocDate}</td>
                                <td style="font-size: 10px;">${venta.CardCode}</td>
                                <td style="font-size: 10px;"> ${venta.CardName}</td>
                                <td style="font-size: 10px;">${(venta.DocTotal).toLocaleString('es-CO', { style: 'currency', currency: 'COP' })}</td>
                                <td style="font-size: 10px;">${venta.Address2}</td>
                            </tr>`;
                                encabezadosBody.append(encabezadosRow);

                                // Llenar tabla de líneas
                                lines.forEach(function(line) {
                                    const lineRow = `
                                <tr>
                                    <td style="font-size: 10px;">${line.ItemCode}</td>
                                    <td style="font-size: 10px;">${line.ItemDescription}</td>
                                    <td style="font-size: 10px;">${line.CostingCode}</td>
                                    <td style="font-size: 10px;">${line.CostingCode4}</td>
                                </tr>`;
                                    lineasBody.append(lineRow);
                                });
                            }

                            // Inicializa DataTables después de agregar los datos
                            $('#encabezados-table').DataTable();
                            $('#lineas-table').DataTable();

                            Swal.fire({
                                icon: 'success',
                                title: 'Consulta Exitosa',
                                text: 'Los resultados se han cargado correctamente.',
                            });

                            // Cerrar automáticamente la alerta de éxito después de 1000 milisegundos (1 segundo)
                            setTimeout(function() {
                                Swal.close();
                            }, 70);
                        },
                        error: function(error) {
                            $('#indicador').addClass('d-none');
                            console.error('Error en la consulta AJAX:', error);
                            console.log(error.responseText);

                            Swal.fire({
                                icon: 'error',
                                title: 'Error en la Consulta',
                                text: 'Ha ocurrido un error al cargar los resultados.',
                            });
                        }
                    });
                });
            });
        </script>


        @endsection


















        <style>
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