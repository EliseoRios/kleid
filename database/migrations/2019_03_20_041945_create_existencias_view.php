<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistenciasView extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('v_existencias')) {
            $sql = "
            CREATE VIEW v_existencias AS
            SELECT v_compradas.productos_id as productos_id, 
            COALESCE(v_compradas.compradas,0) as compradas, v_vendidas.vendidas as vendidas,
            (COALESCE(v_compradas.compradas,0) - COALESCE(SUM(v_vendidas.vendidas))) as disponibles
            FROM v_compradas 
            LEFT JOIN v_vendidas on v_compradas.productos_id = v_vendidas.productos_id
            WHERE 1
            GROUP BY productos_id";

            /*
            CREATE VIEW v_existencias AS
            SELECT productos.id as productos_id, 
             COALESCE(SUM(productos_detalles.piezas),0) as compradas, 
             COALESCE(SUM(ventas.piezas),0) as vendidas, 
             COALESCE(SUM(productos_detalles.piezas) - COALESCE(SUM(ventas.piezas),0),0) as disponibles,
             COALESCE(SUM(productos_detalles.costo_total),0) as total_compras,
             COALESCE(SUM(ventas.total_pago),0) as total_ventas,
             COALESCE(SUM(ventas.comision),0) as total_comisiones,
             COALESCE(SUM(ventas.ganancia),0) as total_ganancias,
             COALESCE(SUM(ventas.ganancia_neta),0) as total_ganancias_netas
             FROM productos
            LEFT JOIN productos_detalles ON productos.id = productos_detalles.productos_id
            LEFT JOIN ventas ON productos.id = ventas.productos_id         
            WHERE productos.estatus<>0 && (ventas.estatus<>0 or ventas.id IS NULL) && (productos_detalles.estatus<>0 or productos_detalles.id IS NULL)
            GROUP BY productos_id
            */

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
        if (Schema::hasTable('v_existencias')) {
            $sql = "DROP VIEW IF EXISTS `v_existencias`;";
            DB::statement($sql);
        }
    }
}
