<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenRealizadoDetalle extends Model
{
    protected $table = 'detalle_examen_realizado';

	public function examenRealizado()
    {
    	return $this->belongsTo('App\ExamenRealizado');
    }

	public function parametroMedico()
    {
    	return $this->belongsTo('App\ParametroMedico');
    }
    
}
