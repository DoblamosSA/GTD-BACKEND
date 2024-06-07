<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoCRMVortexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimiento_c_r_m_vortexes', function (Blueprint $table) {
            $table->id();
            $table->Integer('vorte_id');
            $table->date('Fecha_Seguimiento');
            $table->string('Evento');
            $table->string('Observaciones');
            $table->date('Fecha_Nuevo_Seguimiento')->nullable();
            $table->timestamps();
            $table->foreign('vorte_id')->references('id')->on('vortes')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimiento_c_r_m_vortexes');
    }
}
