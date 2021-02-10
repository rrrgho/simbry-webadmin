<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MigrationController;

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