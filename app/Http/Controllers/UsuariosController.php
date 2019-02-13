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
        return view('usuarios.index');      
    }

    public function datatables() {

        $datos = Usuarios::where('estatus','=',1)->select('id','nombre','email','estatus')->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($usuario) {

            $opciones = "";

            if (Auth::user()->permiso(array('menu',9001)) == 2 ) {

                $opciones = '<a href="'. url('usuarios/editar/'.  Hashids::encode($usuario->id) ) .'" class="btn btn-xs btn-primary" title="Consultar"><i class="material-icons">edit</i> </a>';

                $opciones .= '<a href="'. url('usuarios/eliminar/'.  Hashids::encode($usuario->id) ) .'"  onclick="return confirm('."' Eliminar usuario ?'".')" class="btn btn-xs btn-danger" title="Eliminar"><i class="material-icons">delete</i> </a>';

            } 

            return $opciones;

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
               
         $usuario->save();

         return redirect('usuarios/editar/'.Hashids::encode($usuario->id));
        
    }

    public function editar($hash_id){
        
        $id = Hashids::decode($hash_id);
                
        $usuario = Usuarios::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        $opciones = array('0'=>'Sin Permiso','1'=>'Lectura','2'=>'Total');

        //$permiso_supervisor_crm = $usuario->permiso(array('permiso_supervisor_crm','9999'));
        $departamentos = Departamentos::activos()->pluck('nombre','id');

        return view('usuarios.editar',compact('usuario','opciones','permiso_supervisor_crm','permiso_crear_proyectos','permiso_reportes_oportunidades','departamentos'));
    }

    public function actualizar(Request $request) {

        $usuario = Usuarios::find($request->id);
        //dd($request->all());

        if ($usuario) {

            $usuario->nombre = ($request->nombre != null)?$request->nombre:"";
            $usuario->email = ($request->email != null)?$request->email:"";
            $usuario->telefonos = ($request->telefonos != null)?$request->telefonos:"";
            $usuario->departamentos_id = ($request->departamentos_id != null)?$request->departamentos_id:0;
            $usuario->genero = ($request->genero != null)?$request->genero:0;

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
   
