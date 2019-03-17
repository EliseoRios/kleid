<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Abonos;
use App\Models\Productos;
use App\Models\Usuarios;
use App\Models\Ventas;
use App\Models\Existencias;

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
        if (Auth::user()->permiso(['menu',4002]) < 1)
            return redirect()->back();

        return view('apartado.index');      
    }

    public function datatables() {

        $datos = Usuarios::activos()->where(function($query){
            $query->where('perfiles_id',3)->orWhere('permiso_comprar',1);
        })->get();

        return Datatables::of($datos)
        ->editcolumn('id',function ($usuario) {

            $opciones = '';

            if (Auth::user()->permiso(array('menu',4002)) === 2 ) {

                $opciones .= '<a href="'.url('sistema_apartado/cliente/'.Hashids::encode($usuario->id)).'" class="btn btn-xs btn-primary" title="Control de apartados" style="color: white; margin: 3px;"><i class="fas fa-shopping-basket"></i> </a>';      

            } 

            return $opciones;

        })
        ->addColumn('adeudo',function($usuario){
            return 0;//$usuario->adeudo;
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

    public function cliente($hash_id)
    {
        if (Auth::user()->permiso(['menu',4002]) < 2)
            return redirect()->back();

    	$id = Hashids::decode($hash_id);    	        

    	if ($id[0] == null)
    	    return redirect()->back();

    	$cliente = Usuarios::find($id[0]);
    	$ventas_sin_liquidar = $cliente->compras()->sinLiquidar()->activas()->get();
    	//$ventas_liquidadas = $cliente->compras()->liquidadas()->activas()->get();

        $existencias = Existencias::where('disponibles','>',0)->pluck('productos_id','productos_id')->toArray();
        $productos = Productos::activos()->whereIn('id',$existencias)->select(DB::raw("CONCAT(codigo,' | ',nombre) as nuevo_nombre, id"))->pluck('nuevo_nombre','id');

    	return view('apartado.cliente',compact('cliente','ventas_sin_liquidar','ventas_liquidadas','productos'));
    }

    public function apartar(Request $request)
    {
        if (Auth::user()->permiso(['menu',4002]) < 2)
            return redirect()->back();

        //dd($request->all());    	

    	for ($i=0; $i < (int)$request->piezas; $i++) {
            $venta = new Ventas;

    		$venta->usuarios_id = Auth::user()->id;
    		$venta->cliente_usuarios_id = ($request->clientes_id > 0)?$request->clientes_id:0;
    		$venta->productos_id = ($request->productos_id > 0)?$request->productos_id:0;

    		$producto = Productos::find($venta->productos_id);

    		$venta->tipo_venta = 'abono';
            $venta->pago = ($request->pago > 0)?$request->pago:0;
            $venta->comision = $producto->comision;
            $venta->fecha_plazo = Carbon::now()->addMonth();

            $venta->total_pago = ($request->pago > 0)?$request->pago:0;
            $venta->total_comision = $producto->comision;
            $venta->ganancia = $venta->total_pago - $producto->costo;
            $venta->ganancia_neta = $venta->ganancia - $venta->total_comision;

    		$venta->save();
    	}

    	return redirect()->back();
    }    

    public function abonos($hash_id)
    {
        if (Auth::user()->permiso(['menu',4002]) < 1)
            return redirect()->back();

        $id = Hashids::decode($hash_id);                

        if ($id[0] == null)
            return redirect()->back();

        $cliente = Usuarios::find($id[0]);
        $abonos = $cliente->abonos()->activos()->orderBy('created_at','DESC')->get();

        return view('apartado.abonos',compact('cliente','abonos'));
    }

    public function agregar_abono(Request $request)
    {
        if (Auth::user()->permiso(['menu',4002]) < 2)
            return redirect()->back();

        $abono = new Abonos;

        $cantidad = $request->abono;

        if ($request->formulario !== 'abono') {
            $cantidad = $request->abono*-1;
        }

        $abono->usuarios_id = Auth::user()->id;
        $abono->cliente_usuarios_id = ($request->clientes_id > 0)?$request->clientes_id:0;
        $abono->abono = $cantidad;

        $abono->save();

        return redirect()->back();
    }

    public function eliminar($hash_id)
    {
        $id = Hashids::decode($hash_id);                
        $venta = Ventas::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        if ($venta) { 
            $venta->delete();
        }

        return redirect()->back();
    }

    public function liquidar($hash_id)
    {
        $id = Hashids::decode($hash_id);                
        $venta = Ventas::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        if ($venta) { 
            $venta->liquidado = 1;
            $venta->estatus = 2;
            $venta->save();
        }

        return redirect()->back();
    }

    public function entregar($hash_id)
    {
        $id = Hashids::decode($hash_id);                
        $venta = Ventas::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        if ($venta) { 
            $venta->entregado = 1;
            $venta->save();
        }

        return redirect()->back();
    }

    public function saldar_comision($hash_id)
    {
        $id = Hashids::decode($hash_id);                
        $venta = Ventas::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        if ($venta) { 
            $venta->comision_pagada = 1;
            $venta->save();
        }

        return redirect()->back();
    }


}
