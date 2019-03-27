<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;
use App\Models\Departamentos;
use App\Models\Menus;

use DB;
use Html;
use Hashids;
use Validator;
use Hash;
use App\Http\Requests;
use Datatables;
use Auth;

class UsuariosController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        if(Auth::user()->perfiles_id != 1 || Auth::user()->permiso(['menu',9001]) < 2)
            return redirect()->back();

        return view('usuarios.index');      
    }

    public function datatables() {

        $datos = Usuarios::activos()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($usuario) {

            $opciones = '';

            if (Auth::user()->permiso(array('menu',9001)) == 2 ) {

                $opciones .= '<a href="'. url('usuarios/editar/'.  Hashids::encode($usuario->id) ) .'" class="btn btn-xs btn-primary" title="Consultar" style="color: white; margin: 3px;"><i class="fa fa-edit"></i> </a>';

                if ($usuario->compras()->count() <= 0 && $usuario->ventas()->count() <= 0) {
                    $opciones .= '<a href="'. url('usuarios/eliminar/'.  Hashids::encode($usuario->id) ) .'"  onclick="return confirm('."' Eliminar usuario ?'".')" class="btn btn-xs btn-danger" title="Eliminar" style="color: white; margin: 3px;"><i class="fa fa-trash"></i> </a>';
                }

            } 

            return $opciones;

        })
        ->editcolumn('perfiles_id',function ($usuario){ 
            return config('sistema.perfiles')[$usuario->perfiles_id];
        })
        ->editcolumn('estatus',function ($usuario){ 

            if ($usuario->estatus ==1)  {
                return "Activo";
            } else {
                return "Suspendido";
            }

        })

        ->escapeColumns([])       
        ->make(TRUE);
    }
    
    public function guardar(Request $request) {

        $error = Validator::make($request->all(),['nombre' => 'required|max:255',
            'email' => 'required|email|max:255|unique:usuarios']);

        if ($error->fails()) {           
          return redirect()->back()->withErrors($error)->withInput();
        }

        $usuario = new Usuarios ;

        $usuario->nombre    = $request->nombre;
        $usuario->email     = $request->email;
        $usuario->password  = Hash::make($request->password);

        $usuario->perfiles_id = 2;//Ventas por defecto

        $usuario->save();

        //eturn redirect('usuarios/editar/'.Hashids::encode($usuario->id));
        return redirect()->back();
        
    }

    public function editar($hash_id){
        
        $id = Hashids::decode($hash_id);
                
        $usuario = Usuarios::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        $opciones = array('0'=>'Sin Permiso','1'=>'Lectura','2'=>'Total');

        //$permiso_supervisor_crm = $usuario->permiso(array('permiso_supervisor_crm','9999'));
        $perfiles = config('sistema.perfiles');

        $comision_ventas = $usuario->ventas()->ventas()->comisionAdeuda()->sum('total_comision');
        $comision_abonos = $usuario->ventas()->apartado()->comisionAdeuda()->sum('total_comision');

        return view('usuarios.editar',compact('usuario','opciones','permiso_supervisor_crm','permiso_crear_proyectos','permiso_reportes_oportunidades','perfiles','comision_ventas','comision_abonos'));
    }

    public function actualizar(Request $request) {

        $usuario = Usuarios::find($request->id);
        //dd($request->all());

        if ($usuario) {

            $usuario->nombre = ($request->nombre != null)?$request->nombre:"";
            $usuario->email = ($request->email != null)?$request->email:"";
            $usuario->telefonos = ($request->telefonos != null)?$request->telefonos:"";
            $usuario->genero = ($request->genero != null)?$request->genero:0;
            $usuario->permiso_comprar = ($request->permiso_comprar > 0)?1:0;
            
            if(Auth::user()->permiso(array('menu',9001)) == 2)
                $usuario->perfiles_id = ($request->perfiles_id != null)?$request->perfiles_id:0;

            if ($request->password != "")
                $usuario->password = Hash::make($request->password);
            
            $usuario->save();

        }

        //return redirect('usuarios/editar/'.Hashids::encode($usuario->id));
        return redirect()->back();
    }	
	
	public function eliminar($hash_id){
		
		$id = Hashids::decode($hash_id);
                
        $usuario = Usuarios::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

		if ($usuario) { 
			$usuario->estatus = 0; 
			$usuario->email   = 'x'. $usuario->email;

			$usuario->save();
		}

		return redirect()->back();

	}	

	public function update_permisos(Request $request) {

		$usuario  = Usuarios::find($request->usuario_id);

		$opciones= array();
		$opciones = $request->except('usuario_id','_token');

		$usuario->borrar_permisos();

		foreach($opciones as $codigo => $valor) {
		
			if ($valor != 0 ) {
				$usuario->agregar_permiso(array('menu',$codigo,$valor));
			}

		}

        //Permiso Supervisor de CRM
        /*if ($request->has('permiso_supervisor_crm'))
            $usuario->agregar_permiso(array('permiso_supervisor_crm',9999,$request->permiso_supervisor_crm)); 
        else
            $usuario->agregar_permiso(array('permiso_supervisor_crm',9999,0));*/
        
		$usuario->save();
		
		// return redirect('usuarios/editar/'.Hashids::encode($usuario->id));
		return redirect()->back();
	}

}
   
