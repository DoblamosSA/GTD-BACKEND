@extends('layouts.app')

@section('template_title')
    Datos Juntas Partes Magneticas Imagene
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Datos Juntas Partes Magneticas Imagene</span>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('juntas-partes-magneticas-imagenes.update', $juntasPartesMagneticasImagene->id) }}"
                            role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('juntas-partes-magneticas-imagene.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
