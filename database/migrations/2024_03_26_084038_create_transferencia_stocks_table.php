<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciaStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencia_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('SOLICITUD_TRASLADO')->nullable();
            $table->string('COD_ARTI')->nullable();
            $table->string('BODEGA_ORIGEN')->nullable();
            $table->string('BODEGA_TRANSITO')->nullable();
            $table->string('ALMACEN_FINAL')->nullable();
            $table->integer('CANTIDAD_TRASLADO')->nullable();
            $table->unsignedBigInteger('id_articulo_abastecimiento')->nullable();
            // $table->foreign('id_articulo_abastecimiento')->references('id')->on('abastesimientos')->onDelete('cascade');
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
        Schema::dropIfExists('transferencia_stocks');
    }
}
