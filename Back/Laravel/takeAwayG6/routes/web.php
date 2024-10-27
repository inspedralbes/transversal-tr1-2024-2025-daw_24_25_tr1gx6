<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get.productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');

Route::get('/sceenProductos',[ProductoController::class, 'getScreenProducto'])->name('screen.productos');
Route::get('/getCategory',[CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas',[MarcaController::class, 'getMarcas'])->name('get.marcas');

// Route::prefix('/productos')->group(callback: function () {

// });

//Route::post('/createProduct', [ProductoController::class, 'createProducto'])->name('create.product');
