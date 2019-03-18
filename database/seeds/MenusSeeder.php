<?php

use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();

        // Catálogos 2000
        DB::table('menus')->insert([
            'codigo'       => '2001',
            'dependencia'  => 'Catálogos',
            'area'         => 'Catálogos',
            'opcion'       => 'Clientes',
            'url'          => 'clientes',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        DB::table('menus')->insert([
            'codigo'       => '2002',
            'dependencia'  => 'Catálogos',
            'area'         => 'Catálogos',
            'opcion'       => 'Productos',
            'url'          => 'productos',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        DB::table('menus')->insert([
            'codigo'       => '2003',
            'dependencia'  => 'Catálogos',
            'area'         => 'Catálogos',
            'opcion'       => 'Surtidos',
            'url'          => 'surtidos',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        DB::table('menus')->insert([
            'codigo'       => '2004',
            'dependencia'  => 'Catálogos',
            'area'         => 'Catálogos',
            'opcion'       => 'Categorías',
            'url'          => 'categorias',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        // CRM 3000
        /*DB::table('menus')->insert([
            'codigo'       => '3001',
            'dependencia'  => 'CRM',
            'area'         => 'CRM',
            'opcion'       => 'Correos',
            'url'          => 'correos',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);

        DB::table('menus')->insert([
            'codigo'       => '3002',
            'dependencia'  => 'CRM',
            'area'         => 'CRM',
            'opcion'       => 'Eventos',
            //'url'          => 'eventos',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);

        DB::table('menus')->insert([
            'codigo'       => '3003',
            'dependencia'  => 'CRM',
            'area'         => 'CRM',
            'opcion'       => 'Abonos programados',
            //'url'          => 'abonos_programados',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);*/

        // Ventas
        /*DB::table('menus')->insert([
            'codigo'       => '4001',
            'dependencia'  => 'Ventas',
            'area'         => 'Ventas',
            'opcion'       => 'Caja',
            'url'          => 'caja',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);*/

        DB::table('menus')->insert([
            'codigo'       => '4002',
            'dependencia'  => 'Ventas',
            'area'         => 'Ventas',
            'opcion'       => 'Sistema de apartado',
            'url'          => 'sistema_apartado',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);

        /*DB::table('menus')->insert([
            'codigo'       => '4003',
            'dependencia'  => 'Ventas',
            'area'         => 'Ventas',
            'opcion'       => 'Tickets',
            'url'          => 'tickets',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);*/

        // Configuración 9000
        DB::table('menus')->insert([
            'codigo'       => '9001',
            'dependencia'  => 'Configuración',
            'area'         => 'Configuración',
            'opcion'       => 'Usuarios',
            'url'          => 'usuarios',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);

        DB::table('menus')->insert([
            'codigo'       => '9002',
            'dependencia'  => 'Configuración',
            'area'         => 'Configuración',
            'opcion'       => 'Parametros',
            'url'          => 'parametros',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')        
        ]);
        
    }
}
