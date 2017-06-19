@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text"></i> Ver Examen Medico Realizado
                </div>
                <div class="panel-body">
                    <form action="{{route('examenRealizado.index')}}">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Paciente : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $paciente->nombre_completo() }}</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Edad : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $paciente->edad() }} Años</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Doctor : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $user->name }}</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Especialidad : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $user->especialidad->nombre }}</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Fecha examen : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $examen_realizado->fecha }}</h4>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Codigo examen : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $examen_realizado->codigo() }}</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Tipo examen : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $examen_medico->tipoAnalisis->nombre }}</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Examen Medico : </label>
                                    <div class="col-md-6" align="left">
                                        <h4>{{ $examen_medico->nombre }}</h4>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Resultados : </label>
                                    <div class="col-md-6">
                                        @foreach($parametros_medicos as $parametro_medico)
                                            <?php
                                                $encontrado = false;
                                                $aux_valor = 0;
                                                foreach ($examen_realizado_detalle as $aux) {
                                                    if($aux->parametro_medico_id == $parametro_medico->id){
                                                        $encontrado = true;
                                                        $aux_valor = $aux->valor_parametro;
                                                    }
                                                }
                                            ?>
                                            - {{$parametro_medico->nombre}}<br/>[ {{ $aux_valor }} {{$parametro_medico->unidad_medida}} ] <br/><br/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <!--div class="col-md-6" align="left">
                                    <button type="submit" class="btn btn-block btn-success">
                                        Imprimir
                                    </button>
                                </div-->
                                <div class="col-md-6" align="right">
                                    <a class="btn btn-default btn-block" href="{{url()->previous()}}">
                                        Volver
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
