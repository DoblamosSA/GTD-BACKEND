@extends('layouts.app')

@section('template_title')
    {{ $juntasInformeLiquidosPenetrante->name ?? 'Show Juntas Informe Liquidos Penetrante' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Juntas Informe Liquidos Penetrante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('juntas-informe-liquidos-penetrantes.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Elemento:</strong>
                            {{ $juntasInformeLiquidosPenetrante->elemento }}
                        </div>
                        <div class="form-group">
                            <strong>Junta:</strong>
                            {{ $juntasInformeLiquidosPenetrante->junta }}
                        </div>
                        <div class="form-group">
                            <strong>Indicacion:</strong>
                            {{ $juntasInformeLiquidosPenetrante->indicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Calificacion:</strong>
                            {{ $juntasInformeLiquidosPenetrante->calificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $juntasInformeLiquidosPenetrante->observaciones }}
                        </div>
                        <div class="form-group">
                            <strong>Inf Liq Penetran Id:</strong>
                            {{ $juntasInformeLiquidosPenetrante->inf_liq_penetran_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
