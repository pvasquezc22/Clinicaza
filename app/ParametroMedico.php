<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametroMedico extends Model
{
    protected $table = 'parametro_medico';

    public function examenesMedicos()
    {
    	return $this->belongsToMany('App\ExamenMedico', 'examen_parametro', 'examen_medico_id', 'parametro_medico_id');
    }

}
