<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ComandasController;

Route::get('/', function () {
    return view('welcome');
});


// Rutas para CRUD de categorías
Route::get('/crudCategory', [CategoriaController::class, 'getCategory'])->name('get.category');
Route::post('/createCategory', [CategoriaController::class, 'CreateCategory'])->name('create.category');
Route::post('/updateCategory/{id}', [CategoriaController::class, 'UpdateCategory'])->name('update.category');
Route::post('/deleteCategory/{id}', [CategoriaController::class, 'DeleteCategory'])->name('delete.category');

// Otras rutas de usuario (si es necesario)
Route::post('/getUsers', [CategoriaController::class, 'getUsers'])->name('get.users');
Route::post('/createUser', [CategoriaController::class, 'createUser'])->name('create.user');
Route::post('/updateUser', [CategoriaController::class, 'updateUser'])->name('update.user');
Route::post('/deleteUser', [CategoriaController::class, 'deleteUser'])->name('deleteUser');

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get.productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');

Route::get('/sceenProductos',[ProductoController::class, 'getScreenProducto'])->name('screen.productos');
Route::get('/getCategory',[CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas',[MarcaController::class, 'getMarcas'])->name('get.marcas');


//Ruta para CRUD de comandas

// Ruta para mostrar la vista de comandas
Route::get('/comanda', function () {
    return view('comandas.comanda');
});

Route::get('/comanda', [ComandasController::class, 'comanda'])->name('comandas.view');
Route::post('/pedidoUser', [ComandasController::class, 'pedidoUser'])->name('comanda.pedidoUser');
Route::post('/updateEstadoComanda/{id}', [ComandasController::class, 'updateEstadoComanda'])->name('comanda.updateEstado');
Route::post('/deleteComanda/{id}', [ComandasController::class, 'eliminarComanda'])->name('comandas.delete');


// Route::prefix('/productos')->group(callback: function () {

// });

//Route::post('/createProduct', [ProductoController::class, 'createProducto'])->name('create.product');

