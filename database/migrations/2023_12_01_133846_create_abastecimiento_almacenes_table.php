<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbastecimientoAlmacenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abastecimiento_almacenes', function (Blueprint $table) {
            $table->id();  
            $table->string('ItemCode'); 
            $table->string('Dscription');
            $table->decimal('SWeight1')->nullable();
            $table->string('SubGrupo');
            $table->string('Almacen');
            $table->decimal('Stock');
            $table->decimal('Comprometido');
            $table->decimal('Pedido');
            $table->decimal('Disponible');
            $table->decimal('Sugerido');
            $table->decimal('Cantidad');
            $table->integer('id__');
            $table->boolean('existencia_arti_historial')->nullable();
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
        Schema::dropIfExists('abastecimiento_almacenes');
    }
}
