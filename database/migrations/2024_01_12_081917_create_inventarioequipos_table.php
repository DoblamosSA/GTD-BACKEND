<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioequiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarioequipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_equipo');
            $table->string('modelo');
            $table->string('marca');
            $table->enum('estado',['Activo','Inactivo','Debaja']);
            $table->string('serial');
            $table->string('sistema_operativo');
            $table->string('procesador');
            $table->string('memoria_ram');
            $table->string('hdd');
            $table->string('sede');
            $table->string('piso');
            $table->integer('area');
            $table->date('fecha_garantia')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->string('numero_facturasap')->nullable();
            $table->string('codigo_Activosap')->nullable();
            $table->string('codigoactivoSaG')->nullable();
            $table->unsignedBigInteger('asignado_A');
            $table->foreign('asignado_A')->references('id')->on('empledo_s_a_p_s');
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
        Schema::dropIfExists('inventarioequipos');
    }
}
