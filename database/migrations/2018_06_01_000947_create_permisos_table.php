<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permisos')) {
            Schema::create('permisos', function (Blueprint $table) {
                 $table->bigIncrements('id');

                 $table->integer('usuarios_id');
                 $table->string('elemento',64);
                 $table->integer('elemento_id');
                 $table->integer('permiso');
                 
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
        Schema::dropIfExists('permisos');
    }
}
