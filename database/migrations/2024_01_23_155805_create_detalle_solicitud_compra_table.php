<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleSolicitudCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_solicitud_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_solicitud_compra');
            $table->unsignedBigInteger('Materiales_id');
            $table->string('Descripcion');
            $table->string('TextoLibre');
            $table->string('Cantidad');
            $table->string('Proyecto');
            $table->string('Almacen');
            $table->string('CentroOperaciones');
            $table->string('CentroCostos');
            $table->string('Departamento');
           
            $table->foreign('Materiales_id')->references('id')->on('consumibles_saps');
            $table->foreign('id_solicitud_compra')->references('id')->on('solicitudes_compra_aprobaciones');
            $table->string('TaxCode')->nullable();
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
        Schema::dropIfExists('detalle_solicitud_compra');
    }
}
