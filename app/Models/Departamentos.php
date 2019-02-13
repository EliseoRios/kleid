<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $table = "departamentos";

    public function usuarios(){
    	return $this->hasMany('App\Models\Usuarios','departamentos_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }
}
