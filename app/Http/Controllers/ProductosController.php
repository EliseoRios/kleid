<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;
use App\Models\ProductosDetalles;
use App\Models\Materiales;
use App\Models\Parametros;
use App\Models\Usuarios;
use App\Models\Departamentos;

use Auth;
use Datatables;
use Hashids;

class ProductosController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        return view('productos.index');      
    }

    public function datatables() {

        $datos = Productos::activos()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = "";

            if (Auth::user()->permiso(array('menu',2002)) == 2 ) {

                $opciones = '<a href="'. url('productos/editar/'.  Hashids::encode($registro->id) ) .'" class="btn btn-primary btn-xs " title="Consultar"><i class="material-icons">edit</i> </a>';

                $opciones .= '<a href="'. url('productos/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar producto ?'".')" class="btn btn-danger btn-xs " title="Eliminar">   <i class="material-icons">delete</i> </a>';

            } 

            return $opciones;

        })
        ->editcolumn('materiales_id', function($producto){
            $material = ($producto->material != null)?$producto->material->nombre:"N/D";
            return $material;
        })
        ->editcolumn('genero', function($producto){
            $array_genero = config('sistema.generos');
            $genero = (array_key_exists($producto->genero, $array_genero))?$array_genero[$producto->genero]:"N/D";
            return $genero;
        })
        ->addcolumn('imagen', function($producto){
            /*'<a href="'.url('imagen/'.$imagen->id).'" class="image-popup-no-margins img-responsive">
                            <img src="'.url('imagen/'.$imagen->id).'" title="Ver" style="max-width: 100%;">
                        </a>';*/

            $imagen = '<img src="https://gloimg.zafcdn.com/zaful/pdm-product-pic/Clothing/2017/03/09/goods-first-img/1493334007827612138.png" class="img-thumbnail" alt="Foto" style="width: 80px;">';
            return $imagen;
        })
        ->editcolumn('estatus',function ($usuario){ 

            if ($usuario->estatus ==1)  {
                return "Activo";
            } else {
                return "Eliminado";
            }

        })

        ->escapeColumns([])       
        ->make(TRUE);
    }

    public function dtdetalles() {

        $datos = ProductosDetalles::activos()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = "";

            if (Auth::user()->permiso(array('menu',2002)) == 2 ) {

                $opciones = '<a href="'. url('productos/editar/'.  Hashids::encode($registro->id) ) .'" class="btn btn-primary btn-xs " title="Consultar"><i class="material-icons">edit</i> </a>';

                $opciones .= '<a href="'. url('productos/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar producto ?'".')" class="btn btn-danger btn-xs " title="Eliminar">   <i class="material-icons">delete</i> </a>';

            } 

            return $opciones;

        })
        ->escapeColumns([])       
        ->make(TRUE);
    }
    
    public function guardar(Request $request) {

        //dd($request->all());

        $formulario = $request->formulario;

        switch ($formulario) {
            case 'producto':
                $producto = new Productos;

                $producto->codigo = ($request->codigo)?$request->codigo:"";
                $producto->usuarios_id = Auth::user()->id;
                $producto->nombre = ($request->nombre)?$request->nombre:"";
                $producto->descripcion = ($request->descripcion)?$request->descripcion:"";

                $material = Materiales::find($request->materiales_id);
                if(isset($material)){
                    $producto->materiales_id = ($request->materiales_id)?$request->materiales_id:0;
                }else{
                    $material = new Materiales;
                    $material->nombre = $request->materiales_id;
                    $material->save();

                    $producto->materiales_id = $material->id;
                }

                $producto->genero = ($request->genero)?$request->genero:0;

                $producto->costo = ($request->costo)?(float)$request->costo:0;
                $producto->precio = ($request->precio)?(float)$request->precio:0;

                //Automaticos
                $producto->ganancia = $producto->precio - $producto->costo;

                $parametro_comision = (int)Parametros::where('identificador','comision')->first()->valor;
                $parametro_abono = (int)Parametros::where('identificador','abono')->first()->valor;

                $producto->comision_propuesta = $parametro_comision * $producto->ganancia / 100;
                $producto->precio_abono = ($parametro_abono * $producto->precio / 100) + $producto->precio;
                $producto->ganancia_final = $producto->ganancia - $producto->comision_propuesta;

                $producto->save();
                $producto_id = $request->producto->id;
                break;

            case 'detalle':
                $detalle = new ProductosDetalles;

                $detalle->productos_id = ($request->productos_id)?$request->productos_id:0;
                $detalle->color = ($request->color)?$request->color:"";
                $detalle->talla = ($request->talla)?$request->talla:"";
                $detalle->piezas_disponibles = ($request->piezas_disponibles)?$request->piezas_disponibles:0;
                $detalle->piezas_totales = ($request->piezas_disponibles)?$request->piezas_disponibles:0;
                $detalle->detalles = ($request->detalles)?$request->detalles:"";

                $detalle->save();
                $producto_id = $request->productos_id;
                break;
            
            default:
                # code...
                break;
        }

        return redirect('productos/editar/'.Hashids::encode($producto_id));        
    }

    public function editar($hash_id){        
        $id = Hashids::decode($hash_id);
                
        $producto = Productos::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        return view('productos.editar',compact('producto'));
    }

    public function actualizar(Request $request) {

        $producto = Productos::find($request->id);
        //dd($request->all());

        if ($producto) {

            $producto->codigo = ($request->codigo)?$request->codigo:"";
            $producto->usuarios_id = Auth::user()->id;
            $producto->nombre = ($request->nombre)?$request->nombre:"";
            $producto->descripcion = ($request->descripcion)?$request->descripcion:"";

            $material = Materiales::find($request->materiales_id);
            if(isset($material)){
                $producto->materiales_id = ($request->materiales_id)?$request->materiales_id:0;
            }else{
                $material = new Materiales;
                $material->nombre = $request->materiales_id;
                $material->save();

                $producto->materiales_id = $material->id;
            }

            $producto->genero = ($request->genero)?$request->genero:0;

            $producto->costo = ($request->costo)?(float)$request->costo:0;
            $producto->precio = ($request->precio)?(float)$request->precio:0;

            //Automaticos
            $producto->ganancia = $producto->precio - $producto->costo;

            $parametro_comision = (int)Parametros::where('identificador','comision')->first()->valor;
            $parametro_abono = (int)Parametros::where('identificador','abono')->first()->valor;

            $producto->comision_propuesta = $parametro_comision * $producto->ganancia / 100;
            $producto->precio_abono = ($parametro_abono * $producto->precio / 100) + $producto->precio;
            $producto->ganancia_final = $producto->ganancia - $producto->comision_propuesta;

            $producto->save();
        }

        return redirect()->back();
    }	
	
	public function eliminar($hash_id){
		
		$id = Hashids::decode($hash_id);
                
        $producto = Productos::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

		if ($usuario) { 
			$producto->estatus = 0;
			$usuario->save();
		}

		return redirect()->back();
	}	

}
