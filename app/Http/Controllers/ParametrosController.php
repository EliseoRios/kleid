<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Parametros;

use Hashids;
use Auth;
use Datatables;

class ParametrosController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        if(Auth::user()->permiso(array('menu',9002)) < 1 )
            return redirect()->back();

        return view('parametros.index');
    }

    public function datatables() {

        $datos = Parametros::activos()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = "";

            if (Auth::user()->permiso(array('menu',9002)) == 2 ) {

                $opciones = '<a class="btn btn-primary btn-xs" title="Editar" data-identifier="'.Hashids::encode($registro->id).'" data-formulario="editar" data-toggle="modal" data-target="#modalParametros" style="margin-right: 4px;"><i class="material-icons">edit</i> </a>';
            }

            /*if (Auth::user()->permiso(array('menu',9002)) == 2) {
                $opciones .= '<a href="'. url('parametros/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar parametro ?'".')" class="btn btn-danger btn-xs " title="eliminar">   <i class="fa fa-trash"></i> </a>';
            }*/

            return $opciones;

        })
        ->editColumn('valor', function($registro){
        	return $registro->valor;
        })
        ->escapeColumns([])       
        ->make(TRUE);
    }

    public function crear(){
        if(Auth::user()->permiso(array('menu',9002)) < 2)
            return redirect()->back();

        return view('parametros.formularios.crear');
    }

    public function guardar(Request $request) {
        if(Auth::user()->permiso(array('menu',9002)) < 2)
            return redirect()->back();

        $parametro = new Parametros;

        $parametro->identificador = ($request->identificador != null)?$request->identificador:"";
        $parametro->nombre   = ($request->nombre != null)?$request->nombre:"";
        $parametro->valor    = ($request->valor != null)?$request->valor:"";
                       
        $parametro->save();

        return redirect()->back();
    }

    public function ver($hash_id){
        if(Auth::user()->permiso(array('menu',9002)) < 2)
            return redirect()->back();
        
        $id = Hashids::decode($hash_id);

        if ($id[0] == null)
            return redirect()->back();
        
        $parametro = Parametros::find($id[0]);

        return view('parametros.ver',compact('parametro'));
    }

    public function editar($hash_id){
        if(Auth::user()->permiso(array('menu',9002)) < 1)
            return redirect()->back();
        
        $id = Hashids::decode($hash_id);

        if ($id[0] == null)
            return redirect()->back();

        $parametro = Parametros::find($id[0]);

        return view('parametros.formularios.editar',compact('parametro'));
    }

    public function actualizar(Request $request) {
        if(Auth::user()->permiso(array('menu',9002)) < 2)
            return redirect()->back();

        $parametro = Parametros::find($request->id);

        if ($parametro) {
            $parametro->identificador = ($request->identificador != null)?$request->identificador:"";
            $parametro->nombre   = ($request->nombre != null)?$request->nombre:"";
            $parametro->valor    = ($request->valor != null)?$request->valor:"";
                   
            $parametro->save();
        }

        return redirect()->back();
    }
	
	public function eliminar($hash_id){
        if(Auth::user()->permiso(array('menu',9002)) < 2)
            return redirect()->back();
		
		$id = Hashids::decode($hash_id);
                
        $parametro = Parametros::find($id[0]);

		if ($parametro) { 
			$parametro->estatus = 0; 
			$parametro->save();
		}

		return redirect()->back();
	}
}
