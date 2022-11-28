<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-6">
                {{ Form::label('id_columna') }}
                {{ Form::text('id_columna', $juntasInformeVertMetalica->id_columna, ['class' => 'form-control' . ($errors->has('id_columna') ? ' is-invalid' : ''),'placeholder' => 'Id Columna']) }}
                {!! $errors->first('id_columna', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('teorica') }}
                {{ Form::text('teorica', $juntasInformeVertMetalica->teorica, ['class' => 'form-control' . ($errors->has('teorica') ? ' is-invalid' : ''),'placeholder' => 'Teorica']) }}
                {!! $errors->first('teorica', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                {{ Form::label('real') }}
                {{ Form::text('real', $juntasInformeVertMetalica->real, ['class' => 'form-control' . ($errors->has('real') ? ' is-invalid' : ''),'placeholder' => 'Real']) }}
                {!! $errors->first('real', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('desviacion') }}
                {{ Form::text('desviacion', $juntasInformeVertMetalica->desviacion, ['class' => 'form-control' . ($errors->has('desviacion') ? ' is-invalid' : ''),'placeholder' => 'Desviacion']) }}
                {!! $errors->first('desviacion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                {{ Form::label('altura_Columna') }}
                {{ Form::number('altura_Columna', $juntasInformeVertMetalica->altura_Columna, ['class' => 'form-control' . ($errors->has('altura_Columna') ? ' is-invalid' : ''),'placeholder' => 'Altura Columna']) }}
                {!! $errors->first('altura_Columna', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('tolerancia') }}
                {{ Form::text('tolerancia', $juntasInformeVertMetalica->tolerancia, ['class' => 'form-control' . ($errors->has('tolerancia') ? ' is-invalid' : ''),'placeholder' => 'Tolerancia']) }}
                {!! $errors->first('tolerancia', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            
        </div>
        <div class="row">

            <div class="form-group col-6">
                {{ Form::label('norte_1') }}
                {{ Form::text('norte_1', $juntasInformeVertMetalica->norte_1, ['class' => 'form-control' . ($errors->has('norte_1') ? ' is-invalid' : ''),'placeholder' => 'Norte 1']) }}
                {!! $errors->first('norte_1', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('norte_2') }}
                {{ Form::text('norte_2', $juntasInformeVertMetalica->norte_2, ['class' => 'form-control' . ($errors->has('norte_2') ? ' is-invalid' : ''),'placeholder' => 'Norte 2']) }}
                {!! $errors->first('norte_2', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                {{ Form::label('sur_1') }}
                {{ Form::text('sur_1', $juntasInformeVertMetalica->sur_1, ['class' => 'form-control' . ($errors->has('sur_1') ? ' is-invalid' : ''),'placeholder' => 'Sur 1']) }}
                {!! $errors->first('sur_1', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('sur_2') }}
                {{ Form::text('sur_2', $juntasInformeVertMetalica->sur_2, ['class' => 'form-control' . ($errors->has('sur_2') ? ' is-invalid' : ''),'placeholder' => 'Sur 2']) }}
                {!! $errors->first('sur_2', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                {{ Form::label('oriente_1') }}
                {{ Form::text('oriente_1', $juntasInformeVertMetalica->oriente_1, ['class' => 'form-control' . ($errors->has('oriente_1') ? ' is-invalid' : ''),'placeholder' => 'Oriente 1']) }}
                {!! $errors->first('oriente_1', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('oriente_2') }}
                {{ Form::text('oriente_2', $juntasInformeVertMetalica->oriente_2, ['class' => 'form-control' . ($errors->has('oriente_2') ? ' is-invalid' : ''),'placeholder' => 'Oriente 2']) }}
                {!! $errors->first('oriente_2', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                {{ Form::label('occidente_1') }}
                {{ Form::text('occidente_1', $juntasInformeVertMetalica->occidente_1, ['class' => 'form-control' . ($errors->has('occidente_1') ? ' is-invalid' : ''),'placeholder' => 'Occidente 1']) }}
                {!! $errors->first('occidente_1', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-6">
                {{ Form::label('occidente_2') }}
                {{ Form::text('occidente_2', $juntasInformeVertMetalica->occidente_2, ['class' => 'form-control' . ($errors->has('occidente_2') ? ' is-invalid' : ''),'placeholder' => 'Occidente 2']) }}
                {!! $errors->first('occidente_2', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {{ Form::label('resultado_inspeccion') }}
                {{ Form::text('resultado_inspeccion', $juntasInformeVertMetalica->resultado_inspeccion, ['class' => 'form-control' . ($errors->has('resultado_inspeccion') ? ' is-invalid' : ''),'placeholder' => 'Resultado Inspeccion']) }}
                {!! $errors->first('resultado_inspeccion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

    </div>

    <div>
        <button type="submit" class="btn btn-primary btnEnviar" id="btn_salvar_juntas" >Aceptar</button>
    </div>
</div>


<script>
    document.getElementById('tolerancia').disabled = true;
    document.getElementById("altura_Columna").onchange = function() {calcularTolerancia()};

    function calcularTolerancia() {
        let txtAltura = document.getElementById("altura_Columna");
        let txtTolerancia = document.getElementById("tolerancia");

        txtTolerancia.value=txtAltura.value / 500;
    }
</script>
