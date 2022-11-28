<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntasPartesMagneticasImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juntas_partes_magneticas_imagenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path')->nullable();
            $table->integer('junta_id')->unsigned()->index()->nullable();        

            $table->foreign('junta_id')->references('id')->on('juntas_informe_partes_magneticas')
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
        Schema::dropIfExists('juntas_partes_magneticas_imagenes');
    }
}
