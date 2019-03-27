<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categorias;

use DB;
use Hashids;
use Datatables;
use Auth;

class CategoriasController extends Controller
{
    public function __construct()
    {
    	parent::__construct();
    }

    public function index(Request $request) {
        if (Auth::user()->permiso(['menu',2004]) < 1)
            return redirect()->back();

        return view('categorias.index');      
    }

    public function datatables() {

        $datos = Categorias::activas()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = '';

            if (Auth::user()->permiso(array('menu',2004)) == 2) {

                $opciones .= '<a href="" class="btn btn-xs btn-primary" title="Editar" style="color: white; margin: 3px;" data-toggle="modal" data-target="#modalNuevo" data-formulario="editar" data-identifier="'.Hashids::encode($registro->id).'"><i class="fa fa-edit"></i> </a>';

                if($registro->productos()->count() <= 0){
                	$opciones .= '<a href="'. url('categorias/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar categoría ?'".')" class="btn btn-xs btn-danger" title="Eliminar" style="color: white; margin: 3px;"><i class="fa fa-trash"></i> </a>';
                }                

            } 

            return $opciones;

        })
        ->escapeColumns([])       
        ->make(TRUE);
    }

    public function crear()
    {
    	return view('categorias.formularios.crear');
    }
    
    public function guardar(Request $request) {

        if (Auth::user()->permiso(['menu',2004]) < 2)
            return redirect()->back();

		$categoria = new Categorias;

		$categoria->categorias_id = ($request->categoria > 0)?$request->categoria:0;
		$categoria->categoria = ($request->categoria != null)?$request->categoria:"";

		$categoria->save();
		return redirect()->back();
        
    }

    public function editar($hash_id){
        
        $id = Hashids::decode($hash_id);
                
        if ($id[0] == null)
            return redirect()->back();

        $categoria = Categorias::find($id[0]);

        return view('categorias.formularios.editar', compact('categoria'));
    }

    public function actualizar(Request $request) {

        if (Auth::user()->permiso(['menu',2004]) < 2)
            return redirect()->back();

        $categoria = Categorias::find($request->id);

        if ($categoria) {

           $categoria->categorias_id = ($request->categoria > 0)?$request->categoria:0;
           $categoria->categoria = ($request->categoria != null)?$request->categoria:"";

           $categoria->save();

        }

        return redirect()->back();
    }	
	
	public function eliminar($hash_id){

        if (Auth::user()->permiso(['menu',2004]) < 2)
            return redirect()->back();
		
		$id = Hashids::decode($hash_id);
                
        $categoria = Categorias::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

		if ($categoria) { 
			$categoria->estatus = 0;

			$categoria->save();
		}

		return redirect()->back();

	}
}
