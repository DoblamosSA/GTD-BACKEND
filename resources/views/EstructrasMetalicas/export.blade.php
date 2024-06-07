<table>
    <thead>
        <tr>
        <th>Cliente</th>
            <th>Nombres</th>
            <th>Telefono</th>
            <th>#Obra</th>
            <th>Nombre Obra</th>
            <th>Lugar Obra</th>
            <th>Fecha Recibido</th>
            <th>Fecha Cotizada</th>
            <th>Valor A.Iva</th>
            <th>Valor Adjudicado</th>
            <th>Tipologia</th>
            <th>Estado</th>
            <th>Peso Cotizado</th>
            <th>Area Cotizada</th>


        </tr>
    </thead>
    <tbody>
        @foreach($estructuraMelalica as $row)
        <tr>

            <td>{{$row->clientes->CardCode}}</td>
            <td>{{$row->clientes->CardName}}</td>
            <td>{{$row->clientes->Phone1}}</td>
            <td>{{$row->Numero_Obra}}</td>
            <td>{{$row->Nombre_Obra}}</td>
            <td>{{$row->Lugar_Obra}}</td>
            <td>{{$row->Fecha_Recibido}}</td>
            <td>{{$row->Fecha_Cotizada}}</td>
            <td>${{number_format($row->Valor_Antes_Iva)}} </td>
            <td>${{number_format($row->Valor_Adjudicado)}}</td>
            <td>{{$row->Tipologia}}</td>
            <td>{{$row->Estado}}</td>
            <td>{{$row->Peso_Cotizado}}</td>
            <td>{{$row->Area_Cotizada}}</td>




        </tr>

        @endforeach

    </tbody>

</table>