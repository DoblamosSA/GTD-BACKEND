<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntasInformeLiquidosPenetrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juntas_informe_liquidos_penetrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('elemento')->nullable();
            $table->string('junta')->nullable();
            $table->string('indicacion')->nullable();
            $table->string('calificacion')->nullable();
            $table->longText('observaciones')->nullable();
            $table->integer('inf_liq_penetran_id')->unsigned()->index()->nullable();        

            $table->foreign('inf_liq_penetran_id')->references('id')->on('informe_liquidos_penetrantes')
            ->onDelete('cascade');

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
        Schema::dropIfExists('juntas_informe_liquidos_penetrantes');
    }
}
