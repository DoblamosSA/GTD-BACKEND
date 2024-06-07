<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeAntiguedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_antiguedads', function (Blueprint $table) {
            $table->id();
            $table->string('Tipo');
            $table->string('Codigo_SN');
            $table->string('Nombre_SN');
            $table->string('Nit');
            $table->string('Grupo');
            $table->string('Cuenta');
            $table->string('CuentaVisible');
            $table->string('Tipo_Doc')->nullable();
            $table->string('Documento');
            $table->string('Numero_de_referencia')->nullable();
            $table->integer('Numero_de_plazos')->nullable();
            $table->integer('Numero_plazo')->nullable();
            $table->date('Fecha_de_contabilizacion');
            $table->dateTime('Fecha_Vencimiento');
            $table->date('Fecha_de_Documento');
            $table->integer('Dias');
            $table->decimal('LimiteCredito', 15, 6);
            $table->decimal('Importe_Original', 15, 6);
            $table->decimal('Saldo_Vencido', 15, 6);
            $table->decimal('Sin_Vencer', 15, 6);
            $table->string('Proyecto');
            $table->string('ProyectoNom');
            $table->decimal('1-15', 15, 6);
            $table->decimal('16-30', 15, 6);
            $table->decimal('0-30', 15, 6);
            $table->decimal('31-60', 15, 6);
            $table->decimal('61-90', 15, 6);
            $table->decimal('91-120', 15, 6);
            $table->decimal('121-150', 15, 6);
            $table->decimal('151-180', 15, 6);
            $table->decimal('> 180', 15, 6);
            $table->decimal('> 90', 15, 6);
            $table->decimal('> 121', 15, 6);
            $table->string('Territorio');
            $table->string('Telefono');
            $table->string('Fax')->nullable();
            $table->string('Telefono2')->nullable();
            $table->string('Celular')->nullable();
            $table->string('Email');
            $table->string('NombreEmpleado');
            $table->integer('Empleado');
            $table->decimal('Valor_Abonado', 15, 6);
            $table->string('Municipio');
            $table->string('DestinatarioFactura');
            $table->string('DestinatarioMercancia');
            $table->string('Responsable')->nullable();
            $table->decimal('ValorChequesAplicados', 15, 6);
            $table->string('FCCurrency')->nullable();
            $table->decimal('ImporteMS', 15, 6);
            $table->decimal('SaldoVencidoMS', 15, 6);
            $table->decimal('Valor_Abonado_MS', 15, 6);
            $table->decimal('Sin_Vencer_MS', 15, 6);
            $table->decimal('1-15_MS', 15, 6);
            $table->decimal('16-30_MS', 15, 6);
            $table->decimal('0-30_MS', 15, 6);
            $table->decimal('31-60_MS', 15, 6);
            $table->decimal('61-90_MS', 15, 6);
            $table->decimal('91-120_MS', 15, 6);
            $table->decimal('121-150_MS', 15, 6);
            $table->decimal('151-180_MS', 15, 6);
            $table->decimal('> 180_MS', 15, 6);
            $table->decimal('ImporteME', 15, 6);
            $table->decimal('SaldoVencidoME', 15, 6);
            $table->decimal('Valor_Abonado_ME', 15, 6);
            $table->decimal('Sin_Vencer_ME', 15, 6);
            $table->decimal('1-15_ME', 15, 6);
            $table->decimal('16-30_ME', 15, 6);
            $table->decimal('0-30_ME', 15, 6);
            $table->decimal('31-60_ME', 15, 6);
            $table->decimal('61-90_ME', 15, 6);
            $table->decimal('91-120_ME', 15, 6);
            $table->decimal('121-150_ME', 15, 6);
            $table->decimal('151-180_ME', 15, 6);
            $table->decimal('> 180_ME', 15, 6);
            $table->string('PYMNTGROUP');
            $table->string('DocumentoBase');
            $table->string('MonExtr')->nullable();
            $table->string('Referencia1')->nullable();
            $table->integer('DocEntry');
            $table->integer('TransType');
            $table->string('CondicionPagoDocumento')->nullable();
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
        Schema::dropIfExists('informe_antiguedads');
    }
}
