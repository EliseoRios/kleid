<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('perfiles_id')->default(0);
                $table->bigInteger('ultimocorreo_id');
                $table->bigInteger('usuarios_id')->default(0);
                
                $table->string('nombre');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('telefonos')->nullable();

                //Para cliente
                $table->string('genero')->default('f');            
                $table->text('domicilio')->nullable();
                $table->text('observaciones')->nullable();

                $table->boolean('frecuente')->default(0);
                $table->boolean('recibe_publicidad')->default(0);
                $table->boolean('permiso_comprar')->default(0);
                
                $table->integer('estatus')->default(1);
                $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
