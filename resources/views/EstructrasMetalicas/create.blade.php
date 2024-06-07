@extends('layouts.dashboard')

@section('template_title')
Nueva cotizacion
@endsection

@section('content')

<br>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Registro seguimiento cotización</span>
                </div> <br>


                <div class="col">

                    <a class="btn btn btn-primary" data-toggle="modal" data-target="#create-user-modal"><i></i>Buscar
                        cliente
                    </a>

                </div>
                <br>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog"
                    aria-labelledby="create-user-modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-user-modal-label">Buscar Cliente</h5>
                                <button type="button" class="close" aria-label="Cerrar" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Nombre Cliente</th>
                                                    <th>Telefono</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">
                                                        <form id="search-form" class="form-inline" method="GET"
                                                            action="{{ route('estructurasMetalicas.create') }}">
                                                            <input type="text" class="form-control mr-sm-2" name="query"
                                                                aria-label="Search" placeholder="Buscar..."
                                                                value="{{ $query ?? '' }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-success my-2 my-sm-0 ">Buscar</button>
                                                        </form>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($clientesSAP as $cliente)
                                                <tr>
                                                    <td>{{ $cliente->CardCode }}</td>
                                                    <td>{{ $cliente->CardName }}</td>
                                                    <td>{{ $cliente->Phone1 }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-select-cliente"
                                                            data-id="{{ $cliente->id }}">
                                                            Seleccionar
                                                        </button>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {!! $clientesSAP->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{route('estructurasMetalicas.store')}}" method="POST" class="formulario-crear"
                    style="background-color:#80808042">
                    @csrf


                    <div class="form-row">


                        <input type="hidden" class="form-control" placeholder="Numero Obra " name="Numero_Obra">


                        <div class="col">
                            <label>Nombre Obra</label>
                            <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra"
                                value="{{old('Nombre_Obra')}}">

                        </div>
                        <div class="col">
                            <label>Lugar Obra</label>
                            <input type="text" class="form-control" placeholder="Lugar_Obra " name="Lugar_Obra"
                                value="{{old('Lugar_Obra')}}">

                        </div>
                        <div class="col">
                            <label>Fecha Recibido</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Recibido"
                                value="{{old('Fecha_Recibido ')}}">

                        </div>


                    </div>

                    <br>
                    <div class="form-row">

                        <div class="col">
                            <label>Fecha Cotizada</label>
                            <input type="date" class="form-control" placeholder="Fecha Cotizada " name="Fecha_Cotizada"
                                value="{{old('Fecha_Cotizada')}}">

                        </div>

                        <div class="col">
                            <label>Valor Antes Iva</label>
                            <input type="float" class="form-control" placeholder="Valor antes iva "
                                name="Valor_Antes_Iva" value="{{old('Valor_Antes_Iva')}}">

                        </div>
                        <div class="col">
                            <label>Estado</label>
                            <select name="Estado" id="Estado" class="form-control" placeholder="Estado"
                                value="{{old('Estado')}}">
                                <option class="form-control">{{old('Estado')}}</option>
                                <option class="form-control" value="Perdida">Perdida</option>
                                <option class="form-control" value="Seguimiento">Seguimiento</option>
                                <option class="form-control" value="Vendida">Vendida</option>
                                <option class="form-control" value="Pendiente">Pendiente</option>
                                <option class="form-control" value="Cerrada">Cerrada</option>
                                <option class="form-control" value="Adjudicada">Adjudicada</option>
                                <option class="form-control" value="No cotizada">No cotizada</option>



                            </select>

                        </div>


                        <div class="col">
                            <label>Tipologia</label>
                            <select name="Tipologia" class="form-control" placeholder="Tipologia"
                                aria-valuemax="{{old('Tipologia')}}">
                                <option class="form-control">{{old('Tipologia')}}</option>
                                <option class="form-control" value="Bodegas">Bodegas</option>
                                <option class="form-control" value="Edificio">Edificio</option>
                                <option class="form-control" value="Entrepisos">Entrepisos</option>
                                <option class="form-control" value="Servicios y suministros">Servicios y suministros
                                </option>
                                <option class="form-control" value="Proyectos Especiales">Proyectos Especiales</option>
                                <option class="form-control" value="Cubiertas">Cubiertas</option>
                                <option class="form-control" value="Paneles">Paneles</option>
                                <option class="form-control" value="Casas">Casas</option>
                            </select>

                        </div>






                    </div>


                    <br>
                    <div class="form-row">



                        <div class="col">
                            <label>Valor Adjudicado</label>
                            <input type="float" class="form-control" placeholder="Valor Adjudicado "
                                name="Valor_Adjudicado" id="Valor_Adjudicado" value="{{old('Valor_Adjudicado')}}">

                        </div>



                        <div class="col">
                            <label>Peso Cotizado (KG)</label>
                            <input type="number" class="form-control" placeholder="Peso Cotizado (KG) "
                                name="Peso_Cotizado" value="{{old('Peso_Cotizado')}}">

                        </div>
                        <div class="col">
                            <label>Area(M2)</label>
                            <input type="number" class="form-control" placeholder="Area(M2)" name="Area_Cotizada"
                                value="{{old('Area_Cotizada')}}">

                        </div>


                        <input type="hidden" name="clientes_id" id="clientes_id" value="">




                    </div>
                    <br>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Guardar Registro</button>
                    </div>
                </form>





            </div>
        </div>
    </div>
    </div>
</section>


@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


<script>
$(document).ready(function() {
    $('#create-user-modal').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $('.btn-select-cliente').click(function() {
        var clienteId = $(this).data('id');
        $('#clientes_id').val(clienteId);
        if (confirm('¿Desea seleccionar este cliente?')) {
            $('#create-user-modal').modal('hide');
        }
    });
});
</script>

<script>
$(function() {
    $("#Estado").change(function() {
        if ($(this).val() === "Seguimiento") {
            $("#Valor_Adjudicado").prop("disabled", true);
        } else {
            $("#Valor_Adjudicado").prop("disabled", false);
        }
    });
});
</script>


@endsection