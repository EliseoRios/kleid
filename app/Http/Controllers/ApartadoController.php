<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Abonos;
use App\Models\Productos;
use App\Models\Usuarios;
use App\Models\Ventas;

use DB;
use Html;
use Hashids;
use Validator;
use Hash;
use App\Http\Requests;
use Datatables;
use Auth;
use Carbon\Carbon;

class ApartadoController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        return view('apartado.index');      
    }

    public function cliente($hash_id)
    {
    	$id = Hashids::decode($hash_id);    	        

    	if ($id[0] == null)
    	    return redirect()->back();

    	$cliente = Usuarios::find($id[0]);
    	$ventas_sin_liquidar = $cliente->compras()->sinLiquidar()->activas()->get();
    	$ventas_liquidadas = $cliente->compras()->liquidadas()->activas()->get();

    	return view('apartado.cliente',compact('cliente','ventas_sin_liquidar','ventas_liquidadas'));
    }

    public function productos($hash_id)
    {
    	$id = Hashids::decode($hash_id);    	        

    	if ($id[0] == null)
    	    return redirect()->back();

    	$cliente = Usuarios::find($id[0]);

    	return view('apartado.productos_disponibles',compact('cliente'));
    }

    public function apartado_frm($hash_clientes_id,$hash_productos_id){
	    $id = Hashids::decode($hash_productos_id);     
	    $clientes_id = Hashids::decode($hash_clientes_id);

	    if ($id[0] == null)
	        dd('Producto no encontrado');

        $producto = Productos::find($id[0]);
        $cliente = Usuarios::find($clientes_id[0]);
        $pagos = [
        	$producto->precio => $producto->precio,
        	$producto->precio_minimo => $producto->precio_minimo
        ];

        return view('apartado.formularios.apartar',compact('producto','cliente','pagos'));
    }

    public function apartar(Request $request)
    {
    	$venta = new Ventas;

    	for ($i=0; $i < $request->piezas; $i++) { 
    		$venta->usuarios_id = Auth::user()->id;
    		$venta->cliente_usuarios_id = ($request->clientes_id > 0)?$request->clientes_id:0;
    		$venta->productos_id = ($request->productos_id > 0)?$request->productos_id:0;

    		$producto = Productos::find($venta->productos_id);

    		$venta->tipo_venta = 'abono';
    		$venta->pago = ($request->pago > 0)?$request->pago:0;
    		$venta->comision = $producto->comision;
    		$venta->fecha_plazo = Carbon::now()->addMonth();

    		$venta->save();
    	}

    	return redirect()->back();
    }

    public function agregar_abono(Request $request)
    {
    	$venta = new Ventas;

    	$venta->usuarios_id = Auth::user()->id;
    	$venta->cliente_usuarios_id = ($request->clientes_id > 0)?$request->clientes_id:0;
    	$venta->productos_id = ($request->productos_id > 0)?$request->productos_id:0;

    	$producto = Productos::find($venta->productos_id);

    	$venta->tipo_venta = 'abono';
    	$venta->pago = ($request->pago > 0)?$request->pago:0;
    	$venta->comision = $producto->comision;
    	$venta->fecha_plazo = Carbon::now()->addMonth();

    	$venta->save();

    	return view('apartado.cliente',compact('cliente'));
    }


}
