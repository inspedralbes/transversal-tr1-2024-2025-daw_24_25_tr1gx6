<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;

Route::get('/', function () {
    return view('welcome');
});


// Rutas para CRUD de categorías
Route::get('/crudCategory', [CategoriaController::class, 'getCategory'])->name('get.category');
Route::post('/createCategory', [CategoriaController::class, 'CreateCategory'])->name('create.category');
Route::post('/updateCategory/{id}', [CategoriaController::class, 'UpdateCategory'])->name('update.category');
Route::post('/deleteCategory/{id}', [CategoriaController::class, 'DeleteCategory'])->name('delete.category');

// Otras rutas de usuario (si es necesario)
Route::get('/crudUsers', [UserController::class, 'getUsers'])->name('get.users');
Route::post('/createUser', [UserController::class, 'createUser'])->name('create.user');
Route::post('/updateUser/{id}', [UserController::class, 'updateUser'])->name('update.user');
Route::post('/deleteUser/{id}', [UserController::class, 'deleteUser'])->name('delete.user');

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get.productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');

Route::get('/sceenProductos',[ProductoController::class, 'getScreenProducto'])->name('screen.productos');
Route::get('/getCategory',[CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas',[MarcaController::class, 'getMarcas'])->name('get.marcas');

// Route::prefix('/productos')->group(callback: function () {

// });

//Route::post('/createProduct', [ProductoController::class, 'createProducto'])->name('create.product');
