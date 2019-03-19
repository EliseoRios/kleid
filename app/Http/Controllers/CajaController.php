<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ventas;
use App\Models\Tickets;
use App\Models\Productos;
use App\Models\Existencias;

use Hashids;
use Auth;
use DB;
use Carbon\Carbon;

class CajaController extends Controller
{
    public function index($hash_ticket = null)
    {
        $ticket = null;
    	$ticket_id = 0;
        $ventas = [];
    	$total = 0;

        $existencias = Existencias::where('disponibles','>',0)->pluck('productos_id','productos_id')->toArray();
        $productos = Productos::activos()->whereIn('id',$existencias)->select(DB::raw("CONCAT(id,' | ',codigo,' | ',nombre) as nuevo_nombre, id"))->pluck('nuevo_nombre','id');

    	if ($hash_ticket !== null) {

    		$id = Hashids::decode($hash_ticket);
            $ticket = Tickets::find($id[0]);
    		$ticket_id = $ticket->id;
    		$ventas = $ticket->ventas()->get();
            $total = $ticket->ventas()->sum('total_pago');

    	}else{

    		if(Auth::user()->tickets()->where('estatus',1)->count() > 0){
    			$ticket = Auth::user()->tickets()->where('estatus',1)->first();

    			return redirect('caja/'.Hashids::encode($ticket->id));
    		}

    	}

    	return view('caja.index', compact('ventas','ticket','productos','total','ticket_id'));
    }

    public function generar()
    {
    	$ticket = new Tickets;
    	$ticket->usuarios_id = Auth::user()->id;
    	$ticket->save();

    	return redirect('caja/'.Hashids::encode($ticket->id));
    }

    public function agregar(Request $request)
    {
        $venta = new Ventas;

        $venta->usuarios_id = Auth::user()->id;
        $venta->productos_id = ($request->productos_id > 0)?$request->productos_id:0;
        $venta->tickets_id = ($request->tickets_id > 0)?$request->tickets_id:0;

        $producto = Productos::find($venta->productos_id);

        $venta->tipo_venta = 'venta';
        $venta->piezas = ($request->piezas > 0)?$request->piezas:1;
        $venta->pago = ($request->pago > 0)?$request->pago:0;
        $venta->comision = $producto->comision;
        $venta->fecha_plazo = Carbon::now()->addMonth();
        $venta->fecha_saldado = date('Y-m-d');

        $venta->entregado = 0;
        $venta->liquidado = 0;

        $venta->total_pago = $venta->pago * $venta->piezas;
        $venta->total_comision = $venta->comision * $venta->piezas;
        $venta->ganancia = $venta->total_pago - ($producto->costo * $venta->piezas);
        $venta->ganancia_neta = $venta->ganancia - $venta->total_comision;

        $venta->save();
        return redirect()->back();
    }

    public function completar(Request $request)
    {
        $ticket = Tickets::find($request->id);

        if (isset($ticket)) {
            $ticket->dinero_recibido = ($request->dinero_recibido > 0)?$request->dinero_recibido:0;
            $ticket->total = ($request->total > 0)?$request->total:0;
            $ticket->cambio = ($request->cambio > 0)?$request->cambio:0;

            $ticket->ventas()->update(['entregado' => 1,'liquidado'=>1]);

            $ticket->estatus = 2;
            $ticket->save();
        }

        return redirect('caja');
    }

    public function eliminar($hash_id)
    {
        $id = Hashids::decode($hash_id);                
        $ticket = Tickets::find($id[0]);

        if ($id[0] == null)
            return redirect()->back();

        if (isset($ticket)) { 
            $ticket->estatus = 0;
            $ticket->save();

            $ticket->ventas()->delete();
        }

        return redirect('caja');
    }
}
