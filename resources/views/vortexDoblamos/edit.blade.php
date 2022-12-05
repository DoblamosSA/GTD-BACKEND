@extends('layouts.dashboard')

@section('template_title')
Editar Seguimiento
@endsection

@section('content')

<br>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Editar seguimiento cotización</span>
                </div> <br>

                <form action="{{route('vortexDoblamos.update',$vorte->id)}}" method="POST" class="formulario-editar">
                    @csrf
                    @method('PATCH')

                    <div class="form-row">

                        <div class="col">
                            <label>Numero Obra</label>
                            <input type="text" class="form-control" placeholder="Numero Obra " name="Numero_Obra" value="{{$vorte->Numero_Obra}}">

                        </div>
                        <div class="col">
                            <label>Nombre Obra</label>
                            <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra" value="{{$vorte->Nombre_Obra}}">

                        </div>
                        <div class="col">
                            <label>Lugar Obra</label>
                            <input type="text" class="form-control" placeholder="Lugar_Obra " name="Lugar_Obra" value="{{$vorte->Lugar_Obra}} ">

                        </div>
                        <div class="col">
                            <label>Fecha Recibido</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Recibido" value="{{$vorte->Fecha_Recibido}}">

                        </div>


                    </div>

                    <br>
                    <div class="form-row">

                        <div class="col">
                            <label>Fecha Cotizada</label>
                            <input type="date" class="form-control" placeholder="Fecha Cotizada " name="Fecha_Cotizada" value="{{$vorte->Fecha_Cotizada}}">

                        </div>

                        <div class="col">
                            <label>Valor Antes Iva</label>
                            <input type="float" class="form-control" placeholder="Valor antes iva "
                                name="Valor_Antes_Iva" value="{{$vorte->Valor_Antes_Iva}}">

                        </div>

                        <div class="col">
                            <label>Valor Adjudicado</label>
                            <input type="float" class="form-control" placeholder="Valor Adjudicado "
                                name="Valor_Adjudicado" value="{{$vorte->Valor_Adjudicado}}">

                        </div>

                        <div class="col">
                            <label>Tipologia</label>
                            <select name="Tipologia" class="form-control" placeholder="Tipologia">
                                <option class="form-control">{{$vorte->Tipologia}}</option>
                                <option class="form-control" value="Fachadas 3D">Fachadas 3D</option>
                                <option class="form-control" value="Fachadas 2D">Fachadas 2D</option>
                                <option class="form-control" value="Cerramientos">Cerramientos</option>
                                <option class="form-control" value="Puertas">Puertas</option>
                                <option class="form-control" value="Lamina Perforada">Lamina Perforada</option>
                                <option class="form-control" value="Paneles">Paneles</option>
                                <option class="form-control" value="Cielos">Cielos</option>
                                <option class="form-control" value="Corta Soles">Corta Soles</option>
                                <option class="form-control" value="Avisos">Avisos</option>
                                <option class="form-control" value="Pasamanos">Pasamanos</option>
                                <option class="form-control" value="Otros">Otros</option>
                            </select>

                        </div>






                    </div>


                    <br>
                    <div class="form-row">



                        <div class="col">
                            <label>Estado</label>
                            <select name="Estado" class="form-control" placeholder="Estado">
                                <option class="form-control">{{$vorte->Estado}}</option>
                                <option class="form-control" value="Perdida">Perdida</option>
                                <option class="form-control" value="Seguimiento">Seguimiento</option>
                                <option class="form-control" value="Vendida">Vendida</option>
                                <option class="form-control" value="Vendida">Pendiente</option>
                                <option class="form-control" value="Cerrada">Cerrada</option>
                                <option class="form-control" value="Adjudicada">Adjudicada</option>
                                <option class="form-control" value="No cotizada">No cotizada</option>



                            </select>

                        </div>


                        <div class="col">
                            <label>$M2</label>
                            <input type="number" class="form-control" placeholder="$m2 " name="m2" value="{{$vorte->m2}}">

                        </div>
                        <div class="col">
                            <label>Incluye Montaje</label>
                            <select name="Incluye_Montaje" class="form-control" placeholder="Incluye Montaje">
                                <option class="form-control">{{$vorte->Incluye_Montaje}}</option>
                                <option class="form-control" value="Si Incluye">Si Incluye</option>
                                <option class="form-control" value="No Incluye">No Incluye</option>

                            </select>
                        </div>

                        <div class="col">
                            <label>Origen</label>
                            <input type="text" class="form-control" placeholder="Origen " name="Origen" value="{{$vorte->Origen}}">

                        </div>


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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- CSS only -->

@if (session('eliminar') == 'actual')
<script>
swal.fire(
    'editado Correctamente!',
    'Seguimiento de la cotización Modificado!',
    'success'
)
</script>
@endif

<script>
$('.formulario-editar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas editar el seguimiento?',
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