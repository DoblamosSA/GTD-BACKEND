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
                            <input type="text" class="form-control" placeholder="Numero Obra " name="Numero_Obra"
                                value="{{$vorte->Numero_Obra}}">

                        </div>
                        <div class="col">
                            <label>Nombre Obra</label>
                            <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra"
                                value="{{$vorte->Nombre_Obra}}">

                        </div>
                        <div class="col">
                            <label>Lugar Obra</label>
                            <input type="text" class="form-control" placeholder="Lugar_Obra " name="Lugar_Obra"
                                value="{{$vorte->Lugar_Obra}} ">

                        </div>
                        <div class="col">
                            <label>Fecha Recibido</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Recibido"
                                value="{{$vorte->Fecha_Recibido}}">

                        </div>


                    </div>

                    <br>
                    <div class="form-row">

                        <div class="col">
                            <label>Fecha Cotizada</label>
                            <input type="date" class="form-control" placeholder="Fecha Cotizada " name="Fecha_Cotizada"
                                value="{{$vorte->Fecha_Cotizada}}">

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
    				<option class="form-control" value="Louvers">Louvers</option>
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
                                <option class="form-control" value="Pendiente">Pendiente</option>
                                <option class="form-control" value="Cerrada">Cerrada</option>
                                <option class="form-control" value="Adjudicada">Adjudicada</option>
                                <option class="form-control" value="No cotizada">No cotizada</option>



                            </select>

                        </div>


                        <div class="col">
                            <label>$M2</label>
                            <input type="number" class="form-control" placeholder="$m2 " name="m2"
                                value="{{$vorte->m2}}">

                        </div>
                        <div class="col-4">
                            <label for="Fecha Recibido">Consecutivo</label>
                            <input type="text" class="form-control" name="Total_Asesor"
                                value="{{$vorte->Total_Asesor}}">
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
                            <select name="Origen" class="form-control" id="origen" id="origen" onchange="checkOrigen(this)">

                                <option>{{$vorte->Origen}}</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Pagina web">Página web</option>
                                <option value="Valla">Valla</option>
                                <option value="Referido">Referido</option>
                                <option value="Cliente actual">Cliente actual</option>
                                <option value="Distribuidor">Distribuidor</option>
                                <option value="Ideo">Ideo</option>
				<option value="Ferias">Ferias</option>
                                <option value="Asesor">Asesor</option>
 <option value="Doblacero">Doblacero</option>

                                <option value="Otro">Otro</option>
                            </select>

                        </div>
 			
                                <div id="modal-otro" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ingresar otro valor</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" id="input-origen-otro" class="form-control"
                                                    placeholder="Ingresar otro valor">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
                                                <button id="btn-guardar-modal" type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                    </div>
                    <div class="col">
                        <label for="Asesor_id">Asesor</label>
                        <select name="Asesor_id" class="form-control" id="Asesor_id">
                            <option value="">Seleccione un asesor</option>
                            @foreach ($Asesor as $asesor)
                            <option value="{{ $asesor->id }}"
                                {{ old('Asesor_id', $vorte->Asesor_id) == $asesor->id ? 'selected' : '' }}>
                                {{ $asesor->Nombre_Asesor }}</option>
                            @endforeach
                        </select>
                    </div>
		<div class="col">
                        <label for="Pais">pais</label>
                          <select name="Pais" class="form-control" id="" required>
                            @foreach ($pais as $p)
                            <option value="{{ $p->id }}"
                                {{ old('Pais') == $p->id || $vorte->Pais == $p->id ? 'selected' : '' }}>
                                {{ $p->countryName }}
                            </option>
                            @endforeach
                        </select>

                    </div>
					
					<div class="col-4">
                        <label for="Fecha de venta">Fecha de venta</label>
                        <input type="date" name="Fecha_Venta" class="form-control"
                            value="{{$vorte->Fecha_Venta}}"></input>
                    </div>
                    <br>
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
<script>
  // JavaScript
  function checkOrigen(selectElement) {
    var selectedValue = selectElement.value;
    if (selectedValue === "Otro") {
      $('#modal-otro').modal('show'); // Abre el modal
    }
  }

  $('#btn-guardar-modal').click(function() {
    var otroValor = $('#input-origen-otro').val();

    if (otroValor.trim() !== "") {
      var selectOrigen = $('select[name="Origen"]');
      var option = '<option value="' + otroValor + '">' + otroValor + '</option>';
      selectOrigen.append(option);
      selectOrigen.val(otroValor);
    }
  });
</script>
@endsection