<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('parametros')) {
            Schema::create('parametros', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuarios_id')->default(0);

                $table->string('identificador')->nullable();
                $table->string('nombre')->nullable();

                $table->text('valor')->nullable();

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
        Schema::dropIfExists('parametros');
    }
}
