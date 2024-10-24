<?php

use App\Http\Controllers\ComandasController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ComandaArticuloController;
use App\Http\Controllers\AutorizacionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get.productos');
Route::get('/getCategory',[CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas',[MarcaController::class, 'getMarcas'])->name('get.marcas');

//RUTA PARA DEVOLVER UN JSON CON LA COMANDA DEL USUARIO FILTRADA
Route::post('/pedidoUser',[ComandasController::class, 'pedidoUser'])->name('pedido.user');
Route::post('/createComandaArt',[ComandaArticuloController::class, 'createComandaArt'])->name('create.comandaArt');
Route::post('/createComanda',[ComandasController::class, 'createComanda'])->name('create.comanda');

Route::post('/registerUser', [UserController::class, 'createUser'])->name('register.user');
Route::post('/loginUser', [UserController::class, 'loginUser'])->name('login.user');
