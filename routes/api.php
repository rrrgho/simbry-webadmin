<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MigrationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\ClassController;
// use App\Http\Controllers\BooksController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\PreferencsController;
use App\Http\Controllers\STUDENT\BooksStudentController;
use App\Models\User;
use App\Http\Middleware\UserMiddleware;
use Maatwebsite\Excel\Row;
use Spatie\Permission\Contracts\Role;

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
Route::post('login', [UserController::class, 'Login']);
Route::post('tes', [UserController::class, 'tesapi']);
Route::get('books-order',[OrderController::class,'booksOrder']);
// Route::get('migrasi-user',[UserController::class,'migrasiUser']);
// Route::post('reset-passsword-all', [ClassController::class, 'allReset'])->name('reset-passsword-all');
Route::middleware('cors')->namespace('API')->group(function(){
    Route::post('search-book-web', [BooksController::class, 'bookSearchWeb']);
    Route::get('book-data', [BooksController::class, 'bookData']);
    Route::get('announcement', [UserController::class, 'announcement']);
    Route::post('rating', [UserController::class, 'rating']);
    Route::get('student-popular', [UserController::class, 'studentPopular']);
    Route::get('slide-banner', [UserController::class, 'slideBanner']);
    Route::post('slide-banner', [UserController::class, 'slideBanner']);
    Route::post('contact', [UserController::class, 'contact']);
    Route::get('about', [UserController::class, 'about']);
    Route::post('delete-preference',[PreferencsController::class, 'delete_preference']);
    Route::post('books-ocr',[BooksController::class,'ocrBooks']);
    Route::middleware('auth:api')->group(function(){
        Route::get('e-books-data',[BooksController::class,'eBooksData']);
        Route::get('e-books-detail/{id}',[BooksController::class,'eBooksDetail']);
        Route::post('search-book', [BooksController::class, 'bookSearch']);
        Route::post('search-ebook', [BooksController::class, 'EbookSearch']);
        Route::post('chat-bot',[UserController::class,'ChatBot']);
        Route::get('delete-preferensi/{id}',[PreferencsController::class,'deletePrefernsi']);
        Route::post('preferensi',[PreferencsController::class,'addPreferensi']);
        Route::get('get-preferensi',[PreferencsController::class,'getPrefernsi']);
        Route::get('book-data-mobile', [BooksController::class, 'bookDataM']);
        // Route::post('get-bypreference',[BooksController::class,'getBookbyPreference']);
        Route::get('get-bypreference',[BooksController::class,'getBookbyPreference']);
        Route::post('israting-finished', [UserController::class, 'ratingOrder']);
        Route::get('category/{id}',[PreferencsController::class, 'categoryID']);
        Route::get('get_category',[PreferencsController::class,'category_buku']);
        Route::post('add_preference',[PreferencsController::class,'addPreference']);
        Route::get('get_preference',[PreferencsController::class,'get_preference']);
        Route::post('return-book',[UserController::class,'returnbook']);
        Route::post('komentar',[UserController::class,'komentar']);
        Route::post('like',[UserController::class,'like']);
        Route::post('order-wishlist',[UserController::class,'orderBookWishlist']);
        Route::get('get-wishlist',[UserController::class,'getWishlist']);
        Route::get('no-approved',[UserController::class,'noApproved']);
        Route::post('extend-book',[UserController::class, 'extendsbooks']);
        Route::get('data-user',[UserController::class, 'getAlldataUser']);
        Route::get('book-detail/{id}', [BooksController::class, 'bookDetail']);
        // Route::post('order-book', [UserController::class, 'orderBook']);
        Route::post('history-user', [UserController::class, 'historybook']);
        Route::post('history-selesai', [UserController::class, 'historyselesai']);
        Route::post('history-berjalan', [UserController::class, 'historyberjalan']);
        Route::post('order', [UserController::class, 'orderBook']);
        Route::post('history', [UserController::class, 'historybook']);
        Route::post('kritik',[UserController::class, 'kritik']);
        Route::get('notifikasi',[UserController::class, 'notifikasi']);
        Route::post('change-password', [UserController::class, 'changePassword']);
    });
});
