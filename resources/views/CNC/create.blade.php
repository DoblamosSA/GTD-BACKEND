@extends('layouts.dashboard')

@section('template_title')
CNC
@endsection



@section('content')


<BR>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" style="color: black; margin-left:40%; ">
                            {{ __('COSTOS DE NO CALIDAD') }}
                        </span>
                    </div>
                </div>

                <div class="modal-body" style="background-color:">

                    <form action="{{route('Costo-No-Calidad.store')}}" method="POST" class="guardadosap">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 ">
                                <label>Sede</label>
                                <select class="form-control" name="sede">
                                    <option>{{old('sede')}}</option>
                                    <option value="Estructuras Sabaneta">Estructuras Sabaneta</option>
                                    <option value="Estructuras Medellin">Estructuras Medellin</option>
                                    <option value="Medellin">Medellin</option>
                                    <option value="Rionegro">Rionegro</option>
                                    <option value="Sabaneta">Sabaneta</option>
                                    <option value="La 33">La 33</option>
                                    <option value="Copacabana">Copacabana</option>

                                </select>
                                @if($errors->has('sede'))
                                <p class="text-danger">{{ $errors->first('sede') }}</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label>Fecha</label>
                                <input type="DATE" class="form-control" placeholder="Fecha del CNC" name="FechaCNC"
                                    value="{{old('FechaCNC')}}">
                                @if($errors->has('FechaCNC'))
                                <p class="text-danger">{{ $errors->first('FechaCNC') }}</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <textarea class="form-control" placeholder="Descripcion breve" name="Descripcion"
                                    style="height: 100px">{{old('Descripcion')}}</textarea>
                                @if($errors->has('Descripcion'))
                                <p class="text-danger">{{ $errors->first('Descripcion') }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="C.C/OP" name="Ccop"
                                    value="{{old('Ccop')}}">
                                @if($errors->has('Ccop'))
                                <p class="text-danger">{{ $errors->first('Ccop') }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 ">
                                <label>Area responsable del CNC</label>
                                <select name="AreaResponsableCNC" class="form-control">
                                    <option class="form-control">{{old('AreaResponsableCNC')}}</option>

                                    <option value="Logistica">Logistica</option>
                                    <option value="Gestion Humana">Gestión Humana</option>
                                    <option value="Estructuras Sabaneta">Estructuras Sabaneta</option>
 				 <option value="Estructuras Copacabana">Estructuras Copacabana</option>
				 <option value="Produccion Rionegro">Producción Rionegro</option>
                                    <option value="Estructuras Medellin">Estructuras Medellin</option>
                                    <option value="Produccion Medellin">Produccion Medellin</option>
                                    <option value="Produccion Sabaneta">Produccion Sabaneta</option>
                                    <option value="Calidad Medellin">Calidad Medellin</option>
                                    <option value="Calidad Sabaneta">Calidad Sabaneta</option>
                                    <option value="Calidad Rionegro">Calidad Rionegro</option>
                                    <option value="Calidad Obras">Calidad Obras</option>
                                    <option value="Vortex">Vortex</option>
                                
                                    <option value="Formaletas">Formaletas</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                    <option value="Cliente">Cliente</option>
  					<option value="Compras">Compras</option>
					<option value="Almacen">Almacen</option>
<option value="Comercial Sabaneta">Comercial Sabaneta</option>
<option value="Comercial Medellin">Comercial Medellin</option>
<option value="Comercial Rionegro">Comercial Rionegro</option>
<option value="Departamento t.i">Departamento t.i</option>
<option value="Comercial La 33">Comercial La 33</option>



                                </select>

                            </div>

                            <div class="col-md-6 ">
                                <label>Subproceso CNC</label>
                                <select name="SubprocesoCNC" class="form-control" id="subproceso">
                                    <option class="form-control">Subproceso CNC</option>
                                    <option class="form-control">{{old('Estado')}}</option>
                                    <option value="Laser">Laser</option>
                                    <option value="Cizalla">Cizalla</option>
                                    <option value="Pantografo">Pantógrafo</option>
                                    <option value="Doblez">Doblez</option>
                                    <option value="Cilindrado">Cilindrado</option>
                                    <option value="Rolado">Rolado</option>
                                    <option value="Geka">Geka</option>
                                    <option value="Trumatic">Trumatic</option>
                                    <option value="Colillado">Colillado</option>
                                    <option value="Sierra Taladro">Sierra Taladro</option>
                                    <option value="Granallado">Granallado</option>
                                    <option value="Soldadura">Soldadura</option>
                                    <option value="Juntas de soldadura">Juntas de soldadura</option>
                                    <option value="Armado">Armado</option>
                                    <option value="Pintura">Pintura</option>
                                    <option value="Transporte">Transporte</option>
                                    <option value="Descargue">Descargue</option>
                                    <option value="Proveedor">Proveedor</option>
                                    <option value="Material">Material</option>
                                    <option value="Puente Grua">Puente grúa</option>
                                    <option value="Comercial">Comercial</option>
                                    <option value="Dibujo">Dibujo</option>
                                    <option value="Montaje">Montaje</option>
                                    <option value="Almacenamiento">Almacenamiento</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                    <option value="Compras">Compras</option>
                                    <option value="Varios">Varios</option>
                                    <option value="Programacion">Programacion</option>
                                    <option value="Ingenieria">Ingenieria</option>
                                    <option value="Calidad">Calidad</option>
 					<option value="Almacen">Almacen</option>
                                   
                                </select>

                            </div>
                            <div class="col-md-6 ">
                            
                                <select id="causa_raiz" class="form-control" name="causa_raiz">
                                    <option> Seleccione una Causa/Origen  </option>
                                    <option>{{old('causa_raiz')}} </option>
                                </select>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class="form-control" placeholder="¿Por qué #1?" name="Porque1"
                                    value="{{old('Porque1')}}">
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class="form-control" placeholder="¿Por qué #2?" name="Porque2"
                                    value="{{old('Porque2')}}">
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class="form-control" placeholder="¿Por qué #3?" name="Porque3"
                                    value="{{old('Porque3')}}">

                            </div>

                            <div class="col-md-6 m-2">
                                <label>Responsable CNC</label>


                                <select name="IdResponsablecnc" class="form-control" id="ResponsableCNC">
                                    <option class="form-control">{{old('IdResponsablecnc')}}</option>
                                    @foreach ($empleadosSAP as $row)
                                    <option class="form-control" value="{{ $row->id }}">
                                        {{ $row->CardCode}} {{ $row->CardName }}
                                    </option>
                                    @endforeach
                                </select>
                                @if($errors->has('sede'))
                                <p class="text-danger">{{ $errors->first('IdResponsablecnc') }}</p>
                                @endif
                            </div>


                            <div class="col-md-6">
                                <label>Proceso que reporta</label>
                                <select class="form-control" name="ProcesoReporta">
                                    <option class="form-control">{{old('ProcesoReporta')}}</option>
                                    <option value="Calidad Medellin">Calidad Medellin</option>
         			  <option value="Calidad Copacabana">Calidad Copacabana</option>
                                    <option value="Calidad Sabaneta">Calidad Sabaneta</option>
                                    <option value="Calidad Rionegro">Calidad Rionegro</option>
                                    <option value="Calidad Obras">Calidad Obras</option>
                                    <option value="Vortex">Vortex</option>
                                    <option value="Home">Home</option>
                                    <option value="Formaletas">Formaletas</option>
                                    <option value="Mantenimiento">Mantenimiento</option>

                                </select>


                            </div>
                            <div class="col-md-6 ">
                                <label>Proceso Detecta</label>
                                <select class="form-control" name="ProcesoDetecta">
                                    <option class="form-control">{{old('ProcesoDetecta')}}</option>
                                    <option value="Compras">Compras</option>
                                    <option value="Logistica">Logistica</option>
                                    <option value="Gestion Humana">Gestión Humana</option>
                                    <option value="Estructuras Sabaneta">Estructuras Sabaneta</option>
 				                    <option value="Estructuras Copacabana">Estructuras Copacabana</option>
                                    <option value="Estructuras Medellin">Estructuras Medellin</option>
                                    <option value="Produccion Medellin">Produccion Medellin</option>
                                    <option value="Produccion Sabaneta">Produccion Sabaneta</option>
                                    <option value="Calidad Medellin">Calidad Medellin</option>
                                    <option value="Calidad Sabaneta">Calidad Sabaneta</option>
                                    <option value="Calidad Rionegro">Calidad Rionegro</option>
                                    <option value="Calidad Obras">Calidad Obras</option>
                                    <option value="Vortex">Vortex</option>
                                    <option value="Home">Home</option>
                                    <option value="Formaletas">Formaletas</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                    <option value="Cliente">Cliente</option>

                                </select>

                            </div>
                            
                            <div class="col-md-6 ">
                                <input type="number" class="form-control" placeholder="Costo del CNC" name="CostoCNC"
                                    id="costo" onchange="calculateTotal()" style="background-color:#ffa50047"
                                    value="{{old('CostoCNC')}}">
                                <div>
                                    <input type="number" class="form-control" placeholder="Valor recuperado"
                                        name="SaldoRecuperado" id="saldo_recuperado" onchange="calculateTotal()"
                                        style="background-color:#ffa50047" value="old('SaldoRecuperado')">
                                </div>
                                <div>
                                    <input type="number" class="form-control" placeholder="Saldo Final CNC"
                                        name="SaldoFinalCNC" id="total" style="background-color:#ffa50047"
                                        value="{{old('SaldoFinalCNC')}}">
                                </div>


                            </div>

                           
                             <div class="col-md-6 ">
                                <input type="number" class="form-control" placeholder="cantidad piezas dañadas"
                                    name="Cantidadpiezasdanadas" style="background-color:#ffa50047"
                                    value="{{old('Cantidadpiezasdanadas')}}" required>

                            </div>
 				<div class="col-md-6 ">
                                <input type="text" class="form-control" placeholder="Corrección del evento"
                                    name="CorreccionEvento" style="background-color:#ffa50047"
                                    value="{{old('CorreccionEvento')}}">

                            </div>
                            <div class="col-md-6">
                                <label>Tipo accion</label>
                                <select class="form-control" name="TipoAccion" style="background-color:#ffa50047">
                                    <option class="form-control">{{old('TipoAccion')}}</option>
                                    <option value="Correctiva">Correctiva</option>
                                    <option value="Preventiva">Preventiva</option>
                                    <option value="Mejora">Mejora</option>

                                </select>

                            </div>
                            <div class="col-md-6 ">
                                <select class="form-control" name="EstadoCNC" style="background-color:#ffd7008c" required>
                                    <option class="form-control" value="">Estado del cnc</option>
                                    <option value="Costeado">Costeado</option>
                                    <option value="No Costeado">No costeado</option>
                                    <option value="En proceso">En proceso</option>

                                </select>

                            </div>

                            <div class="col-md-6 ">
                                <label>Analista Reporto</label>
                                <select name="IdAnalistaReporto" class="form-control" id="Analistareporto">


                                    <option class="form-control"></option>
                                    @foreach ($empleadosSAP as $row)
                                    <option class="form-control" value="{{ $row->id }}">
                                        {{ $row->CardCode}} {{ $row->CardName }}
                                    </option>
                                    @endforeach

                                </select>
                                @if($errors->has('IdAnalistaReporto'))
                                <p class="text-danger">{{ $errors->first('IdAnalistaReporto') }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 ">
                                <select class="form-control" name="QuienCostea" style="background-color:#ffd7008c" required>
                                    <option class="form-control" value="" selected disabled>Quien Costea</option>
                                    <option value="Adriana Cano">Adriana Cano</option>
                                    <option value="Andrea González">Andrea González</option>
                                    <option value="Camila Villada">Camila Villada</option>
                                    <option value="Daniel Builes">Daniel Builes</option>
                                    <option value="Elias Ciro">Elias Ciro</option>
                                    <option value="Elmer Uribe">Elmer Uribe</option>
                                    <option value="Elmer Uribe ">Elmer Uribe</option>
                                    <option value="Elymar Gamboa">Elymar Gamboa</option>
                                    <option value="Fredy Castro">Fredy Castro</option>
                                    <option value="Fredy Quintero">Fredy Quintero</option>
                                    <option value="Richard Ruiz">Richard Ruiz</option>
                                    <option value="Santiago Agudelo">Santiago Agudelo</option>
                                    <option value="Sonia Olaya Lopez">Sonia Olaya Lopez</option>
                                </select>
                            </div>

                        </div>
                        <BR>
                        <button type="submit" class="btn btn-primary">Guardar Registro</button>

                </div>

            </div>

            </form>

        </div>


    </div>
</div>
</div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/subproceso.js') }}"></script>

@endsection