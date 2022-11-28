@extends('layouts.dashboard')

@section('template_title')
    {{ $juntasInformeUltrasonido->name ?? 'Show Juntas Informe Ultrasonido' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Juntas Informe Ultrasonido</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('juntas-informe-ultrasonidos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $juntasInformeUltrasonido->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Identificacion Elemento:</strong>
                            {{ $juntasInformeUltrasonido->identificacion_elemento }}
                        </div>
                        <div class="form-group">
                            <strong>Junta:</strong>
                            {{ $juntasInformeUltrasonido->junta }}
                        </div>
                        <div class="form-group">
                            <strong>Ubicacion Junta:</strong>
                            {{ $juntasInformeUltrasonido->ubicacion_junta }}
                        </div>
                        <div class="form-group">
                            <strong>Indicacion Numero:</strong>
                            {{ $juntasInformeUltrasonido->indicacion_numero }}
                        </div>
                        <div class="form-group">
                            <strong>Desde Cara:</strong>
                            {{ $juntasInformeUltrasonido->desde_cara }}
                        </div>
                        <div class="form-group">
                            <strong>Pierna:</strong>
                            {{ $juntasInformeUltrasonido->pierna }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel Indicacion:</strong>
                            {{ $juntasInformeUltrasonido->nivel_indicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel Referencia:</strong>
                            {{ $juntasInformeUltrasonido->nivel_referencia }}
                        </div>
                        <div class="form-group">
                            <strong>Factor Atenuacion:</strong>
                            {{ $juntasInformeUltrasonido->factor_atenuacion }}
                        </div>
                        <div class="form-group">
                            <strong>Valoracion Indicacion:</strong>
                            {{ $juntasInformeUltrasonido->valoracion_indicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Longitud Defecto:</strong>
                            {{ $juntasInformeUltrasonido->longitud_defecto }}
                        </div>
                        <div class="form-group">
                            <strong>Distancia Angular:</strong>
                            {{ $juntasInformeUltrasonido->distancia_angular }}
                        </div>
                        <div class="form-group">
                            <strong>Profundidad Desde:</strong>
                            {{ $juntasInformeUltrasonido->profundidad_desde }}
                        </div>
                        <div class="form-group">
                            <strong>Evaluacion Discontinuidad 1:</strong>
                            {{ $juntasInformeUltrasonido->evaluacion_discontinuidad_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Evaluacion Discontinuidad 2:</strong>
                            {{ $juntasInformeUltrasonido->evaluacion_discontinuidad_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Evaluacion Discontinuidad 3:</strong>
                            {{ $juntasInformeUltrasonido->evaluacion_discontinuidad_3 }}
                        </div>
                        <div class="form-group">
                            <strong>Distancia Desde X:</strong>
                            {{ $juntasInformeUltrasonido->distancia_desde_x }}
                        </div>
                        <div class="form-group">
                            <strong>Distancia Desde Y:</strong>
                            {{ $juntasInformeUltrasonido->distancia_desde_y }}
                        </div>
                        <div class="form-group">
                            <strong>Estampe Soldador:</strong>
                            {{ $juntasInformeUltrasonido->estampe_soldador }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $juntasInformeUltrasonido->observaciones }}
                        </div>
                        <div class="form-group">
                            <strong>Inf Ultrasonido Id:</strong>
                            {{ $juntasInformeUltrasonido->inf_ultrasonido_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
