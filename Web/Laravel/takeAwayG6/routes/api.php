<?php

use App\Http\Controllers\ComandasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get.productos');
Route::get('/getCategory',[CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas',[MarcaController::class, 'getMarcas'])->name('get.marcas');

//RUTA PARA DEVOLVER UN JSON CON LA COMANDA DEL USUARIO FILTRADA
Route::post('/pedidoUser',[ComandasController::class, 'pedidoUser'])->name('pedido.user');
