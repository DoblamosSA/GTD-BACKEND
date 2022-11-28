@extends('layouts.app')

@section('template_title')
    {{ $juntasLiqPenIma->name ?? 'Show Juntas Liq Pen Ima' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Juntas Liq Pen Ima</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('juntas-liq-pen-imas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>File Path:</strong>
                            {{ $juntasLiqPenIma->file_path }}
                        </div>
                        <div class="form-group">
                            <strong>Junta Liq Penetran Id:</strong>
                            {{ $juntasLiqPenIma->junta_liq_penetran_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
