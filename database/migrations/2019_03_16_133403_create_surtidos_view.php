<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurtidosView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('v_surtidos')) {
            $sql = "CREATE VIEW v_surtidos AS
                    SELECT DATE(created_at) as fecha, 
                        SUM(piezas) as piezas, SUM(costo_total) as costo, 
                        SUM(comision_total) as comision, 
                        SUM(ganancia_total) as ganancia, 
                        SUM(venta_total) as venta 
                    FROM `productos_detalles` 
                    WHERE estatus=1 
                    GROUP BY fecha;";

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
        if (Schema::hasTable('v_surtidos')) {
            $sql = "DROP VIEW IF EXISTS `v_surtidos`;";
            DB::statement($sql);
        }
    }
}
