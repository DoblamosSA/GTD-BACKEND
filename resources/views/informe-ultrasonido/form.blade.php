<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('proyecto') }}
                {{ Form::text('proyecto', $informeUltrasonido->proyecto, ['class' => 'form-control' . ($errors->has('proyecto') ? ' is-invalid' : ''),'placeholder' => 'Proyecto']) }}
                {!! $errors->first('proyecto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('grado_calibracion') }}
                {{ Form::text('grado_calibracion', $informeUltrasonido->grado_calibracion, ['class' => 'form-control' . ($errors->has('grado_calibracion') ? ' is-invalid' : ''),'placeholder' => 'Grado Calibracion']) }}
                {!! $errors->first('grado_calibracion', '<div class="invalid-feedback">:message </div>') !!}
            </div>

           
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('angulos_grados')}}
                {{ Form::number('angulos_grados', $informeUltrasonido->angulos_grados, ['class' => 'form-control' . ($errors->has('angulos_grados') ? ' is-invalid' : ''),'placeholder' => 'Angulos grados']) }}
                {!! $errors->first('angulos_grados', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('bloquereferencia_tipo') }}
                {{ Form::text('bloquereferencia_tipo', $informeUltrasonido->bloquereferencia_tipo, ['class' => 'form-control' . ($errors->has('bloquereferencia_tipo') ? ' is-invalid' : ''),'placeholder' => 'Bloquereferencia Tipo']) }}
                {!! $errors->first('bloquereferencia_tipo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('bloque_referencia_serial') }}
                {{ Form::text('bloque_referencia_serial', $informeUltrasonido->bloque_referencia_serial, ['class' => 'form-control' . ($errors->has('bloque_referencia_serial') ? ' is-invalid' : ''),'placeholder' => 'Bloque referencia serial']) }}
                {!! $errors->first('bloque_referencia_serial', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('calidad_material_base') }}
                {{ Form::text('calidad_material_base', $informeUltrasonido->calidad_material_base, ['class' => 'form-control' . ($errors->has('calidad_material_base') ? ' is-invalid' : ''),'placeholder' => 'Calidad Material Base']) }}
                {!! $errors->first('calidad_material_base', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('espesor') }}
                {{ Form::number('espesor', $informeUltrasonido->espesor, ['class' => 'form-control' . ($errors->has('espesor') ? ' is-invalid' : ''),'placeholder' => 'Espesor']) }}
                {!! $errors->first('espesor', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('metal_aporte') }}
                {{ Form::text('metal_aporte', $informeUltrasonido->metal_aporte, ['class' => 'form-control' . ($errors->has('metal_aporte') ? ' is-invalid' : ''),'placeholder' => 'Metal Aporte']) }}
                {!! $errors->first('metal_aporte', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('acoplante') }}
                {{ Form::text('acoplante', $informeUltrasonido->acoplante, ['class' => 'form-control' . ($errors->has('acoplante') ? ' is-invalid' : ''),'placeholder' => 'Acoplante']) }}
                {!! $errors->first('acoplante', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('proceso') }}
                {{ Form::text('proceso', $informeUltrasonido->proceso, ['class' => 'form-control' . ($errors->has('proceso') ? ' is-invalid' : ''),'placeholder' => 'Proceso']) }}
                {!! $errors->first('proceso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('tipo_junta') }}
                {{ Form::text('tipo_junta', $informeUltrasonido->tipo_junta, ['class' => 'form-control' . ($errors->has('tipo_junta') ? ' is-invalid' : ''),'placeholder' => 'Tipo Junta']) }}
                {!! $errors->first('tipo_junta', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('paso') }}
                {{ Form::text('paso', $informeUltrasonido->paso, ['class' => 'form-control' . ($errors->has('paso') ? ' is-invalid' : ''),'placeholder' => 'Paso']) }}
                {!! $errors->first('paso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('medio_paso') }}
                {{ Form::text('medio_paso', $informeUltrasonido->medio_paso, ['class' => 'form-control' . ($errors->has('medio_paso') ? ' is-invalid' : ''),'placeholder' => 'Medio Paso']) }}
                {!! $errors->first('medio_paso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('rango') }}
                {{ Form::text('rango', $informeUltrasonido->rango, ['class' => 'form-control' . ($errors->has('rango') ? ' is-invalid' : ''),'placeholder' => 'Rango']) }}
                {!! $errors->first('rango', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('elaboro') }}
                {{ Form::text('elaboro', $informeUltrasonido->elaboro, ['class' => 'form-control' . ($errors->has('elaboro') ? ' is-invalid' : ''),'placeholder' => 'Elaboro']) }}
                {!! $errors->first('elaboro', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('reviso') }}
                {{ Form::text('reviso', $informeUltrasonido->reviso, ['class' => 'form-control' . ($errors->has('reviso') ? ' is-invalid' : ''),'placeholder' => 'Reviso']) }}
                {!! $errors->first('reviso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

    </div>

    <div>
        <button  type="submit" class="btn btn-primary btnEnviar">Aceptar</button>
    </div>

        
</div>




@section('scripts')
    <script>
        var txtAngulos_grados = $("#angulos_grados");
        var txtEspesor = $("#espesor");
        var txtPaso = $("#paso");
        var txtMedioPaso = $("#medio_paso");
        var txtRango = $("#rango");


        function calcularValores() {
            var paso = null;
            var medio_paso = null;
            var rango = null;
            var angulo = null;
            var Angulos_grados = 0;
            var espesor = parseInt(txtEspesor.val());
            var angulo = parseInt(txtAngulos_grados.val());

            Angulos_grados = angulo * (Math.PI / 180);
            paso = espesor * 2 * Math.tan(Angulos_grados);
            medio_paso = paso / 2;
            rango = espesor * 2 / Math.cos(Angulos_grados);

            txtPaso.val(paso.toFixed(3));
            txtMedioPaso.val(medio_paso.toFixed(3));
            txtRango.val(rango.toFixed(3));
        }

        $(document).ready(function() {

            $("#angulos_grados").change(function() {
                calcularValores();
            });
            $("#espesor").change(function() {
                calcularValores();
            });

        });

        
    </script>

<script src="{{ asset('js/cruds/juntas_informe_ultrasonido.js') }}"></script>
<script src="{{ asset('js/cruds/datos_juntas_informe_ultrasonido.js') }}"></script>
@endsection