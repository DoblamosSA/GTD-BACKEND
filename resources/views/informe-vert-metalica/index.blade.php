@extends('layouts.dashboard')

@section('template_title')
    Informe Vert Metalica
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Informe Vert Metalica') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('informe-vert-metalica.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Crear Nuevo') }} <i class="fa fa-plus"></i>
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                        <div class="row col-12 mb-3">
                               
                                <!-- <div class="d-md-flex justify-content-md-end">
                                    <form action="{{route('informe-vert-metalica.index')}}" method="GET">
                                        <div class="btn-group">

                                        <input type="text" name="busqueda" class="form-control"> 
                                        <input type="submit" value="buscar" class="btn bg-gradient-success ml-2">

                                        </div>

                                        
                                    </form> -->


                                </div>
                                    
                                </form>
                            </div>
                    

                            <table class="table table-striped table-hover"  id="datatableinfo">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Proyecto</th>
										<th>Fecha_Verificacion</th>
										<th>Estructuras</th>
										<th>Planta_Area</th>
										<th>Contratista</th>
										<th>Equipo_Medicion</th>
										<th>Torque</th>
                                    
										{{-- <th>Resultado Inspeccion</th>
										<th>Observaciones</th>
										<th>Adjuntos</th>
										<th>Contratisca Nombre</th>
										<th>Contratisca Firma</th>
										<th>Contratisca Cargo</th>
										<th>Residente Nombre</th>
										<th>Residente Firma</th>
										<th>Residente Cargo</th>
										<th>Inspector Nombre</th>
										<th>Inspector Firma</th>
										<th>Inspector Cargo</th>
										<th>Representante Nombre</th>
										<th>Representante Firma</th>
										<th>Representante Cargo</th> --}}

                                        <th style="width: 250px">Seleccion_accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $informeVertMetalicas as $informeVertMetalica)
                                        <tr>
                                            <td>{{ $informeVertMetalica->id  }}</td>
                                            
											<td>{{ $informeVertMetalica->proyecto }}</td>
											<td>{{ $informeVertMetalica->fecha_verificacion }}</td>
											<td>{{ $informeVertMetalica->estructuras }}</td>
											<td>{{ $informeVertMetalica->planta_area }}</td>
											<td>{{ $informeVertMetalica->contratista }}</td>
											<td>{{ $informeVertMetalica->equipo_medicion }}</td>
											<td>{{ $informeVertMetalica->torque }}</td>
                                           
											{{-- <td>{{ $informeVertMetalica->resultado_inspeccion }}</td>
											<td>{{ $informeVertMetalica->observaciones }}</td>
											<td>{{ $informeVertMetalica->adjuntos }}</td>
											<td>{{ $informeVertMetalica->contratisca_nombre }}</td>
											<td>{{ $informeVertMetalica->contratisca_firma }}</td>
											<td>{{ $informeVertMetalica->contratisca_cargo }}</td>
											<td>{{ $informeVertMetalica->residente_nombre }}</td>
											<td>{{ $informeVertMetalica->residente_firma }}</td>
											<td>{{ $informeVertMetalica->residente_cargo }}</td>
											<td>{{ $informeVertMetalica->inspector_nombre }}</td>
											<td>{{ $informeVertMetalica->inspector_firma }}</td>
											<td>{{ $informeVertMetalica->inspector_cargo }}</td>
											<td>{{ $informeVertMetalica->representante_nombre }}</td>
											<td>{{ $informeVertMetalica->representante_firma }}</td>
											<td>{{ $informeVertMetalica->representante_cargo }}</td> --}}

                                            <td style="width: 250px">

                                                <form action="{{ route('informe-vert-metalica.destroy',$informeVertMetalica->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('reportes-pdf.vert-metalica',$informeVertMetalica->id) }}" target="_blank"><i class="fas fa-file-pdf"></i> </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('informe-vert-metalica.edit',$informeVertMetalica->id) }}"><i class="{{ App\Models\User::find(Auth::user()->id)->getRol()=="ADMINISTRADOR" ? "fa fa-fw fa-edit" : "fa fa-fw fa-eye" }}"></i> </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash" onclick="return confirm('Desea eliminar el registro?');"></i></button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $informeVertMetalicas->links() !!} --}}
            </div>
        </div>
    </div>
@endsection

