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
                	<i class="fa fa-plus-circle"></i> Crear Examen Medico
                </div>
                <div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{route('examenMedico.store')}}">
						{{ csrf_field() }}

                        <div class="form-group{{ ($errors->has('nombre')) ? $errors->first('nombre') : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" name="nombre" id="nombre" class="form-control">
                                {!! $errors->first('nombre','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('descripcion')) ? $errors->first('descripcion') : '' }}">
                            <label for="descripcion" class="col-md-4 control-label">Descripcion</label>
                            <div class="col-md-6">
                                <textarea type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa la descripcion aqui" required>
                                </textarea>
                                {!! $errors->first('descripcion','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('tipo_analisis_id')) ? $errors->first('tipo_analisis_id') : '' }}">
                            <label for="tipo_analisis_id" class="col-md-4 control-label">Categoria</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="tipo_analisis_id" id="tipo_analisis_id" data-live-search="true">
                                    @foreach($tipos_analisis as $tipo_analisis)
                                        <option value="{{$tipo_analisis->id}}">{{$tipo_analisis->nombre}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('tipo_analisis_id','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('indicadores')) ? $errors->first('indicadores') : '' }}">
                            <label for="indicadores" class="col-md-4 control-label">Indicadores</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" name="indicadores[]" id="indicadores" multiple="multiple" data-live-search="true">
                                    @foreach($parametros_medicos as $indicador)
                                        <option value="{{$indicador->id}}">{{$indicador->nombre}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('indicadores','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

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

@section('scripts')
    {!! Html::script('js/bootstrap-select.min.js') !!}
@endsection