<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRadicadoToSolicitudesCreditos extends Migration
{
    public function up()
    {
        Schema::table('solicitudes__creditos', function (Blueprint $table) {
            $table->string('radicado')->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('solicitudes__creditos', function (Blueprint $table) {
            $table->dropUnique('solicitudes__creditos_radicado_unique'); // Elimina la restricción de unicidad
            $table->dropColumn('radicado');
        });
    }
}
