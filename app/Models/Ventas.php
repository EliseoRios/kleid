<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = "ventas";

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuarios','usuarios_id','id');
    }

    public function producto(){
    	return $this->belongsTo('App\Models\Productos','productos_id','id');
    }

    public function cliente(){
    	return $this->belongsTo('App\Models\Clientes','clientes_id','id');
    }

    public function ticket(){
    	return $this->belongsTo('App\Models\Tickets','tickets_id','id');
    }

    public function abonos(){
        return $this->hasMany('App\Models\Abonos','usuarios_id','id');
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }

}
