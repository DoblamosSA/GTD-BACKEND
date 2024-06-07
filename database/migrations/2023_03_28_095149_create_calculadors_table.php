<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculadors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lamina_id');
            $table->unsignedBigInteger('calibre_id');
            $table->unsignedBigInteger('Recurso_id');
            $table->unsignedBigInteger('costo_nocalidad_id');
            $table->integer('user_costea_id');
            $table->integer('Cantidad_Piezas');
            $table->float('Espesor_Material');
            $table->float('Ancho_Platina');
            $table->float('Longitud');
            $table->float('Total');
            $table->foreign('lamina_id')->references('id')->on('laminas');
            $table->foreign('calibre_id')->references('id')->on('calibres');
            $table->foreign('Recurso_id')->references('id')->on('recursos_s_a_p_s');
            $table->foreign('costo_nocalidad_id')->references('id')->on('costo_nocalidads');
            $table->foreign('user_costea_id')->references('id')->on('users');
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
        Schema::dropIfExists('calculadors');
    }
}
