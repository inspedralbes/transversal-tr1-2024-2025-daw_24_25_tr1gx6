<?php

use App\Http\Controllers\ComandasController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ComandaArticuloController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//GET DE LA TABLAS
Route::get('/getProductos', [ProductoController::class, 'getProductos'])->name('get.productos');
Route::get('/getCategory', [CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas', [MarcaController::class, 'getMarcas'])->name('get.marcas');

//LOGINS
Route::post('/registerUser', [UserController::class, 'registerUser'])->name('register.user');
Route::post('/loginUser', [UserController::class, 'loginUser'])->name('login.user');

//STRIPE
Route::post('/compraStripe',[StripeController::class, 'compra'])->name('compra.stripe');


Route::middleware('auth:sanctum')->group( function () {
    Route::post('/createComanda', [ComandasController::class, 'createComanda'])->name('create.comanda');
    Route::post('/createComandaArt', [ComandaArticuloController::class, 'createComandaArt'])->name('create.comandaArt');
    Route::post('/pedidoUser', [ComandasController::class, 'pedidoUser'])->name('pedido.user');
    Route::post('/productoById', [StockController::class, 'getProducteID'])->name('get.productoID');
});
