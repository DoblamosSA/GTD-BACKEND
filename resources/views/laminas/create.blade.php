@extends('layouts.dashboard')

@section('template_title')
CNC
@endsection

@section('content')

<style>
.bodega-1 {
    color: red;
}
</style>
<style>
.form-control-checkbox {
    height: auto;
    padding-top: 0;
    padding-bottom: 0;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    display: inline-block;
    position: relative;
    vertical-align: middle;
    margin-right: 10px;
    margin-bottom: 10px;
    padding: 5px 35px 5px 10px;
}

.form-control-checkbox option::before {
    content: "\2714";
    font-size: 14px;
    color: #fff;
    background-color: #17a2b8;
    border-radius: 50%;
    display: inline-block;
    height: 20px;
    width: 20px;
    line-height: 20px;
    text-align: center;
    vertical-align: middle;
    margin-right: 10px;
}

.form-control-checkbox option:checked::before {
    content: "\2714";
}

.form-control-wide {
    width: 100%;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <br>
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __(' Registrar Laminas') }}
                        </span>
                    </div>
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

                    <form method="POST" action="{{ url('Laminas/store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="codigo">Código:</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="calibres">Calibres:</label>
                            <div id="calibres">
                                <div class="input-group mb-3">
                                    <select name="calibres[]" class="form-control" required>
                                        <option value="">Seleccione un calibre</option>
                                        @foreach ($calibres as $calibre)
                                        <option value="{{ $calibre->id }}">{{ $calibre->Calibre }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="precios[]" class="form-control" required
                                        placeholder="Ingrese el precio por kilo">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary add-calibre" type="button">Agregar</button>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
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


<script>
$(function() {
    $('.add-calibre').click(function() {
        var html = '<div class="input-group mb-3">' +
            '<select name="calibres[]" class="form-control" required>' +
            '<option value="">Seleccione un calibre</option>' +
            '@foreach ($calibres as $calibre)' +
            '<option value="{{ $calibre->id }}">{{ $calibre->Calibre }}</option>' +
            '@endforeach' +
            '</select>' +
            '<input type="number" name="precios[]" class="form-control" required>' +
            '<div class="input-group-append">' +
            '<button class="btn btn-outline-secondary remove-calibre" type="button">Eliminar</button>' +
            '</div>' +
            '</div>';
        $('#calibres').append(html);
    });
    $(document).on('click', '.remove-calibre', function() {
        $(this).closest('.input-group').remove();
    });
});
</script>
@endsection