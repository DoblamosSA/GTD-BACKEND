<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesFeriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_ferias', function (Blueprint $table) {
            $table->id();
            $table->string('empresa')->nullable();
            $table->string('contacto')->nullable();
            $table->string('apellido')->nullable();
            $table->string('pais')->nullable();
            $table->string('region')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('vortex')->nullable();
            $table->string('formaletas')->nullable();
            $table->string('estructuras')->nullable();
            $table->string('servicios')->nullable();
            $table->string('venta_acero')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('tipo_bd')->nullable();
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
        Schema::dropIfExists('clientes_ferias');
    }
}
