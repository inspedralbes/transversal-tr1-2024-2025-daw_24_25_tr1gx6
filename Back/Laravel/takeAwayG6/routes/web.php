<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getProductos', [ProductoController::class, 'getProductos'])->name('get-productos');

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
