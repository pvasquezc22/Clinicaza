<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoAnalisis;

class ControllerTipoAnalisis extends Controller
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
        $tiposAnalisis = TipoAnalisis::all();
        return view('tipoAnalisis.index',['tiposAnalisis' => $tiposAnalisis]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create new data
        return view('tipoAnalisis.create');
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
        $this->validate($request,['nombre'=>'required']);
        //create new data
        $tipoAnalisis = new TipoAnalisis;
        $tipoAnalisis->nombre = $request->nombre;
        $tipoAnalisis->save();
        return redirect()->route('tipoAnalisis.index')->with('alert-success','Analisis creado');
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
        $tipoAnalisis = TipoAnalisis::findOrFail($id);
        //return to view edit
        return view('tipoAnalisis.edit',compact('tipoAnalisis'));
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
        $this->validate($request,['nombre'=>'required']);
        //edit updated data
        $tipoAnalisis = TipoAnalisis::findOrFail($id);
        $tipoAnalisis->nombre = $request->nombre;
        $tipoAnalisis->save();
        return redirect()->route('tipoAnalisis.index')->with('alert-warning','Analisis editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoAnalisis = TipoAnalisis::findOrFail($id);
        $tipoAnalisis->delete();
        return redirect()->route('tipoAnalisis.index')->with('alert-warning','Analisis eliminado');
    }
}