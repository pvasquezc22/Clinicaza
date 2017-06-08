@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-home"></i> Inicio
                @if (Auth::guest())
                    <span class=" pull-right badge">Debes iniciar sesion, antes de continuar</span>
                @endif
                </div>
                <div class="panel-body">
                    <row class="col-md-12">
                        <div class="col-md-12">
                            <div align="center">
                                <div class="row">
                                    <div class="col-md-6" align="center">
                                        {{ Html::image('img/logo2.jpg' , 'Logo', array('class' => 'thumb' , 'width' => '100%')) }}
                                    </div>
                                    <div class="col-md-6">
                                        <br/>
                                        <br/>
                                        <button class="btn btn-info"><font size="6">Nuestro trabajo<br/>es cuidar de tu salud</font></button>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <p>
                                La Clínica Cochabamba ofrece a todos los pacientes atención medica las 24 horas del día y contratando a profesionales altamente calificados. Todo ello acompañado del trato humano más cercano tanto al paciente como a sus acompañantes.
                            </p>
                            <p>
                                Se encuentra al servicio de la sociedad hace 25 años, acompañada de la continua actualización y renovación de nuestra tecnología, ya que tiene como objetivo proporcionar los mejores recursos humanos y tecnológicos para que los pacientes tengan una rápida y adecuada recuperación, con seguridad y responsabilidad.
                            </p>
                            {{ Html::image('img/login.png' , 'Presentación', array('class' => 'thumb' , 'width' => '100%')) }}
                        </div>
                    </row>
                    <row class="col-md-12">
                        <div class="col-md-4">
                            <h2>Misión</h2>
                            <p>
                                Brindar servicios de salud confiables y seguros a nuestros pacientes, orientándonos permanentemente hacia la excelencia, con alta calidad humana y ética con el fin de  contribuir en la mejora de la salud y el estándar de vida de nuestra sociedad.
                            </p>
                            {{ Html::image('img/mision.png' , 'Presentación', array('class' => 'thumb' , 'width' => '100%')) }}
                        </div>
                        <div class="col-md-4">
                            <h2>Visión</h2>
                            <p>
                                Ser reconocidos en el ámbito de salud por nuestro prestigio, trayectoria y vocación de servicio, orientados a nuestros pacientes, a través, de la renovación constante de tecnología, conocimientos capacitación profesional y la responsabilidad social.
                            </p>
                            {{ Html::image('img/especialidades.png' , 'Presentación', array('class' => 'thumb' , 'width' => '100%')) }}
                        </div>
                        <div class="col-md-4">
                            <h2>Especialidades</h2>
                            <p>
                                Contamos con las siguientes especialidades:
                                <ul>
                                    <li>Endocrinología</li>
                                    <li>Gastroenterología</li>
                                    <li>Cardiología</li>
                                    <li>Nefrología</li>
                                    <li>Hematología</li>
                                    <li>Oftalmología</li>
                                    <li>Neumología</li>
                                    <li>Traumatología</li>
                                </ul>
                            </p>
                            {{ Html::image('img/vision.png' , 'Presentación', array('class' => 'thumb' , 'width' => '100%')) }}
                        </div>
                    </row>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection