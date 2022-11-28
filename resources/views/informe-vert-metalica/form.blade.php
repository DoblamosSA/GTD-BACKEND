<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-8 col-sm-12">
                {{ Form::label('proyecto') }}
                {{ Form::text('proyecto', $informeVertMetalica->proyecto, ['class' => 'form-control' . ($errors->has('proyecto') ? ' is-invalid' : ''),'placeholder' => 'Proyecto']) }}
                {!! $errors->first('proyecto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('fecha_verificacion') }}
                {{ Form::date('fecha_verificacion', $informeVertMetalica->fecha_verificacion, ['class' => 'form-control' . ($errors->has('fecha_verificacion') ? ' is-invalid' : ''),'placeholder' => 'Fecha Verificacion']) }}
                {!! $errors->first('fecha_verificacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('estructuras') }}
                {{ Form::text('estructuras', $informeVertMetalica->estructuras, ['class' => 'form-control' . ($errors->has('estructuras') ? ' is-invalid' : ''),'placeholder' => 'Estructuras']) }}
                {!! $errors->first('estructuras', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('planta_area') }}
                {{ Form::text('planta_area', $informeVertMetalica->planta_area, ['class' => 'form-control' . ($errors->has('planta_area') ? ' is-invalid' : ''),'placeholder' => 'Planta Area']) }}
                {!! $errors->first('planta_area', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('contratista') }}
                {{ Form::text('contratista', $informeVertMetalica->contratista, ['class' => 'form-control' . ($errors->has('contratista') ? ' is-invalid' : ''),'placeholder' => 'Contratista']) }}
                {!! $errors->first('contratista', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('equipo_medicion') }}
                {{ Form::text('equipo_medicion', $informeVertMetalica->equipo_medicion, ['class' => 'form-control' . ($errors->has('equipo_medicion') ? ' is-invalid' : ''),'placeholder' => 'Equipo Medicion']) }}
                {!! $errors->first('equipo_medicion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('toma de datos') }}
                <select class="form-control" name="torque" id="torque" required>
                    @foreach (config('menus.TomaDatos') as $dato)
                        <option value="{{ $dato }}"
                            {{ $informeVertMetalica->torque == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('torque', $informeVertMetalica->torque, ['class' => 'form-control' . ($errors->has('torque') ? ' is-invalid' : ''),'placeholder' => 'Torque 1']) }} -->
                {!! $errors->first('torque', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('resultado_inspeccion') }}
                {{ Form::text('resultado_inspeccion', $informeVertMetalica->resultado_inspeccion, ['class' => 'form-control' . ($errors->has('resultado_inspeccion') ? ' is-invalid' : ''),'placeholder' => 'Resultado Inspeccion']) }}
                {!! $errors->first('resultado_inspeccion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('observaciones') }}
                {{ Form::text('observaciones', $informeVertMetalica->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''),'placeholder' => 'Observaciones']) }}
                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('contratisca_nombre') }}
                {{ Form::text('contratisca_nombre', $informeVertMetalica->contratisca_nombre, ['class' => 'form-control' . ($errors->has('contratisca_nombre') ? ' is-invalid' : ''),'placeholder' => 'Contratisca Nombre']) }}
                {!! $errors->first('contratisca_nombre', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('contratisca_firma') }}
                {{ Form::text('contratisca_firma', $informeVertMetalica->contratisca_firma, ['class' => 'form-control' . ($errors->has('contratisca_firma') ? ' is-invalid' : ''),'placeholder' => 'Contratisca Firma']) }}
                {!! $errors->first('contratisca_firma', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('contratisca_cargo') }}
                {{ Form::text('contratisca_cargo', $informeVertMetalica->contratisca_cargo, ['class' => 'form-control' . ($errors->has('contratisca_cargo') ? ' is-invalid' : ''),'placeholder' => 'Contratisca Cargo']) }}
                {!! $errors->first('contratisca_cargo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('residente_nombre') }}
                {{ Form::text('residente_nombre', $informeVertMetalica->residente_nombre, ['class' => 'form-control' . ($errors->has('residente_nombre') ? ' is-invalid' : ''),'placeholder' => 'Residente Nombre']) }}
                {!! $errors->first('residente_nombre', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('residente_firma') }}
                {{ Form::text('residente_firma', $informeVertMetalica->residente_firma, ['class' => 'form-control' . ($errors->has('residente_firma') ? ' is-invalid' : ''),'placeholder' => 'Residente Firma']) }}
                {!! $errors->first('residente_firma', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('residente_cargo') }}
                {{ Form::text('residente_cargo', $informeVertMetalica->residente_cargo, ['class' => 'form-control' . ($errors->has('residente_cargo') ? ' is-invalid' : ''),'placeholder' => 'Residente Cargo']) }}
                {!! $errors->first('residente_cargo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('inspector_nombre') }}
                {{ Form::text('inspector_nombre', $informeVertMetalica->inspector_nombre, ['class' => 'form-control' . ($errors->has('inspector_nombre') ? ' is-invalid' : ''),'placeholder' => 'Inspector Nombre']) }}
                {!! $errors->first('inspector_nombre', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('inspector_firma') }}
                {{ Form::text('inspector_firma', $informeVertMetalica->inspector_firma, ['class' => 'form-control' . ($errors->has('inspector_firma') ? ' is-invalid' : ''),'placeholder' => 'Inspector Firma']) }}
                {!! $errors->first('inspector_firma', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('inspector_cargo') }}
                {{ Form::text('inspector_cargo', $informeVertMetalica->inspector_cargo, ['class' => 'form-control' . ($errors->has('inspector_cargo') ? ' is-invalid' : ''),'placeholder' => 'Inspector Cargo']) }}
                {!! $errors->first('inspector_cargo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('representante_nombre') }}
                {{ Form::text('representante_nombre', $informeVertMetalica->representante_nombre, ['class' => 'form-control' . ($errors->has('representante_nombre') ? ' is-invalid' : ''),'placeholder' => 'Representante Nombre']) }}
                {!! $errors->first('representante_nombre', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('representante_firma') }}
                {{ Form::text('representante_firma', $informeVertMetalica->representante_firma, ['class' => 'form-control' . ($errors->has('representante_firma') ? ' is-invalid' : ''),'placeholder' => 'Representante Firma']) }}
                {!! $errors->first('representante_firma', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('representante_cargo') }}
                {{ Form::text('representante_cargo', $informeVertMetalica->representante_cargo, ['class' => 'form-control' . ($errors->has('representante_cargo') ? ' is-invalid' : ''),'placeholder' => 'Representante Cargo']) }}
                {!! $errors->first('representante_cargo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="form-group col-md-6 col-sm-12">
            {{ Form::hidden('adjuntos', 0, ['class' => 'form-control' . ($errors->has('adjuntos') ? ' is-invalid' : ''),'placeholder' => 'Adjuntos']) }}
            {!! $errors->first('adjuntos', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>

    <div>
        <button  type="submit" class="btn btn-primary btnEnviar">Aceptar</button>
    </div>
</div>
