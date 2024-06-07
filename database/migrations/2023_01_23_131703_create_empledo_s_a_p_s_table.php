<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpledoSAPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empledo_s_a_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('CardCode')->nullable()->unique();
            $table->string('CardName')->nullable();
            $table->string('CardType')->nullable();
            $table->string('Phone1')->nullable();
            $table->string('Currency')->nullable();
            $table->string('Cellular')->nullable();
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
        Schema::dropIfExists('empledo_s_a_p_s');
    }
}
