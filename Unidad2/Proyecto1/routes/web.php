<?php

use Illuminate\Support\Facades\Route;

//Vista para el controlador empleados
Route::resource('empleados','empleadosController');































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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/productos', function () {
    return view('Listado de productos');
});

Route::post('/productos', function(){
    return view('Almacenando productos (post)');
});

Route::put('/productos/{id}', function($id){
    return view('Actualizando productos: '.$id);
});
//Parametro
Route::get('saludo/{nombre}/{apodo?}',function($nombre,$apodo=null){
    //Poner la primera letra en mayuscula
    $nombre=ucfirst($nombre);
    //Validar si tine un apodo
    if($apodo){
        return "Bienvenido {$nombre}, tu apodo es {$apodo}";
    } else{
        return "Bienvenido {$nombre}";
    }
});

// Metodos para obtencion, guardado y eliminacion de datos:
// get (listado u obtener), post (guardar), put (actualizar), delete
*/