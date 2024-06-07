<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostoNocalidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costo_nocalidads', function (Blueprint $table) {
            $table->id();
            $table->string('sede',50)->nullable();
            $table->date('FechaCNC')->nullable();
            $table->string('Descripcion',4000)->nullable();
            $table->string('Ccop')->nullable();
            $table->string('AreaResponsableCNC',50)->nullable();
            $table->string('SubprocesoCNC',50)->nullable();
            $table->string('causa_raiz',50)->nullable();
            $table->string('Porque1')->nullable();
            $table->string('Porque2')->nullable();
            $table->string('Porque3')->nullable();
            $table->unsignedBigInteger('IdResponsablecnc')->index();
            $table->string('ProcesoReporta')->nullable();
            $table->string('ProcesoDetecta')->nullable();
            $table->float('CostoCNC')->nullable();
            $table->float('SaldoRecuperado')->nullable();
            $table->float('SaldoFinalCNC')->nullable();
            $table->string('DescripcionOP',4000)->nullable();
            $table->string('CorreccionEvento')->nullable();
            $table->string('TipoAccion')->nullable();
            $table->unsignedBigInteger('IdAnalistaReporto')->index();
            $table->foreign('IdResponsablecnc')->references('id')->on('empledo_s_a_p_s');
            $table->foreign('IdAnalistaReporto')->references('id')->on('empledo_s_a_p_s');
            $table->timestamps();
  		$table->string('EstadoCNC')->nullable();
   		$table->string('QuienCostea')->nullable();
     $table->int('Cantidadpiezasdanadas')->nullable();
	$table->string('confirmacion_asistencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costo_nocalidads');
    }
}
