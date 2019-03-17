<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosDetallesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('productos_detalles')) {
            Schema::create('productos_detalles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('productos_id')->default(0);

                $table->bigInteger('piezas')->default(1);

                //Totales aproximados - Precalculados
                $table->decimal('costo_total',19,2)->default(0.00);
                $table->decimal('comision_total',19,2)->default(0.00);
                $table->decimal('ganancia_total',19,2)->default(0.00);
                $table->decimal('venta_total',19,2)->default(0.00);
                $table->decimal('ganancia_vs_comision',19,2)->default(0.00);

                $table->integer('estatus')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('productos_detalles');
    }
}
