<table class="table table-striped">
    <thead>
        <tr>

            <th>Codigo</th>
            <th>Sede</th>
            <th>FechaCNC</th>
            <th>Descripción</th>
            <th>C.C/OP</th>
            <th>Area Responsable CNC</th>
            <th>SubprocesoCNC</th>
            <th>Caura Raíz</th>
            <th>Porque#1</th>
            <th>Porque#2</th>
            <th>Porque#3</th>
            <th>ResponsableCNC</th>
            <th>Proceso Reporta</th>
            <th>Proceso Detecta</th>
            <th>Costo CNC</th>
            <th>Saldo Recuperado</th>
            <th>Costo Final</th>
            <th>Descripcion OP</th>
            <th>Correccion Evento</th>
            <th>Tipo Accion</th>
            <th>Analista Reporta</th>
            <th>Estado</th>
            <th>Quien Costea</th>
            <th>Cant piezas dañadas</th>
        </tr>
    </thead>

    <tbody>

        @foreach($costonocalidad as $costonocalidad)
        <tr>

            <td>{{$costonocalidad->id}}</td>
            <td>{{$costonocalidad->sede}}</td>
            <td>{{$costonocalidad->FechaCNC}}</td>
            <td>{{$costonocalidad->Descripcion}}</td>
            <td>{{$costonocalidad->Ccop}}</td>
            <td>{{$costonocalidad->AreaResponsableCNC}}</td>
            <td>{{$costonocalidad->SubprocesoCNC}}</td>
            <td>{{$costonocalidad->causa_raiz}}</td>
            <td>{{$costonocalidad->Porque1}}</td>
            <td>{{$costonocalidad->Porque2}}</td>
            <td>{{$costonocalidad->Porque3}}</td>
            <td>{{$costonocalidad->empleado->CardName}}</td>
            <td>{{$costonocalidad->ProcesoReporta}}</td>
            <td>{{$costonocalidad->ProcesoDetecta}}</td>
            <td>${{number_format($costonocalidad->CostoCNC)}}</td>
            <td>${{number_format($costonocalidad->SaldoRecuperado)}}</td>
            <td>${{number_format($costonocalidad->SaldoFinalCNC)}}</td>
            <td>{{$costonocalidad->DescripcionOP}}</td>
            <td>{{$costonocalidad->CorreccionEvento}}</td>
            <td>{{$costonocalidad->TipoAccion}}</td>
            <td>{{$costonocalidad->analista->CardName}}</td>
            <td>{{$costonocalidad->EstadoCNC}}</td>
            <td>{{$costonocalidad->QuienCostea}}</td>
            <td>{{$costonocalidad->Cantidadpiezasdanadas}}</td>





        </tr>
        @endforeach
</table>