<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Existencias;

class Productos extends Model
{
    protected $table = "productos";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function existencia(){
        return $this->hasOne('App\Models\Existencias','productos_id','id');
    }

    public function ventas(){
        return $this->hasMany('App\Models\Ventas','productos_id','id');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagenes','productos_id','id');
    }

    public function detalles(){
        return $this->hasMany('App\Models\ProductosDetalles','productos_id','id');
    }

    public function scopeActivos($query)
    {
    	return $query->where('estatus','<>',0);
    }

    public function scopeDisponibles($query)
    {
        $existencias = Existencias::where('disponibles','>',0)->pluck('productos_id','productos_id')->toArray();
        return $query->whereIn('id',$existencias);
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
