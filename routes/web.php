<?php

use Illuminate\Support\Facades\Route;
use Luecano\NumeroALetras\NumeroALetras;
use App\Mascota;
use App\Propietario;
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

Route::get('/', function () {
    return view('welcome');
});

Route::view('vue','pruebaVue');

// Ruta de tipo clousure
Route::get('prueba',function(){
	return Mascota::all();
});

Route::apiResource('apiMascota','MascotaController');
Route::apiResource('apiEspecie','EspecieController');
Route::apiResource('apiPropietario','PropietarioController');
Route::apiResource('apiProducto','ProductoController');

Route::view('mascotas','mascotas');
Route::view('ventas','ventas');


Route::get('pdf','ReporteController@pdf');


// RUTA PARAMETRIZADAS

Route::get('getRazas/{id_especie}', [
    'as' => 'getRazas',
    'uses' => 'EspecieController@getRazas',
]);

Route::view('productos','productos');

Route::apiResource('apiVenta', 'VentaController');

Route::get('convertir', function(){
	$convertir = new NumeroALetras();
	return $convertir->toMoney(12515.58, 2, 'PESOS', 'CENTAVOS');
});

Route::get('ticket/{folio}',[
			'as'=>'ticket',
			'uses'=>'VentaController@ticket']);

Route::view('graf','grafica');

Route::get('getDatos', 'GraficoController@getDatos');

Route::view('grafvue', 'graficovue');
