<?php

use App\Http\Controllers\AutorizacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComandasController;

Route::get('/', function () {
    return redirect()->route('login');
});

//LOGINS
Route::post('/loginAdmin', [AutorizacionController::class, 'login'])->name('login.admin');

//PANTALLAS
Route::get('/login', [AutorizacionController::class, 'screenlogin'])->name('login');


Route::get('/getProductos', [ProductoController::class, 'getProductos'])->name('get.productos');
//Route::post('/getProductos',[ProductoController::class, 'updateProducto'])->name('get-productos');
Route::get('/getCategory', [CategoriaController::class, 'getCategory'])->name('get.category');
Route::get('/getMarcas', [MarcaController::class, 'getMarcas'])->name('get.marcas');


Route::middleware(['auth'])->group(function () {

    Route::get('/screenHome', [AutorizacionController::class, 'getscreenHome'])->name('screen.home');
    Route::get('/screenProductos', [ProductoController::class, 'getScreenProducto'])->name('screen.productos');
    Route::get('/screenStock', [StockController::class, 'getScreenStocks'])->name('screen.stocks');
    Route::get('/screenUsers', [UserController::class, 'getUsers'])->name('screen.users');
    Route::get('/screenCategory', [CategoriaController::class, 'getCategory'])->name('screen.category');
    Route::get('/screenMarca', [MarcaController::class, 'getScreenMarca'])->name('screen.marca');

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

    // Otras rutas de usuario (si es necesario)
    Route::prefix('/user')->group(function () {
        Route::post('/create', [UserController::class, 'createUser'])->name('create.user');
        Route::post('/update/{id}', [UserController::class, 'updateUser'])->name('update.user');
        Route::delete('/delete/{id}', [UserController::class, 'deleteUser'])->name('delete.user');
    });

    // Rutas para CRUD de categorías
    Route::prefix('/category')->group(function () {
        Route::post('/create', [CategoriaController::class, 'CreateCategory'])->name('create.category');
        Route::post('/update/{id}', [CategoriaController::class, 'UpdateCategory'])->name('update.category');
        Route::delete('/delete/{id}', [CategoriaController::class, 'DeleteCategory'])->name('delete.category');
    });

    Route::prefix('/marca')->group(function () {
        Route::post('/create', [MarcaController::class, 'createMarca'])->name('create.marca');
        Route::post('/update/{id}', [MarcaController::class, 'updateMarca'])->name('update.marca');
        Route::delete('/delete/{id}', [MarcaController::class, 'deleteMarca'])->name('delete.marca');
    });
});


// Ruta para mostrar la vista de comandas
Route::get('/comanda', function () {
    return view('comandas.comanda');
});

Route::get('/comanda', [ComandasController::class, 'comanda'])->name('comandas.view');
Route::post('/pedidoUser', [ComandasController::class, 'pedidoUser'])->name('comanda.pedidoUser');
Route::post('/updateEstadoComanda/{id}', [ComandasController::class, 'updateEstadoComanda'])->name('comanda.updateEstado');
Route::post('/deleteComanda/{id}', [ComandasController::class, 'eliminarComanda'])->name('comandas.delete');
