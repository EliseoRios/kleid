<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Abonos;
use App\Models\Productos;
use App\Models\Usuarios;

use DB;
use Html;
use Hashids;
use Validator;
use Hash;
use App\Http\Requests;
use Datatables;
use Auth;

class ApartadoController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request) {
        return view('apartado.index');      
    }
}
