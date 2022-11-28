<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntasInformeVertMetalicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juntas_informe_vert_metalicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_columna')->nullable();
            $table->string('teorica')->nullable();
            $table->string('real')->nullable(); 
            $table->string('desviacion')->nullable();
            $table->string('altura_Columna')->nullable();
            $table->string('tolerancia')->nullable();
            $table->string('norte_1')->nullable();
            $table->string('norte_2')->nullable();
            $table->string('sur_1')->nullable();
            $table->string('sur_2')->nullable();
            $table->string('oriente_1')->nullable();
            $table->string('oriente_2')->nullable();
            $table->string('occidente_1')->nullable();
            $table->string('occidente_2')->nullable();
            $table->longText('resultado_inspeccion')->nullable();
            $table->integer('inf_vert_met_id')->unsigned()->index()->nullable();        

            $table->foreign('inf_vert_met_id')->references('id')->on('informe_vert_metalicas')
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
        Schema::dropIfExists('juntas_informe_vert_metalicas');
    }
}
