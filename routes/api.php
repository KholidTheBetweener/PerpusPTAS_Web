<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\RentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\PasswordChangeController;

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
Route::post('forgot-password', [RegisterController::class, 'forgot_password']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('reset-password', [RegisterController::class, 'passwordReset']);
    Route::post('change-password', [RegisterController::class, 'change_password']);
});

Route::post('change-password-dummy',  function (Request $request) {
    // Dummy response
    return response()->json([
        'status' => 'success',
        'message' => 'Password changed successfully'
    ]);
});

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
    Route::post('notifications/{id}', [NotificationController::class, 'markAsRead']);
    Route::get('myProfile', [UserController::class, 'show']);
    Route::get('checkProfile', [UserController::class, 'isProfileComplete']);
    Route::post('myProfile', [UserController::class, 'update']);
    Route::post('photo', [UserController::class, 'store']);
    Route::post('password', [RegisterController::class, 'change_password']);
    Route::resource('books', BookController::class);
    Route::resource('rent', RentController::class);
});
