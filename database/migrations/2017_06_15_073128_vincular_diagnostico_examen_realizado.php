<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VincularDiagnosticoExamenRealizado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examen_realizado', function($table) {
            $table->integer('diagnostico_id')->unsigned()->nullable();
            $table->foreign('diagnostico_id')->references('id')->on('diagnosticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examen_realizado', function($table) {
            $table->dropColumn('diagnostico_id');
        });
    }
}
