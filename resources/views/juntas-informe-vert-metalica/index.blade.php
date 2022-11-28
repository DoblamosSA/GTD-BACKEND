@extends('layouts.dashboard')

@section('template_title')
    Juntas Informe Vert Metalica
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Juntas Informe Vert Metalica') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('juntas-informe-vert-metalicas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Id Columna</th>
										<th>Teorica</th>
										<th>Real</th>
										<th>Desviacion</th>
										<th>Altura Columna</th>
										<th>Tolerancia</th>
										<th>Norte 1</th>
										<th>Norte 2</th>
										<th>Sur 1</th>
										<th>Sur 2</th>
										<th>Oriente 1</th>
										<th>Oriente 2</th>
										<th>Occidente 1</th>
										<th>Occidente 2</th>
										<th>Resultado Inspeccion</th>
										<th>Inf Vert Met Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($juntasInformeVertMetalicas as $juntasInformeVertMetalica)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $juntasInformeVertMetalica->id_columna }}</td>
											<td>{{ $juntasInformeVertMetalica->teorica }}</td>
											<td>{{ $juntasInformeVertMetalica->real }}</td>
											<td>{{ $juntasInformeVertMetalica->desviacion }}</td>
											<td>{{ $juntasInformeVertMetalica->altura_Columna }}</td>
											<td>{{ $juntasInformeVertMetalica->tolerancia }}</td>
											<td>{{ $juntasInformeVertMetalica->norte_1 }}</td>
											<td>{{ $juntasInformeVertMetalica->norte_2 }}</td>
											<td>{{ $juntasInformeVertMetalica->sur_1 }}</td>
											<td>{{ $juntasInformeVertMetalica->sur_2 }}</td>
											<td>{{ $juntasInformeVertMetalica->oriente_1 }}</td>
											<td>{{ $juntasInformeVertMetalica->oriente_2 }}</td>
											<td>{{ $juntasInformeVertMetalica->occidente_1 }}</td>
											<td>{{ $juntasInformeVertMetalica->occidente_2 }}</td>
											<td>{{ $juntasInformeVertMetalica->resultado_inspeccion }}</td>
											<td>{{ $juntasInformeVertMetalica->inf_vert_met_id }}</td>

                                            <td>
                                                <form action="{{ route('juntas-informe-vert-metalicas.destroy',$juntasInformeVertMetalica->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('juntas-informe-vert-metalicas.show',$juntasInformeVertMetalica->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('juntas-informe-vert-metalicas.edit',$juntasInformeVertMetalica->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                {!! $juntasInformeVertMetalicas->links() !!}
            </div>
        </div>
    </div>
@endsection
