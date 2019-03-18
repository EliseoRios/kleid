<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ventas;
use App\Models\Tickets;

use Hashids;
use Auth;

class CajaController extends Controller
{
    public function index($hash_ticket = null)
    {
    	$ticket = null;
    	$ventas = [];     	

    	if ($hash_ticket !== null) {
    		$id = Hashids::decode($hash_ticket);
    		$ticket = Tickets::find($id[0]);
    		$ventas = $ticket->ventas();
    	}else{
    		if(Auth::user()->tickets()->where('estatus',1)->count() > 0){
    			$ticket = Auth::user()->tickets()->where('estatus',1)->first();
    			$ventas = $ticket->ventas();

    			return redirect('caja/'.Hashids::encode($ticket->id));
    		}
    	}

    	return view('caja.index', compact('ventas'));
    }

    public function generar()
    {
    	$ticket = new Tickets;
    	$ticket->usuarios_id = Auth::user()->id;
    	$ticket->save();

    	return redirect('caja/'.Hashids::encode($ticket->id));
    }
}
