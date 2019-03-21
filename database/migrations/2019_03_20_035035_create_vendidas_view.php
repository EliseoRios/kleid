<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendidasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('v_vendidas')) {
            $sql = "
            CREATE VIEW v_vendidas AS
            SELECT productos.id as productos_id, COALESCE(SUM(ventas.piezas),0) as vendidas
            FROM `productos` 
            LEFT JOIN ventas on productos.id = ventas.productos_id
            WHERE 1
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
        if (Schema::hasTable('v_vendidas')) {
            $sql = "DROP VIEW IF EXISTS `v_vendidas`;";
            DB::statement($sql);
        }
    }
}
