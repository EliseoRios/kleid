<?php

use Illuminate\Database\Seeder;

use App\Models\Usuarios;
use App\Models\Menus;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('permisos')->truncate();
      
        $usuarios = Usuarios::where('departamentos_id','=',1)->get(); 

        foreach ($usuarios as  $usuario) {
        
            $opciones = Menus::where('estatus','=',1)->select('id','codigo')->get();
                
            foreach ($opciones as $opcion) {     
                   
                $usuario->agregar_permiso(array('menu',$opcion->codigo,2));

           }
        }
    }
}
