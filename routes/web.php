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

use App\Http\Middleware\ApiAuthMiddleware;


//RUTAS PARA USER
Route::get('/user','UserController@index');
Route::get('/user/{id}','UserController@show');
Route::post('/user','UserController@register');
Route::post('/user/login','UserController@login');
Route::put('/user/update','UserController@update');
Route::post('/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/user/image/{filename}','UserController@getImage');
Route::put('/userRoleA/{id}','UserController@roleA');
Route::put('/userRoleB/{id}','UserController@roleB');
Route::put('/userRoleO/{id}','UserController@roleO');
Route::put('/userDisable/{id}','UserController@disable');
Route::put('/userHabilitar/{id}','UserController@habilitar');
Route::delete('/user/{id}','UserController@destroy');

//rutas Bodegas
Route::get('/bodegas','BodegaController@index');
Route::get('/bodega/{id}','BodegaController@show');
Route::post('/bodega','BodegaController@store');
Route::put('/bodega/{id}','BodegaController@update');
Route::delete('/bodega/{id}','BodegaController@destroy');

//rutas Autorizado
Route::get('/autorizados','AutorizadoController@index');
Route::get('/autorizado/{id}','AutorizadoController@show');
Route::post('/autorizado','AutorizadoController@store');
Route::put('/autorizado/{id}','AutorizadoController@update');
Route::delete('/autorizado/{id}','AutorizadoController@destroy');

//rutas Compañias
Route::get('/compañias','CompañiaController@index');
Route::get('/compañia/{id}','CompañiaController@show');
Route::post('/compañia','CompañiaController@store');
Route::put('/compañia/{id}','CompañiaController@update');
Route::delete('/compañia/{id}','CompañiaController@destroy');
Route::post('/compania/upload','CompañiaController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/compania/image/{filename}','CompañiaController@getImage');

//rutas malla
Route::get('/mallas','MallaController@index');
Route::get('/malla/{id}','MallaController@show');


//rutas Rol
Route::get('/roles','RolController@index');

//rutas Conductor
Route::get('/conductores','ConductorController@index');
Route::get('/conductor/{id}','ConductorController@show');
Route::post('/conductor','ConductorController@store');
Route::put('/conductor/{id}','ConductorController@update');
Route::delete('/conductor/{id}','ConductorController@destroy');

//rutas Detalle bodega
Route::get('/detallesbodegas','DetalleBodController@index');
Route::get('/detallesbodega/{id}','DetalleBodController@show');
Route::post('/detallesbodega','DetalleBodController@store');
Route::put('/detallesbodega/{id}','DetalleBodController@update');
Route::delete('/detallesbodega/{id}','DetalleBodController@destroy');

//rutas Detalle bomberos
Route::get('/detallesbomberos','DetalleBomController@index');
Route::get('/detallesbombero/{id}','DetalleBomController@show');
Route::post('/detallesbombero','DetalleBomController@store');
Route::put('/detallesbombero/{id}','DetalleBomController@update');
Route::delete('/detallesbombero/{id}','DetalleBomController@destroy');

//rutas Detalle material  mayor
Route::get('/detallesmaterialmayors','DetalleMatController@index');
Route::get('/detallesmaterialmayor/{id}','DetalleMatController@show');
Route::post('/detallesmaterialmayor','DetalleMatController@store');
Route::put('/detallesmaterialmayor/{id}','DetalleMatController@update');
Route::delete('/detallesmaterialmayor/{id}','DetalleMatController@destroy');

//rutas mantenciones
Route::get('/mantenciones','MantencionController@index');
Route::get('/mantencion/{id}','MantencionController@show');
Route::post('/mantencion','MantencionController@store');
Route::put('/mantencion/{id}','MantencionController@update');
Route::delete('/mantencion/{id}','MantencionController@destroy');

//rutas Revision
Route::get('/revisiones','RevisionController@index');
Route::get('/revision/{id}','RevisionController@show');
Route::post('/revision','RevisionController@store');
Route::put('/revision/{id}','RevisionController@update');
Route::delete('/revision/{id}','RevisionController@destroy');

//rutas material mayor
Route::get('/materialmayors','MaterialMayorController@index');
Route::get('/materialmayor/{id}','MaterialMayorController@show');
Route::get('/materialmayor2/{id}','MaterialMayorController@show2');
Route::post('/materialmayor','MaterialMayorController@store');
Route::put('/materialmayor/{id}','MaterialMayorController@update');
Route::delete('/materialmayor/{id}','MaterialMayorController@destroy');
Route::post('/materialmayor/upload','MaterialMayorController@upload');
Route::get('/materialmayor/image/{filename}','MaterialMayorController@getImage');


//rutas material menor
Route::get('/materialmenors','MaterialMenorController@index');
Route::get('/materialmenor/{id}','MaterialMenorController@show');
Route::post('/materialmenor','MaterialMenorController@store');
Route::put('/materialmenor/{id}','MaterialMenorController@update');
Route::delete('/materialmenor/{id}','MaterialMenorController@destroy');


Route::get('/', function () {
    return view('/welcome');
});

Route::get('/hola', function () {
    return "<h1>bienvenido</h1>";
});
//Rutas del controlador de usuario
//Route::get('/api/estudiante','EstudianteController@index');
//Route::post('/api/login','UserController@login');
//Route::put('/api/user/update','UserController@update');
//Route::post('/api/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
//Route::get('/api/user/avatar/{filename}','UserController@getImage');   //retorna la imagen que se entrega por url
