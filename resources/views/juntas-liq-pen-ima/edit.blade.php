@extends('layouts.app')

@section('template_title')
    Update Juntas Liq Pen Ima
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Juntas Liq Pen Ima</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('juntas-liq-pen-imas.update', $juntasLiqPenIma->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('juntas-liq-pen-ima.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
