@extends('layouts.dashboard')

@section('template_title')
    {{ $juntasInformeVertMetalica->name ?? 'Show Juntas Informe Vert Metalica' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Juntas Informe Vert Metalica</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('juntas-informe-vert-metalicas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Columna:</strong>
                            {{ $juntasInformeVertMetalica->id_columna }}
                        </div>
                        <div class="form-group">
                            <strong>Teorica:</strong>
                            {{ $juntasInformeVertMetalica->teorica }}
                        </div>
                        <div class="form-group">
                            <strong>Real:</strong>
                            {{ $juntasInformeVertMetalica->real }}
                        </div>
                        <div class="form-group">
                            <strong>Desviacion:</strong>
                            {{ $juntasInformeVertMetalica->desviacion }}
                        </div>
                        <div class="form-group">
                            <strong>Altura Columna:</strong>
                            {{ $juntasInformeVertMetalica->altura_Columna }}
                        </div>
                        <div class="form-group">
                            <strong>Tolerancia:</strong>
                            {{ $juntasInformeVertMetalica->tolerancia }}
                        </div>
                        <div class="form-group">
                            <strong>Norte 1:</strong>
                            {{ $juntasInformeVertMetalica->norte_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Norte 2:</strong>
                            {{ $juntasInformeVertMetalica->norte_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Sur 1:</strong>
                            {{ $juntasInformeVertMetalica->sur_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Sur 2:</strong>
                            {{ $juntasInformeVertMetalica->sur_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Oriente 1:</strong>
                            {{ $juntasInformeVertMetalica->oriente_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Oriente 2:</strong>
                            {{ $juntasInformeVertMetalica->oriente_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Occidente 1:</strong>
                            {{ $juntasInformeVertMetalica->occidente_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Occidente 2:</strong>
                            {{ $juntasInformeVertMetalica->occidente_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Resultado Inspeccion:</strong>
                            {{ $juntasInformeVertMetalica->resultado_inspeccion }}
                        </div>
                        <div class="form-group">
                            <strong>Inf Vert Met Id:</strong>
                            {{ $juntasInformeVertMetalica->inf_vert_met_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
