<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get-productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');