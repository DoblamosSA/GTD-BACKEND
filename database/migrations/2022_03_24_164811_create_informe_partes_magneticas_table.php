<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformePartesMagneticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_partes_magneticas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proyecto')->nullable();
            $table->date('fecha');
            $table->string('sitio_inspeccion')->nullable();
            $table->string('cod_acep_rechazo')->nullable(); //seleccion
            $table->string('calidad_material_b')->nullable();
            $table->string('proceso_soldadura')->nullable();
            $table->string('espesor_material_b')->nullable();
            $table->string('inspeccionador')->nullable();
            $table->string('nivel')->nullable();
            $table->string('reviso')->nullable();
            $table->string('nivelreviso')->nullable();
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
        Schema::dropIfExists('informe_partes_magneticas');
    }
}
