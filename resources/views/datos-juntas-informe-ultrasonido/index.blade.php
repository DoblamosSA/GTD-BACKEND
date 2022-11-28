@extends('layouts.app')

@section('template_title')
    Datos Juntas Informe Ultrasonido
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Datos Juntas Informe Ultrasonido') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('datos-juntas-informe-ultrasonidos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Ubicacion Junta</th>
										<th>Indicacion Numero</th>
										<th>Desde Cara</th>
										<th>Pierna</th>
										<th>Nivel Indicacion</th>
										<th>Nivel Referencia</th>
										<th>Factor Atenuacion</th>
										<th>Valoracion Indicacion</th>
										<th>Longitud Defecto</th>
										<th>Distancia Angular</th>
										<th>Profundidad Desde</th>
										<th>Evaluacion Discontinuidad 1</th>
										<th>Evaluacion Discontinuidad 2</th>
										<th>Evaluacion Discontinuidad 3</th>
										<th>Distancia Desde X</th>
										<th>Distancia Desde Y</th>
										<th>Estampe Soldador</th>
										<th>Observaciones</th>
										<th>Jun Inf Ult Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datosJuntasInformeUltrasonidos as $datosJuntasInformeUltrasonido)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $datosJuntasInformeUltrasonido->ubicacion_junta }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->indicacion_numero }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->desde_cara }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->pierna }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->nivel_indicacion }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->nivel_referencia }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->factor_atenuacion }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->valoracion_indicacion }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->longitud_defecto }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->distancia_angular }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->profundidad_desde }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_1 }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_2 }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->evaluacion_discontinuidad_3 }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->distancia_desde_x }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->distancia_desde_y }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->estampe_soldador }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->observaciones }}</td>
											<td>{{ $datosJuntasInformeUltrasonido->jun_inf_ult_id }}</td>

                                            <td>
                                                <form action="{{ route('datos-juntas-informe-ultrasonidos.destroy',$datosJuntasInformeUltrasonido->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('datos-juntas-informe-ultrasonidos.show',$datosJuntasInformeUltrasonido->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('datos-juntas-informe-ultrasonidos.edit',$datosJuntasInformeUltrasonido->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $datosJuntasInformeUltrasonidos->links() !!}
            </div>
        </div>
    </div>
@endsection
