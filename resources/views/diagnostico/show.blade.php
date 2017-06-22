@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text"></i> Resumen Diagnostico
                </div>
                <div class="panel-body">
                    <form action="{{route('diagnostico.index')}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="well">
                                    <div class="row show-grid">
                                        <div class="col-md-4">
                                            <h4><strong>Paciente</strong></h4>
                                            <div class="col-md-2 col-md-offset-1"><br><i class="fa fa-address-card fa-5x"></i></div>
                                        </div>
                                        <div class="col-md-8">
                                            <p><strong>Nombre : </strong>{{ $diagnostico->paciente->nombre_completo() }}</p>
                                            <p><strong>CI : </strong>{{ $diagnostico->paciente->carnet}} {{ $diagnostico->paciente->departamento->abreviatura }}</p>
                                            <p><strong>Edad : </strong>{{ $diagnostico->paciente->edad() }} Años</p>
                                            <p><strong>Fecha nacimiento : </strong>{{ $diagnostico->paciente->nacimiento }}</p>
                                            <p><strong>Debe retornar : </strong>{{ $diagnostico->retorno }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="well">
                                    <div class="row show-grid">
                                        <div class="col-md-4">
                                            <h4><strong>Doctor</strong></h4>
                                            <div class="col-md-2 col-md-offset-1"><br><i class="fa fa-user-md fa-5x"></i></div>
                                        </div>
                                        <div class="col-md-8">
                                            <p><strong>Nombre : </strong>{{ $diagnostico->user->name }}</p>
                                            <p><strong>Especialidad : </strong>{{ $diagnostico->user->especialidad->nombre }}</p>
                                            <p><strong>Fecha diagnostico : </strong>{{ $diagnostico->fecha_creacion() }}</p>
                                            <p><strong>Hora diagnostico : </strong>{{ $diagnostico->hora_creacion() }}</p>
                                            <p><strong>Receta medica : </strong>{{ $diagnostico->receta }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="well">
                                    <h4><strong>Sintomas</strong></h4>
                                    @foreach($diagnostico->sintomas as $sintoma_lista)
                                        - {{ $sintoma_lista->nombre }}<br/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="well">
                                    <h4><strong>Enfermedades</strong></h4>
                                    @foreach($diagnostico->enfermedades as $enfermedad_lista)
                                        - {{ $enfermedad_lista->nombre }}<br/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="well">
                                    <h4><strong>Recomendaciones</strong></h4>
                                    <p>{{ $diagnostico->recomendacion }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="well">
                                    <h4><strong>Examenes medicos complementarios</strong></h4>
                                    <ul class="nav nav-pills">
                                        <?php $num = 1; ?>
                                        @foreach($diagnostico->examenes_realizados as $examen_realizado)
                                            <li class="{{ ($num == 1) ? 'active':'' }}" ><a href="#pill-{{ $examen_realizado->id }}" data-toggle="tab">{{ $examen_realizado->examenMedico->nombre }}</a></li>
                                            <?php $num = $num + 1; ?>
                                        @endforeach
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <?php $num = 1; ?>
                                        @foreach($diagnostico->examenes_realizados as $examen_realizado)
                                            <div class="{{ ($num == 1) ? 'tab-pane fade in active':'tab-pane fade' }}" id="pill-{{ $examen_realizado->id }}">
                                                <div class="row">
                                                    <br/>
                                                    <div class="col-md-6">
                                                        <h4><strong>Descripcion</strong></h4>
                                                        <p>{{$examen_realizado->examenMedico->descripcion}} </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4><strong>Resultados</strong></h4>
                                                        @foreach($examen_realizado->examenRealizadoDetalle as $aux_detalle)
                                                            <strong> - {{ $aux_detalle->parametroMedico->nombre }} : </strong>{{ $aux_detalle->valor_parametro }} [{{$aux_detalle->parametroMedico->unidad_medida}}]<br/>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $num = $num + 1; ?>
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
                                <div class="col-md-12" align="right">
                                    <a class="btn btn-default btn-block btn-lg" href="{{url()->previous()}}">
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
