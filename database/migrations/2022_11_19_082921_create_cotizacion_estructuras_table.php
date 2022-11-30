<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionEstructurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_estructuras', function (Blueprint $table) {
            $table->id();
            $table->string('Numero_Obra')->nullable();
            $table->string('Empresa_Cliente');
            $table->date('Fecha_Recibido')->nullable();
            $table->string('Nombre_Obra')->nullable();
            $table->string('Descripcion')->nullable();
            $table->string('Estado')->nullable();
            $table->date('Fecha_Cotizada')->nullable();
            $table->float('Valor_Antes_Iva')->nullable();
            $table->string('Contacto')->nullable();
            $table->integer('AreaM2')->nullable();
            $table->integer('m2')->nullable();
            $table->string('Incluye_Montaje')->nullable();
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
        Schema::dropIfExists('cotizacion_estructuras');
    }
}
