<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');
Route::get('/admin/register',[RegisterController::class,'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register',[RegisterController::class,'createAdmin'])->name('admin.register');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard',function(){
    $admin = Admin::count();
    $user = User::count();
    $book = Book::count();
    $apply = Rent::whereNull('status')->whereNotNull('date_request')->count();
    $rent = Rent::where('status', true)->whereNotNull('date_rent')->count();
    $due = Rent::where('date_due', '<', Carbon::now())->where('status', true)->count();
    $notifications = Auth::guard('admin')->user()->unreadNotifications();
    return view('admin', compact('admin', 'user', 'book', 'apply', 'rent', 'due', 'notifications'));
})->middleware('auth:admin')->name('admin.dashboard');
//notify
Route::get('/send-notification', [NotificationController::class, 'sendNotification']);
//Admin Resource

Route::get('/admin/rent/all',[RentController::class,'all'])->middleware('auth:admin')->name('rent.record');
Route::get('/admin/rent/search',[RentController::class,'search'])->middleware('auth:admin')->name('rent.search');
Route::get('/admin/rent/track',[RentController::class,'track'])->middleware('auth:admin')->name('rent.track');
Route::post('/admin/user/photo/{user}',[UserController::class,'photo'])->middleware('auth:admin')->name('user.photo');
Route::post('/admin/book/cover/{book}',[BookController::class,'cover'])->middleware('auth:admin')->name('book.cover');
Route::post('/admin/book/barcode/{book}',[BookController::class,'barcode'])->middleware('auth:admin')->name('book.barcode');
Route::post('/admin/rent/approve/{rent}',[RentController::class,'approve'])->middleware('auth:admin')->name('rent.approve');
Route::get('/admin/rent/alert/{rent}',[RentController::class,'alert'])->middleware('auth:admin')->name('rent.alert');
Route::post('/admin/rent/return/{rent}',[RentController::class,'return'])->middleware('auth:admin')->name('rent.return');
Route::get('/admin/rent/warning/{rent}',[RentController::class,'warning'])->middleware('auth:admin')->name('rent.warning');
//Route::get('/admin/rent/denied/{id}',[RentController::class,'denied'])->middleware('auth:admin')->name('rent.denied');
Route::get('/admin/user/search',[UserController::class,'search'])->middleware('auth:admin')->name('user.search');
Route::get('/admin/book/search',[BookController::class,'search'])->middleware('auth:admin')->name('book.search');
Route::resource('/admin/admin',AdminController::class)->middleware('auth:admin');
Route::resource('/admin/user',UserController::class)->middleware('auth:admin');
Route::resource('/admin/book',BookController::class)->middleware('auth:admin');
Route::resource('/admin/rent',RentController::class)->middleware('auth:admin');
Route::resource('/admin/categories',CategoriesController::class)->middleware('auth:admin');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
