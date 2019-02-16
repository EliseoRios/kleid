<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surtidos extends Model
{
    protected $table = "surtidos";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function productos(){
        return $this->hasMany('App\Models\Productos','surtidos_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }

    public function getGastoAttribute()
    {
        return $this->productos()->activos()->sum('costo');
    }
}
