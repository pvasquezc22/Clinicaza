@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-cubes"></i> Examenes Medicos
					<div class="pull-right">
						<a href="{{route('examenMedico.create')}}" class="btn btn-primary btn-xs pull-right"> <i class="fa fa-plus-circle"></i> Nuevo</a>
                	</div>
                </div>

                <div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Categoria</th>
								<th>Indicadores</th>
								<th>Editar</th>
								<th>Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<?php $num = 1; ?>
							@foreach($examenes_medicos as $examen_medico)
								<tr>
									<td>{{$num++}}</td>
									<td>{{$examen_medico->nombre}}</td>
									<td>{{$examen_medico->descripcion}}</td>
									<td>{{$examen_medico->tipoAnalisis->nombre}}</td>
									<td>
										<div class="sintomas">
											@foreach($examen_medico->parametrosMedicos as $parametro)
												<span class="label label-default">{{$parametro->nombre}}</span>
											@endforeach
										</div>
									</td>
									<td>
										<a href="{{route('examenMedico.edit',$examen_medico->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
									</td>
									<td>
										<form class="" action="{{route('examenMedico.destroy',$examen_medico->id)}}" method="post">
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<button type="submit" class="btn btn-danger" onclick="return confirm('Esta seguro de eliminar este registro?');"><i class="fa fa-trash"></i></button>
										</form>
									</td>

								</tr>
							@endforeach
						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection