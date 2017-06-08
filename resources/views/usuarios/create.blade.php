@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-circle"></i> Nuevo Usuario</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('usuarios.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre completo</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" onkeyup="this.value=this.value.replace(/[^A-Za-z ]/g,'');"  required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('carnet') ? ' has-error' : '' }}">
                            <label for="carnet" class="col-md-4 control-label">Carnet de identidad</label>

                            <div class="col-md-6">
                                <input id="carnet" type="text" class="form-control" name="carnet" value="{{ old('carnet') }}" onkeypress="return isNumber(event)" required>

                                @if ($errors->has('carnet'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('carnet') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('departamento_id') ? ' has-error' : '' }}">
                            <label for="departamento_id" class="col-md-4 control-label">Departamento</label>
                            <div class="col-md-6">
                                <select id="departamento_id" name="departamento_id" class="form-control">
                                    @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->id}}" {{ (old('departamento_id') == $departamento->id) ? 'selected':'' }} >
                                    {{$departamento->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('departamento_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departamento_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tipo_usuario') ? ' has-error' : '' }}">
                            <label for="tipo_usuario" class="col-md-4 control-label">Tipo usuario</label>
                            <div class="col-md-6">
                                <select id="tipo_usuario" name="tipo_usuario" class="form-control" onchange="evento_tipo_usuario()">
                                    <option value="Administrador" {{ (old('tipo_usuario') == 'Administrador') ? 'selected':'' }}>Administrador</option>
                                    <option value="Medico" {{ (old('tipo_usuario') == 'Medico') ? 'selected':'' }}>Medico</option>
                                </select>
                                @if ($errors->has('tipo_usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo_usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('especialidad_id') ? ' has-error' : '' }}">
                            <label for="especialidad_id" class="col-md-4 control-label">Especialidad</label>
                            <div class="col-md-6">
                                <select id="especialidad_id" name="especialidad_id" class="form-control">
                                    @foreach($especialidades as $especialidad)
                                    <option value="{{$especialidad->id}}" {{ (old('especialidad_id') == $especialidad->id) ? 'selected':'' }} >
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

                        <div class="form-group{{ $errors->has('turno_id') ? ' has-error' : '' }}">
                            <label for="turno_id" class="col-md-4 control-label">Turno</label>
                            <div class="col-md-6">
                                <select id="turno_id" name="turno_id" class="form-control">
                                    @foreach($turnos as $turno)
                                    <option value="{{$turno->id}}" {{ (old('turno_id') == $turno->id) ? 'selected':'' }} >
                                    {{$turno->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('turno_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('turno_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo electronico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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

<script type="text/javascript">
    function evento_tipo_usuario(){
        var val = document.getElementById('tipo_usuario').value;
        if (val == "Administrador") {
            document.getElementById('especialidad_id').disabled = true;
            document.getElementById('turno_id').disabled = true;
        }else{
            document.getElementById('especialidad_id').disabled = false;
            document.getElementById('turno_id').disabled = false;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        evento_tipo_usuario();
    }, false);
    function isNumber(evt) {
        if(document.getElementById('carnet').value.length < 6){
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }else{
            return true;
        }
    }
</script>