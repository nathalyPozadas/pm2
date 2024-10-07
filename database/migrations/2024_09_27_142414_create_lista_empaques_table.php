<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_empaques', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('factura');
            $table->unsignedBigInteger('proveedor_id');
            $table->integer('stock_esperado');
            $table->integer('stock_registrado')->default(0);
            $table->integer('stock_actual')->default(0);
            $table->date('fecha_recepcion');
            $table->date('fecha_llegada');
            $table->string('transporte')->nullable();
            $table->string(  'canal_aduana');
            $table->unsignedBigInteger('almacen_id');
            $table->date('fecha_creacion');
            $table->unsignedBigInteger('encargado_id');
            $table->unsignedBigInteger('empresa_id');
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign(columns: 'almacen_id')->references('id')->on('almacen');
            $table->foreign('encargado_id')->references('id')->on('trabajador');
            $table->foreign(columns: 'proveedor_id')->references('id')->on('proveedor');
            $table->foreign('empresa_id')->references('id')->on('empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_paquete');
    }
};
