<div class="box box-info padding-1">
    <div class="box-body">
    <input type="hidden" name="id" id="id" value="{{ $liquidosPenetrante->id }}">
        <div class="row">
            <div class="form-group col-md-5 col-sm-12">
                {{ Form::label('nombre_proyecto') }}
                {{ Form::text('nombre_proyecto', $liquidosPenetrante->nombre_proyecto, ['class' => 'form-control' . ($errors->has('nombre_proyecto') ? ' is-invalid' : ''),'placeholder' => 'Nombre Proyecto']) }}
                {!! $errors->first('nombre_proyecto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('fecha') }}
                {{ Form::date('fecha', $liquidosPenetrante->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''),'placeholder' => 'Fecha']) }}
                {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-5 col-sm-12">
                {{ Form::label('sitio_inspeccion') }}
                <select class="form-control" name="sitio_inspeccion" id="sitio_inspeccion" required>
                    @foreach (config('menus.sitioInspeccion') as $dato)
                        <option value="{{ $dato }}"
                            {{ $liquidosPenetrante->sitio_inspeccion == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('sitio_inspeccion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('calidad_material_base') }}
                 <select class="form-control" name="calidad_material_base" id="calidad_material_base" required>
                    @foreach (config('menus.calidadmaterialB') as $dato)
                        <option value="{{ $dato }}"
                            {{ $liquidosPenetrante->calidad_material_base == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('calidad_material_base', $liquidosPenetrante->calidad_material_base, ['class' => 'form-control' . ($errors->has('calidad_material_base') ? ' is-invalid' : ''),'placeholder' => 'Calidad Material Base']) }}
                {!! $errors->first('calidad_material_base', '<div class="invalid-feedback">:message</div>') !!} -->
            </div>
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('proceso_soldadura') }}
                <select class="form-control" name="proceso_soldadura" id="proceso_soldadura" required>
                    @foreach (config('menus.proceso_soldaruRa') as $dato)
                        <option value="{{ $dato }}"
                            {{ $liquidosPenetrante->proceso_soldadura == $dato ? 'selected' : '' }}>
                            {{ $dato }}
                        </option>
                    @endforeach
                </select>
                <!-- {{ Form::text('proceso_soldadura', $liquidosPenetrante->proceso_soldadura, ['class' => 'form-control' . ($errors->has('proceso_soldadura') ? ' is-invalid' : ''),'placeholder' => 'Proceso Soldadura']) }}
                {!! $errors->first('proceso_soldadura', '<div class="invalid-feedback">:message</div>') !!} -->
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                {{ Form::label('espesor_material_base') }}
                {{ Form::text('espesor_material_base', $liquidosPenetrante->espesor_material_base, ['class' => 'form-control' . ($errors->has('espesor_material_base') ? ' is-invalid' : ''),'placeholder' => 'Espesor Material Base']) }}
                {!! $errors->first('espesor_material_base', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-8 col-sm-12">
                {{ Form::label('elemento') }}
                {{ Form::text('elemento', $liquidosPenetrante->elemento, ['class' => 'form-control' . ($errors->has('elemento') ? ' is-invalid' : ''),'placeholder' => 'Elemento']) }}
                {!! $errors->first('elemento', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
       
        <div class="row">
            <div class="form-group col-md-8 col-sm-12">
                {{ Form::label('inspeccionado_por') }}
                <div>
                    <button class="btn btn-danger btn-sm mb-2" id="inspectpor-clear">Limpiar</button>
                    <canvas id="inspectpor-canvas" height="128" width="450" class="{{ $errors->has('inspeccionado_por') ? ' is-invalid' : '' }}" style="height: 8rem;"></canvas>
                    {!! $errors->first('inspeccionador', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('nivel') }}
                {{ Form::text('nivel', $liquidosPenetrante->nivel, ['class' => 'form-control' . ($errors->has('nivel') ? ' is-invalid' : ''),'placeholder' => 'Nivel']) }}
                {!! $errors->first('nivel', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-8 col-sm-12">
                {{ Form::label('revisado_por') }}
                <div>
                    <button class="btn btn-danger btn-sm mb-2" id="review-clear">Limpiar</button>
                    <canvas id="reviewpor-canvas" height="128" width="450" class="{{ $errors->has('revisado_por') ? ' is-invalid' : '' }}" style="height: 8rem;"></canvas>
                </div>
                {!! $errors->first('revisado_por', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{ Form::label('nivel2') }}
                {{ Form::text('nivel2', $liquidosPenetrante->nivel2, ['class' => 'form-control' . ($errors->has('nivel2') ? ' is-invalid' : ''),'placeholder' => 'Nivel2']) }}
                {!! $errors->first('nivel2', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                {{ Form::label('observaciones') }}
                {{ Form::text('observaciones', $liquidosPenetrante->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''),'placeholder' => 'Observaciones']) }}
                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <input type="hidden" name="inspeccionado_por" id="inspectpor-input">
        <input type="hidden" name="revisado_por" id="reviewpor-input">
        

    </div>
    <div>
        <button  type="submit" class="btn btn-primary btnEnviar">Aceptar</button>
    </div>
</div>
