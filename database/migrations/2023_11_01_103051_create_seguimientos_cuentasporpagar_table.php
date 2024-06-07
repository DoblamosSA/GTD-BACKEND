<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientosCuentasporpagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos_cuentasporpagar', function (Blueprint $table) {
            $table->unsignedBigInteger('cuentasporpagar_id');
            $table->foreign('cuentasporpagar_id')->references('id')->on('cuentasporpagars')->onDelete('cascade');
            $table->text('comentario');
            $table->date('Fecha_Seguimiento');
            $table->date('Fecha_compromiso_pago');
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
        Schema::dropIfExists('seguimientos_cuentasporpagar');
    }
}
