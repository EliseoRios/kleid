<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;
use App\Models\Parametros;
use App\Models\Usuarios;
use App\Models\Imagenes;

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

    public function datatables($surtidos_id = 0) {

        if ($surtidos_id > 0)
            $datos = Productos::activos()->where('surtidos_id',$surtidos_id)->get();
        else
            $datos = Productos::activos()->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($registro) {

            $opciones = '<div class="btn-group">';

            if (Auth::user()->permiso(array('menu',2002)) == 2 ) {

                $opciones .= '<a href="'. url('productos/editar/'.  Hashids::encode($registro->id) ) .'" class="btn btn-primary btn-xs " title="Consultar" style="width: 28px;"><i class="fa fa-edit"></i> </a>';

                if($registro->ventas()->count() <= 0){
                    $opciones .= '<a href="'. url('productos/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar producto ?'".')" class="btn btn-danger btn-xs " title="Eliminar" style="width: 28px;">   <i class="fa fa-trash"></i> </a>';
                }
            } 

            $opciones .= '</div>';

            return $opciones;

        })
        ->editcolumn('genero', function($producto){
            $array_genero = config('sistema.generos');
            $genero = (array_key_exists($producto->genero, $array_genero))?$array_genero[$producto->genero]:"N/D";
            return $genero;
        })
        ->addcolumn('imagen', function($producto){
            $primer_imagen= $producto->imagenes()->first();
            $imagen_id = (isset($primer_imagen))?$primer_imagen->id:0;

            $imagen = '<img src="'.url('imagen/'.$imagen_id).'" class="img-thumbnail" alt="Foto" style="width: 80px;">';

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

    public function crear(){
        if(Auth::user()->permiso(array('menu',9002)) < 2)
            return redirect()->back();

        return view('parametros.formularios.crear');
    }
    
    public function guardar(Request $request) {

        //dd($request->all());

        $producto = new Productos;

        $producto->usuarios_id = Auth::user()->id;
        $producto->surtidos_id = ($request->surtidos_id > 0)?$request->surtidos_id:0;
        $producto->nombre = ($request->nombre != null)?$request->nombre:"";

        $producto->genero = ($request->genero != null)?$request->genero:"";
        $producto->color = ($request->color != null)?$request->color:"";
        $producto->talla = ($request->talla != null)?$request->talla:"";

        $producto->piezas = ($request->piezas > 0)?(int)$request->piezas:0;

        $producto->costo = ($request->costo > 0)?(float)$request->costo:0;
        $producto->precio = ($request->precio > 0)?(float)$request->precio:0;
        $producto->precio_minimo = ($request->precio_minimo > 0)?(float)$request->precio_minimo:0;

        //Automaticos
        $producto->ganancia = $producto->precio - $producto->costo;

        $parametro_comision = (int)Parametros::where('identificador','comision')->first()->valor;

        $producto->comision = $parametro_comision * $producto->ganancia / 100;
        $producto->ganancia_final = $producto->ganancia - $producto->comision;

        $producto->save();

        //Subir imagenes
        if ($request->hasFile('imagen1'))
            $this->guardar_imagen($request->file('imagen1'), $producto->id);
        if ($request->hasFile('imagen2'))
            $this->guardar_imagen($request->file('imagen2'), $producto->id);
        if ($request->hasFile('imagen3'))
            $this->guardar_imagen($request->file('imagen3'), $producto->id);

        return redirect()->back();        
    }

    private function guardar_imagen($request_imagen, $objeto_id){

        //$archivo = $request->file('foto');
        $archivo = $request_imagen;
       
        file_put_contents($archivo->getClientOriginalName(), file_get_contents($archivo->getRealPath()));
             
        $imagen = new Imagenes;

        $imagen->archivo = $archivo->getClientOriginalName();
        $imagen->imagen = file_get_contents($archivo->getClientOriginalName());
        $mime = $archivo->getMimeType();

        switch ($mime) {
            case 'image/jpeg':
                $extension = '.jpg';
                break; 
            case 'image/png':
                $extension = '.png';
                break; 
            case 'image/gif':
                $extension = '.gif';
                break; 
            case 'image/bmp':
                $extension = '.bmp';
                break;                
            default:
                $extension = '';
                break;
        }                                 

        $imagen->mime         = $mime;
        $imagen->extension    = $extension ;
        $imagen->productos_id = $objeto_id;     

        $imagen->save();

        unlink($archivo->getClientOriginalName());
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
