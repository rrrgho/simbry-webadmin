<?php

use App\Http\Controllers\ActivityController;
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
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Generator;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\ManagementPeraturan;
use App\Http\Controllers\ManagementPeminjaman;
use App\Http\Controllers\PreferencsController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\SettingsController;

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
Route::get('welcome',[BooksStudentController::class, 'welcome'])->name('welcome');
Route::get('login', [AuthController::class, 'Login'])->name('login');
Route::post('login', [AuthController::class, 'Login'])->name('login');
Route::get('logout', [AuthController::class, 'Logout'])->name('logout');

Route::middleware('cors')->group(function(){

    Route::get('socket.io',[AuthController::class, 'Redis']);
});
// Route Midleware Admin

Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/', [DashboardController::class, 'adminHome'])->name('main')->middleware('admin');
    Route::get('change-password', [SettingsController::class, 'changePassword'])->name('change-password');
    Route::post('change-password-post', [SettingsController::class, 'changePasswordPost'])->name('change-password-post');

    Route::prefix('class-management')->group(function(){
        // Class Data Student
        Route::get('/student', [ClassController::class, 'index'])->name('main-class-management');
        Route::get('upgrade-siswa', [ClassController::class, 'upgradeSiswa'])->name('main-upgrade-siswa');
        Route::post('delete-siswa', [ClassController::class, 'deleteSiswa'])->name('main-delete-siswa');
        Route::post('upgrade-siswa', [ClassController::class, 'upgradeSiswa'])->name('main-upgrade-siswa');
        Route::post('move-class', [ClassController::class, 'moveClass'])->name('move-class');
        Route::get('student-datatable', [ClassController::class, 'studentDatatable'])->name('student-datatable');
        Route::get('component-add-student', [ClassController::class, 'componentAddStudent'])->name('component-add-student');
        Route::post('component-edit-student', [ClassController::class, 'componentEditStudent'])->name('component-edit-student');
        Route::get('component-student-datatable', [ClassController::class, 'componentStudentDatatable'])->name('component-student-datatable');
        Route::post('add-class', [ClassController::class, 'addClass'])->name('add-class');
        Route::post('add-student', [ClassController::class, 'addStudent'])->name('add-student');
        Route::post('edit-student', [ClassController::class, 'editStudent'])->name('edit-student');
        Route::post('delete-student', [ClassController::class, 'deleteStudent'])->name('delete-student');
        Route::get('migrasi-class', [ClassController::class, 'migrasiClass'])->name('migrasi-class');
        Route::get('student-terpopuler', [ClassController::class, 'StudentTerpopuler'])->name('student-terpopuler');
        Route::post('student-publish', [ClassController::class, 'StudentPublish'])->name('student-publish');
        Route::post('reset-point', [ClassController::class, 'ResetPoint'])->name('reset-point');
        Route::post('reset-passsword-all', [ClassController::class, 'allReset'])->name('reset-passsword-all');
        Route::post('reset-passsword', [ClassController::class, 'ResetPassword'])->name('reset-passsword');
        Route::get('detail-siswa/{id}', [ClassController::class, 'detailSiswa'])->name('detail-siswa');
        Route::post('detail-siswa-execute', [ClassController::class, 'detailSiswaExecute'])->name('detail-siswa-execute');
        // Route::get('student-terpopuler-datatable', [ClassController::class, 'StudentTerpopulerDatatable'])->name('student-terpopuler-datatable');
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
        // Add Buku
        Route::get('books', [BooksController::class, 'books'])->name('main-books');
        Route::post('books', [BooksController::class, 'books_add']);
        Route::get('books-datatable', [BooksController::class, 'booksDatatable'])->name('books-datatable');
        Route::get('books-datatable-examplar', [BooksController::class, 'booksDatatableExamplar'])->name('books-datatable-examplar');
        Route::get('books-detail/{examplar}', [BooksController::class, 'booksDetail'])->name('book-detail');
        Route::get('book-qr/{id}', [BooksController::class, 'bookQrDetail'])->name('qrcode');
        Route::post('books-delete', [BooksController::class, 'booksDelete'])->name('book-delete');
        Route::post('books-duplicate', [BooksController::class, 'booksDuplicate'])->name('duplicate-book');
        // Route::get('books-edit/{examplar}', [BooksController::class, 'booksEdit'])->name('books-edit');
        Route::post('/{examplar}/edit-books', [BooksController::class, 'booksEditExecute']);
        Route::get('books-qr', [BooksController::class, 'booksQR'])->name('books-qr');

        // Print QR
        Route::post('print-qr', [BooksController::class, 'printQR'])->name('print-qr');
        Route::get('qr-page/{data}', [BooksController::class, 'qrPage'])->name('qr-page');
    });
    Route::prefix('management-peminjaman')->group(function(){
        Route::get('masuk', [ManagementPeminjaman::class, 'masuk'])->name('main-management-peminjaman-berjalan');
        // Route::get('masuk-datatable', [ManagementPeminjaman::class, 'masukDatatable'])->name('masuk-datatable');
        Route::get('expired', [ManagementPeminjaman::class, 'expired'])->name('main-management-peminjaman-expired');
        Route::get('expired-datatable', [ManagementPeminjaman::class, 'expiredDatatable'])->name('expired-datatable');
        Route::post('search', [ManagementPeminjaman::class, 'search'])->name('search');
        Route::post('finished' , [ManagementPeminjaman::class, 'finished'])->name('finished');
        Route::get('history', [ManagementPeminjaman::class, 'history'])->name('main-management-peminjaman-history');
        Route::get('extends', [ManagementPeminjaman::class, 'extends'])->name('main-management-peminjaman-extends');
    });
    Route::get('pemulangan',[OrderController::class, 'pemulangan'])->name('main-pemulangan-buku');
    Route::post('pemulangan',[OrderController::class, 'savePemulangan'])->name('main-pemulangan-buku');
    Route::get('get-book-user',[OrderController::class, 'getBookByUserId'])->name('main-getBookByUserId-buku');
    Route::prefix('order')->group(function(){
        Route::post('check-user', [OrderController::class, 'CheckUser'])->name('check-user');
        Route::post('new-order', [OrderController::class, 'NewOrder'])->name('new-order');
        Route::post('pemulangan', [OrderController::class, 'pemulangan'])->name('pemulangan');
    });
    Route::prefix('settings')->group(function(){
        // Slide
        Route::get('slide-banner',[SettingsController::class, 'slideBanner'])->name('slide-banner');
        Route::post('slide-post',[SettingsController::class, 'slideBannerPost'])->name('slide-post');
        Route::get('slide-datatable',[SettingsController::class, 'slideDatatable'])->name('slide-datatable');
        Route::get('/{id}/slide-edit',[SettingsController::class, 'slideEdit'])->name('slide-edit');
        Route::post('slide-edit-execute',[SettingsController::class, 'slideEditExecute'])->name('slide-edit-execute');
        Route::get('slide-delete/{id}',[SettingsController::class, 'slideDelete'])->name('slide-delete');
        // Contact
        Route::get('contact',[SettingsController::class, 'contact'])->name('contact');
        Route::post('contact-post',[SettingsController::class, 'contactPost'])->name('contact-post');
        Route::post('contact-store',[SettingsController::class, 'contactStore'])->name('contact-store');
        Route::get('contact-datatable',[SettingsController::class, 'contactDatatable'])->name('contact-datatable');
        Route::get('/{id}/contact-edit',[SettingsController::class, 'contactEdit'])->name('contact-edit');
        Route::post('contact-edit-execute',[SettingsController::class, 'contactEditExecute'])->name('contact-edit-execute');
        Route::get('contact-delete/{id}',[SettingsController::class, 'contactDelete'])->name('contact-delete');
        // About
        Route::get('about-school',[SettingsController::class, 'about'])->name('about-school');
        Route::post('about-school-post',[SettingsController::class, 'aboutPost'])->name('about-school-post');
        Route::post('about-store',[SettingsController::class, 'aboutStore'])->name('about-store');
        Route::get('about-school-datatable',[SettingsController::class, 'aboutDatable'])->name('about-school-datatable');
        Route::get('/{id}/about-edit', [SettingsController::class, 'aboutEdit'])->name('about-edit');
        Route::post('about-edit-execute', [SettingsController::class, 'aboutEditExecute'])->name('about-edit-execute');
        Route::get('about-delete/{id}', [SettingsController::class, 'aboutDelete'])->name('about-edit-delete');
    });
    // Route::prefix('manajemen-peraturan')->group(function(){
    //     Route::get('peraturan' , [ManagementPeraturan::class, 'index'])->name('main-management-peraturan');
    //     Route::post('edit-peraturan', [ManagementPeraturan::class, 'edit'])->name('main-peraturan');
    // });
    // Peminjaman Tambah
    // Route::get('add-peminjaman', [OrderController::class, 'Order'])->name('main-peminjaman-siswa');
    // Route::post('add-peminjaman', [OrderController::class, 'Order']);
    // Route::post('add-peminjaman', [OrderController::class, 'addOrder'])->name('peminjaman-siswa');
    Route::prefix('peminjaman-masuk')->group(function(){
        Route::get('peminjaman-masuk', [OrderController::class , 'peminjaman'])->name('main-peminjaman-masuk');
        Route::post('approved' , [OrderController::class, 'approved'])->name('approved');
        Route::post('extends' , [OrderController::class, 'extends'])->name('extends');
    });
    Route::get('announcements',[AnnouncementsController::class, 'announcement'])->name('announcements');
    Route::post('add-announcements', [AnnouncementsController::class, 'announcement_add'])->name('add-annountcements');
    Route::get('announcement-datatable', [AnnouncementsController::class, 'annountcementDatatable'])->name('announcement-datatable');
    Route::get('announcement-delete/{id}', [AnnouncementsController::class, 'announcementDelete']);
    Route::get('/announcement-edit/{id}/', [AnnouncementsController::class, 'announcementEdit'])->name('announcementEdit');
    Route::post('announcementEditExecute', [AnnouncementsController::class, 'announcementEditExecute']);
    Route::get('/kritik',[KritikSaranController::class, 'kritik_saran'])->name('main-kritik-saran');
    Route::get('kritik-datatable',[KritikSaranController::class, 'kritik_datatable'])->name('kritik-saran-datatable');
    Route::post('kritik-delete', [KritikSaranController::class, 'kritikDelete'])->name('kritik-delete');
    Route::prefix('activity')->group(function(){
        Route::get('log', [ActivityController::class, 'log'])->name('main-activity-log');
    });
    Route::get('preferensi',[PreferencsController::class,'preferensi'])->name('main-preferensi');
    Route::get('preferensi-datatable',[PreferencsController::class, 'preferensiDataTable'])->name('preferensi-siswa-datatable');
});
// Route Midleware User
// Route::middleware([UserMiddleware::class])->group(function(){
//     Route::get('/user', [BooksStudentController::class, 'index'])->name('main-user')->middleware('user');
//     Route::post('/user', [BooksStudentController::class, 'index'])->name('main-user');
//     Route::get('user/books-detail/{examplar}', [BooksController::class, 'booksDetailUser'])->name('book-detail-user');


//     Route::prefix('user')->group(function(){
//         Route::post('show-book-component', [BooksStudentController::class, 'userShowBookComponent']);
//         Route::post('order-book', [BooksStudentController::class, 'orderBook']);
//         Route::get('show-order-component', [BooksStudentController::class, 'userShowOrderComponent']);
//     });

// });
