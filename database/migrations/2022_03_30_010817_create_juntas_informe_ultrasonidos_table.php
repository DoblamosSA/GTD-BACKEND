<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntasInformeUltrasonidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juntas_informe_ultrasonidos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->string('identificacion_elemento')->nullable();
            $table->string('junta')->nullable();
           
            $table->integer('inf_ultrasonido_id')->unsigned()->index()->nullable();        

            $table->foreign('inf_ultrasonido_id')->references('id')->on('informe_ultrasonidos')
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
        Schema::dropIfExists('juntas_informe_ultrasonidos');
    }
}
