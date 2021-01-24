<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AUTH\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;

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

// Without Midleware
Route::get('login', [AuthController::class, 'Login'])->name('login');
Route::post('login', [AuthController::class, 'Login'])->name('login');
Route::get('logout', [AuthController::class, 'Logout'])->name('logout');

Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('main');

    Route::prefix('class-management')->group(function(){
        Route::get('/', [ClassController::class, 'index'])->name('main-class-management');
    });
});
