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
        Schema::create('movimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empaque_id');
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo_movimiento'); //ingreso, movimiento entre almacenes, dentro del mismo almacen, salida
            $table->unsignedBigInteger('ubicacion_origen_id')->nullable();
            $table->unsignedBigInteger('ubicacion_destino_id')->nullable();
            $table->string('nota')->nullable();
            $table->string('cliente')->nullable();
            $table->string('destino')->nullable();
            $table->unsignedBigInteger('encargado_id');
            $table->unsignedBigInteger('empresa_id');
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign('empaque_id')->references('id')->on('empaque');
            $table->foreign('ubicacion_origen_id')->references('id')->on('almacen');
            $table->foreign(columns: 'ubicacion_destino_id')->references('id')->on('almacen');
            $table->foreign(columns: 'encargado_id')->references('id')->on('trabajador');
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
        Schema::dropIfExists('movimiento');
    }
};
