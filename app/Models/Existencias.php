<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Existencias extends Model
{
    protected $table = 'v_existencias';

    public function producto(){
    	return $this->belongsTo('App\Models\Productos','productos_id','id');
    }
}
