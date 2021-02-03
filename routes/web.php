<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\AUTH\AuthController;
use App\Http\Controllers\AUTH\UserController;
use App\Http\Controllers\STUDENT\BooksStudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ManagemetBooksController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HistoryController;
use App\Models\History;
use App\Models\User;

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

// Without Midleware Admin
Route::get('login', [AuthController::class, 'Login'])->name('login');
Route::post('login', [AuthController::class, 'Login'])->name('login');
Route::get('logout', [AuthController::class, 'Logout'])->name('logout');
// Route Midleware Admin
Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/', [DashboardController::class, 'adminHome'])->name('main')->middleware('admin');

    Route::prefix('class-management')->group(function(){
        // Class Data Student
        Route::get('/student', [ClassController::class, 'index'])->name('main-class-management');
        Route::get('student-datatable', [ClassController::class, 'studentDatatable'])->name('student-datatable');
        Route::get('component-add-student', [ClassController::class, 'componentAddStudent'])->name('component-add-student');
        Route::post('component-edit-student', [ClassController::class, 'componentEditStudent'])->name('component-edit-student');
        Route::get('component-student-datatable', [ClassController::class, 'componentStudentDatatable'])->name('component-student-datatable');
        Route::post('add-class', [ClassController::class, 'addClass'])->name('add-class');
        Route::post('add-student', [ClassController::class, 'addStudent'])->name('add-student');
        Route::post('edit-student', [ClassController::class, 'editStudent'])->name('edit-student');
        Route::post('delete-student', [ClassController::class, 'deleteStudent'])->name('delete-student');
        // Class Data Teacher
        Route::get('/teacher', [ClassController::class , 'teacher'])->name('main-teacher-management');
        Route::get('teacher-datatable',[ClassController::class, 'teacherDatatable'])->name('teacher-datatable');
        Route::get('component-add-teacher',[ClassController::class, 'componentAddTeacher'])->name('component-add-teacher');
        Route::get('component-teacher-datatable',[ClassController::class, 'componentTeacherDatatable'])->name('component-teacher-datatable');
        Route::post('component-edit-teacher', [ClassController::class, 'componentEditTeacher'])->name('component-edit-teacher');
        Route::post('add-teacher', [ClassController::class , 'addTeacher'])->name('add-teacher');
        Route::post('edit-teacher', [ClassController::class, 'editTeacher'])->name('edit-teacher');
        Route::post('delete-teacher', [ClassController::class, 'deleteTeacher'])->name('delete-teacher');
    });
    Route::prefix('books-management')->group(function(){
        // Category
        Route::get('category', [ManagemetBooksController::class, 'category'])->name('main-category-management');
        Route::post('category', [ManagemetBooksController::class, 'categoryCreate']);
        Route::get('category-datatable',[ManagemetBooksController::class, 'categoryDatatable'])->name('category-datatable');
        Route::get('category-delete/{id}', [ManagemetBooksController::class, 'categoryDelete']);
        Route::get('/{id}/category-edit', [ManagemetBooksController::class, 'categoryEdit'])->name('categoryEdit');
        Route::post('categoryEditExecute',[ManagemetBooksController::class, 'categoryEditExecute']);

        // author
        Route::get('author',[ManagemetBooksController::class, 'author'])->name('main-author-management');
        Route::post('author',[ManagemetBooksController::class, 'authorCreate']);
        Route::get('author-datatable', [ManagemetBooksController::class, 'authorDatatable'])->name('author-datatable');
        Route::get('author-delete/{id}', [ManagemetBooksController::class, 'authorDelete']);
        Route::get('/{id}/author-edit', [ManagemetBooksController::class, 'authorEdit'])->name('authorEdit');
        Route::post('authorEditExecute', [ManagemetBooksController::class, 'authorEditExecute']);
        
        // Publisher
        Route::get('publisher', [ManagemetBooksController::class, 'publisher'])->name('main-publisher-management');
        Route::post('publisher', [ManagemetBooksController::class, 'publisherCreate']);
        Route::get('publisher-datatable',[ManagemetBooksController::class, 'publisherDatatable'])->name('publisher-datatable');
        Route::get('publisher-delete/{id}', [ManagemetBooksController::class, 'publisherDelete']);
        Route::get('/{id}/publisher-edit', [ManagemetBooksController::class, 'publisherEdit'])->name('publisherEdit');
        Route::post('publisherEditExecute', [ManagemetBooksController::class, 'publisherEditExecute']);

        // Edition
        Route::get('edition', [ManagemetBooksController::class, 'edition'])->name('main-edition-management');
        Route::post('edition', [ManagemetBooksController::class, 'editionCreate']);
        Route::get('edition-datatable', [ManagemetBooksController::class, 'editionDatatable'])->name('edition-datatable');
        Route::get('edition-delete/{id}', [ManagemetBooksController::class, 'editionDelete']);
        Route::get('/{id}/edition-edit', [ManagemetBooksController::class, 'editionEdit'])->name('editionEdit');
        Route::post('edtionEditExecute', [ManagemetBooksController::class, 'editionEditExecute']);

        // Locker
        Route::get('locker', [ManagemetBooksController::class, 'locker'])->name('main-locker-management');
        Route::post('locker', [ManagemetBooksController::class, 'lockerCreate']);
        Route::get('locker-datatable', [ManagemetBooksController::class, 'lockerDatatable'])->name('locker-datatable');
        Route::get('locker-delete/{id}', [ManagemetBooksController::class, 'lockerDelete']);
        Route::get('/{id}/locker-edit',[ManagemetBooksController::class, 'lockerEdit'])->name('lockerEdit');
        Route::post('lockerEditExecute', [ManagemetBooksController::class, 'lockerEditExecute']);
    });
    Route::prefix('order')->group(function(){
        Route::post('check-user', [OrderController::class, 'CheckUser'])->name('check-user');
        Route::post('new-order', [OrderController::class, 'NewOrder'])->name('new-order');
    });
    
    Route::prefix('books')->group(function(){
        // Add Buku
        Route::get('books', [BooksController::class, 'books'])->name('main-books');
        Route::post('books', [BooksController::class, 'books_add']);
        Route::get('books-datatable', [BooksController::class, 'booksDatatable'])->name('books-datatable');
        Route::get('books-datatable-examplar', [BooksController::class, 'booksDatatableExamplar'])->name('books-datatable-examplar');
        Route::get('books-detail/{examplar}', [BooksController::class, 'booksDetail'])->name('book-detail');
        Route::post('books-delete', [BooksController::class, 'booksDelete'])->name('delete-book');
        Route::post('books-duplicate', [BooksController::class, 'booksDuplicate'])->name('duplicate-book');
        Route::get('/{id}/books-edit', [BooksController::class, 'booksEdit'])->name('books-edit');
        Route::post('booksEditExecute', [BooksController::class, 'booksEditExecute']);
    });
    // Order History
    Route::prefix('history')->group(function(){
        // 
        Route::get('/', [HistoryController::class, 'orders'])->name('main-orders');
        Route::get('history-datatable', [HistoryController::class, 'historyDatatable'])->name('history-datatable');
        Route::get('filter', [HistoryController::class, 'filter'])->name('filter');
    });
});
// Route Midleware User
Route::middleware([UserMiddleware::class])->group(function(){
    Route::get('/user', [BooksStudentController::class, 'index'])->name('main-user')->middleware('user');
    Route::post('/user', [BooksStudentController::class, 'index'])->name('main-user');
});
