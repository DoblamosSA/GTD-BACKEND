<div class="box box-info padding-1">
    <div class="box-body">

        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('elemento') }}
                {{ Form::text('elemento', $juntasInformePartesMagnetica->elemento, ['class' => 'form-control' . ($errors->has('elemento') ? ' is-invalid' : ''),'placeholder' => 'Elemento']) }}
                {!! $errors->first('elemento', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('junta') }}
                {{ Form::text('junta', $juntasInformePartesMagnetica->junta, ['class' => 'form-control' . ($errors->has('junta') ? ' is-invalid' : ''),'placeholder' => 'Junta']) }}
                {!! $errors->first('junta', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('calificacion') }}
                {{ Form::label('nivelreviso') }}
                <select class="form-control" name="calificacion" id="calificacion" required>
                    @foreach (config('menus.Calificacion') as $dato)
                        <option value="{{ $dato }}"
                            {{ $informePartesMagnetica->calificacion == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('calificacion', $juntasInformePartesMagnetica->calificacion, ['class' => 'form-control' . ($errors->has('calificacion') ? ' is-invalid' : ''),'placeholder' => 'Calificacion']) }}
                {!! $errors->first('calificacion', '<div class="invalid-feedback">:message</div>') !!} -->
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {{ Form::label('indicacion') }}
                {{ Form::text('indicacion', $juntasInformePartesMagnetica->indicacion, ['class' => 'form-control' . ($errors->has('indicacion') ? ' is-invalid' : ''),'placeholder' => 'indicacion']) }}
                {!! $errors->first('indicacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {{ Form::label('observaciones') }}
                {{ Form::text('observaciones', $juntasInformePartesMagnetica->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''),'placeholder' => 'Observaciones']) }}
                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

    </div>
    <div class="box-footer mt-6">
        <button type="submit" class="btn btn-primary" id="btn_salvar_juntas_inf_magne">Aceptar</button>
    </div>
</div>