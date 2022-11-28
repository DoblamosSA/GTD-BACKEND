<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeVertMetalicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_vert_metalicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proyecto')->nullable();
            $table->date('fecha_verificacion');
            $table->string('estructuras')->nullable();
            $table->string('planta_area')->nullable();
            $table->string('contratista')->nullable();
            $table->string('equipo_medicion')->nullable();
            $table->string('torque')->nullable();
            $table->string('resultado_inspeccion')->nullable();            
            $table->longText('observaciones')->nullable();
            $table->string('adjuntos')->nullable();
            $table->string('contratisca_nombre')->nullable();
            $table->string('contratisca_firma')->nullable();
            $table->string('contratisca_cargo')->nullable();
            $table->string('residente_nombre')->nullable();
            $table->string('residente_firma')->nullable();
            $table->string('residente_cargo')->nullable();
            $table->string('inspector_nombre')->nullable();
            $table->string('inspector_firma')->nullable();
            $table->string('inspector_cargo')->nullable();
            $table->string('representante_nombre')->nullable();
            $table->string('representante_firma')->nullable();
            $table->string('representante_cargo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informe_vert_metalicas');
    }
}
