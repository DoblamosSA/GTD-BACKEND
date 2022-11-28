<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosJuntasInformeUltrasonidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_juntas_informe_ultrasonidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ubicacion_junta')->nullable();
            $table->string('indicacion_numero')->nullable();
            $table->string('desde_cara')->nullable();
            $table->string('pierna')->nullable();
            $table->string('nivel_indicacion')->nullable();
            $table->string('nivel_referencia')->nullable();
            $table->string('factor_atenuacion')->nullable();
            $table->string('valoracion_indicacion')->nullable();
            $table->string('longitud_defecto')->nullable();
            $table->string('distancia_angular')->nullable();
            $table->string('profundidad_desde')->nullable();
            $table->string('evaluacion_discontinuidad_1')->nullable();
            $table->string('evaluacion_discontinuidad_2')->nullable();
            $table->string('evaluacion_discontinuidad_3')->nullable();
            $table->string('distancia_desde_x')->nullable();
            $table->string('distancia_desde_y')->nullable();
            $table->string('estampe_soldador')->nullable();
            $table->longText('observaciones')->nullable();
            $table->integer('jun_inf_ult_id')->unsigned()->index()->nullable();        

            $table->foreign('jun_inf_ult_id')->references('id')->on('juntas_informe_ultrasonidos')
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
        Schema::dropIfExists('datos_juntas_informe_ultrasonidos');
    }
}
