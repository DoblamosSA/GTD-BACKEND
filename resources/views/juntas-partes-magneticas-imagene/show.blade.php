@extends('layouts.app')

@section('template_title')
    {{ $juntasPartesMagneticasImagene->name ?? 'Show Juntas Partes Magneticas Imagene' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Juntas Partes Magneticas Imagene</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('juntas-partes-magneticas-imagenes.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>File Path:</strong>
                            {{ $juntasPartesMagneticasImagene->file_path }}
                        </div>
                        <div class="form-group">
                            <strong>Junta Id:</strong>
                            {{ $juntasPartesMagneticasImagene->junta_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
