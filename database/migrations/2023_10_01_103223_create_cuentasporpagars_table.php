<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasporpagarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('cuentasporpagars', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->string('Numero_Tarjeta')->nullable();
            $table->string('Estado_Documento');
            $table->date('Fecha_Documento');
            $table->date('Fecha_Vencimiento');
            $table->string('Codigo_cliente');
            $table->string('Nombre_Cliente');
            $table->string('Vendedor');
            $table->decimal('Total_Documento', 10, 2);
            $table->decimal('pagado_hasta_la_fecha', 10, 2);
            $table->decimal('Saldo_Pendiente', 10, 2);
            $table->string('E_Mail')->nullable();
            $table->int('Dias_Vencidos')->nullable();
            $table->boolean('EnvioCorreo')->nullable();


           
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
        Schema::dropIfExists('cuentasporpagars');
    }
}