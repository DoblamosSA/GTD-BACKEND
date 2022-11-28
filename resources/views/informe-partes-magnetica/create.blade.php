@extends('layouts.dashboard')

@section('template_title')
    Create Informe Partes Magnetica
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Informe Partes Magnetica</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('informe-partes-magneticas.store') }}"  role="form" enctype="multipart/form-data" id="informe-partes-magneticas-form">
                            @csrf
                            <input type="hidden" name="digitar" value="true">
                            @include('informe-partes-magnetica.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        #inspect-canvas,
        #review-canvas {
            border: 1px solid #060606;
            border-radius: .25rem;
        }
    </style>
@endsection
