<?php

use Illuminate\Support\Facades\Route;

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
    return view('inicio');
})->name('inicio');
Route::get('/congruencia/fundamental', 'CongruenciaFundamental@formularioCargaCF')->name('formularioCargaCF');
Route::post('/congruencia/fundamental/calcular', 'CongruenciaFundamental@formularioResultados')->name('formularioResultados');