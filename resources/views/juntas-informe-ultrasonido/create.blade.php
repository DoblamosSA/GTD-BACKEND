@extends('layouts.dashboard')

@section('template_title')
    Create Juntas Informe Ultrasonido
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Juntas Informe Ultrasonido</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('juntas-informe-ultrasonidos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('juntas-informe-ultrasonido.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
