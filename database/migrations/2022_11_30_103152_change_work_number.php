<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeWorkNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `Numero_Obra` `Numero_Obra` VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `Valor_Antes_Iva` `Valor_Antes_Iva` DOUBLE(8,2) NULL; ");
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `AreaM2` `AreaM2` INT(11) NULL; ");
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `m2` `m2` INT(11) NULL; ");
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `Numero_Obra` `Numero_Obra` int(11) NOT NULL");
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `Valor_Antes_Iva` `Valor_Antes_Iva` DOUBLE(8,2) NOT NULL; ");
        DB::statement("ALTER TABLE `cotizacion_estructuras` CHANGE `m2` `m2` INT(11) NOT NULL; ");
    }
}
