<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamenRealizadoDetalle;
use App\ParametroMedico;
use App\ExamenRealizado;
use App\ExamenMedico;
use App\Paciente;
use App\User;
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
        $user = Auth::user();
        if ($user->tipo_usuario=="Administrador") {
            $examenes_realizados = ExamenRealizado::all();
        }else{
            $examenes_realizados = ExamenRealizado::where('user_id', '=', $user->id)
                                    ->get();
        }
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
            $examenRealizadoDetalle->valor_parametro = $request['parametro_'.$parametro_medico->id];
            $examenRealizadoDetalle->save();
        }
        return redirect()->route('examenRealizado.index')->with('alert-success','Examen realizado creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $examen_realizado = ExamenRealizado::findOrFail($id);
        $examen_medico = ExamenMedico::findOrFail($examen_realizado->examen_medico_id);
        $paciente = Paciente::findOrFail($examen_realizado->paciente_id);
        $user = User::findOrFail($examen_realizado->user_id);
        $examen_realizado_detalle = ExamenRealizadoDetalle::where('examen_realizado_id', '=', $examen_realizado->id)->get();
        $aux_parametros = DB::table('examen_parametro')->select('parametro_medico_id')->where('examen_medico_id', '=', $examen_realizado->examen_medico_id);
        $parametros_medicos = ParametroMedico::whereIn('id', $aux_parametros)->get();
        return view('examenesRealizados.show',['examen_realizado' => $examen_realizado , 'examen_medico' => $examen_medico , 'paciente' => $paciente , 'user' => $user , 'examen_realizado_detalle' => $examen_realizado_detalle , 'parametros_medicos' => $parametros_medicos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $examen_realizado = ExamenRealizado::findOrFail($id);
        $examenes_medicos = ExamenMedico::all();
        $pacientes = Paciente::all();
        $examen_realizado_detalle = ExamenRealizadoDetalle::where('examen_realizado_id', '=', $examen_realizado->id)->get();
        $aux_parametros = DB::table('examen_parametro')->select('parametro_medico_id')->where('examen_medico_id', '=', $examen_realizado->examen_medico_id);
        $parametros_medicos = ParametroMedico::whereIn('id', $aux_parametros)->get();
        return view('examenesRealizados.edit',compact('examen_realizado'),['examenes_medicos' => $examenes_medicos , 'pacientes' => $pacientes , 'parametros_medicos' => $parametros_medicos , 'examen_realizado_detalle' => $examen_realizado_detalle]);
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
        $this->validate($request,['paciente_id'=>'required','fecha'=>'required','examenes_medicos_id'=>'required']);
        $examenRealizado = ExamenRealizado::findOrFail($id);
        $examenRealizado->paciente_id = $request->paciente_id;
        $examenRealizado->fecha = $request->fecha;
        $examenRealizado->examen_medico_id = $request->examenes_medicos_id;
        $examenRealizado->save();

        ExamenRealizadoDetalle::where('examen_realizado_id', '=', $id)->delete();

        $aux_parametros = DB::table('examen_parametro')->select('parametro_medico_id')->where('examen_medico_id', '=', $request->examenes_medicos_id);
        $parametros_medicos = ParametroMedico::whereIn('id', $aux_parametros)->get();
        foreach ($parametros_medicos as $parametro_medico) {
            $examenRealizadoDetalle = new ExamenRealizadoDetalle;
            $examenRealizadoDetalle->examen_realizado_id = $examenRealizado->id;
            $examenRealizadoDetalle->parametro_medico_id = $parametro_medico->id;
            $aux_name_parametro = 'parametro_' . $parametro_medico->id;
            $examenRealizadoDetalle->valor_parametro = $request['parametro_'.$parametro_medico->id];
            $examenRealizadoDetalle->save();
        }
        return redirect()->route('examenRealizado.index')->with('alert-warning','Examen realizado editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $examenRealizado = ExamenRealizado::findOrFail($id);
        ExamenRealizadoDetalle::where('examen_realizado_id', '=', $id)->delete();
        $examenRealizado->delete();
        return redirect()->route('examenRealizado.index')->with('alert-warning','Examen realizado eliminado');
    }

    public function parametrosMedicos(Request $request)
    {
        $aux_parametros = DB::table('examen_parametro')->select('parametro_medico_id')->where('examen_medico_id', '=', $request->examen_medico_id);
        return ParametroMedico::whereIn('id', $aux_parametros)->get();
    }

    public function examenesRealizadosPaciente(Request $request)
    {
        $examenes_realizados = ExamenRealizado::where('paciente_id', '=', $request->id_paciente)
                                    ->whereNull('diagnostico_id')
                                    ->get();
        return $examenes_realizados;
    }

}