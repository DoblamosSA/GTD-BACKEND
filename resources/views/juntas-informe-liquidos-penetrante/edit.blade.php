@extends('layouts.app')

@section('template_title')
    Update Juntas Informe Liquidos Penetrante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Datos Juntas Informe Liquidos Penetrante</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('juntas-informe-liquidos-penetrantes.update', $juntasInformeLiquidosPenetrante->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('juntas-informe-liquidos-penetrante.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
