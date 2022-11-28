<div class="box box-info padding-1">
    <div class="box-body">
        <input type="hidden" name="id" id="id" value="{{ $informePartesMagnetica->id }}">
        <div class="row col-12">
            <div class="form-group col-md-8 col-sm-12">
                {{ Form::label('proyecto') }}
                {{ Form::text('proyecto', $informePartesMagnetica->proyecto, ['class' => 'form-control' . ($errors->has('proyecto') ? ' is-invalid' : ''),'placeholder' => 'Proyecto']) }}
                {!! $errors->first('proyecto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('fecha') }}
                {{ Form::date('fecha', $informePartesMagnetica->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''),'placeholder' => 'Fecha']) }}
                {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-md-6 col-sm-12">
                {{ Form::label('sitio_inspeccion') }}
                <select class="form-control" name="sitio_inspeccion" id="sitio_inspeccion" required>
                    @foreach (config('menus.sitioInspeccion') as $dato)
                        <option value="{{ $dato }}"
                            {{ $informePartesMagnetica->sitio_inspeccion == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('sitio_inspeccion', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('cod_acep_rechazo') }}
                <select class="form-control" name="cod_acep_rechazo" id="cod_acep_rechazo" required>
                    @foreach (config('menus.codigoAceptacionRechazo') as $dato)
                        <option value="{{ $dato }}"
                            {{ $informePartesMagnetica->sitio_inspeccion == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('cod_acep_rechazo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-12">
                {{ Form::label('calidad_material_b') }}
                <select class="form-control" name="calidad_material_b" id="calidad_material_b" required>
                    @foreach (config('menus.calidadmaterialB') as $dato)
                        <option value="{{ $dato }}"
                            {{ $informePartesMagnetica->calidad_material_b == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('calidad_material_b', $informePartesMagnetica->calidad_material_b, ['class' => 'form-control' . ($errors->has('calidad_material_b') ? ' is-invalid' : ''),'placeholder' => 'Calidad Material B']) }}
                {!! $errors->first('calidad_material_b', '<div class="invalid-feedback">:message</div>') !!} -->
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-12">
                {{ Form::label('proceso_soldadura') }}
                <select class="form-control" name="proceso_soldadura" id="proceso_soldadura" required>
                    @foreach (config('menus.proceso_soldaruRa') as $dato)
                        <option value="{{ $dato }}"
                            {{ $informePartesMagnetica->proceso_soldadura == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('proceso_soldadura', $informePartesMagnetica->proceso_soldadura, ['class' => 'form-control' . ($errors->has('proceso_soldadura') ? ' is-invalid' : ''),'placeholder' => 'Proceso Soldadura']) }}
                {!! $errors->first('proceso_soldadura', '<div class="invalid-feedback">:message</div>') !!} -->
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-12">
                {{ Form::label('espesor_material_b') }}
                {{ Form::text('espesor_material_b', $informePartesMagnetica->espesor_material_b, ['class' => 'form-control' . ($errors->has('espesor_material_b') ? ' is-invalid' : ''),'placeholder' => 'Espesor Material B']) }}
                {!! $errors->first('espesor_material_b', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row col-12">
            <div class="form-group col-md-8 col-sm-12" id="inspect-container">
                {{ Form::label('inspeccionador') }}
                <div>
                    <button class="btn btn-danger btn-sm mb-2" id="inspect-clear">Limpiar</button>
                    <canvas id="inspect-canvas" height="128" width="450" class="{{ $errors->has('inspeccionador') ? ' is-invalid' : '' }}" style="height: 8rem;"></canvas>
                    {!! $errors->first('inspeccionador', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('nivel') }}
                {{ Form::text('nivel', $informePartesMagnetica->nivel, ['class' => 'form-control' . ($errors->has('nivel') ? ' is-invalid' : ''),'placeholder' => 'Nivel']) }}
                {!! $errors->first('nivel', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="row col-12">
            <div class="form-group col-md-8 col-sm-12">
                {{ Form::label('reviso') }}
                <div>
                    <button class="btn btn-danger btn-sm mb-2" id="review-clear">Limpiar</button>
                    <canvas id="review-canvas" height="128" width="450" class="{{ $errors->has('reviso') ? ' is-invalid' : '' }}" style="height: 8rem;"></canvas>
                </div>
                {!! $errors->first('reviso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('nivelreviso') }}
                {{ Form::text('nivelreviso', $informePartesMagnetica->nivelreviso, ['class' => 'form-control' . ($errors->has('nivelreviso') ? ' is-invalid' : ''),'placeholder' => 'Nivelreviso']) }}
                {!! $errors->first('nivelreviso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <input type="hidden" name="reviso" id="review-input">
        <input type="hidden" name="inspeccionador" id="inspect-input">

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Aceptar</button>
    </div>


</div>
