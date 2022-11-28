<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('ubicacion_junta') }}
                {{ Form::text('ubicacion_junta', $datosJuntasInformeUltrasonido->ubicacion_junta, ['class' => 'form-control' . ($errors->has('ubicacion_junta') ? ' is-invalid' : ''),'placeholder' => 'Ubicacion Junta']) }}
                {!! $errors->first('ubicacion_junta', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('indicacion_numero') }}
                {{ Form::text('indicacion_numero', $datosJuntasInformeUltrasonido->indicacion_numero, ['class' => 'form-control' . ($errors->has('indicacion_numero') ? ' is-invalid' : ''),'placeholder' => 'Indicacion Numero']) }}
                {!! $errors->first('indicacion_numero', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('desde_cara') }}
                {{ Form::text('desde_cara', $datosJuntasInformeUltrasonido->desde_cara, ['class' => 'form-control' . ($errors->has('desde_cara') ? ' is-invalid' : ''),'placeholder' => 'Desde Cara']) }}
                {!! $errors->first('desde_cara', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('pierna') }}
                {{ Form::text('pierna', $datosJuntasInformeUltrasonido->pierna, ['class' => 'form-control' . ($errors->has('pierna') ? ' is-invalid' : ''),'placeholder' => 'Pierna']) }}
                {!! $errors->first('pierna', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('nivel_indicacion') }}
                {{ Form::text('nivel_indicacion', $datosJuntasInformeUltrasonido->nivel_indicacion, ['class' => 'form-control' . ($errors->has('nivel_indicacion') ? ' is-invalid' : ''),'placeholder' => 'Nivel Indicacion']) }}
                {!! $errors->first('nivel_indicacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('nivel_referencia') }}
                {{ Form::text('nivel_referencia', $datosJuntasInformeUltrasonido->nivel_referencia, ['class' => 'form-control' . ($errors->has('nivel_referencia') ? ' is-invalid' : ''),'placeholder' => 'Nivel Referencia']) }}
                {!! $errors->first('nivel_referencia', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('factor_atenuacion') }}
                {{ Form::text('factor_atenuacion', $datosJuntasInformeUltrasonido->factor_atenuacion, ['class' => 'form-control' . ($errors->has('factor_atenuacion') ? ' is-invalid' : ''),'placeholder' => 'Factor Atenuacion']) }}
                {!! $errors->first('factor_atenuacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('valoracion_indicacion') }}
                {{ Form::text('valoracion_indicacion', $datosJuntasInformeUltrasonido->valoracion_indicacion, ['class' => 'form-control' . ($errors->has('valoracion_indicacion') ? ' is-invalid' : ''),'placeholder' => 'Valoracion Indicacion']) }}
                {!! $errors->first('valoracion_indicacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('longitud_defecto') }}
                {{ Form::text('longitud_defecto', $datosJuntasInformeUltrasonido->longitud_defecto, ['class' => 'form-control' . ($errors->has('longitud_defecto') ? ' is-invalid' : ''),'placeholder' => 'Longitud Defecto']) }}
                {!! $errors->first('longitud_defecto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('distancia_angular') }}
                {{ Form::text('distancia_angular', $datosJuntasInformeUltrasonido->distancia_angular, ['class' => 'form-control' . ($errors->has('distancia_angular') ? ' is-invalid' : ''),'placeholder' => 'Distancia Angular']) }}
                {!! $errors->first('distancia_angular', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('profundidad_desde') }}
                {{ Form::text('profundidad_desde', $datosJuntasInformeUltrasonido->profundidad_desde, ['class' => 'form-control' . ($errors->has('profundidad_desde') ? ' is-invalid' : ''),'placeholder' => 'Profundidad Desde']) }}
                {!! $errors->first('profundidad_desde', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('evaluacion_discontinuidad_1') }}
                {{ Form::text('evaluacion_discontinuidad_1', $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_1, ['class' => 'form-control' . ($errors->has('evaluacion_discontinuidad_1') ? ' is-invalid' : ''),'placeholder' => 'Evaluacion Discontinuidad 1']) }}
                {!! $errors->first('evaluacion_discontinuidad_1', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('evaluacion_discontinuidad_2') }}
                {{ Form::text('evaluacion_discontinuidad_2', $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_2, ['class' => 'form-control' . ($errors->has('evaluacion_discontinuidad_2') ? ' is-invalid' : ''),'placeholder' => 'Evaluacion Discontinuidad 2']) }}
                {!! $errors->first('evaluacion_discontinuidad_2', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('evaluacion_discontinuidad_3') }}
                {{ Form::text('evaluacion_discontinuidad_3', $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_3, ['class' => 'form-control' . ($errors->has('evaluacion_discontinuidad_3') ? ' is-invalid' : ''),'placeholder' => 'Evaluacion Discontinuidad 3']) }}
                {!! $errors->first('evaluacion_discontinuidad_3', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('distancia_desde_x') }}
                {{ Form::text('distancia_desde_x', $datosJuntasInformeUltrasonido->distancia_desde_x, ['class' => 'form-control' . ($errors->has('distancia_desde_x') ? ' is-invalid' : ''),'placeholder' => 'Distancia Desde X']) }}
                {!! $errors->first('distancia_desde_x', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('distancia_desde_y') }}
                {{ Form::text('distancia_desde_y', $datosJuntasInformeUltrasonido->distancia_desde_y, ['class' => 'form-control' . ($errors->has('distancia_desde_y') ? ' is-invalid' : ''),'placeholder' => 'Distancia Desde Y']) }}
                {!! $errors->first('distancia_desde_y', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('estampe_soldador') }}
                {{ Form::text('estampe_soldador', $datosJuntasInformeUltrasonido->estampe_soldador, ['class' => 'form-control' . ($errors->has('estampe_soldador') ? ' is-invalid' : ''),'placeholder' => 'Estampe Soldador']) }}
                {!! $errors->first('estampe_soldador', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                {{ Form::label('observaciones') }}
                {{ Form::text('observaciones', $datosJuntasInformeUltrasonido->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''),'placeholder' => 'Observaciones']) }}
                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>



    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary" id="btn-salvar-dato-junta" onclick="saveDetalleJuntas()">Aceptar</button>
        <button type="submit" class="btn btn-danger" id="btn-cancelar-dato-junta" onclick=" mostrarListadoDatosDetalleJuntas()">Cancelar</button>
    </div>
</div>
