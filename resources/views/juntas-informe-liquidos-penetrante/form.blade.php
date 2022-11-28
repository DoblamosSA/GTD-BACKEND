<div class="box box-info padding-1">
    <div class="box-body">

        <div class="row col-12">
            <div class="form-group col-6">
                {{ Form::label('elemento') }}
                {{ Form::text('elemento', $juntasInformeLiquidosPenetrante->elemento, ['class' => 'form-control' . ($errors->has('elemento') ? ' is-invalid' : ''),'placeholder' => 'Elemento']) }}
                {!! $errors->first('elemento', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-3">
                {{ Form::label('junta') }}
                {{ Form::text('junta', $juntasInformeLiquidosPenetrante->junta, ['class' => 'form-control' . ($errors->has('junta') ? ' is-invalid' : ''),'placeholder' => 'Junta']) }}
                {!! $errors->first('junta', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-3">
                {{ Form::label('calificacion') }}
                <select class="form-control" name="calificacion" id="calificacion" required>
                    @foreach (config('menus.Calificacion') as $dato)
                        <option value="{{ $dato }}"
                            {{ $liquidosPenetrante->calificacion == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('calificacion', $juntasInformeLiquidosPenetrante->calificacion, ['class' => 'form-control' . ($errors->has('calificacion') ? ' is-invalid' : ''),'placeholder' => 'Calificacion']) }}
                {!! $errors->first('calificacion', '<div class="invalid-feedback">:message</div>') !!} -->
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-12">
                {{ Form::label('indicacion') }}
                {{ Form::text('indicacion', $juntasInformeLiquidosPenetrante->indicacion, ['class' => 'form-control' . ($errors->has('indicacion') ? ' is-invalid' : ''),'placeholder' => 'indicacion']) }}
                {!! $errors->first('indicacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-12">
                {{ Form::label('observaciones') }}
                {{ Form::text('observaciones', $juntasInformeLiquidosPenetrante->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''),'placeholder' => 'Observaciones']) }}
                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

    </div>

    <div>
        <button type="submit" class="btn btn-primary btnEnviar" id="btn_salvar_juntas_inf_magne">Aceptar</button>
    </div>
</div>
