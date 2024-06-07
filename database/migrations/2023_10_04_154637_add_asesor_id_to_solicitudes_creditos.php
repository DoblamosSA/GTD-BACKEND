<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsesorIdToSolicitudesCreditos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
     {
         Schema::table('solicitudes__creditos', function (Blueprint $table) {
             // Nueva columna asesor_id
             $table->bigInteger('asesor_id')->unsigned()->nullable();
             $table->foreign('asesor_id')->references('id')->on('asesores')->onDelete('cascade');
         });
     }
 
     public function down()
     {
         Schema::table('solicitudes__creditos', function (Blueprint $table) {
             // Revertir la migración eliminando la columna
             $table->dropForeign(['asesor_id']);
             $table->dropColumn('asesor_id');
         });
     }
}
