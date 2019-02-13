<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correos extends Model
{
    protected $table = "correos";

    public function emisor(){
    	return $this->belongsTo('App\Models\Usuarios', 'usuarios_id','id');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagenes','correos_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }
}
