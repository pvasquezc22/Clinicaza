@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-vcard-o"></i> Diagnostico
                	<input id="csrf_token" name="csrf_token" type="hidden" value="{{ csrf_token() }}">
                </div>

                <div class="panel-body">

					<ul class="nav nav-tabs nav-justified">
                	<?php $num = 0; ?>
					@foreach($categorias as $categoria)
						<li><a data-toggle="tab" href="#tab_{{$num++}}">{{$categoria->nombre}}</a></li>
					@endforeach
						<li><a data-toggle="tab" href="#tab_{{$num++}}"><i class="fa fa-bars"></i> Probabilidades</a></li>
						<li><a data-toggle="tab" href="#tab_{{$num++}}"><i class="fa fa-check-circle"></i> Consultar</a></li>
					</ul>

					<div class="tab-content">
	                	<?php $num = 0; ?>
						@foreach($categorias as $categoria)
						<div id="tab_{{$num++}}" @if($num == 0) class="tab-pane fade in active" @else class="tab-pane fade" @endif>
						 	<h3>{{$categoria->nombre}}</h3>
		                	<?php $aux = 0; ?>
		                	@foreach($categoria->sintomas as $sintoma)
								@if(($aux == 0) || ($aux%5 == 0))
									<div class="col-md-4">
								   		<div class="list-group">
								@endif
									<a href="#" class="list-group-item" id="{{$sintoma->id}}">
										@if(isset($sintoma->imagen))
										<div class="row">
											<div class="col-md-8">
												<h4 class="list-group-item-heading">{{$sintoma->nombre}}</h4>
												<p class="list-group-item-text">{{$sintoma->descripcion}}</p>
											</div>
											<div class="col-md-4" style="display:table-cell; vertical-align: middle;" align="center">
												<br/>
												<img src="{{$sintoma->imagen}}" width="100%" />
											</div>
										</div>
										@else
											<h4 class="list-group-item-heading">{{$sintoma->nombre}}</h4>
											<p class="list-group-item-text">{{$sintoma->descripcion}}</p>
										@endif
									</a>
									<?php $aux++; ?>
								@if($aux%5 == 0)
								   		</div>
								  	</div>
								@endif
							@endforeach
							@if($aux%5 > 0)
							  		</div>
							  	</div>
							@endif
						</div>
						@endforeach
						<div id="tab_{{$num++}}" class="tab-pane fade">
							<br/>
							<div class="col-md-12" align="center">
								<table class="table table-bordered">
									<thead>
										<tr>
										<th style="vertical-align: center;text-align: center;">
										Enfermedades
										<br/>
										Sintomas
										</th>
										<?php $aux_enfermedad = array(); ?>
										@foreach($enfermedades as $enfermedad)
											<?php
												$aux_enfermedad[$enfermedad->id] = array();
												$aux_enfermedad[$enfermedad->id]['condicional'] = array();
												$aux_enfermedad[$enfermedad->id]['acumulado'] = $enfermedad->diagnosticosCount()/$enfermedades_diagnosticadas;
												foreach ($sintomas as $sintoma) {
													$aux_enfermedad[$enfermedad->id]['condicional'][$sintoma->id] = 0;
												}
												//var_dump($enfermedad->diagnosticos->count());
												foreach ($enfermedad->diagnosticos as $diagnostico) {
													foreach ($diagnostico->sintomas as $sintoma) {
														$aux_enfermedad[$enfermedad->id]['condicional'][$sintoma->id] += 1;
													}
												}
											?>
											<th style="vertical-align: center;text-align: center;" colspan="3">
											{{$enfermedad->nombre}}
											<br/>
											{{($enfermedad->diagnosticosCount()/$enfermedades_diagnosticadas)*100}} %
											</th>
										@endforeach
										</tr>
									</thead>
									<tbody>
										@foreach($categorias as $categoria)
											@foreach($categoria->sintomas as $sintoma)
											<tr>
												<td>{{$sintoma->nombre}}</td>
												@foreach($enfermedades as $enfermedad)
													<td style="vertical-align: center;text-align: center;">{{$aux_enfermedad[$enfermedad->id]['condicional'][$sintoma->id]}}</td>
													<td style="vertical-align: center;text-align: center;">{{round(($aux_enfermedad[$enfermedad->id]['condicional'][$sintoma->id]/$enfermedad->diagnosticosCount())*100)/100}}</td>
													<td style="vertical-align: center;text-align: center;" id="td_{{$enfermedad->id}}_{{$sintoma->id}}">-</td>
												@endforeach
											</tr>
											@endforeach
										@endforeach
									</tbody>
								</table>
							</div>
							<br/>
						</div>
						<div id="tab_{{$num++}}" class="tab-pane fade">
							<br/>
							<div class="col-md-12" align="center">
	                            <div class="col-md-4 col-md-offset-4">
	                                <button type="submit" class="btn btn-block btn-lg btn-success" onclick="consultaBayes()">
	                                    <strong>Consulta<br/>de Especialidad</strong>
	                                </button>
	                            </div>
								<div id="modalDiagnostico" class="modal fade" role="dialog">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Consulta automatizada</h4>
								      </div>
								      <div class="modal-body">
								      	<div align="center" id="modalDiagnosticoBody"></div>
								      	<div align="center" id="divReserva">
								      		<br/><br/>
								      		<label for="id_turno" class="col-md-4 control-label">Turno</label>
                            				<div class="col-md-6">
									      		<select class="form-control" name="id_turno" id="id_turno">
				                                    @foreach($turnos as $turno)
				                                        <option value="{{$turno->id}}">{{$turno->nombre}}</option>
				                                    @endforeach
				                                </select>
				                            </div>
				                            <br/><br/>
							      			<label for="id_paciente" class="col-md-4 control-label">Paciente</label>
                            				<div class="col-md-6">
									      		<select class="form-control selectpicker" name="paciente[]" id="id_paciente" data-live-search="true">
									      			<option value="0">Seleccione su nombre ...</option>
				                                    @foreach($pacientes as $paciente)
				                                        <option value="{{$paciente->id}}">{{$paciente->nombre_completo()}} - CI {{$paciente->carnet}}</option>
				                                    @endforeach
				                                </select>
				                            </div>
				                            <br/><br/>
							      			<button id="btnReservar" class="btn btn-success btn-lg" onclick="realizar_reserva()">Realizar reserva</button>
								      	</div>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>
	                        </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

    {!! Html::script('js/jquery.min.js') !!}

<script type="text/javascript">
	var sintoma_array = [];
	$(document).ready(function() {
		$('.list-group-item').click(function(e) {
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				if(sintoma_array.indexOf(parseInt($(this).first().attr('id'))) >= 0){
					sintoma_array.splice(sintoma_array.indexOf(parseInt($(this).first().attr('id'))), 1);
				}
			}else{
	    		$(this).addClass('active');
	    		sintoma_array.push(parseInt($(this).first().attr('id')));
	    	}
	    });
        $('.nav-tabs a[href="#tab_0"]').tab('show');

    });
	function consultaBayes(){
		if(sintoma_array.length>2){
			$.ajax({
	            type: "POST",
	            headers: {'X-CSRF-Token':document.getElementById('csrf_token').value},
	            url: 'bayes/consulta',
	            data: {sintomas: sintoma_array},
	            success: function( msg ) {
	            	//"td_" + enfermedad['id'] + "_" + sintoma['id']
	            	$("#modalDiagnostico").modal('show');
					$("#modalDiagnosticoBody").html("<h2>Solicite ficha para " + msg['especialidad']['nombre'] + "</h2><input id='id_especialidad' value='" + msg['especialidad']['id'] + "' style='display:none;'/><br/><div align='center'><button class='btn btn-info btn-lg'> Diagnostico presuntivo<br/>" + msg['enfermedad_estimada']['nombre'] + "</button></div>");
	            }
	        });
		}else{
			alert("Debe seleccionar al menos tres sintomas");
			$('.nav-tabs a[href="#tab_0"]').tab('show');
		}
	}
	function realizar_reserva(){
		if(sintoma_array.length>2){
			if(parseInt(document.getElementById('id_paciente').value)>0){
				var datos = {
				    paciente_id : document.getElementById('id_paciente').value,
				    especialidad_id : document.getElementById('id_especialidad').value,
				    turno_id : document.getElementById('id_turno').value,
				    sintomas : sintoma_array
				};
				$.ajax({
		            type: "POST",
		            headers: {'X-CSRF-Token':document.getElementById('csrf_token').value},
		            url: 'bayes/reserva',
		            data: datos,
		            success: function( msg ) {
		            	if(msg.respuesta){
							alert(msg.informacion);
							location.reload();
		            	}else{
		            		alert(msg.informacion);
		            	}
		            }
		        });
			}else{
				alert("Seleccione un paciente");
			}
		}else{
			alert("Debe seleccionar al menos tres sintomas");
			$('.nav-tabs a[href="#tab_0"]').tab('show');
		}
	}
</script>