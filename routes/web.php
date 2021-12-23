<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['logged']], function(){
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('login_post', [AuthController::class, 'login_post']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register_post', [AuthController::class, 'register_post']);
});

Route::group(['middleware' => ['auth']], function(){
    
    Route::group(['middleware' => ['blockMember']], function(){
        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::get('produk', [ProdukController::class, 'index']);
        Route::post('produk', [ProdukController::class, 'store']);
        Route::get('produk/{id}', [ProdukController::class, 'show']);
        Route::patch('produk/{id}', [ProdukController::class, 'update']);
        Route::delete('produk/{id}', [ProdukController::class, 'destroy']);
    });

    Route::get('home', [HomeController::class, 'index']);
    
    Route::get('logout', [AuthController::class, 'logout']);
});
