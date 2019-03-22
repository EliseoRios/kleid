<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class FormatosController extends Controller
{
	public function index()
	{
		return view('formatos.index');
	}

    public function venta_libre()
    {
    	$pdf = PDF::loadView('formatos.venta_libre')->setPaper('a4');
    	return $pdf->inline('venta_libre.pdf');
    }
}
