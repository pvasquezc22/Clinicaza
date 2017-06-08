@extends('layouts.app')

    {!! Html::style('css/bootstrap-select.min.css') !!}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-plus-circle"></i> Crear Diagnostico
                </div>
                <div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{route('diagnostico.store')}}">
						{{ csrf_field() }}


                        <div class="form-group{{ ($errors->has('paciente_id')) ? $errors->first('paciente_id') : '' }}">
                            <label for="paciente_id" class="col-md-4 control-label">Paciente</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="paciente_id" id="paciente_id" data-live-search="true">
                                    @foreach($pacientes as $paciente)
                                        <option value="{{$paciente->id}}">{{$paciente->nombre_completo()}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('paciente_id','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('sintomas')) ? $errors->first('sintomas') : '' }}">
                            <label for="sintomas" class="col-md-4 control-label">Sintomas</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="sintomas[]" id="sintomas" multiple="multiple" data-live-search="true">
                                    @foreach($sintomas as $sintoma)
                                        <option value="{{$sintoma->id}}">{{$sintoma->nombre}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('sintomas','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
						
                        <div class="form-group{{ ($errors->has('enfermedades')) ? $errors->first('enfermedades') : '' }}">
                            <label for="enfermedades" class="col-md-4 control-label">Enfermedades</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="enfermedades[]" id="enfermedades" multiple="multiple" data-live-search="true">
                                    @foreach($enfermedades as $enfermedad)
                                        <option value="{{$enfermedad->id}}">{{$enfermedad->nombre}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('enfermedades','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('recomendacion')) ? $errors->first('recomendacion') : '' }}">
                            <label for="recomendacion" class="col-md-4 control-label">Recomendacion</label>
                            <div class="col-md-6">
                                <textarea type="text" id="recomendacion" name="recomendacion" class="form-control" placeholder="Ingresa las recomendaciones aqui" required>
                                </textarea>
                                {!! $errors->first('recomendacion','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('retorno')) ? $errors->first('retorno') : '' }}">
                            <label for="retorno" class="col-md-4 control-label">Fecha de retorno</label>
                            <div class="col-md-6">
                                <input type="date" name="retorno" id="retorno" class="form-control">
                                {!! $errors->first('retorno','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('receta') ? ' has-error' : '' }}">
                            <label for="receta" class="col-md-4 control-label">Receta medica</label>
                            <div class="col-md-6">
                                <select id="receta" name="receta" class="form-control">
                                    <option value="Emitida" {{ (old('receta') == 'Emitida') ? 'selected':'' }}>Emitida</option>
                                    <option value="No emitida" {{ (old('receta') == 'No emitida') ? 'selected':'' }}>No emitida</option>
                                </select>
                                @if ($errors->has('tipo_usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo_usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <input type="text" name="estado" id="estado" class="form-control" value="Terminado" style="display: none;">
						
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
