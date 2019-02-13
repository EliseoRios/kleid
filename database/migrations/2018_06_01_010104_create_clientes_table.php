<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('ultimocorreo_id');
                $table->bigInteger('usuarios_id')->default(0);

                $table->integer('codigo')->default(0);
                $table->string('rfc',15)->nullable();

                $table->string('nombre')->nullable();
                $table->string('email')->nullable();
                $table->text('telefonos')->nullable();
                $table->integer('genero')->default(0);            
                $table->text('domicilio')->nullable();
                $table->text('observaciones')->nullable();

                $table->boolean('frecuente')->default(0);
                $table->boolean('recibe_publicidad')->default(0);

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
        Schema::dropIfExists('clientes');
    }
}
