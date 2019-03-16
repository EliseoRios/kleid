<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('prestamos')) {
            Schema::create('prestamos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('cliente_usuarios_id')->default(0);

                $table->bigInteger('productos_id')->default(0);
                $table->integer('piezas')->default(0);

                $table->date('fecha_prestamo')->nullable();
                $table->date('fecha_concluyo')->nullable();
                $table->integer('duracion_dias')->default(0);

                $table->boolean('concluido')->default(0);
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
        Schema::dropIfExists('prestamos');
    }
}
