<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeUltrasonidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_ultrasonidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proyecto')->nullable();
            $table->string('grado_calibracion')->nullable();
            $table->string('angulos_grados')->nullable();            
            $table->string('bloquereferencia_tipo')->nullable();
            $table->string('bloque_referencia_serial')->nullable();
            $table->string('calidad_material_base')->nullable();
            $table->string('espesor')->nullable(); 
            $table->string('metal_aporte')->nullable();
            $table->string('acoplante')->nullable();
            $table->string('proceso')->nullable();
            $table->string('tipo_junta')->nullable();
            $table->string('paso')->nullable();
            $table->string('medio_paso')->nullable();
            $table->string('rango')->nullable();
            $table->string('elaboro');
            $table->string('reviso');            
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
        Schema::dropIfExists('informe_ultrasonidos');
    }
}
