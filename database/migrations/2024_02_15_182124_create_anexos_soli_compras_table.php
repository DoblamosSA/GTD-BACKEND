<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosSoliComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_soli_compras', function (Blueprint $table) {
            $table->id();
            $table->string('Ruta_documento_Adjunto');
            $table->unsignedBigInteger('id_solicitud_compra')->nullable();
            $table->foreign('id_solicitud_compra')->references('id')->on('solicitudes_compra_aprobaciones');
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
        Schema::dropIfExists('anexos_soli_compras');
    }
}
