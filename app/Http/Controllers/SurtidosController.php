<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Surtidos;
use App\Models\Productos;

use Auth;
use Hashids;
use Datatables;

class SurtidosController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        return view('surtidos.index');      
    }

    public function datatables() {

        $datos = Surtidos::where('estatus','=',1)->with('usuario')->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = '<div class="btn-group">';

            if (Auth::user()->permiso(array('menu',2003)) == 2 ) {

                $opciones .= '<a href="'. url('surtidos/editar/'.  Hashids::encode($registro->id) ) .'" class="btn btn-xs btn-primary" title="Consultar"><i class="fa fa-edit"></i> </a>';

                //Mientras no hay productos
                if ($registro->productos()->activos()->count() <= 0) {
                    $opciones .= '<a href="'. url('surtidos/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar ?'".')" class="btn btn-xs btn-danger" title="Eliminar"><i class="fa fa-trash"></i> </a>';
                }

            } 
            $opciones .= "</div>";

            return $opciones;

        })
        ->editcolumn('created_at',function ($registro){
        	return date('d/m/Y', strtotime($registro->created_at));
        })
        ->editcolumn('costo',function ($registro){
            return $registro->costo;
        })
        ->editcolumn('venta',function ($registro){
            return $registro->venta;
        })
        ->editcolumn('comision',function ($registro){
            return $registro->comision;
        })
        ->editcolumn('ganancia',function ($registro){
            return $registro->ganancia;
        })
        ->escapeColumns([])       
        ->make(TRUE);
    }
    
    public function guardar(Request $request) {

         $surtido = new Surtidos ;
         $surtido->usuarios_id = Auth::user()->id;               
         $surtido->save();

         return redirect('surtidos/editar/'.Hashids::encode($surtido->id));
        
    }

    public function editar($hash_id){
        
        $id = Hashids::decode($hash_id);                
        $surtido = Surtidos::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        $productos = $surtido->productos()->activos()->get();
        $generos = config('sistema.generos');

        $tallas  = Productos::lista_tallas();
        $colores = Productos::lista_colores();

        return view('surtidos.editar',compact('surtido','productos','generos','tallas','colores'));
    }
	
	public function eliminar($hash_id){		
		$id = Hashids::decode($hash_id);                
        $surtido = Surtidos::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

		if ($surtido) { 
			$surtido->estatus = 0;
			$surtido->save();

			$surtido->productos()->update(['estatus'=>0]);
		}

		return redirect()->back();
	}	
}
