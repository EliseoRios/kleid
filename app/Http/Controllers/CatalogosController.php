<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;

class CatalogosController extends Controller
{
    public function modal_producto($producto_id)
    {
    	$producto = Productos::find($producto_id);
    	$imagenes = $producto->imagenes()->get();

    	return view('catalogos.modal_product',compact('producto','imagenes'));
    }
}
