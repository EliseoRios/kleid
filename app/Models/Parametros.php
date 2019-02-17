<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    protected $table = "parametros";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }
    
    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }

    public static function identificador($identificador)
    {
    	$valor = '';
    	$parametro = Parametros::where('identificador','comision')->first();

    	if(isset($parametro))
    		$valor = $parametro->valor;

    	return $valor;
    }
}
