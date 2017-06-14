<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamenMedico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_medico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('tipo_analisis_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('tipo_analisis_id')->references('id')->on('tipo_analisis');
        });

        Schema::create('examen_parametro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examen_medico_id')->unsigned();
            $table->foreign('examen_medico_id')->references('id')->on('examen_medico');
            $table->integer('parametro_medico_id')->unsigned();
            $table->foreign('parametro_medico_id')->references('id')->on('parametro_medico');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_parametro');
        Schema::dropIfExists('examen_medico');
    }
}
