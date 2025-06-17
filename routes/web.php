<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotificationController;
use App\Models\Admin;
use App\Models\User;
use App\Models\Book;
use App\Models\Rent;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|A
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/profile', function () {
    return view('profile');
})->name('profile');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/download', function () {
    return view('download');
})->name('download');
Auth::routes();
/*Route::namespace('Auth')->group(function(){
        
    //Login Routes
    Route::get('/login','LoginController@showLoginForm')->name('login');
    Route::post('/login','LoginController@login');
    Route::post('/logout','LoginController@logout')->name('logout');

    //Forgot Password Routes
    Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    //Reset Password Routes
    Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

});*/
//
Route::get('/books/{id}', [HomeController::class, 'show'])->middleware('auth')->name('detail');
Route::get('/notifications',[HomeController::class,'notifications'])->middleware('auth')->name('notifications');
Route::post('/notifications/{id}', [HomeController::class, 'marknotify'])->middleware('auth')->name('marknotify');
Route::get('/notifications/all', [HomeController::class, 'marknotifyall'])->middleware('auth')->name('marknotifyall');
Route::get('/userprofile',[HomeController::class,'profile'])->middleware('auth')->name('userprofile');
Route::post('/userprofile',[HomeController::class,'update'])->middleware('auth')->name('userupdate');
Route::post('/emailpassword',[HomeController::class,'emailpassword'])->middleware('auth')->name('emailpassword');
Route::get('/search',[HomeController::class,'search'])->middleware('auth')->name('search');
Route::get('/rent',[HomeController::class,'rent'])->middleware('auth')->name('rent');
Route::post('/book/{id}/rent', [HomeController::class, 'store'])->middleware('auth')->name('requestrent');
Route::get('/rent/{id}',[HomeController::class,'rentinfo'])->middleware('auth')->name('rentinfo');
//
Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');
//Route::post('admin/logout',[LoginController::class,'adminLogout'])->name('admin.logout');

Route::get('/admin/register',[RegisterController::class,'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register',[RegisterController::class,'createAdmin'])->name('admin.register');
//Forgot Password Routes
Route::get('/admin/password/reset',[App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request')->middleware('guest');
Route::post('/admin/password/email',[App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

//Reset Password Routes
Route::get('/admin/password/reset/{token}',[App\Http\Controllers\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset',[App\Http\Controllers\Auth\AdminResetPasswordController::class, 'reset'])->name('admin.password.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/admin/dashboard',[App\Http\Controllers\HomeController::class, 'dashboard'])->middleware('auth:admin')->name('admin.dashboard');
Route::post('/admin/mark-as-read/{id}', [HomeController::class, 'markNotification'])->name('admin.markNotification');
Route::post('/admin/mark-as-read', [HomeController::class, 'markAll'])->name('admin.markAll');
//notify
//Route::get('/send-notification', [NotificationController::class, 'sendNotification']);
//Admin Resource
Route::get('/admin/rent/all',[RentController::class,'all'])->middleware('auth:admin')->name('rent.record');
Route::get('/admin/rent/search',[RentController::class,'search'])->middleware('auth:admin')->name('rent.search');
Route::get('/admin/rent/track',[RentController::class,'track'])->middleware('auth:admin')->name('rent.track');
Route::post('/admin/user/photo/{user}',[UserController::class,'photo'])->middleware('auth:admin')->name('user.photo');
Route::post('/admin/book/import-excel', [BookController::class,'import'])->middleware('auth:admin')->name('book.import');
Route::post('/admin/book/cover/{book}',[BookController::class,'cover'])->middleware('auth:admin')->name('book.cover');
Route::post('/admin/book/barcode/{book}',[BookController::class,'barcode'])->middleware('auth:admin')->name('book.barcode');
Route::post('/admin/rent/approve/{rent}',[RentController::class,'approve'])->middleware('auth:admin')->name('rent.approve');
Route::get('/admin/rent/alert/{rent}',[RentController::class,'alert'])->middleware('auth:admin')->name('rent.alert');
Route::post('/admin/rent/return/{rent}',[RentController::class,'return'])->middleware('auth:admin')->name('rent.return');
Route::get('/admin/rent/warning/{rent}',[RentController::class,'warning'])->middleware('auth:admin')->name('rent.warning');
Route::get('/admin/user/search',[UserController::class,'search'])->middleware('auth:admin')->name('user.search');
Route::get('/book/search',[BookController::class,'search'])->name('book.search');
Route::resource('/admin/admin',AdminController::class)->middleware('auth:admin');
Route::resource('/admin/user',UserController::class)->middleware('auth:admin');
Route::resource('/admin/book',BookController::class)->middleware('auth:admin');
Route::resource('/admin/rent',RentController::class)->middleware('auth:admin');
Route::resource('/admin/categories',CategoriesController::class)->middleware('auth:admin');