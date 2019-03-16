<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('imagenes')){
            Schema::create('imagenes', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('usuarios_id')->default(0);
                $table->bigInteger('productos_id')->default(0);
                $table->bigInteger('encargos_id')->default(0);
                $table->bigInteger('correos_id')->default(0);

                $table->string("mime");
                $table->string("extension");
                $table->string("archivo");

                $table->text('comentario')->nullable();  

                $table->timestamps();
             });

             DB::statement("ALTER TABLE imagenes ADD imagen LONGBLOB NULL AFTER `archivo`");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagenes');
    }
}
