@extends('layouts.dashboard')

@section('template_title')
    Juntas Informe Ultrasonido
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Juntas Informe Ultrasonido') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('juntas-informe-ultrasonidos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Crear Nuevo') }}
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
                                        
										<th>Fecha</th>
										<th>Identificacion Elemento</th>
										<th>Junta</th>
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
										<th>Inf Ultrasonido Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($juntasInformeUltrasonidos as $juntasInformeUltrasonido)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $juntasInformeUltrasonido->fecha }}</td>
											<td>{{ $juntasInformeUltrasonido->identificacion_elemento }}</td>
											<td>{{ $juntasInformeUltrasonido->junta }}</td>
											<td>{{ $juntasInformeUltrasonido->ubicacion_junta }}</td>
											<td>{{ $juntasInformeUltrasonido->indicacion_numero }}</td>
											<td>{{ $juntasInformeUltrasonido->desde_cara }}</td>
											<td>{{ $juntasInformeUltrasonido->pierna }}</td>
											<td>{{ $juntasInformeUltrasonido->nivel_indicacion }}</td>
											<td>{{ $juntasInformeUltrasonido->nivel_referencia }}</td>
											<td>{{ $juntasInformeUltrasonido->factor_atenuacion }}</td>
											<td>{{ $juntasInformeUltrasonido->valoracion_indicacion }}</td>
											<td>{{ $juntasInformeUltrasonido->longitud_defecto }}</td>
											<td>{{ $juntasInformeUltrasonido->distancia_angular }}</td>
											<td>{{ $juntasInformeUltrasonido->profundidad_desde }}</td>
											<td>{{ $juntasInformeUltrasonido->evaluacion_discontinuidad_1 }}</td>
											<td>{{ $juntasInformeUltrasonido->evaluacion_discontinuidad_2 }}</td>
											<td>{{ $juntasInformeUltrasonido->evaluacion_discontinuidad_3 }}</td>
											<td>{{ $juntasInformeUltrasonido->distancia_desde_x }}</td>
											<td>{{ $juntasInformeUltrasonido->distancia_desde_y }}</td>
											<td>{{ $juntasInformeUltrasonido->estampe_soldador }}</td>
											<td>{{ $juntasInformeUltrasonido->observaciones }}</td>
											<td>{{ $juntasInformeUltrasonido->inf_ultrasonido_id }}</td>

                                            <td>
                                                <form action="{{ route('juntas-informe-ultrasonidos.destroy',$juntasInformeUltrasonido->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('juntas-informe-ultrasonidos.show',$juntasInformeUltrasonido->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('juntas-informe-ultrasonidos.edit',$juntasInformeUltrasonido->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                {!! $juntasInformeUltrasonidos->links() !!}
            </div>
        </div>
    </div>
@endsection
