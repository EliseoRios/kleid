<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = "clientes";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario','usuarios_id','id');
    }

    public function compras(){
        return $this->hasMany('App\Models\Ventas','clientes_id','id');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagenes','clientes_id','id');
    }

    public function abonos(){
        return $this->hasMany('App\Models\Abonos','clientes_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }
}
