<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaSintoma;
use App\Especialidad;
use App\Diagnostico;
use App\Enfermedad;
use App\Paciente;
use App\Sintoma;
use App\Turno;
use App\User;
use DB;

class ControlerBayes extends Controller
{
    public function index()
    {
        $enfermedades_diagnosticadas = DB::table('diagnostico_enfermedad')->count();
        $categorias = CategoriaSintoma::all();
        $enfermedades = Enfermedad::all();
        $pacientes = Paciente::all();
        $sintomas = Sintoma::all();
        $turnos = Turno::all();
        return view('bayes.index',['categorias' => $categorias , 'sintomas'=>$sintomas , 'enfermedades'=>$enfermedades , 'enfermedades_diagnosticadas'=>$enfermedades_diagnosticadas , 'pacientes' => $pacientes , 'turnos'=>$turnos]);
    }

    public function consulta(Request $request)
    {
    	$enfermedad_id_paciente = 0;
    	$probabilidad_enfermedad_paciente = 0;
        $sintomas = Sintoma::all();
        $enfermedades = Enfermedad::all();
        $probabilidad_enfermedad = array();
        $enfermedad_paciente = array();
        $enfermedades_diagnosticadas = DB::table('diagnostico_enfermedad')->count();
        foreach ($enfermedades as $enfermedad) {
        	$probabilidad_enfermedad[$enfermedad->id] = array();
        	$probabilidad_enfermedad[$enfermedad->id]['probabilidad_total'] = $enfermedad->diagnosticosCount()/$enfermedades_diagnosticadas;
        	$probabilidad_enfermedad[$enfermedad->id]['probabilidad_condicional'] = array();
        	foreach ($sintomas as $sintoma) {
        		$probabilidad_enfermedad[$enfermedad->id]['probabilidad_condicional'][$sintoma->id] = 0;
        	}
        	$diagnosticos_enfermedad = DB::table('diagnostico_enfermedad')->where('enfermedad_id', '=', $enfermedad->id)->get();
        	foreach ($diagnosticos_enfermedad as $diagnostico_registro) {
        		$sintomas_diagnostico = DB::table('diagnostico_sintoma')->where('diagnostico_id', '=', $diagnostico_registro->diagnostico_id)->get();
        		foreach ($sintomas_diagnostico as $sintomas_diagnostico_aux) {
        			$sintoma = Sintoma::findOrFail($sintomas_diagnostico_aux->sintoma_id);
        			$probabilidad_enfermedad[$enfermedad->id]['probabilidad_condicional'][$sintoma->id] += 1;
        		}
        	}
        	foreach ($sintomas as $sintoma) {
        		$probabilidad_enfermedad[$enfermedad->id]['probabilidad_condicional'][$sintoma->id] /= $enfermedad->diagnosticosCount();
        	}
        }
        foreach ($enfermedades as $enfermedad) {
        	$enfermedad_paciente[$enfermedad->id] = 0;
        	foreach ($request->sintomas as $key => $value) {
        		$enfermedad_paciente[$enfermedad->id] += $probabilidad_enfermedad[$enfermedad->id]['probabilidad_condicional'][$value];
	    	}
	    	if($enfermedad_paciente[$enfermedad->id]>$probabilidad_enfermedad_paciente){
	    		$probabilidad_enfermedad_paciente = $enfermedad_paciente[$enfermedad->id];
	    		$enfermedad_id_paciente = $enfermedad->id;
	    	}
        }
        $enfermedad_estimada = Enfermedad::findOrFail($enfermedad_id_paciente);
        return array('enfermedad_estimada'=>$enfermedad_estimada , 'especialidad'=>$enfermedad_estimada->especialidad);
    }
    public function reserva(Request $request)
    {
        $respuesta = false;
        $especialidad = Especialidad::findOrFail($request->especialidad_id);
        $users = User::where('tipo_usuario', '=', 'Medico')
                                    ->where('turno_id', '=', $request->turno_id)
                                    ->where('especialidad_id', '=', $request->especialidad_id)
                                    ->get();
        if($users->count()>0){
            $respuesta = true;
            $diagnostico = new Diagnostico;
            foreach ($users as $user) {
                $diagnostico->user_id = $user->id;
            }
            $diagnostico->paciente_id = $request->paciente_id;
            $diagnostico->estado = "Pendiente";
            $diagnostico->save();
            if (isset($request->sintomas)) {
                $diagnostico->sintomas()->sync($request->sintomas, false);
            }
            $informacion = "Reserva realizada";
        }else{
            $informacion = "No existen medicos disponibles, para ".$especialidad->nombre." en el turno seleccionado";
        }
        return array('respuesta'=>$respuesta , 'informacion'=>$informacion);
    }
}