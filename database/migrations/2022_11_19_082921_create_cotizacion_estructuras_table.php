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
            $table->integer('Numero_Obra');
            $table->string('Empresa_Cliente');
            $table->date('Fecha_Recibido')->nullable();
            $table->string('Nombre_Obra');
            $table->string('Descripcion');
            $table->string('Estado');
            $table->date('Fecha_Cotizada')->nullable();
            $table->float('Valor_Antes_Iva');
            $table->string('Contacto');
            $table->integer('AreaM2');
            $table->integer('m2');
            $table->string('Incluye_Montaje');
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
