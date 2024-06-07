<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesComprahistorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_comprahistoriales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doc_entry')->nullable();
            $table->unsignedBigInteger('doc_num')->nullable();
            $table->string('item_id')->nullable();  // Agrega el ID del artículo si lo tienes en tu modelo
            $table->json('data')->nullable();
            $table->string('DocumentStatus')->nullable();
            $table->string('WarehouseCode')->nullable();
            $table->string('Fecha_contabilizacion')->nullable();
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
        Schema::dropIfExists('solicitudes_comprahistoriales');
    }
}
