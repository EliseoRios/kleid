<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompradasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('v_compradas')) {
            $sql = "
            CREATE VIEW v_compradas AS
            SELECT productos.id as productos_id, COALESCE(SUM(productos_detalles.piezas),0) as compradas
            FROM `productos` 
            LEFT JOIN productos_detalles on productos.id = productos_detalles.productos_id
            WHERE productos_detalles.estatus<>0
            GROUP BY productos.id";

            DB::statement($sql);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('v_compradas')) {
            $sql = "DROP VIEW IF EXISTS `v_compradas`;";
            DB::statement($sql);
        }
    }
}
