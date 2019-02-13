<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('productos_detalles')) {
            Schema::create('productos_detalles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('productos_id')->default(0);

                $table->text('color')->nullable();
                $table->text('talla')->nullable();
                $table->integer('piezas_disponibles')->default(0);
                $table->integer('piezas_totales')->default(0);
                $table->text('detalles')->nullable();

                $table->integer('estatus')->default(1);
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
        Schema::dropIfExists('productos_detalles');
    }
}
