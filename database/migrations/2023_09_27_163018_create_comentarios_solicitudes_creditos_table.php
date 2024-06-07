<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosSolicitudesCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios__solicitudes__creditos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_credito_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comentario');
            $table->timestamps();
        
            $table->foreign('solicitud_credito_id')->references('id')->on('solicitudes__creditos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios_solicitudes_creditos');
    }
}
