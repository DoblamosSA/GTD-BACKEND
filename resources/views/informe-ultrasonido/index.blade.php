@extends('layouts.dashboard')

@section('template_title')
    Informe Ultrasonido
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Informe Ultrasonido') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('informe-ultrasonido.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                    <BR>

                    <div class="card-body">
                        <div class="table-responsive">
                        <div class="row col-12 mb-3">
                            <!-- <div class="d-md-flex justify-content-md-end">
                                <form action="{{route('informe-ultrasonido.index')}}" method="GET">
                                    <div class="btn-group">

                                        <input type="text" name="busqueda" class="form-control"> 
                                        <input type="submit" value="buscar" class="btn bg-gradient-success ml-2">

                                    </div>

                                    
                                </form> -->
                        </div>

                    </div> 
                            <table class="table table-striped table-hover"  id="datatableinfo">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Proyecto</th>
                                       
										<th>Grado_Calibracion</th>
										<th>Calidad_Material</th>
										<th>Espesor</th>
										<th>Metal_Aporte</th>
										<th>Acoplante</th>
                                        <th>Proceso</th>
										
										

                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($informeUltrasonidos as $informeUltrasonido)
                                        <tr>
                                            <td>{{ $informeUltrasonido->id }}</td>
                                            
											<td>{{ $informeUltrasonido->proyecto }}</td>
											<td>{{ $informeUltrasonido->grado_calibracion }}</td>
								  		    <td>{{ $informeUltrasonido->calidad_material_base }}</td>
											<td>{{ $informeUltrasonido->espesor }}</td>
											<td>{{ $informeUltrasonido->metal_aporte }}</td>
											<td>{{ $informeUltrasonido->acoplante }}</td>
											<td>{{ $informeUltrasonido->proceso }}</td>
                                            
                                            
											

                                            <td style="width: 150px">
                                                <form action="{{ route('informe-ultrasonido.destroy',$informeUltrasonido->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('reportes-pdf.ultrasonido',$informeUltrasonido->id) }}" target="_blank"><i class="fas fa-file-pdf"></i> </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('informe-ultrasonido.edit',$informeUltrasonido->id) }}"><i class="{{ App\Models\User::find(Auth::user()->id)->getRol()=="ADMINISTRADOR" ? "fa fa-fw fa-edit" : "fa fa-fw fa-eye" }}"></i></a>
                                                    @csrf
                                                    {{-- @method('DELETE') --}}
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
                {!! $informeUltrasonidos->links() !!}
            </div>
        </div>
    </div>
@endsection
