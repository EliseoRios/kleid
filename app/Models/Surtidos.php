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

    public function getCostoAttribute()
    {
        return $this->productos()->activos()->sum('costo_total');
    }

    public function getComisionAttribute()
    {
        return $this->productos()->activos()->sum('comision_total');
    }

    public function getGananciaAttribute()
    {
        return $this->productos()->activos()->sum('ganancia_vs_comision');
    }

    public function getVentaAttribute()
    {
        return $this->productos()->activos()->sum('venta_total');
    }
}
