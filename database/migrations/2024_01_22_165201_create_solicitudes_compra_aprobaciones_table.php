<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesCompraAprobacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('solicitudes_compra_aprobaciones', function (Blueprint $table) {
            $table->id();
            $table->date('RequriedDate');
            $table->string('RequesterName');
            $table->string('U_HBT_AproComp');
            $table->string('Comments')->nullable();
            $table->enum('estado',['Pendiente','Aprobada','Rechazada','No_requiere_apr'])->nullable();
            $table->unsignedBigInteger('UsuarioSolicitante_id')->nullable();
            $table->unsignedBigInteger('UsuarioModifico_id')->nullable();
            $table->foreign('UsuarioSolicitante_id')->references('id')->on('users');
            $table->foreign('UsuarioModifico_id')->references('id')->on('users');
            $table->string('DocNum')->nullable();
            $table->string('DocEntry')->nullable();
            $table->integer('usuarioaprobador')->nullable();
            $table->integer('RefDocNumOrder')->nullable();  
            $table->integer('DocEntryOrdenVenta')->nullable();
            $table->float('Price')->nullable();       
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
        Schema::dropIfExists('solicitudes_compra_aprobaciones');
    }
}
