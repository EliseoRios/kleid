<?php

use Illuminate\Database\Seeder;

class ParametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(!DB::table('parametros')->count() > 0){
    		
    		DB::table('parametros')->insert([
    			'id' => 1,
    		    'usuarios_id'       => 1,
    		    'identificador'  => 'iva',
    		    'nombre'         => 'I.V.A.',
    		    'valor'       => '16',
    		    'created_at' =>  date('Y-m-d H:i:s'),
    		    'updated_at' =>  date('Y-m-d H:i:s')
    		]);

    		DB::table('parametros')->insert([
    			'id' => 2,
    		    'usuarios_id'       => 1,
    		    'identificador'  => 'comision',
    		    'nombre'         => 'Comisión',
    		    'valor'       => '30',
    		    'created_at' =>  date('Y-m-d H:i:s'),
    		    'updated_at' =>  date('Y-m-d H:i:s')
    		]);

    	}
        
    }
}
