@extends('layouts.app')

@section('styles')
    {!! Html::style('css/jquery.dataTables.min.css') !!}
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if ( Auth::user()->tipo_usuario == 'Administrador' )
    	<div class="col-md-12">
    	@else
		<div class="col-md-10 col-md-offset-1">
    	@endif
            <div class="panel panel-default">
                <div class="panel-heading">
                	@if ( Auth::user()->tipo_usuario == 'Administrador' )
                	<i class="fa fa-medkit"></i> Diagnosticos Registrados
                	@else
                	<i class="fa fa-medkit"></i> Diagnosticos Realizados
                	@endif
                </div>

                <div class="panel-body">
					<table class="table table-striped" id="main-table">
						<thead>
							<tr>
								<th>No.</th>
								@if ( Auth::user()->tipo_usuario == 'Administrador' )
								<th>Doctor</th>
								<th>Especialidad</th>
    							@endif
								<th>Paciente</th>
								<th>Edad</th>
								<th>Fecha</th>
								<th>Hora</th>
								@if ( Auth::user()->tipo_usuario == 'Administrador' )
								<th>Estado</th>
    							@endif
								<th>Revisar</th>
							</tr>
						</thead>
						<tbody>
							<?php $num = 1; ?>
							@foreach($diagnosticos as $diagnostico)
								<tr>
									<td>{{$num++}}</td>
									@if ( Auth::user()->tipo_usuario == 'Administrador' )
									<td>{{$diagnostico->user->name}}</td>
									<td>{{$diagnostico->user->especialidad->nombre}}</td>
	    							@endif
									<td>{{$diagnostico->paciente->nombre_completo()}}</td>
									<td>{{$diagnostico->paciente->edad()}}</td>
									<td>{{$diagnostico->fecha_creacion()}}</td>
									<td>{{$diagnostico->hora_creacion()}}</td>
									@if ( Auth::user()->tipo_usuario == 'Administrador' )
									<td>{{$diagnostico->estado}}</td>
	    							@endif
									<td>
										<a href="{{route('diagnostico.show',$diagnostico->id)}}" class="btn btn-success"><i class="fa fa-file-text"></i></a>
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

@section('scripts')

    {!! Html::script('js/jquery.dataTables.min.js') !!}

    <script type="text/javascript">
        $(document).ready(function(){
        	$('#main-table').DataTable({
		        processing: true,
		        serverSide: false
		    });
        });
    </script>

@endsection