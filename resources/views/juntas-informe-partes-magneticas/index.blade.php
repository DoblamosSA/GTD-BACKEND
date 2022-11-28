@extends('layouts.app')

@section('template_title')
    Juntas Informe Partes Magnetica
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Juntas Informe Partes Magnetica') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('juntas-informe-partes-magneticas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Elemento</th>
										<th>Junta</th>
										<th>Indicacion</th>
										<th>Calificacion</th>
										<th>Observaciones</th>
										<th>Inf Part Magneticas Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($juntasInformePartesMagneticas as $juntasInformePartesMagnetica)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $juntasInformePartesMagnetica->elemento }}</td>
											<td>{{ $juntasInformePartesMagnetica->junta }}</td>
											<td>{{ $juntasInformePartesMagnetica->indicacion }}</td>
											<td>{{ $juntasInformePartesMagnetica->calificacion }}</td>
											<td>{{ $juntasInformePartesMagnetica->observaciones }}</td>
											<td>{{ $juntasInformePartesMagnetica->inf_part_magneticas_id }}</td>

                                            <td>
                                                <form action="{{ route('juntas-informe-partes-magneticas.destroy',$juntasInformePartesMagnetica->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('juntas-informe-partes-magneticas.show',$juntasInformePartesMagnetica->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('juntas-informe-partes-magneticas.edit',$juntasInformePartesMagnetica->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                {!! $juntasInformePartesMagneticas->links() !!}
            </div>
        </div>
    </div>
@endsection
