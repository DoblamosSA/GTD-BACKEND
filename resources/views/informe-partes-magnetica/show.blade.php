@extends('layouts.dashboard')

@section('template_title')
    {{ $informePartesMagnetica->name ?? 'Show Informe Partes Magnetica' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Informe Partes Magnetica</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('informe-partes-magneticas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Proyecto:</strong>
                            {{ $informePartesMagnetica->proyecto }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $informePartesMagnetica->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Sitio Inspeccion:</strong>
                            {{ $informePartesMagnetica->sitio_inspeccion }}
                        </div>
                        <div class="form-group">
                            <strong>Cod Acep Rechazo:</strong>
                            {{ $informePartesMagnetica->cod_acep_rechazo }}
                        </div>
                        <div class="form-group">
                            <strong>Calidad Material B:</strong>
                            {{ $informePartesMagnetica->calidad_material_b }}
                        </div>
                        <div class="form-group">
                            <strong>Proceso Soldadura:</strong>
                            {{ $informePartesMagnetica->proceso_soldadura }}
                        </div>
                        <div class="form-group">
                            <strong>Espesor Material B:</strong>
                            {{ $informePartesMagnetica->espesor_material_b }}
                        </div>
                        <div class="form-group">
                            <strong>Inspeccionador:</strong>
                            {{ $informePartesMagnetica->inspeccionador }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel:</strong>
                            {{ $informePartesMagnetica->nivel }}
                        </div>
                        <div class="form-group">
                            <strong>Reviso:</strong>
                            {{ $informePartesMagnetica->reviso }}
                        </div>
                        <div class="form-group">
                            <strong>Nivelreviso:</strong>
                            {{ $informePartesMagnetica->nivelreviso }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
