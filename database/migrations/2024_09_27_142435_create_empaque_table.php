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
        Schema::create('empaque', function (Blueprint $table) {
            $table->id();
            $table->float('peso')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('estado');
            $table->string('tipo');
            $table->string('numero');
            $table->integer('cantidad_cajas')->nullable();
            $table->text('observacion_estado')->nullable();
            $table->unsignedBigInteger('lista_empaques_id');
            $table->date('fecha_registro');
            $table->unsignedBigInteger('encargado_id');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger( 'ubicacion_almacen_id')->nullable();
            $table->boolean( 'criterio1')->default(false);
            $table->boolean('criterio2')->default(false);
            $table->boolean('criterio3')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign(columns: 'lista_empaques_id')->references('id')->on('lista_empaques');
            $table->foreign(columns: 'encargado_id')->references('id')->on('trabajador');
            $table->foreign(columns: 'ubicacion_almacen_id')->references('id')->on('ubicacion_almacen');
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
        Schema::dropIfExists('pallet');
    }
};
