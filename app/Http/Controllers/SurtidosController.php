<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;
use App\Models\ProductosDetalles;
use App\Models\Surtidos;

use Auth;
use Hashids;
use Datatables;
use DB;

class SurtidosController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {

        if (Auth::user()->permiso(['menu',2003]) < 1)
            return redirect()->back();

        $productos = Productos::activos()->select(DB::raw("CONCAT(id,' | ',codigo,' | ',nombre) as nuevo_nombre, id"))->pluck('nuevo_nombre','id');

        return view('surtidos.index', compact('productos'));      
    }

    public function datatables() {

        $datos = Surtidos::all();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = '<div class="btn-group">';

            if (Auth::user()->permiso(array('menu',2003)) === 2) {
                $opciones .= '<a href="'. url('surtidos/editar/'.$registro->fecha) .'" class="btn btn-xs btn-primary" title="Consultar"><i class="fas fa-dolly-flatbed"></i> </a>';
            }

            $opciones .= "</div>";

            return $opciones;

        })
        ->addColumn('fecha',function ($registro){
        	return date('d/m/Y', strtotime($registro->fecha));
        })
        ->escapeColumns([])       
        ->make(TRUE);
    }

    public function dtproductos($fecha = null) {

        if ($fecha != null){
            $datos = ProductosDetalles::activos()->whereDate('created_at',$fecha)->with('producto')->get();
        }else{
            $datos = ProductosDetalles::activos()->with('producto')->get();
        }

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = '';

            if (Auth::user()->permiso(array('menu',2003)) === 2) {
                $opciones .= '<a href="'. url('productos/del_detalle/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar registro ?'".')" class="btn btn-danger btn-xs " title="Eliminar" style="width: 30px; margin: 3px; color: white;">   <i class="fa fa-trash"></i> </a>';
            }

            return $opciones;

        })
        ->editcolumn('genero', function($registro){
            $array_genero = config('sistema.generos');
            $genero = (array_key_exists($registro->producto->genero, $array_genero))?$array_genero[$registro->producto->genero]:"N/D";
            return $genero;
        })
        ->addcolumn('imagen', function($registro){
            $primer_imagen= $registro->producto->imagenes()->first();
            $imagen_id = (isset($primer_imagen))?$primer_imagen->id:0;

            $imagen = '<img src="'.url('imagen/'.$imagen_id).'" class="img-thumbnail" alt="Foto" style="width: 80px;">';

            return $imagen;
        })
        ->escapeColumns([])       
        ->make(TRUE);
    }

    public function editar($fecha = null){
        if (Auth::user()->permiso(['menu',2003]) < 1)
            return redirect()->back();

        return view('surtidos.editar',compact('fecha'));
    }
}
