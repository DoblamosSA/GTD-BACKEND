@extends('layouts.dashboard')

@section('template_title')
Nueva cotizacion
@endsection

@section('content')

<br><br><br><br><br><br>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header" style="background-color:#343a40;  ">
                    <span class="card-title" style="margin-left: 40%; color:white">Registro Clientes SAP</span>
                </div>

                <div class="card-body">

                    @if (session()->has('msj'))

                    <div class="alert alert-info" role="alert">
                        {{session('msj')}}
                    </div>
                    @endif
                    <form action="{{route('ClientesSAP.RegistroClienteSAP')}}" method="POST" class="guardadosap">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Cedula o nit cliente"
                                    name="CardCode" >
                            </div>


                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Nombres Cliente" name="CardName"
                                    value="{{old('CardName')}}">

                            </div>

                            <!-- <div class="col-md-6 mt-2">
                                <select class="form-control" name="CardType" disabled>
                                    <option value="L">cLid</option>

                                </select>



                            </div> -->

                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control" placeholder="Rut Cliente" name="FederalTaxID">


                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control" placeholder="Email" name="Address">

                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="number" class="form-control" placeholder="Telefono" name="Phone1">

                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control" placeholder="Ciudad" name="City">

                            </div>


                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control" placeholder="Pais" name="Country" value="CO"
                                    disabled>


                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control" placeholder="correo facturacion eletronica"
                                    name="EmailAddress">

                            </div>
                            <!-- <div class="col-md-6 mt-2">
                                <select class="form-control" name="GroupCode" disabled>
                                    <option value="108">108</option>

                                </select>



                            </div> -->


                        </div>

                </div>

                <div class="box-footer mt-2">
                    <button type="submit" class="btn btn-primary">Guardar Registro</button>
                </div>
                </form>
            </div>
        </div>







    </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- CSS only -->

@if (session('msj') == 'ok')
<script>
swal.fire(
    'Cliente creado correctamente',
    'Registro guardado en SAP!',
    'success'
)
</script>
@endif

<script>
$('.guardadosap').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas crear el cliente en SAP?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '3085d6',
        CancelButtonColor: '#d33',
        CancelButtonText: 'yes, delete it!'

    }).then((result) => {
        if (result.value) {
            this.submit();
        }

    })
});
</script>

@endsection