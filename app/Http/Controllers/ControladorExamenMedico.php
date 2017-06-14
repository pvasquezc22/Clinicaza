<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamenMedico;
use App\TipoAnalisis;
use App\ParametroMedico;

class ControladorExamenMedico extends Controller
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
        $examenes_medicos = ExamenMedico::all();
        return view('examenesMedicos.index',['examenes_medicos' => $examenes_medicos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create new data
        $tipos_analisis = TipoAnalisis::all();
        $parametros_medicos = ParametroMedico::all();
        return view('examenesMedicos.create',['tipos_analisis' => $tipos_analisis , 'parametros_medicos' => $parametros_medicos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['nombre'=>'required','descripcion'=>'required','tipo_analisis_id'=>'required']);
        $examenMedico = new ExamenMedico;
        $examenMedico->nombre = $request->nombre;
        $examenMedico->descripcion = $request->descripcion;
        $examenMedico->tipo_analisis_id = $request->tipo_analisis_id;
        $examenMedico->save();
        if (isset($request->indicadores)) {
            $examenMedico->parametrosMedicos()->sync($request->indicadores, false);
        }
        return redirect()->route('examenMedico.index')->with('alert-success','Examen medico creado');
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
}