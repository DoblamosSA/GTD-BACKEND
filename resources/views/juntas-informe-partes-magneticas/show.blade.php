@extends('layouts.app')

@section('template_title')
    {{ $juntasInformePartesMagnetica->name ?? 'Show Juntas Informe Partes Magnetica' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Juntas Informe Partes Magnetica</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('juntas-informe-partes-magneticas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Elemento:</strong>
                            {{ $juntasInformePartesMagnetica->elemento }}
                        </div>
                        <div class="form-group">
                            <strong>Junta:</strong>
                            {{ $juntasInformePartesMagnetica->junta }}
                        </div>
                        <div class="form-group">
                            <strong>Indicacion:</strong>
                            {{ $juntasInformePartesMagnetica->indicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Calificacion:</strong>
                            {{ $juntasInformePartesMagnetica->calificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $juntasInformePartesMagnetica->observaciones }}
                        </div>
                        <div class="form-group">
                            <strong>Inf Part Magneticas Id:</strong>
                            {{ $juntasInformePartesMagnetica->inf_part_magneticas_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
