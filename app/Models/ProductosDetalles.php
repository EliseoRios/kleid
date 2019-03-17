<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductosDetalles extends Model
{
    protected $table = 'productos_detalles';

    public function usuario()
    {
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function producto()
    {
    	return $this->belongsTo('App\Models\Productos','productos_id','id');
    }

    public function scopeActivos($query)
    {
    	return $query->where('estatus','<>',0);
    }
}
