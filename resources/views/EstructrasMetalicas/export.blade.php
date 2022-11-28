<table>
    <thead>
        <tr>
            <th>#Obra</th>
            <th>Empresa o Cliente</th>
            <th>Fecha de Recibo</th>
            <th>Nombre de la Obra</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Fecha Cotizada</th>
            <th>Valor Antes Iva</th>
            <th>Contacto</th>
            <th>Area(m/2)</th>
            <th>$/m2</th>
            <th>Incluye Montaje</th>
          

        </tr>
    </thead>
    <tbody>
        @foreach($estructuraMelalica as $row)
        <tr>


            <td>{{$row->Numero_Obra}}</td>
            <td>{{$row->Empresa_Cliente}}</td>
            <td>{{$row->Fecha_Recibido}}</td>
            <td>{{$row->Nombre_Obra}}</td>
            <td>{{$row->Descripcion}}</td>
            <td >{{$row->Estado}}</td>
            <td>{{$row->Fecha_Cotizada}}</td>
            <td>{{$row->Valor_Antes_Iva}} </td>
            <td>{{$row->Contacto}}</td>
            <td>{{$row->AreaM2}}</td>
            <td>{{$row->m2}}</td>
            <td>{{$row->Incluye_Montaje}}</td>




        </tr>

        @endforeach

    </tbody>

</table>