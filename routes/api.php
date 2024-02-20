<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\RentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::controller(BookController::class)->group(function(){
    Route::get('index', 'index');
    Route::get('categories', [CategoriesController::class, 'index']);
});
Route::middleware('auth:sanctum')->group(function(){
    //Route::resource('users', UserController::class);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/{id}', [NotificationController::class, 'show']);
    Route::get('myProfile', [UserController::class, 'show']);
    Route::get('checkProfile', [UserController::class, 'isProfileComplete']);
    Route::post('myProfile', [UserController::class, 'update']);
    Route::post('photo', [UserController::class, 'store']);
    Route::post('password', [UserController::class, 'password']);
    Route::resource('books', BookController::class);
    Route::resource('rent', RentController::class);
});
