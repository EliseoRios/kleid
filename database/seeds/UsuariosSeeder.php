<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(!DB::table('usuarios')->count() > 0){
            DB::table('usuarios')->insert([
                'id' => 1,
                'nombre' => 'Eliseo Ríos',
                'email' => 'eliseo.root@gmail.com',
                'perfiles_id' => 1,
                'genero' => 'm',
                'password' => Hash::make('123456'),
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_at' =>  date('Y-m-d H:i:s')
            ]);
                    
    		DB::table('usuarios')->insert([
    			'id' => 2,
    			'nombre' => 'Roox',
    			'email' => 'Rooxzavala@outlook.com',
                'perfiles_id' => 1,
                'genero' => 'f',
    			'password' => Hash::make('123456'),
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_at' =>  date('Y-m-d H:i:s')
    		]);    		
    	}
    }
}
