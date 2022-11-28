<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntasLiqPenImaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juntas_liq_pen_ima', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path')->nullable();
            $table->integer('junta_liq_penetran_id')->unsigned()->index()->nullable();        

            $table->foreign('junta_liq_penetran_id')->references('id')->on('juntas_informe_liquidos_penetrantes')
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
        Schema::dropIfExists('juntas_liq_pen_ima');
    }
}
