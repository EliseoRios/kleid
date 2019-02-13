<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ventas')) {
            Schema::create('ventas', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('clientes_id')->default(0);
                $table->bigInteger('tickets_id')->default(0);
                $table->bigInteger('productos_id')->default(0);
                $table->bigInteger('productosdetalles_id')->default(0);

                $table->integer('tipo_venta')->default(0);//abono/venta

                $table->double('pago',19,2)->default(0.00);
                $table->double('comision',19,2)->default(0.00);

                $table->date('fecha_inicio')->nullable();
                $table->date('fecha_fin')->nullable();

                $table->boolean('entregado')->default(0);
                $table->boolean('liquidado')->default(0);
                $table->boolean('comision_pagada')->default(0);
                $table->boolean('estatus')->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
