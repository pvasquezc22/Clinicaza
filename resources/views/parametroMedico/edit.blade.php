@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<i class="fa fa-edit"></i> Editar Indicador Analitico
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('parametroMedico.update',$parametroMedico->id)}}">
                        <input name="_method" type="hidden" value="PATCH">
						{{ csrf_field() }}

                        <div class="form-group{{ ($errors->has('nombre')) ? $errors->first('nombre') : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa el nombre aqui" value="{{$parametroMedico->nombre}}" required autofocus>
                                {!! $errors->first('nombre','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('unidad_medida')) ? $errors->first('unidad_medida') : '' }}">
                            <label for="unidad_medida" class="col-md-4 control-label">Unidad de medida</label>
                            <div class="col-md-6">
                                <input type="text" id="unidad_medida" name="unidad_medida" class="form-control" placeholder="Ingresa la unidad de medida aqui (g/100ml)" value="{{$parametroMedico->unidad_medida}}" required autofocus>
                                {!! $errors->first('nombre','<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('descripcion')) ? $errors->first('descripcion') : '' }}">
                            <label for="descripcion" class="col-md-4 control-label">Descripcion</label>
                            <div class="col-md-6">
                                <textarea type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa la descripcion aqui" required autofocus>{{$parametroMedico->descripcion}}</textarea>
                                {!! $errors->first('nombre','<p class="help-block">:message</p>') !!}
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