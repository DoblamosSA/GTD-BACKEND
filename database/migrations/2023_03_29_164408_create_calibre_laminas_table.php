<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalibreLaminasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calibre_lamina', function (Blueprint $table) {
            $table->unsignedBigInteger('calibre_id');
            $table->unsignedBigInteger('lamina_id');
            $table->decimal('precio', 10, 2)->nullable();
            $table->foreign('calibre_id')->references('id')->on('calibres')->onDelete('cascade');
            $table->foreign('lamina_id')->references('id')->on('laminas')->onDelete('cascade');
            $table->primary(['calibre_id', 'lamina_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calibre_laminas');
    }
}
