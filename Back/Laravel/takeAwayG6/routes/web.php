<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getProductos',[ProductoController::class, 'getProductos'])->name('get-productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');
Route::post('/deleteCategory',[CategoriaController::class, 'DeleteCategory'])->name('delete.category');
Route::post('/updateCategory',[CategoriaController::class, 'UpdateCategory'])->name('update.category');
Route::post('/createCategory',[CategoriaController::class, 'CreateCategory'])->name('create.category');
Route::post('/getCategory',[CategoriaController::class, 'getCategory'])->name('get.category');
Route::post('/getUsers',[CategoriaController::class, 'getUsers'])->name('get.users');
Route::post('/createUser',[CategoriaController::class, 'createUser'])->name('create.user');
Route::post('/updateUser',[CategoriaController::class, 'updateUser'])->name('update.user');
Route::post('/deleteUser',[CategoriaController::class, 'deleteUser'])->name('deleteUser');

