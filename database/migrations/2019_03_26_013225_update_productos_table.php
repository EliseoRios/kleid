<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('productos', 'imagen_principal_id')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->bigInteger('imagen_principal_id')->default(0)->after('id');
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
        if (Schema::hasColumn('productos', 'imagen_principal_id')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('imagen_principal_id');
            });
        }
    }
}
