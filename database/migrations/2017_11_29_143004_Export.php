<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Export extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Exports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rfc_emisor');
            $table->string('rfc_receptor');
            $table->string('nombre_emisor')->nullable();
            $table->string('cp')->nullable();
            $table->string('pob_col')->nullable();
            $table->string('dis_mun')->nullable();
            $table->string('pais')->nullable();
            $table->string('estado')->nullable();
            $table->string('localidad')->nullable();
            $table->string('met_pag')->nullable();
            $table->string('version_cfdi')->nullable();
            $table->string('forma_pago')->nullable();
            $table->string('uso_cfdi')->nullable();
            $table->string('regimen_fiscal')->nullable();
            $table->string('clave_producto')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('cve_unidad')->nullable();
            $table->text('descripcion')->nullable();
            $table->double('val_uni')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('iva')->nullable();
            $table->double('isr_retenido')->nullable();
            $table->double('iva_retenido')->nullable();
            $table->string('uuid');
            $table->dateTime('fecha_emision')->nullable();
            $table->dateTime('fecha_certificacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::dropIfExists('Exports');
    }
}
