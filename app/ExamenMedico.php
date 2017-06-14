<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenMedico extends Model
{
    protected $table = 'examen_medico';

    public function tipoAnalisis()
    {
    	return $this->belongsTo('App\TipoAnalisis');
    }

    public function parametrosMedicos()
    {
    	return $this->belongsToMany('App\ParametroMedico', 'examen_parametro', 'examen_medico_id', 'parametro_medico_id');
    }

}