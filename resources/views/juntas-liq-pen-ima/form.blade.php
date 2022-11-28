<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('file_path') }}
            {{ Form::text('file_path', $juntasLiqPenIma->file_path, ['class' => 'form-control' . ($errors->has('file_path') ? ' is-invalid' : ''), 'placeholder' => 'File Path']) }}
            {!! $errors->first('file_path', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('junta_liq_penetran_id') }}
            {{ Form::text('junta_liq_penetran_id', $juntasLiqPenIma->junta_liq_penetran_id, ['class' => 'form-control' . ($errors->has('junta_liq_penetran_id') ? ' is-invalid' : ''), 'placeholder' => 'Junta Liq Penetran Id']) }}
            {!! $errors->first('junta_liq_penetran_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
         <button  type="submit" class="btn btn-primary btnEnviar">Aceptar</button>
    </div>
</div>