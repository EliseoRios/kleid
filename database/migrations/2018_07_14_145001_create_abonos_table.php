<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('abonos')) {
            Schema::create('abonos', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('ventas_id')->default(0);

                $table->decimal('abono',19,2)->default(0.00);

                $table->date('fecha')->nullable();
                $table->bigInteger('fecha_unix')->default(0);

                $table->boolean('estatus')->default(0);
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
        Schema::dropIfExists('abonos');
    }
}
