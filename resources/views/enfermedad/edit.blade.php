@extends('layouts.app')

@section('styles')
    {!! Html::style('css/bootstrap-select.min.css') !!}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-edit"></i> Editar Enfermedad
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('enfermedad.update',$enfermedad->id)}}">
                        <input name="_method" type="hidden" value="PATCH">
						{{ csrf_field() }}

						<div class="form-group{{ ($errors->has('nombre')) ? $errors->first('nombre') : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
    							<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa el nombre aqui" value="{{$enfermedad->nombre}}" autofocus>
    							{!! $errors->first('nombre','<p class="help-block">:message</p>') !!}
                            </div>
						</div>

                        <div class="form-group{{ ($errors->has('descripcion')) ? $errors->first('descripcion') : '' }}">
                            <label for="descripcion" class="col-md-4 control-label">Descripcion</label>
                            <div class="col-md-6">
                                <textarea type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa la descripcion aqui">{{$enfermedad->descripcion}}</textarea>
                                {!! $errors->first('descripcion','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('especialidad_id') ? ' has-error' : '' }}">
                            <label for="especialidad_id" class="col-md-4 control-label">Especialidad</label>
                            <div class="col-md-6">
                                <select id="especialidad_id" name="especialidad_id" class="form-control">
                                    @foreach($especialidades as $especialidad)
                                    <option value="{{$especialidad->id}}" {{ ($enfermedad->especialidad_id == $especialidad->id) ? 'selected':'' }} >
                                    {{$especialidad->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('especialidad_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('especialidad_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('sintomas')) ? $errors->first('sintomas') : '' }}">
                            <label for="sintomas" class="col-md-4 control-label">Sintomas</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="sintomas[]" id="sintomas" multiple="multiple" data-live-search="true">
                                    @foreach($sintomas as $sintoma)
                                        <option value="{{$sintoma->id}}"
                                        @foreach($enfermedad->sintomas as $sintoma_lista)
                                            {{ ($sintoma->id == $sintoma_lista->id) ? 'selected':'' }}
                                        @endforeach
                                            >{{$sintoma->nombre}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('sintomas','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="col-md-6" align="left">
                                    <button type="submit" class="btn btn-block btn-warning">
                                        Editar
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

@section('scripts')
    {!! Html::script('js/bootstrap-select.min.js') !!}
@endsection