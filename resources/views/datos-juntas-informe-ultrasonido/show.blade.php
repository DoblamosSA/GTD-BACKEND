@extends('layouts.app')

@section('template_title')
    {{ $datosJuntasInformeUltrasonido->name ?? 'Show Datos Juntas Informe Ultrasonido' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Datos Juntas Informe Ultrasonido</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('datos-juntas-informe-ultrasonidos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Ubicacion Junta:</strong>
                            {{ $datosJuntasInformeUltrasonido->ubicacion_junta }}
                        </div>
                        <div class="form-group">
                            <strong>Indicacion Numero:</strong>
                            {{ $datosJuntasInformeUltrasonido->indicacion_numero }}
                        </div>
                        <div class="form-group">
                            <strong>Desde Cara:</strong>
                            {{ $datosJuntasInformeUltrasonido->desde_cara }}
                        </div>
                        <div class="form-group">
                            <strong>Pierna:</strong>
                            {{ $datosJuntasInformeUltrasonido->pierna }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel Indicacion:</strong>
                            {{ $datosJuntasInformeUltrasonido->nivel_indicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel Referencia:</strong>
                            {{ $datosJuntasInformeUltrasonido->nivel_referencia }}
                        </div>
                        <div class="form-group">
                            <strong>Factor Atenuacion:</strong>
                            {{ $datosJuntasInformeUltrasonido->factor_atenuacion }}
                        </div>
                        <div class="form-group">
                            <strong>Valoracion Indicacion:</strong>
                            {{ $datosJuntasInformeUltrasonido->valoracion_indicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Longitud Defecto:</strong>
                            {{ $datosJuntasInformeUltrasonido->longitud_defecto }}
                        </div>
                        <div class="form-group">
                            <strong>Distancia Angular:</strong>
                            {{ $datosJuntasInformeUltrasonido->distancia_angular }}
                        </div>
                        <div class="form-group">
                            <strong>Profundidad Desde:</strong>
                            {{ $datosJuntasInformeUltrasonido->profundidad_desde }}
                        </div>
                        <div class="form-group">
                            <strong>Evaluacion Discontinuidad 1:</strong>
                            {{ $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Evaluacion Discontinuidad 2:</strong>
                            {{ $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Evaluacion Discontinuidad 3:</strong>
                            {{ $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_3 }}
                        </div>
                        <div class="form-group">
                            <strong>Distancia Desde X:</strong>
                            {{ $datosJuntasInformeUltrasonido->distancia_desde_x }}
                        </div>
                        <div class="form-group">
                            <strong>Distancia Desde Y:</strong>
                            {{ $datosJuntasInformeUltrasonido->distancia_desde_y }}
                        </div>
                        <div class="form-group">
                            <strong>Estampe Soldador:</strong>
                            {{ $datosJuntasInformeUltrasonido->estampe_soldador }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $datosJuntasInformeUltrasonido->observaciones }}
                        </div>
                        <div class="form-group">
                            <strong>Jun Inf Ult Id:</strong>
                            {{ $datosJuntasInformeUltrasonido->jun_inf_ult_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
