<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstructuraMelalicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estructura_melalicas', function (Blueprint $table) {
            $table->id();
            $table->integer('Numero_Obra');
            $table->string('Nombre_Obra');
            $table->string('Lugar_Obra');
            $table->date('Fecha_Recibido')->nullable();
            $table->date('Fecha_Cotizada')->nullable();
            $table->float('Valor_Antes_Iva');
            $table->float('Valor_Adjudicado');
            $table->string('Tipologia');
            $table->string('Estado');
            $table->integer('Peso_Cotizado');
            $table->integer('Area_Cotizada');
            $table->unsignedBigInteger('clientes_id')->unsigned()->index();
            $table->foreign('clientes_id')->references('id')->on('clientes')
            ->onDelete('cascade');
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
        Schema::dropIfExists('estructura_melalicas');
    }
}