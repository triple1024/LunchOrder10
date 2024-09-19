<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\EatsController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.welcome');
});

Route::middleware('auth:users')->group(function (){
    Route::get('/',[EatsController::class,'index'])->name('eats.index');
    Route::get('show/{eat}',[EatsController::class,'show'])->name('eats.show');
});

Route::prefix('orders')->
    middleware('auth:users')->group(function (){
    Route::get('/',[OrderController::class,'index'])->name('orders.index');
});

Route::prefix('cart')->
    middleware('auth:users')->group(function (){
    Route::get('/',[CartController::class, 'index'])->name('cart.index');
    Route::post('update/{food}', [CartController::class, 'update'])->name('cart.update');
    Route::post('add',[CartController::class,'add'])->name('cart.add');
    Route::post('delete/{eat}',[CartController::class,'delete'])->name('cart.delete');
    Route::post('checkout',[CartController::class,'checkout'])->name('cart.checkout');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
