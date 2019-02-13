<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = "tickets";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function ventas(){
        return $this->hasMany('App\Models\Ventas','tickets_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }
}
