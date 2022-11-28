@extends('layouts.dashboard')

@section('template_title')
    Update Juntas Informe Vert Metalica
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Datos Juntas Informe Vert Metalica</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('juntas-informe-vert-metalicas.update', $juntasInformeVertMetalica->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('juntas-informe-vert-metalica.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
