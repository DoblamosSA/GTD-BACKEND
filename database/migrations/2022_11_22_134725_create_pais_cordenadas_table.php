<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaisCordenadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pais_cordenadas', function (Blueprint $table) {
            $table->id();
            $table->string('countryName');
            $table->float('latitude', 8, 6)->nullable();
            $table->float('longitude', 9, 6)->nullable();
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
        Schema::dropIfExists('pais_cordenadas');
    }
}
