@extends('layouts.dashboard')

@section('template_title')
    Create Liquidos Penetrante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Informe Liquidos Penetrante</span>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('informe-liquidos-penetrante.store') }}" role="form" enctype="multipart/form-data" id="informe-liquidos-penetrante">
                            @csrf
                            <input type="hidden" name="digitar" value="true">
                            @include('informe-liquidos-penetrante.form')
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <style>
        #inspectpor-canvas,
        #reviewpor-canvas {
            border: 1px solid #060606;
            border-radius: .25rem;
        }
    </style>
@endsection
