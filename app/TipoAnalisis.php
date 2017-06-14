<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAnalisis extends Model
{
    protected $table = 'tipo_analisis';

    public function examenesMedicos()
    {
    	return $this->hasMany('App\ExamenMedico');
    }

}
