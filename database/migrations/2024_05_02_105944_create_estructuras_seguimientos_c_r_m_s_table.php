<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstructurasSeguimientosCRMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estructuras_seguimientos_c_r_m_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estructuras_id');
            $table->date('Fecha_Seguimiento');
            $table->string('Evento');
            $table->string('Observaciones');
            $table->date('Fecha_Nuevo_Seguimiento')->nullable();
            $table->timestamps();
            $table->foreign('estructuras_id')->references('id')->on('estructura_melalicas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estructuras_seguimientos_c_r_m_s');
    }
}
