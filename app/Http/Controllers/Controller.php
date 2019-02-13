<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Menus;

use View;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $menus;

    public function __construct(){

    	//$this->middleware(function ($request, $next) {

	    	$this->menus = Menus::select('id','codigo','dependencia','area','opcion','url')->OrderBy('codigo')->groupby('area')->get();

	    	View::share ( 'menus', $this->menus );
	    //});
    }
}
