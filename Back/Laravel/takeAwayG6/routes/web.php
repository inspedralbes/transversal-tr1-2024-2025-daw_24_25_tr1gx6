<?php

use App\Http\Controllers\AutorizacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return redirect()->route('login');
});

//LOGINS
Route::post('/loginAdmin', [AutorizacionController::class, 'login'])->name('login.admin');

//PANTALLAS
Route::get('/login', [AutorizacionController::class, 'screenlogin'])->name('login');

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

Route::get('/getProductos', [ProductoController::class, 'getProductos'])->name('get.productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');
Route::get('/getCategory', [CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas', [MarcaController::class, 'getMarcas'])->name('get.marcas');


Route::middleware(['auth'])->group(function () {

    Route::get('/screenHome', [AutorizacionController::class, 'getscreenHome'])->name('screen.home');
    Route::get('/screenProductos', [ProductoController::class, 'getScreenProducto'])->name('screen.productos');
    Route::get('/screenStock', [StockController::class, 'getScreenStocks'])->name('screen.stocks');


    Route::prefix('/stock')->group(function () {
        Route::post('/create', [StockController::class, 'createStock'])->name('create.stock');
        Route::post('/update/{id}', [StockController::class, 'updateStock'])->name('update.stock');
        Route::delete('/delete/{id}', [StockController::class, 'deleteStock'])->name('delete.stock');
    });

    Route::prefix('/productos')->group(callback: function () {
        Route::post('/create', [ProductoController::class, 'createProducto'])->name('create.product');
        Route::post('/update/{id}', [ProductoController::class, 'updateProducto'])->name('update.product');
        Route::delete('/delete/{id}', [ProductoController::class, 'deleteProducto'])->name('delete.product');
    });

});