@extends('layouts.app')

    {!! Html::style('css/bootstrap-select.min.css') !!}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-plus-circle"></i> Registrar examen medico
                    <input id="csrf_token" name="csrf_token" type="hidden" value="{{ csrf_token() }}">
                </div>
                <div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{route('examenRealizado.store')}}">
						{{ csrf_field() }}

                        <div class="form-group{{ ($errors->has('paciente_id')) ? $errors->first('paciente_id') : '' }}">
                            <label for="paciente_id" class="col-md-4 control-label">Paciente</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="paciente_id" id="paciente_id" data-live-search="true" required>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{$paciente->id}}">{{$paciente->nombre_completo()}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('paciente_id','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('fecha')) ? $errors->first('fecha') : '' }}">
                            <label for="fecha" class="col-md-4 control-label">Fecha</label>
                            <div class="col-md-6">
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                                {!! $errors->first('fecha','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('examenes_medicos_id')) ? $errors->first('examenes_medicos_id') : '' }}">
                            <label for="examenes_medicos_id" class="col-md-4 control-label">Examen medico</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="examenes_medicos_id" id="examenes_medicos_id" data-live-search="true" onchange="seleccionar_examen_medico(this.value)">
                                    <option value="0">--Selecciona una opcion--</option>
                                    @foreach($examenes_medicos as $examen_medico)
                                        <option value="{{$examen_medico->id}}">{{$examen_medico->nombre}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('examenes_medicos_id','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div id="div_parametros_medicos"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="col-md-6" align="left">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        Registrar
                                    </button>
                                </div>
                                <div class="col-md-6" align="right">
                                    <a class="btn btn-default btn-block" href="{{url()->previous()}}">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>

					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

    {!! Html::script('js/jquery.min.js') !!}

    {!! Html::script('js/bootstrap-select.min.js') !!}

    <script type="text/javascript">
        function seleccionar_examen_medico(examen_medico_id){
            var aux_html_parametros = '';
            if(examen_medico_id>0){
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-Token':document.getElementById('csrf_token').value},
                    url: 'parametrosMedicos',
                    data: { examen_medico_id : examen_medico_id },
                    success: function( msg ) {
                        for (var i = 0; i < msg.length; i++) {
                            var parametro_medico = msg[i];
                            aux_html_parametros += '<div class="form-group"><label for="parametro_' + parametro_medico['id'] + '" class="col-md-4 control-label"> - ' + parametro_medico['nombre'] + '<br/>   [' + parametro_medico['unidad_medida'] + ']</label><div class="col-md-6"><input type="text" name="parametro_' + parametro_medico['id'] + '" id="parametro_' + parametro_medico['id'] + '" class="form-control" value="0" required></div></div>';
                        }
                    },
                    complete: function(){
                        $("#div_parametros_medicos").html(aux_html_parametros);                       
                    }
                });
            }else{
                $("#div_parametros_medicos").html(aux_html_parametros);
            }
        }
    </script>
