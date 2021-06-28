<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MigrationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BooksController;
// use App\Http\Controllers\BooksController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\STUDENT\BooksStudentController;
use App\Models\User;
use App\Http\Middleware\UserMiddleware;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('migrate_book_category', [MigrationController::class, 'migrateBookCategory']);
Route::get('migrate_book_publisher', [MigrationController::class, 'migrateBookPublisher']);
Route::get('migrate_book', [MigrationController::class, 'migrateBook']);
Route::get('migrate_book_number', [MigrationController::class, 'migrateBookNumber']);
Route::get('migrate_unit', [MigrationController::class, 'migrateClassUnit']);

Route::get('add_unit_id', [MigrationController::class, 'add_unit_id']);

Route::post('testing', [MigrationController::class, 'testing']);
Route::get('book-qr/{examplar}', [BooksController::class, 'bookQrDetail'])->name('qrcode');
Route::middleware('cors')->namespace('API')->group(function(){
    Route::post('login', [UserController::class, 'Login']);
    Route::post('announcement', [UserController::class, 'announcement']);
    Route::post('rating', [UserController::class, 'rating']);
    Route::get('student-popular/{unit}', [UserController::class, 'studentPopular']);
    Route::get('slide-banner', [UserController::class, 'slideBanner']);
    Route::post('slide-banner', [UserController::class, 'slideBanner']);
    Route::post('contact', [UserController::class, 'contact']);
    Route::post('about', [UserController::class, 'about']);
    Route::get('book-data', [BooksController::class, 'bookData']);
    Route::middleware('auth:api')->group(function(){
        Route::post('search-book', [BooksController::class, 'bookSearch']);
        Route::get('book-detail/{id}', [BooksController::class, 'bookDetail']);
        // Route::post('order-book', [UserController::class, 'orderBook']);
        Route::post('history-user', [UserController::class, 'historybook']);
        Route::post('history-selesai', [UserController::class, 'historyselesai']);
        Route::post('history-berjalan', [UserController::class, 'historyberjalan']);
        Route::post('order', [UserController::class, 'orderBook']);
        Route::post('history', [UserController::class, 'historybook']);
        Route::post('kritik',[UserController::class, 'kritik']);
        Route::post('notifikasi',[UserController::class, 'notifikasi']);
        Route::post('change-password', [UserController::class, 'changePassword']);
    });
});
