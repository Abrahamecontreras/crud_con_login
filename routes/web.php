<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Routing\RouteGroup;

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
    return view('auth.login');
});

//Route::get('/empleado', function () {
//    return view('empleado.index');
//} );

//Route::get('empleado/create', [EmpleadoController::class, 'create']);

//La siguiente linea reemplaza la funcionalidad de las lineas anteriores
Route::resource('empleado', EmpleadoController::class)->middleware('auth'); //Valida que le usuario este logueado, si no, no muestra la vista

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function () { //cuando el usuario se logue

    Route::get('/', [EmpleadoController::class, 'index'])->name('home'); //entra en empleados index
});
