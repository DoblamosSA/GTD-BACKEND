@extends('layouts.dashboard')

@section('template_title')
Editar Seguimiento
@endsection

@section('content')

<br>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Editar seguimiento cotización</span>
                </div> <br>
              
                <form action="{{route('estructurasMetalicas.update',$estructuraMelalica->id)}}" method="POST" class="formulario-editar">
                    @csrf
                    @method('PATCH')

                    <div class="form-row">

                        <div class="col">
                            <label>Numero Obra</label>
                            <input type="number" class="form-control" placeholder="Numero Obra " name="Numero_Obra" value="{{ $estructuraMelalica->Numero_Obra}}">
                           
                        </div>
                        <div class="col">
                            <label>Empresa Cliente</label>
                            <input type="text" class="form-control" placeholder="Empresa Cliente "
                                name="Empresa_Cliente" value="{{ $estructuraMelalica->Empresa_Cliente}}">

                        </div>
                        <div class="col">
                            <label>Fecha Recibido</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Recibido" value="{{ $estructuraMelalica->Fecha_Recibido}}">

                        </div>
                        <div class="col">
                            <label>Nombre Obra</label>
                            <input type="text" class="form-control" placeholder="Nombre Obra " name="Nombre_Obra" value="{{$estructuraMelalica->Nombre_Obra}}">

                        </div>


                    </div>

                    <br>
                     <div class="form-row">

                        <div class="col">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" placeholder="Descripción " name="Descripcion" value="{{ $estructuraMelalica->Descripcion}}">

                        </div>
                        <div class="col">
                            <label>Estado</label>
                            <select name="Estado" class="form-control" placeholder="Estado" style="background-color:#6dbafd;"> 
                                <option class="form-control" >{{ $estructuraMelalica->Estado}}</option>
                                <option class="form-control" value="Perdida">Perdida</option>
                                <option class="form-control" value="Seguimiento">Seguimiento</option>
                                <option class="form-control" value="Vendida">Vendida</option>


                            </select>

                        </div>

                        <div class="col">
                            <label>Fecha Cotizada</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Cotizada" value="{{$estructuraMelalica->Fecha_Cotizada}}">
                        </div>
                        <div class="col">
                            <label>Valor Antes Iva</label>
                            <input type="number" class="form-control" placeholder="Valor antes iva "
                                name="Valor_Antes_Iva" value="{{ $estructuraMelalica->Valor_Antes_Iva}}">

                        </div>


                    </div>


                    <br>
                    <div class="form-row">

                        <div class="col">
                            <label>Contacto</label>
                            <input type="text" class="form-control" placeholder="Contacto " name="Contacto" value="{{ $estructuraMelalica->Contacto}}">

                        </div>


                       <div class="col">
                            <label>AreaM2</label>
                            <input type="number" class="form-control" placeholder="AreaM2 " name="AreaM2" value="{{ $estructuraMelalica->AreaM2}}">

                        </div>
                        <div class="col">
                            <label>/m2</label>
                            <input type="number" class="form-control" placeholder="/m2 " name="m2" value="{{ $estructuraMelalica->m2}}">

                        </div>
                        <div class="col">
                            <label>Incluye Montaje</label>
                            <select name="Incluye_Montaje" class="form-control" placeholder="Incluye Montaje">
                                <option class="form-control">{{ $estructuraMelalica->Incluye_Montaje}}</option>
                                <option class="form-control" value="No inluye">No incluye</option>
                                <option class="form-control" value="Si Incluye">Si Incluye</option>



                            </select>

                        </div> 


                    </div> 
                    <br>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Editar Registro</button>
                    </div>
                </form>




            </div>
        </div>
    </div>
    </div>
</section>


@endsection
