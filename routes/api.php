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
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
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
    Route::post('password', [UserController::class, 'password']);
    Route::resource('books', BookController::class);
    Route::resource('rent', RentController::class);
});
