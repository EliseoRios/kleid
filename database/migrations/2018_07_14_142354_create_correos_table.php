<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('correos')) {
            Schema::create('correos', function (Blueprint $table) {
                $table->bigIncrements('id');
                
                $table->bigInteger('usuarios_id')->default(0);//Creador correo

                $table->string('asunto')->nullable();
                $table->longText('mensaje')->nullable();

                $table->date('fecha')->nullable();

                $table->boolean('estatus')->default(1);
                $table->boolean('finalizo')->default(0);
                $table->text('recibieron')->nullable();

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
        Schema::dropIfExists('correos');
    }
}
