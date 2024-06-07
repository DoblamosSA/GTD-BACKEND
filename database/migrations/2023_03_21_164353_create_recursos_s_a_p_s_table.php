<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecursosSAPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos_s_a_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('Code')->nullable();
            $table->string('Name')->nullable();
            $table->float('Cost1')->nullable();
            $table->string('UnitOfMeasure')->nullable();
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
        Schema::dropIfExists('recursos_s_a_p_s');
    }
}
