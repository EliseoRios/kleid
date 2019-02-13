<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codigo')->nullable(0);
                $table->bigInteger('usuarios_id')->default(0);

                $table->string('nombre')->nullable();
                $table->text('descripcion')->nullable();
                
                $table->integer('materiales_id')->nullable();
                $table->integer('genero')->default(0);

                $table->decimal('costo',19,2)->default(0.00);
                $table->decimal('precio',19,2)->default(0.00);
                $table->decimal('ganancia',19,2)->default(0.00);
                $table->decimal('ganancia_final',19,2)->default(0.00);
                $table->decimal('comision_propuesta',19,2)->default(0.00);
                $table->decimal('precio_abono',19,2)->default(0.00);

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
        Schema::dropIfExists('productos');
    }
}
