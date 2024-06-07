<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbastesimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abastesimientos', function (Blueprint $table) {
            $table->id();  // Esto creará un campo id entero autoincremental, si no lo tienes ya
            $table->string('ItemCode');  // Cambia a string en lugar de integer
            $table->string('Dscription');
 $table->decimal('SWeight1')->nullable();
            $table->string('SubGrupo');
            $table->string('Almacen');
            $table->decimal('Stock');
            $table->decimal('Comprometido');
            $table->decimal('Pedido');
            $table->decimal('Disponible');
            $table->decimal('Sugerido');
            $table->decimal('Pventa');
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
        Schema::dropIfExists('abastesimientos');
    }
}
