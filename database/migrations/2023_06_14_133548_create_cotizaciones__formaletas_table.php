<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesFormaletasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones__formaletas', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_Obra');
            $table->string('Lugar_Obra');
            $table->date('Fecha_Recibido');
            $table->date('Fecha_Cotizada');
            $table->float('Valor_Antes_Iva');
            $table->string('Estado');
            $table->string('Tipologia');
            $table->float('Valor_Adjudicado');
            $table->integer('Valor_Kilogramo');
            $table->integer('Metros_Cuadrados');
            $table->integer('Kilogramos');
            $table->unsignedBigInteger('Asesor_id');
            $table->foreign('Asesor_id')->references('id')->on('asesores');
            $table->string('Origen');
            $table->string('Incluye_Montaje');
            $table->unsignedBigInteger('clientes_id');
            $table->foreign('clientes_id')->references('id')->on('clientes_s_a_p_s');
            $table->unsignedBigInteger('pais_id');
            $table->foreign('pais_id')->references('id')->on('pais_cordenadas')->constrained();
            $table->string('Departamento');
            $table->date('Fecha_Venta');
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
        Schema::dropIfExists('cotizaciones__formaletas');
    }
}
