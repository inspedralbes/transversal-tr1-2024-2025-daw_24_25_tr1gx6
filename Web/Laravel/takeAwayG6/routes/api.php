<?php

use App\Http\Controllers\ComandasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get.productos');

//RUTA PARA DEVOLVER UN JSON CON LA COMANDA DEL USUARIO FILTRADA
Route::post('/pedidoUser',[ComandasController::class, 'pedidoUser'])->name('pedido.user');
