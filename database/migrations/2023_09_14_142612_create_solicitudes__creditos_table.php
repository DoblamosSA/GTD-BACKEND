<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
         Schema::create('solicitudes__creditos', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_Empresa_Persona');
            $table->string('Nit');
            $table->string('correo');
            $table->double('Monto_Solicitado');
            $table->string('Plazo_Credito_Meses');
            $table->string('Aceptacion_Politica_Datos_Personales');
            $table->string('Documento_Consentimiento_inf',300)->nullable();
            $table->string('Documento_Certificado_Bancario',300)->nullable();
            $table->string('Documento_Referencia_Comercial',300)->nullable();
  	    $table->string('Documento_Referencia_Comercial',300)->nullable();
            $table->string('Documento_Cedula',300)->nullable();
            $table->string('Documento_Rut',300)->nullable();
            $table->string('Documento_Camara_Comercio',300)->nullable();
            $table->string('Documento_Declaracion_Renta',300)->nullable();
       	    $table->string('Documento_informa_Cartera',300)->nullable();
            $table->string('Documento_data_credito',300)->nullable();
       	    $table->string('Documento_pagare',300)->nullable();
             // Estados de aprobación para cada aprobador
            $table->enum('Estado_Cartera', ['Pendiente', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->enum('Estado_Beratung', [ 'Pendiente', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->enum('Estado_Sagrilaft', [ 'Pendiente', 'Aprobado', 'Rechazado'])->default('Pendiente');
    	    $table->enum('Estado_Gerencia',['Pendiente','Aprobado','Rechazado'])->default('Pendiente');
        
    
            // ID de usuario que aprobó o rechazó en cada etapa
                $table->bigInteger('usuario_Aprobadorcartera_id')->unsigned()->nullable();
                $table->bigInteger('usuario_Aprobadorberatung_id')->unsigned()->nullable();
                $table->bigInteger('usuario_AprobadorSagrilaft_id')->unsigned()->nullable();
		$table->bigInteger('usuario_Aprobadorgerencia_id')->unsigned()->nullable();
        
                $table->string('Estado_Final')->nullable();
    
                $table->timestamps();
                
                // Claves foráneas
                $table->foreign('usuario_Aprobadorcartera_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('usuario_Aprobadorberatung_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('usuario_AprobadorSagrilaft_id')->references('id')->on('users')->onDelete('cascade');
		$table->foreign('usuario_Aprobadorgerencia_id')->references('id')->on('users')->onDelete('cascade');

        });
        
        
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes__creditos');
    }
}