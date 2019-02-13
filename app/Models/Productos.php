<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = "productos";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function material(){
        return $this->belongsTo('App\Models\Materiales','materiales_id','id');
    }

    public function ventas(){
        return $this->hasMany('App\Models\Ventas','productos_id','id');
    }

    public function detalles(){
        return $this->hasMany('App\Models\ProductosDetalles','productos_id','id');
    }

    public function scopeActivos($query)
    {
    	return $query->where('estatus','<>',0);
    }
}
