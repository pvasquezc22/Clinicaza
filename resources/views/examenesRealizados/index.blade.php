@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-briefcase"></i> Examenes Realizados
					<div class="pull-right">
						<a href="{{route('examenRealizado.create')}}" class="btn btn-primary btn-xs pull-right"> <i class="fa fa-plus-circle"></i> Nuevo</a>
                	</div>
                </div>

                <div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Paciente</th>
								<th>Medico</th>
								<th>Examen</th>
								<th>Resultados</th>
								<th>Editar</th>
								<th>Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<?php $num = 1; ?>
							@foreach($examenes_realizados as $examen_realizado)
								<tr>
									<td>{{$num++}}</td>
									<td>{{$examen_realizado->paciente->nombre_completo()}}</td>
									<td>{{$examen_realizado->user->name}}</td>
									<td>{{$examen_realizado->examenMedico->nombre}}<br/>{{$examen_realizado->examenMedico->tipoAnalisis->nombre}}</td>
									<td>
										<div class="sintomas">
										@foreach($examen_realizado->examenRealizadoDetalle() as $parametro_detalle)
											<span class="label label-default">{{$parametro_detalle->parametroMedico->nombre}} : {{$parametro_detalle->valor_parametro}}</span><br/>
										@endforeach
										</div>
									</td>
									<td>
										<a href="{{route('examenRealizado.edit',$examen_realizado->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
									</td>
									<td>
										<form class="" action="{{route('examenRealizado.destroy',$examen_realizado->id)}}" method="post">
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