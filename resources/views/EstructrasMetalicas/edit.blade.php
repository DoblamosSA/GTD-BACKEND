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
                            <input type="text" class="form-control" placeholder="Numero Obra " name="Numero_Obra" value="{{$estructuraMelalica->Numero_Obra}}">

                        </div>
                        <div class="col">
                            <label>Nombre Obra</label>
                            <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra" value="{{$estructuraMelalica->Nombre_Obra}}">

                        </div>
                        <div class="col">
                            <label>Lugar Obra</label>
                            <input type="text" class="form-control" placeholder="Lugar_Obra " name="Lugar_Obra" value="{{$estructuraMelalica->Lugar_Obra}}">

                        </div>
                        <div class="col">
                            <label>Fecha Recibido</label>
                            <input type="date" class="form-control" placeholder="Fecha Recibido " name="Fecha_Recibido" value="{{$estructuraMelalica->Fecha_Recibido}}">

                        </div>


                    </div>

                    <br>
                    <div class="form-row">

                        <div class="col">
                            <label>Fecha Cotizada</label>
                            <input type="date" class="form-control" placeholder="Fecha Cotizada " name="Fecha_Cotizada" value="{{$estructuraMelalica->Fecha_Cotizada}}">

                        </div>

                        <div class="col">
                            <label>Valor Antes Iva</label>
                            <input type="float" class="form-control" placeholder="Valor antes iva "
                                name="Valor_Antes_Iva" value="{{$estructuraMelalica->Valor_Antes_Iva}}">

                        </div>

                        <div class="col">
                            <label>Valor Adjudicado</label>
                            <input type="float" class="form-control" placeholder="Valor Adjudicado "
                                name="Valor_Adjudicado" value="{{$estructuraMelalica->Valor_Adjudicado}}">

                        </div>

                        <div class="col">
                            <label>Tipologia</label>
                            <select name="Tipologia" class="form-control" placeholder="Tipologia">
                                <option class="form-control">{{$estructuraMelalica->Tipologia}}</option>
                                <option class="form-control" value="Bodegas">Bodegas</option>
                                <option class="form-control" value="Edificio">Edificio</option>
                                <option class="form-control" value="Entrepisos">Entrepisos</option>
                                <option class="form-control" value="Servicios y suministros">Servicios y suministros</option>
                                <option class="form-control" value="Proyectos Especiales">Proyectos Especiales</option>
                                <option class="form-control" value="Cubiertas">Cubiertas</option>
                                <option class="form-control" value="Paneles">Paneles</option>
                                <option class="form-control" value="Casas">Casas</option>
                            </select>

                        </div>




                        

                    </div>


                    <br>
                    <div class="form-row">

                       

                    <div class="col">
                            <label>Estado</label>
                            <select name="Estado" class="form-control" placeholder="Estado">
                                <option class="form-control">{{$estructuraMelalica->Estado}}</option>
                                <option class="form-control" value="Perdida">Perdida</option>
                                <option class="form-control" value="Seguimiento">Seguimiento</option>
                                <option class="form-control" value="Vendida">Vendida</option>
                                <option class="form-control" value="Pendiente">Pendiente</option>
                                <option class="form-control" value="Cerrada">Cerrada</option>
                                <option class="form-control" value="Adjudicada">Adjudicada</option>
                                <option class="form-control" value="No cotizada">No cotizada</option>


                            </select>

                        </div>


                        <div class="col">
                            <label>Peso Cotizado</label>
                            <input type="number" class="form-control" placeholder="Peso Cotizado " name="Peso_Cotizado" value="{{$estructuraMelalica->Peso_Cotizado}}">

                        </div>
                        <div class="col">
                            <label>Area</label>
                            <input type="number" class="form-control" placeholder="Area" name="Area_Cotizada" value="{{$estructuraMelalica->Area_Cotizada}}">

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
