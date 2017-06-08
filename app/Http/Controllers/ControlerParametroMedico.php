<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParametroMedico;

class ControlerParametroMedico extends Controller
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
        $parametrosMedicos = ParametroMedico::all();
        return view('parametroMedico.index',['parametrosMedicos' => $parametrosMedicos]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create new data
        return view('parametroMedico.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//dd($request);
        //validation of data
        $this->validate($request,['nombre'=>'required','unidad_medida'=>'required','descripcion'=>'required']);
        //create new data
        $parametroMedico = new ParametroMedico;
        $parametroMedico->nombre = $request->nombre;
        $parametroMedico->unidad_medida = $request->unidad_medida;
        $parametroMedico->descripcion = $request->descripcion;
        $parametroMedico->save();
        return redirect()->route('parametroMedico.index')->with('alert-success','Parametro medico creado');
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
        $parametroMedico = ParametroMedico::findOrFail($id);
        //return to view edit
        return view('parametroMedico.edit',compact('parametroMedico'));
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
        $this->validate($request,['nombre'=>'required','unidad_medida'=>'required','descripcion'=>'required']);
        //create new data
        $parametroMedico = ParametroMedico::findOrFail($id);
        $parametroMedico->nombre = $request->nombre;
        $parametroMedico->unidad_medida = $request->unidad_medida;
        $parametroMedico->descripcion = $request->descripcion;
        $parametroMedico->save();
        return redirect()->route('parametroMedico.index')->with('alert-warning','Parametro medico editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parametroMedico = ParametroMedico::findOrFail($id);
        $parametroMedico->delete();
        return redirect()->route('parametroMedico.index')->with('alert-warning','Parametro medico eliminado');
    }
}