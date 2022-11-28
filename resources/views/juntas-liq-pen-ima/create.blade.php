@extends('layouts.app')

@section('template_title')
    Create Juntas Liq Pen Ima
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Juntas Liq Pen Ima</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('juntas-liq-pen-imas.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('juntas-liq-pen-ima.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
