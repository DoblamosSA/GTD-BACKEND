<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">

        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('fecha') }}
                {{ Form::date('fecha', $juntasInformeUltrasonido->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''),'placeholder' => 'Fecha']) }}
                {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('identificacion_elemento') }}
                {{ Form::text('identificacion_elemento', $juntasInformeUltrasonido->identificacion_elemento, ['class' => 'form-control' . ($errors->has('identificacion_elemento') ? ' is-invalid' : ''),'placeholder' => 'Identificacion Elemento']) }}
                {!! $errors->first('identificacion_elemento', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('junta') }}
                {{ Form::text('junta', $juntasInformeUltrasonido->junta, ['class' => 'form-control' . ($errors->has('junta') ? ' is-invalid' : ''),'placeholder' => 'Junta']) }}
                {!! $errors->first('junta', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div>
        <button  type="submit" class="btn btn-primary" id="btn_salvar_juntas">Aceptar</button>
    </div>
</div>
