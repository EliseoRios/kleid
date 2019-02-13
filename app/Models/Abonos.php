<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonos extends Model
{
    protected $table = "abonos";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario','usuarios_id','id');
    }

    public function venta(){
    	return $this->belongsTo('App\Models\Ventas','ventas_id','id');
    }

    public function cliente(){
    	return $this->belongsTo('App\Models\Clientes','clientes_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }
}
