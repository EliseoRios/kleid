<?php

use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->truncate();

        DB::table('departamentos')->insert([
        	'id' => 1,
            'usuarios_id'       => '1',
            'nombre'  => 'Administración',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        DB::table('departamentos')->insert([
        	'id' => 2,
            'usuarios_id'       => '1',
            'nombre'  => 'Ventas',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        DB::table('departamentos')->insert([
        	'id' => 3,
            'usuarios_id'       => '1',
            'nombre'  => 'Compras',
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

    }
}
