<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamenRealizadoDetalle;
use App\ParametroMedico;
use App\ExamenRealizado;
use App\ExamenMedico;
use App\Paciente;
use Auth;
use DB;

class ControladorExamenRealizado extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examenes_realizados = ExamenRealizado::all();
        return view('examenesRealizados.index',['examenes_realizados' => $examenes_realizados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create new data
        $examenes_medicos = ExamenMedico::all();
        $pacientes = Paciente::all();
        return view('examenesRealizados.create',['examenes_medicos' => $examenes_medicos , 'pacientes' => $pacientes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['paciente_id'=>'required','fecha'=>'required','examenes_medicos_id'=>'required']);
        $user = Auth::user();
        $examenRealizado = new ExamenRealizado;
        $examenRealizado->paciente_id = $request->paciente_id;
        $examenRealizado->fecha = $request->fecha;
        $examenRealizado->examen_medico_id = $request->examenes_medicos_id;
        $examenRealizado->user_id = $user->id;
        $examenRealizado->save();

        $aux_parametros = DB::table('examen_parametro')->select('parametro_medico_id')->where('examen_medico_id', '=', $request->examenes_medicos_id);
        $parametros_medicos = ParametroMedico::whereIn('id', $aux_parametros)->get();
        foreach ($parametros_medicos as $parametro_medico) {
            $examenRealizadoDetalle = new ExamenRealizadoDetalle;
            $examenRealizadoDetalle->examen_realizado_id = $examenRealizado->id;
            $examenRealizadoDetalle->parametro_medico_id = $parametro_medico->id;
            $aux_name_parametro = 'parametro_' . $parametro_medico->id;
            //dd($request->$aux_name_parametro);
            $examenRealizadoDetalle->valor_parametro = $request['parametro_'.$parametro_medico->id];
            $examenRealizadoDetalle->save();
        }
        return redirect()->route('examenesRealizados.index')->with('alert-success','Examen medico realizado creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$examen_medico = ExamenMedico::findOrFail($id);
        $tipos_analisis = TipoAnalisis::all();
        $parametros_medicos = ParametroMedico::all();
        return view('examenesMedicos.edit',compact('examen_medico'),['tipos_analisis' => $tipos_analisis , 'parametros_medicos' => $parametros_medicos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation of data

        $this->validate($request,['nombre'=>'required','descripcion'=>'required','tipo_analisis_id'=>'required']);
        $examenMedico = ExamenMedico::findOrFail($id);
        $examenMedico->nombre = $request->nombre;
        $examenMedico->descripcion = $request->descripcion;
        $examenMedico->tipo_analisis_id = $request->tipo_analisis_id;
        $examenMedico->save();
        if (isset($request->indicadores)) {
            $examenMedico->parametrosMedicos()->sync($request->indicadores, true);
        }
        return redirect()->route('examenMedico.index')->with('alert-warning','Examen medico editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $examenMedico = ExamenMedico::findOrFail($id);
        $examenMedico->parametrosMedicos()->sync(array(), true);
        $examenMedico->delete();
        return redirect()->route('examenMedico.index')->with('alert-warning','Examen medico eliminado');
    }

    public function parametrosMedicos(Request $request)
    {
        $aux_parametros = DB::table('examen_parametro')->select('parametro_medico_id')->where('examen_medico_id', '=', $request->examen_medico_id);
        return ParametroMedico::whereIn('id', $aux_parametros)->get();
    }
}