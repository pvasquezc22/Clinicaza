<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamenRealizado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_realizado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('paciente_id')->unsigned()->nullable();
            $table->integer('examen_medico_id')->unsigned()->nullable();
            $table->date('fecha');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('examen_medico_id')->references('id')->on('examen_medico');
        });

        Schema::create('detalle_examen_realizado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examen_realizado_id')->unsigned()->nullable();
            $table->integer('parametro_medico_id')->unsigned()->nullable();
            $table->float('valor_parametro');
            $table->timestamps();
            $table->foreign('examen_realizado_id')->references('id')->on('examen_realizado');
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
        Schema::dropIfExists('detalle_examen_realizado');
        Schema::dropIfExists('examen_realizado');
    }
}
