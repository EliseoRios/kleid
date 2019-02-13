<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('departamentos')) {
            Schema::create('departamentos', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('usuarios_id')->default(0);

                $table->string('nombre')->nullable();
                $table->text('descripcion')->nullable();

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
        Schema::dropIfExists('departamentos');
    }
}
