<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    protected $table = "imagenes";
    
    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function cliente(){
    	return $this->belongsTo('App\Models\Clientes','clientes_id','id');
    }

    public function marca(){
    	return $this->belongsTo('App\Models\Marcas','marcas_id','id');
    }

    public function correo(){
    	return $this->belongsTo('App\Models\Correos','correos_id','id');
    }
}
