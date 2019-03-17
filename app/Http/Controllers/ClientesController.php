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

class ClientesController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        if (Auth::user()->permiso(['menu',2001]) < 1)
            return redirect()->back();

        return view('clientes.index');      
    }

    public function datatables() {

        $datos = Usuarios::activos()->sonClientes()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($usuario) {

            $opciones = '';

            if (Auth::user()->permiso(array('menu',2001)) === 2) {

                $opciones .= '<a href="" class="btn btn-xs btn-primary" title="Editar" style="color: white; margin: 3px;" data-toggle="modal" data-target="#modalNuevo" data-formulario="editar" data-identifier="'.Hashids::encode($usuario->id).'"><i class="fa fa-edit"></i> </a>';

                if($usuario->ventas()->count() <= 0 && $usuario->compras()->count() <= 0){
                	$opciones .= '<a href="'. url('clientes/clientes/'.  Hashids::encode($usuario->id) ) .'"  onclick="return confirm('."' Eliminar cliente ?'".')" class="btn btn-xs btn-danger" title="Eliminar" style="color: white; margin: 3px;"><i class="fa fa-trash"></i> </a>';
                }                

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

    public function crear()
    {
    	return view('clientes.formularios.crear');
    }
    
    public function guardar(Request $request) {

        if (Auth::user()->permiso(['menu',2001]) < 2)
            return redirect()->back();

        $error = Validator::make($request->all(),['nombre' => 'required|max:255',
            'email' => 'required|email|max:255|unique:usuarios']);

        if ($error->fails()) {           
          return redirect()->back()->withErrors($error)->withInput();
        }

		$usuario = new Usuarios ;

		$usuario->nombre    = $request->nombre;
		$usuario->email     = $request->email;
		$usuario->password  = Hash::make($request->password);

		$usuario->perfiles_id = 3;//Cliente por defecto

		$usuario->save();
		return redirect()->back();
        
    }

    public function editar($hash_id){
        
        $id = Hashids::decode($hash_id);
                
        if ($id[0] == null)
            return redirect()->back();

        $cliente = Usuarios::find($id[0]);

        return view('clientes.formularios.editar', compact('cliente'));
    }

    public function actualizar(Request $request) {

        if (Auth::user()->permiso(['menu',2001]) < 2)
            return redirect()->back();

        $usuario = Usuarios::find($request->id);

        if ($usuario) {

            $usuario->nombre = ($request->nombre != null)?$request->nombre:"";
            $usuario->email = ($request->email != null)?$request->email:"";
            $usuario->genero = ($request->genero != null)?$request->genero:"";

            if ($request->password != "")
                $usuario->password = Hash::make($request->password);
            
            $usuario->save();

        }

        return redirect()->back();
    }	
	
	public function eliminar($hash_id){

        if (Auth::user()->permiso(['menu',2001]) < 2)
            return redirect()->back();
		
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

}
