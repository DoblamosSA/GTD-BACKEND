<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHitoricoFormaletasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_formaletas', function (Blueprint $table) {
            $table->id();
            $table->string('area')->nullable();
            $table->string('numero_obra')->nullable();
            $table->string('empresa')->nullable();
            $table->string('fecha_Recibido')->nullable();
            $table->string('estado')->nullable();
            $table->string('asesor')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('seguimiento')->nullable();
            $table->string('requiereing')->nullable();
            $table->string('valorcotizado')->nullable();
            $table->string('valoradjudicado')->nullable();
            $table->string('numeroorden')->nullable();
            $table->string('numerofactura')->nullable();
            $table->string('fechafactura')->nullable();
            $table->string('pesokg')->nullable();
            $table->string('aream2')->nullable();
            $table->string('/kg')->nullable();
            $table->string('cantidadelementos')->nullable();
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
        Schema::dropIfExists('hitorico_formaletas');
    }
}
