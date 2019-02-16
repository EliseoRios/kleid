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
                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('surtidos_id')->default(0);

                //Identificadores
                $table->string('codigo')->nullable(0);
                $table->string('nombre')->nullable();
                $table->string('descripcion')->nullable();
                
                //Especificaciones
                $table->string('genero')->default('u');
                $table->string('color')->nullable();
                $table->string('talla')->nullable();
                $table->integer('piezas')->default(0);

                //Unitarios
                $table->decimal('costo',19,2)->default(0.00);
                $table->decimal('precio',19,2)->default(0.00);
                $table->decimal('precio_minimo',19,2)->default(0.00);
                $table->decimal('ganancia',19,2)->default(0.00);//costo/precio
                $table->decimal('ganancia_final',19,2)->default(0.00);//ganancia-comision
                $table->decimal('comision',19,2)->default(0.00);

                $table->boolean('ventas_completadas')->default(0);
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
