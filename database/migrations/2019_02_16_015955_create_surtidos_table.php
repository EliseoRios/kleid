<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurtidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('surtidos')) {
            Schema::create('surtidos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuarios_id')->default(0);

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
        Schema::dropIfExists('surtidos');
    }
}
