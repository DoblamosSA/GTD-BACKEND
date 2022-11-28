<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeLiquidosPenetrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_liquidos_penetrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->String ('nombre_proyecto')->nullable();;
            $table->date('fecha');
            $table->string('sitio_inspeccion')->nullable();
            $table->string('calidad_material_base')->nullable();
            $table->string('proceso_soldadura')->nullable();
            $table->string('espesor_material_base')->nullable();
            $table->string('elemento')->nullable();
            $table->longText('observaciones')->nullable();
            $table->string('inspeccionado_por')->nullable();
            $table->string('nivel')->nullable();
            $table->string('revisado_por')->nullable();
            $table->string('nivel2')->nullable();
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
        Schema::dropIfExists('informe_liquidos_penetrantes');
    }
}
