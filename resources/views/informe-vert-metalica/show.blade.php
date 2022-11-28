@extends('layouts.dashboard')

@section('template_title')
    {{ $informeVertMetalica->name ?? 'Show Informe Vert Metalica' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Informe Vert Metalica</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('informe-vert-metalica.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Proyecto:</strong>
                            {{ $informeVertMetalica->proyecto }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Verificacion:</strong>
                            {{ $informeVertMetalica->fecha_verificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Estructuras:</strong>
                            {{ $informeVertMetalica->estructuras }}
                        </div>
                        <div class="form-group">
                            <strong>Planta Area:</strong>
                            {{ $informeVertMetalica->planta_area }}
                        </div>
                        <div class="form-group">
                            <strong>Contratista:</strong>
                            {{ $informeVertMetalica->contratista }}
                        </div>
                        <div class="form-group">
                            <strong>Equipo Medicion:</strong>
                            {{ $informeVertMetalica->equipo_medicion }}
                        </div>
                        <div class="form-group">
                            <strong>Torque 1:</strong>
                            {{ $informeVertMetalica->torque_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Torque 2:</strong>
                            {{ $informeVertMetalica->torque_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Resultado Inspeccion:</strong>
                            {{ $informeVertMetalica->resultado_inspeccion }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $informeVertMetalica->observaciones }}
                        </div>
                        <div class="form-group">
                            <strong>Adjuntos:</strong>
                            {{ $informeVertMetalica->adjuntos }}
                        </div>
                        <div class="form-group">
                            <strong>Contratisca Nombre:</strong>
                            {{ $informeVertMetalica->contratisca_nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Contratisca Firma:</strong>
                            {{ $informeVertMetalica->contratisca_firma }}
                        </div>
                        <div class="form-group">
                            <strong>Contratisca Cargo:</strong>
                            {{ $informeVertMetalica->contratisca_cargo }}
                        </div>
                        <div class="form-group">
                            <strong>Residente Nombre:</strong>
                            {{ $informeVertMetalica->residente_nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Residente Firma:</strong>
                            {{ $informeVertMetalica->residente_firma }}
                        </div>
                        <div class="form-group">
                            <strong>Residente Cargo:</strong>
                            {{ $informeVertMetalica->residente_cargo }}
                        </div>
                        <div class="form-group">
                            <strong>Inspector Nombre:</strong>
                            {{ $informeVertMetalica->inspector_nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Inspector Firma:</strong>
                            {{ $informeVertMetalica->inspector_firma }}
                        </div>
                        <div class="form-group">
                            <strong>Inspector Cargo:</strong>
                            {{ $informeVertMetalica->inspector_cargo }}
                        </div>
                        <div class="form-group">
                            <strong>Representante Nombre:</strong>
                            {{ $informeVertMetalica->representante_nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Representante Firma:</strong>
                            {{ $informeVertMetalica->representante_firma }}
                        </div>
                        <div class="form-group">
                            <strong>Representante Cargo:</strong>
                            {{ $informeVertMetalica->representante_cargo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
