@extends('layouts.dashboard')

@section('template_title')
    {{ $informeUltrasonido->name ?? 'Show Informe Ultrasonido' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Informe Ultrasonido</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('informe-ultrasonido.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Proyecto:</strong>
                            {{ $informeUltrasonido->proyecto }}
                        </div>
                        <div class="form-group">
                            <strong>Codigo Norma Aplicable:</strong>
                            {{ $informeUltrasonido->codigo_norma_aplicable }}
                        </div>
                        <div class="form-group">
                            <strong>Procedimiento Ut No:</strong>
                            {{ $informeUltrasonido->procedimiento_ut_no }}
                        </div>
                        <div class="form-group">
                            <strong>Metodo Ensayo:</strong>
                            {{ $informeUltrasonido->metodo_ensayo }}
                        </div>
                        <div class="form-group">
                            <strong>Grado Calibracion:</strong>
                            {{ $informeUltrasonido->grado_calibracion }}
                        </div>
                        <div class="form-group">
                            <strong>Bloquereferencia Tipo:</strong>
                            {{ $informeUltrasonido->bloquereferencia_tipo }}
                        </div>
                        <div class="form-group">
                            <strong>Bloque Referencia Serial:</strong>
                            {{ $informeUltrasonido->bloque_referencia_serial }}
                        </div>
                        <div class="form-group">
                            <strong>Calidad Material Base:</strong>
                            {{ $informeUltrasonido->calidad_material_base }}
                        </div>
                        <div class="form-group">
                            <strong>Espesor:</strong>
                            {{ $informeUltrasonido->espesor }}
                        </div>
                        <div class="form-group">
                            <strong>Metal Aporte:</strong>
                            {{ $informeUltrasonido->metal_aporte }}
                        </div>
                        <div class="form-group">
                            <strong>Acoplante:</strong>
                            {{ $informeUltrasonido->acoplante }}
                        </div>
                        <div class="form-group">
                            <strong>Proceso:</strong>
                            {{ $informeUltrasonido->proceso }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo Junta:</strong>
                            {{ $informeUltrasonido->tipo_junta }}
                        </div>
                        <div class="form-group">
                            <strong>Paso:</strong>
                            {{ $informeUltrasonido->paso }}
                        </div>
                        <div class="form-group">
                            <strong>Medio Paso:</strong>
                            {{ $informeUltrasonido->medio_paso }}
                        </div>
                        <div class="form-group">
                            <strong>Rango:</strong>
                            {{ $informeUltrasonido->rango }}
                        </div>
                        <div class="form-group">
                            <strong>Elaboro:</strong>
                            {{ $informeUltrasonido->elaboro }}
                        </div>
                        <div class="form-group">
                            <strong>Reviso:</strong>
                            {{ $informeUltrasonido->reviso }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
