<?php

namespace App;

use DB;
use App\ExamenRealizadoDetalle;
use Illuminate\Database\Eloquent\Model;

class ExamenRealizado extends Model
{
    protected $table = 'examen_realizado';


    public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function paciente()
    {
    	return $this->belongsTo('App\Paciente');
    }

	public function examenMedico()
    {
    	return $this->belongsTo('App\ExamenMedico');
    }

	public function examenRealizadoDetalle()
    {
        return ExamenRealizadoDetalle::where('examen_realizado_id', $this->id)->get();
    }

}
