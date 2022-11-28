@extends('layouts.dashboard')

@section('template_title')
    {{ $liquidosPenetrante->name ?? 'Show Liquidos Penetrante' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Liquidos Penetrante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('informe-liquidos-penetrante.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre Proyecto:</strong>
                            {{ $liquidosPenetrante->nombre_proyecto }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $liquidosPenetrante->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Lugar Inspeccion:</strong>
                            {{ $liquidosPenetrante->lugar_inspeccion }}
                        </div>
                        <div class="form-group">
                            <strong>Metodologia Aplicada:</strong>
                            {{ $liquidosPenetrante->metodologia_aplicada }}
                        </div>
                        <div class="form-group">
                            <strong>Procedimiento Pt:</strong>
                            {{ $liquidosPenetrante->procedimiento_pt }}
                        </div>
                        <div class="form-group">
                            <strong>Codigo Aceptacion Rechazo:</strong>
                            {{ $liquidosPenetrante->codigo_aceptacion_rechazo }}
                        </div>
                        <div class="form-group">
                            <strong>Calidad Material Base:</strong>
                            {{ $liquidosPenetrante->calidad_material_base }}
                        </div>
                        <div class="form-group">
                            <strong>Proceso Soldadura:</strong>
                            {{ $liquidosPenetrante->proceso_soldadura }}
                        </div>
                        <div class="form-group">
                            <strong>Espesor Material Base:</strong>
                            {{ $liquidosPenetrante->espesor_material_base }}
                        </div>
                        <div class="form-group">
                            <strong>Elemento:</strong>
                            {{ $liquidosPenetrante->elemento }}
                        </div>
                        <div class="form-group">
                            <strong>Inspeccionado Por:</strong>
                            {{ $liquidosPenetrante->inspeccionado_por }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel:</strong>
                            {{ $liquidosPenetrante->nivel }}
                        </div>
                        <div class="form-group">
                            <strong>Revisado Por:</strong>
                            {{ $liquidosPenetrante->revisado_por }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel2:</strong>
                            {{ $liquidosPenetrante->nivel2 }}
                        </div>
                        <div class="form-group">
                            <strong>Mensaje Doblamos:</strong>
                            {{ $liquidosPenetrante->mensaje_doblamos }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
