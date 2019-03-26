<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;
use App\Models\Parametros;
use App\Models\Usuarios;
use App\Models\Imagenes;
use App\Models\ProductosDetalles;
use App\Models\Categorias;
use App\Models\Existencias;
use App\Models\Ventas;

use Auth;
use Datatables;
use Hashids;
use PDF;

class ProductosController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {

        if (Auth::user()->permiso(['menu',2002]) < 1)
            return redirect()->back();

        $generos = config('sistema.generos');
        $categorias = Categorias::activas()->pluck('categoria','id');

        return view('productos.index', compact('generos','categorias'));
    }

    public function datatables() {

        $datos = Productos::activos()->with('existencia');

        return Datatables::of($datos)
        ->addColumn('opciones',function ($registro) {

            $opciones = '';

            if (Auth::user()->permiso(array('menu',2002)) === 2) {

                $opciones .= '<a href="'. url('productos/editar/'.  Hashids::encode($registro->id) ) .'" class="btn btn-primary btn-xs " title="Consultar" style="width: 30px; margin: 3px;"><i class="fa fa-eye"></i> </a>';

                if($registro->ventas()->count() <= 0 && $registro->detalles()->count() <= 0){
                    $opciones .= '<a href="'. url('productos/eliminar/'.  Hashids::encode($registro->id) ) .'"  onclick="return confirm('."' Eliminar producto ?'".')" class="btn btn-danger btn-xs " title="Eliminar" style="width: 30px; margin: 3px;">   <i class="fa fa-trash"></i> </a>';
                }
            }

            return $opciones;

        })
        ->editcolumn('genero', function($producto){
            $array_genero = config('sistema.generos');
            $genero = (array_key_exists($producto->genero, $array_genero))?$array_genero[$producto->genero]:"N/D";
            return $genero;
        })
        ->addcolumn('imagen', function($producto){
            /*$primer_imagen= $producto->imagenes()->first();
            $imagen_id = (isset($primer_imagen))?$primer_imagen->id:0;*/

            $imagen = '<img src="'.url('imagen/'.'5').'" class="img-thumbnail" alt="Foto" style="width: 80px;">';

            return $imagen;
        })
        ->addcolumn('disponibles', function($producto){
            $cantidad = $producto->existencia->disponibles;
            $disponibles = '<span class="badge badge-pill badge-success">'.$cantidad.'</span>';

            if($cantidad <= 0)
                $disponibles = '<span class="badge badge-pill badge-danger">AGOTADO</span>';

            return $disponibles;
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
    
    public function guardar(Request $request) {

        if (Auth::user()->permiso(['menu',2002]) < 2)
            return redirect()->back();

        //dd($request->all());

        $producto = new Productos;

        $producto->usuarios_id = Auth::user()->id;
        $producto->nombre = ($request->nombre != null)?$request->nombre:"";
        $producto->codigo = ($request->codigo != null)?$request->codigo:"";

        $producto->genero = ($request->genero != null)?$request->genero:"";
        $producto->categorias_id = ($request->categorias_id > 0)?(float)$request->categorias_id:0;

        $producto->costo = ($request->costo > 0)?(float)$request->costo:0;
        $producto->precio = ($request->precio > 0)?(float)$request->precio:0;
        $producto->precio_minimo = ($request->precio_minimo > 0)?(float)$request->precio_minimo:0;

        //Automaticos (Ganancia minima)
        $producto->ganancia = $producto->precio_minimo - $producto->costo;

        $parametro_comision = (int)Parametros::identificador('comision');

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

        //Crear primer surtido
        $detalle = new ProductosDetalles;

        $detalle->usuarios_id = Auth::user()->id;
        $detalle->productos_id = $producto->id;
        $detalle->piezas = ($request->piezas > 0)?(int)$request->piezas:0;

        $detalle->costo_total = $producto->costo * $detalle->piezas;
        $detalle->comision_total = $producto->comision * $detalle->piezas;
        $detalle->ganancia_total = $producto->ganancia * $detalle->piezas;
        $detalle->venta_total = $producto->precio_minimo * $detalle->piezas;
        $detalle->ganancia_vs_comision = $detalle->ganancia_total - $detalle->comision_total;

        $detalle->save();

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
                
        if ($id[0] == null)
            return redirect()->back();

        $producto = Productos::find($id[0]);

        $generos = config('sistema.generos');
        $categorias = Categorias::activas()->pluck('categoria','id');

        $imagenes = $producto->imagenes()->get();

        return view('productos.editar',compact('producto','generos','imagenes','categorias'));
    }

    public function actualizar(Request $request) {

        if (Auth::user()->permiso(['menu',2002]) < 2)
            return redirect()->back();

        $producto = Productos::find($request->id);

        if ($producto) {
            $producto->usuarios_id = Auth::user()->id;
            $producto->nombre = ($request->nombre != null)?$request->nombre:"";
            $producto->codigo = ($request->codigo != null)?$request->codigo:"";

            $producto->genero = ($request->genero != null)?$request->genero:"";
            $producto->categorias_id = ($request->categorias_id > 0)?(float)$request->categorias_id:0;

            $producto->costo = ($request->costo > 0)?(float)$request->costo:0;
            $producto->precio = ($request->precio > 0)?(float)$request->precio:0;
            $producto->precio_minimo = ($request->precio_minimo > 0)?(float)$request->precio_minimo:0;

            //Automaticos (Ganancia minima)
            $producto->ganancia = $producto->precio_minimo - $producto->costo;

            $parametro_comision = (int)Parametros::identificador('comision');

            $producto->comision = $parametro_comision * $producto->ganancia / 100;
            $producto->ganancia_final = $producto->ganancia - $producto->comision;

            /*$producto->costo_total = $producto->costo * $producto->piezas;
            $producto->comision_total = $producto->comision * $producto->piezas;
            $producto->ganancia_total = $producto->ganancia * $producto->piezas;
            $producto->venta_total = $producto->precio_minimo * $producto->piezas;
            $producto->ganancia_vs_comision = $producto->ganancia_total - $producto->comision_total;*/

            $producto->save();

            //Subir imagenes
            if ($request->hasFile('imagen1') || $request->hasFile('imagen2') || $request->hasFile('imagen3')) 
            {
                $producto->imagenes()->delete();

                if ($request->hasFile('imagen1'))
                    $this->guardar_imagen($request->file('imagen1'), $producto->id);
                if ($request->hasFile('imagen2'))
                    $this->guardar_imagen($request->file('imagen2'), $producto->id);
                if ($request->hasFile('imagen3'))
                    $this->guardar_imagen($request->file('imagen3'), $producto->id);
            }            
        }

        return redirect()->back();
    }	
	
	public function eliminar($hash_id){
        
        if (Auth::user()->permiso(['menu',2002]) < 2)
            return redirect()->back();
		
		$id = Hashids::decode($hash_id);                
        $producto = Productos::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

		if ($producto) { 
			$producto->estatus = 0;
			$producto->save();
		}

		return redirect()->back();
	}

    public function add_detalle(Request $request)
    {
        //Crear primer surtido
        $detalle = new ProductosDetalles;
        $producto = Productos::find($request->productos_id);

        $detalle->usuarios_id = Auth::user()->id;
        $detalle->productos_id = $producto->id;
        $detalle->piezas = ($request->piezas > 0)?(int)$request->piezas:0;

        $detalle->costo_total = $producto->costo * $detalle->piezas;
        $detalle->comision_total = $producto->comision * $detalle->piezas;
        $detalle->ganancia_total = $producto->ganancia * $detalle->piezas;
        $detalle->venta_total = $producto->precio_minimo * $detalle->piezas;
        $detalle->ganancia_vs_comision = $detalle->ganancia_total - $detalle->comision_total;

        $detalle->save();

        return redirect()->back();
    }

    public function del_detalle($hash_id){
        
        $id = Hashids::decode($hash_id);                
        $detalle = ProductosDetalles::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        if ($detalle) { 
            $detalle->estatus = 0;
            $detalle->save();
        }

        return redirect()->back();
    }

    public function existencia($productos_id)
    {
        $producto = Productos::find($productos_id);
        $existencia = $producto->existencia;
        $precio['max'] = $producto->precio;
        $precio['min'] = $producto->precio_minimo;

        $data['existencia'] = $existencia;
        $data['precio'] = $precio;

        return response()->json($data);
    }

    public function imprimir($formulario)
    {
        $nombre = "archivo.pdf";

        switch ($formulario) {
            case 'disponibles':
                $nombre = 'productos_disponibles';
                $existencias = Existencias::where('disponibles','>',0)->pluck('productos_id','productos_id')->toArray();
                $sum_existencias = Existencias::where('disponibles','>',0)->sum('disponibles');
                $productos = Productos::activos()->whereIn('id',$existencias)->get();
                $pdf = PDF::loadView('productos.pdf.disponibles',compact('productos','sum_existencias'));
                break;

            case 'agotados':
                $nombre = 'productos_agotados';
                $existencias = Existencias::where('disponibles','<=',0)->pluck('productos_id','productos_id')->toArray();
                $sum_agotados = Existencias::where('disponibles','<=',0)->count();
                $productos = Productos::activos()->whereIn('id',$existencias)->get();
                $pdf = PDF::loadView('productos.pdf.agotados',compact('productos','sum_agotados'));
                break;

            case 'vendidos':
                $nombre = 'productos_vendidos';
                $ventas = Ventas::pluck('productos_id','productos_id')->toArray();
                $sum_piezas_vendias = Ventas::sum('piezas');
                $productos = Productos::activos()->whereIn('id',$ventas)->get();
                $pdf = PDF::loadView('productos.pdf.vendidos',compact('productos','sum_piezas_vendias'));
                break;
            
            default:
                dd('Formato no encontrado');
                break;
        }

        $pdf->setOption('margin-top',15);
        $pdf->setOption('margin-bottom',15);
        $pdf->setOption('margin-left',15);
        $pdf->setOption('margin-right',15);
        $pdf->setOption('footer-right', '[page] de [toPage]');

        return $pdf->inline($nombre.'pdf');
    }

}
