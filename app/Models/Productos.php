<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = "productos";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function surtido(){
        return $this->belongsTo('App\Models\Surtidos','surtidos_id','id');
    }

    public function ventas(){
        return $this->hasMany('App\Models\Ventas','productos_id','id');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagenes','productos_id','id');
    }

    public function scopeActivos($query)
    {
    	return $query->where('estatus','<>',0);
    }

    public static function lista_tallas()
    {
        return Productos::activos()->groupBy('talla')->pluck('talla','talla')->toArray();
    }

    public static function lista_colores()
    {
        return Productos::activos()->groupBy('color')->pluck('color','color')->toArray();
    }
}
