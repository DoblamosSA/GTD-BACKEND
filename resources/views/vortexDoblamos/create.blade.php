@extends('layouts.dashboard')

@section('template_title')
Nueva cotizacion
@endsection

@section('content')

<br>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Registro seguimiento cotización</span>
                </div> <br>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{route('vortexDoblamos.store')}}" method="POST" class="formulario-crear">
                    @csrf
                    @method('post')

                    <div class="form-row">
                      
                        <div class="col">
                            <label>Numero Obra</label>
                            <input type="text" class="form-control" placeholder="Numero Obra " name="Numero_Obra">

                        </div>
                        <div class="col">
                            <label>Nombre Obra</label>
                            <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra">

                        </div>
                        <div class="col">
                            <label>Lugar Obra</label>
                            <input type="text" class="form-control" placeholder="Lugar_Obra " name="Lugar_Obra">

                        </div>
                        <div class="col">
                            <label>Fecha Recibido</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Recibido">

                        </div>


                    </div>

                    <br>
                    <div class="form-row">

                        <div class="col">
                            <label>Fecha Cotizada</label>
                            <input type="date" class="form-control" placeholder="Fecha Cotizada " name="Fecha_Cotizada">

                        </div>

                        <div class="col">
                            <label>Valor Antes Iva</label>
                            <input type="float" class="form-control" placeholder="Valor antes iva "
                                name="Valor_Antes_Iva">

                        </div>

                        <div class="col">
                            <label>Valor Adjudicado</label>
                            <input type="float" class="form-control" placeholder="Valor Adjudicado "
                                name="Valor_Adjudicado">

                        </div>

                        <div class="col">
                            <label>Tipologia</label>
                            <select name="Tipologia" class="form-control" placeholder="Tipologia">
                                <option class="form-control"></option>
                                <option class="form-control" value="Fachadas 3D">Fachadas 3D</option>
                                <option class="form-control" value="Fachadas 2D">Fachadas 2D</option>
                                <option class="form-control" value="Cerramientos">Cerramientos</option>
                                <option class="form-control" value="Puertas">Puertas</option>
                                <option class="form-control" value="Lamina Perforada">Lamina Perforada</option>
                                <option class="form-control" value="Paneles">Paneles</option>
                                <option class="form-control" value="Cielos">Cielos</option>
                                <option class="form-control" value="Corta Soles">Corta Soles</option>
                                <option class="form-control" value="Avisos">Avisos</option>
                                <option class="form-control" value="Pasamanos">Pasamanos</option>
                                <option class="form-control" value="Otros">Otros</option>
                            </select>

                        </div>






                    </div>


                    <br>
                    <div class="form-row">



                        <div class="col">
                            <label>Estado</label>
                            <select name="Estado" class="form-control" placeholder="Estado">
                                <option class="form-control"></option>
                                <option class="form-control" value="Perdida">Perdida</option>
                                <option class="form-control" value="Seguimiento">Seguimiento</option>
                                <option class="form-control" value="Vendida">Vendida</option>
                                <option class="form-control" value="Vendida">Pendiente</option>
                                <option class="form-control" value="Cerrada">Cerrada</option>
                                <option class="form-control" value="Adjudicada">Adjudicada</option>
                                <option class="form-control" value="No cotizada">No cotizada</option>



                            </select>

                        </div>


                        <div class="col">
                            <label>$M2</label>
                            <input type="number" class="form-control" placeholder="$m2 " name="m2">

                        </div>
                        <div class="col">
                            <label>Incluye Montaje</label>
                            <select name="Incluye_Montaje" class="form-control" placeholder="Incluye Montaje">
                                <option class="form-control"></option>
                                <option class="form-control" value="Si Incluye">Si Incluye</option>
                                <option class="form-control" value="No Incluye">No Incluye</option>

                            </select>
                        </div>

                        <div class="col">
                            <label>Origen</label>
                            <input type="text" class="form-control" placeholder="Origen " name="Origen">

                        </div>
                        <!-- <div class="col">
                            <label>Cliente</label>
                            <input type="text" class="form-control" placeholder="cliente " name="clientes_id">

                        </div> -->
                        <div class="col">
                            <label>Cliente</label>
                            <select name="clientes_id" class="form-control" id="clientes_id">


                                <option class="form-control">Cliente</option>
                                @foreach ($client as $row)
                                <option class="form-control" value="{{ $row->id }}">
                                    {{ $row->Nit}} {{ $row->Empresa }}
                                </option>
                                @endforeach

                            </select>

                        </div>


                    </div>
                    <br>


                    <br>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Guardar Registro</button>
                    </div>
                </form>




            </div>
        </div>
    </div>
    </div>
</section>


@endsection