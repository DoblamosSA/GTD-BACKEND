@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')

<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Clientes Doblamos') }}
                        </span>

                        <div class="float-right">
                            <a href="{{route('clientes.create')}}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Crear Nuevo') }}
                            </a>
                        </div>

                    </div>


                </div>

                <br>
               
                <br>




                <table class="table table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Nit</th>
                            <th>Contacto</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($cliente as $Row)
                       
                        <td>{{$Row->Empresa}}</td>
                        <td>{{$Row->Nit}}</td>
                        <td>{{$Row->Contacto}}</td>
                        <td>{{$Row->Correo}}</td>
                        <td>{{$Row->Telefono}}</td>
                       


                        <td>
                            <form action="{{route('clientes.destroy',$Row->id)}}" method="POST" class="formulario-eliminar" class="formulario-eliminar">

                                @csrf
                                @method('PUT')

                                <a class="btn btn-sm btn-success" href="{{route('clientes.edit',$Row->id)}}"><i class="fa fa-fw fa-edit "></i>
                                </a>

                                <button type="submit" class="btn btn-danger btn-sm "><i
                                        class="fa fa-fw fa-trash"></i></button>

                            </form>

                        </td>


                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
</div>
</div>


@endsection
@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- CSS only -->

@if (session('eliminar') == 'ok')
<script>
swal.fire(
    'Eliminado!',
    'Seguimiento de la cotización eliminado Correctamente!',
    'success'
)
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas eliminar el cliente?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '3085d6',
        CancelButtonColor: '#d33',
        CancelButtonText: 'yes, delete it!'

    }).then((result) => {
        if (result.value) {
            this.submit();
        }

    })
});
</script>
@endsection