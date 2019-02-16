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
    	return $this->belongsTo('App\Models\Usuarios','cliente_usuarios_id','id');
    }

    public function ticket(){
    	return $this->belongsTo('App\Models\Tickets','tickets_id','id');
    }

    public function abonos(){
        return $this->hasMany('App\Models\Abonos','usuarios_id','id');
    }

    public function scopeActivas($query){
        return $query->where('estatus','<>',0);
    }

    public function scopeAbonos($query){
        return $query->where('tipo_venta','abono');
    }

    public function scopeVentas($query){
        return $query->where('tipo_venta','venta');
    }

    public function scopeLiquidadas($query){
        return $query->where('liquidado',1);
    }

    public function scopeSinLiquidar($query){
        return $query->where('liquidado',0);
    }

    public function scopeComisionAdeuda($query){
        return $query->where('comision_pagada',0);
    }

    public function scopeComisionPagada($query){
        return $query->where('comision_pagada',1);
    }
}
