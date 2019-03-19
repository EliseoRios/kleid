<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', function () {
	return redirect('/');
});

Auth::routes();

Route::get('imagen/{id}', 'ImagenesController@imagen');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index');

	//Surtidos
	Route::group(['prefix'=>'surtidos'], function(){

		Route::get('/','SurtidosController@index');
		Route::get('datatables','SurtidosController@datatables');
		Route::get('dtproductos/{fecha?}','SurtidosController@dtproductos');
		Route::get('editar/{fecha?}','SurtidosController@editar');
		Route::get('eliminar/{id}','SurtidosController@eliminar');

		Route::post('guardar','SurtidosController@guardar');
		Route::post('actualizar','SurtidosController@actualizar');
		Route::post('update_permisos','SurtidosController@update_permisos');      

	});

	//Clientes
	Route::group(['prefix'=>'clientes'], function(){

		Route::get('/','ClientesController@index');
		Route::get('datatables','ClientesController@datatables');
		Route::get('crear','ClientesController@crear');
		Route::get('editar/{id}','ClientesController@editar');
		Route::get('eliminar/{id}','ClientesController@eliminar');

		Route::post('guardar','ClientesController@guardar');
		Route::post('actualizar','ClientesController@actualizar');    

	});

	//Categorias
	Route::group(['prefix'=>'categorias'], function(){

		Route::get('/','CategoriasController@index');
		Route::get('datatables','CategoriasController@datatables');
		Route::get('crear','CategoriasController@crear');
		Route::get('editar/{id}','CategoriasController@editar');
		Route::get('eliminar/{id}','CategoriasController@eliminar');

		Route::post('guardar','CategoriasController@guardar');
		Route::post('actualizar','CategoriasController@actualizar');    

	});

	//Caja
	Route::group(['prefix'=>'caja'], function(){

		Route::get('{hash_ticket?}','CajaController@index');

		Route::group(['prefix'=>'ticket'], function(){

			Route::get('generar','CajaController@generar');
			Route::get('imprimir/{ticket}','CajaController@imprimir');
			Route::get('eliminar','CajaController@eliminar');

			Route::post('agregar','CajaController@agregar');
			Route::post('completar','CajaController@completar');    

		});

	});

	//Usuarios
	Route::group(['prefix'=>'usuarios'], function(){

		Route::get('/','UsuariosController@index');
		Route::get('datatables','UsuariosController@datatables');
		Route::get('editar/{id}','UsuariosController@editar');
		Route::get('eliminar/{id}','UsuariosController@eliminar');

		Route::post('guardar','UsuariosController@guardar');
		Route::post('actualizar','UsuariosController@actualizar');
		Route::post('update_permisos','UsuariosController@update_permisos');      

	});

	//Sistema de apartado
	Route::group(['prefix'=>'sistema_apartado'], function(){

		Route::get('/','ApartadoController@index');

		Route::get('datatables','ApartadoController@datatables');

		Route::get('cliente/{hash_id}','ApartadoController@cliente');
		Route::get('productos/{clientes_id}','ApartadoController@productos');		
		Route::get('ventas/{clientes_id}','ApartadoController@ventas');
		Route::get('abonos/{clientes_id}','ApartadoController@abonos');

		Route::get('apartado_frm/{clientes_id}/{productos_id}','ApartadoController@apartado_frm');

		Route::get('editar/{id}','ApartadoController@editar');
		Route::get('eliminar/{id}','ApartadoController@eliminar');
		Route::get('liquidar/{id}','ApartadoController@liquidar');
		Route::get('entregar/{id}','ApartadoController@entregar');
		Route::get('saldar_comision/{id}','ApartadoController@saldar_comision');

		Route::post('guardar','ApartadoController@guardar');
		Route::post('actualizar','ApartadoController@actualizar');
		Route::post('apartar','ApartadoController@apartar');
		Route::post('agregar_abono','ApartadoController@agregar_abono');    

	});

	//Productos
	Route::group(['prefix'=>'productos'], function(){

		Route::get('/','ProductosController@index');
		Route::get('datatables','ProductosController@datatables');
		Route::get('dtdisponibles','ProductosController@dtdisponibles');
		Route::get('dtdetalles', 'ProductosController@dtdetalles');
		Route::get('editar/{id}','ProductosController@editar');
		Route::get('eliminar/{id}','ProductosController@eliminar');
		Route::get('del_detalle/{id}','ProductosController@del_detalle');
		Route::get('existencia/{id}','ProductosController@existencia');

		Route::post('guardar','ProductosController@guardar');
		Route::post('add_detalle','ProductosController@add_detalle');
		Route::post('actualizar','ProductosController@actualizar');
		Route::post('update_permisos','ProductosController@update_permisos');      
	     
	});

	//Configuracion/Parametros
	Route::group(['prefix'=>'parametros'], function(){

		Route::get('/', 'ParametrosController@index');
		Route::get('datatables', 'ParametrosController@datatables');		
		Route::get('crear', 'ParametrosController@crear');
		Route::get('ver/{id}', 'ParametrosController@ver');
		Route::get('editar/{id}', 'ParametrosController@editar');
		Route::get('eliminar/{id}', 'ParametrosController@eliminar');

		Route::get('obtener/{id}', 'ParametrosController@obtener');

		Route::post('guardar','ParametrosController@guardar');
		Route::post('actualizar','ParametrosController@actualizar');

	});

	//Clientes
	/*Route::group(['prefix'=>'clientes'], function(){

		Route::get('/', 'ClientesController@index');
		Route::get('datatables', 'ClientesController@datatables');
		Route::get('crear', 'ClientesController@crear');
		Route::get('ver/{hash_id}', 'ClientesController@ver');
		Route::get('editar/{hash_id}', 'ClientesController@editar');
		Route::get('eliminar/{hash_id}', 'ClientesController@eliminar');
		Route::get('abrir/{id}','ClientesController@abrir');
		Route::get('contactos/{id}','ClientesController@contactos');
		Route::get('oportunidades/{id}','ClientesController@oportunidades');
		
		Route::post('guardar', 'ClientesController@guardar');
		Route::post('actualizar', 'ClientesController@actualizar');
		Route::post('cerrar','ClientesController@cerrar');

	});*/

	//Correos
	/*Route::group(['prefix'=>'correos'], function(){

		Route::get('/', 'CorreosController@index');
		Route::get('datatable', 'CorreosController@datatable');
		Route::get('crear', 'CorreosController@crear');			
		Route::get('ver/{id}', 'CorreosController@ver');
		Route::get('finalizar/{id}', 'CorreosController@finalizar');

		Route::post('guardar', 'CorreosController@guardar');

	});*/

    //Eventos
	/*Route::group(['prefix' => 'eventos'],function(){

        Route::get('/','EventosController@index');
        Route::get('supervisar','EventosController@supervisar');
        Route::get('datatables','EventosController@datatables');
        Route::get('crear','EventosController@crear');
        Route::get('editar/{id}','EventosController@editar');
        Route::get('eliminar/{id}','EventosController@eliminar');
        Route::get('calendario','EventosController@calendario');
        Route::get('ver/{id}','EventosController@ver');

        Route::post('imprimir','EventosController@imprimir');   

        Route::post('guardar','EventosController@guardar');
        Route::post('actualizar','EventosController@actualizar');
        Route::post('concluir','EventosController@concluir');

    	Route::group(['prefix' => 'notas'],function(){

            Route::get('obtener_notas/{id}','EventosNotasController@obtener_notas');
            //Route::get('eliminar/{id}','EventosNotasController@eliminar');

            Route::post('guardar','EventosNotasController@guardar');
            //Route::post('actualizar','EventosNotasController@actualizar');

        });

    });*/

});