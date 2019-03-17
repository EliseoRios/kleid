<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $table = 'categorias';

    public function productos()
    {
    	return $this->hasMany('App\Models\Productos','categorias_id','id');
    }

    public function scopeActivas($query)
    {
    	return $query->where('estatus','<>',0);
    }
}
