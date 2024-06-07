<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('Numero_Obra')->nullable();
            $table->string('Empresa_Cliente')->nullable();
            $table->string('Fecha_Recibido')->nullable();
            $table->string('Nombre_Obra')->nullable();
            $table->string('Descripcion')->nullable();
            $table->string('Estado')->nullable();
            $table->string('Fecha_Cotizada')->nullable();
            $table->string('Valor_Antes_Iva')->nullable();
            $table->string('Contacto')->nullable();
            $table->string('Area_M2')->nullable();
            $table->string('M2')->nullable();
            $table->string('Incluye_Montaje')->nullable();
            $table->string('Origen')->nullable();
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
        Schema::dropIfExists('_historial_cotizaciones');
    }
}
