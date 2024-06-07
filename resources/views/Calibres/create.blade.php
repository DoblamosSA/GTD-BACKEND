@extends('layouts.dashboard')

@section('template_title')
Calibres
@endsection

@section('content')

<style>
.bodega-1 {
    color: red;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <br>
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" style="color: black; margin-left:40%;">
                            {{ __('Creación de calibres') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" >
                    <button type="button" class="btn btn-link" data-bodega="4">Medellin</button>
                    <button type="button" class="btn btn-link" data-bodega="4">Rionegro</button>
                    <button type="button" class="btn btn-link" data-bodega="4">La 33</button>
                    <button type="button" class="btn btn-link" data-bodega="4">Copacabana</button>
                    
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" style="color: black; margin-left:40%; ">
                        </span>
                    </div>
                </div>

                <br>
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                    aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-dark">
                                {{ session('success') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


               


                <div class="container">

                    <form method="post" action="{{route('CalculadorCNC.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Articulo</label>

                                    <select id="materiales" class="form-control" name="Articulo_id">
                                       
                                    </select>
                                </div>
                                <input type="hidden" name="user_costea_id" value=" {{ Auth::user()->id }}">
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">Peso material</label>
                                    <input type="number" class="form-control" id="Peso_Material" disabled>
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">Cantidad pieza</label>
                                    <input type="number" class="form-control" name="Cantidad_Piezas">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="telefono">Calibre</label>
                                    <input type="number" class="form-control" name="Espesor_Material">

                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">Desarrollo MM</label>
                                    <input type="number" class="form-control" id="Peso_Material" name="Ancho_Platina">
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">Longitud MM</label>
                                    <input type="number" class="form-control" id="Peso_Material" name="Longitud">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">Total</label>
                                    <input type="number" class="form-control" id="Peso_Material" name="Total">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="telefono">Recurso</label>
                                    <select id="Recursos" class="form-control" name="Recurso_id">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">Costo del recurso</label>
                                    <input type="number" class="form-control" id="Costo_Recurso" disabled>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-floating">
                                    <label for="floatingInputGrid">H/M</label>
                                    <input type="text" class="form-control" id="Unidad_Recurso" disabled>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Costo de no calidad #</label>
                                    <select id="costo_no_calidad" class="form-control" name="costo_nocalidad_id">
                                       
                                </div>
                            </div>

                            
                                <button type="submit" class="btn btn-primary">Guardar Costeo</button>
                 
                    </form>
                </div>
                <BR>
            </div>

        </div>

    </div>
</div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('js/calculadoracnc.js') }}"></script>

@if (session('success'))
<script>
$(document).ready(function() {
    $('#successModal').modal('show');
});
</script>
@endif


@endsection