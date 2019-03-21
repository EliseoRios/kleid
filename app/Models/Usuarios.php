<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use App\Models\Permisos;
use App\Models\Menus;

use Auth;
//use DB;

class Usuarios extends Authenticatable
{
    protected $table = 'usuarios';

    public function eventos(){
        return $this->hasMany('App\Models\Eventos','usuarios_id','id');
    }

     protected $fillable = [
        'nombre', 'email', 'password',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permiso($datos) {

        if(count($datos) > 1) {

            $registro = Permisos::where('usuarios_id','=',$this->id)->where('elemento','=',$datos[0])->where('elemento_id','=',$datos[1])->first();

            if ($registro){ 
                return $registro->permiso;
            }            
        }

        return 0;
    }

    public function borrar_permisos(){
        $borrar = Permisos::where('usuarios_id','=',$this->id)->delete();

        return 0;
    }

    public function agregar_permiso($datos) {
    
        if (count($datos) < 3){
            return 0 ;
        }
        
        //print_r($datos);
         
       $permiso = new Permisos;

       $permiso->usuarios_id  = $this->id;
       $permiso->elemento     = $datos[0];
       $permiso->elemento_id  = $datos[1];
       $permiso->permiso      = $datos[2];

       $permiso->save();
    }

    public function permiso_area($menu) {
        $permiso = 0;
        $items = Menus::where('area',$menu)->get();

        foreach ($items as $item) {
            if (Auth::user()->permiso(['menu',$item->codigo]))
                $permiso = 1;
        }

        return $permiso;
    }

    public function scopeActivos($query){
        return $query->where('estatus','<>',0);
    }

    public function scopeSonClientes($query){
        return $query->where('perfiles_id',3);
    }

    public static function addw($filtro = 0)
    {          
        $usuarios = Usuarios::active();
        
        if($filtro != 0){
            $usuarios->where('autorizacion',$filtro);
        }

        return  $usuarios->pluck('nombre','id')->toArray();
    }

    public function ventas(){
        return $this->hasMany('App\Models\Ventas','usuarios_id','id');
    }

    public function compras(){
        return $this->hasMany('App\Models\Ventas','cliente_usuarios_id','id');
    }

    public function abonos(){
        return $this->hasMany('App\Models\Abonos','cliente_usuarios_id','id');
    }

    public function tickets(){
        return $this->hasMany('App\Models\Tickets','usuarios_id','id');
    }

    public function productos(){
        return $this->hasMany('App\Models\Productos','usuarios_id','id');
    }

    public function permisos(){
        return $this->hasMany('App\Models\Permisos','usuarios_id','id');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagenes','usuarios_id','id');
    }

    public function correos(){
        return $this->hasMany('App\Models\Correos','usuarios_id','id');
    }

    public function clientes(){
        return $this->hasMany('App\Models\Clientes','usuarios_id','id');
    }

    public function getSumaSinLiquidarAttribute()
    {
        return $this->compras()->activas()->sinLiquidar()->sum('pago');
    }

    public function getSumaLiquidadasAttribute()
    {
        return $this->compras()->activas()->liquidadas()->sum('pago');
    }

    public function getSumaAbonosAttribute()
    {
        return $this->abonos()->activos()->sum('abono');
    }

    public function getAdeudoAttribute()
    {
        return $this->compras()->activas()->sum('pago') - $this->suma_abonos;
    }

    public function getAFavorAttribute()
    {
        return abs($this->suma_liquidadas - $this->suma_abonos);
    }

}
