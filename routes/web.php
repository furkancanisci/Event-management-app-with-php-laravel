<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard'); 
Route::post('/bildirim-okundu/{id}', [CustomAuthController::class, 'markAsRead'])->name('bildirim.okundu');
Route::get('explore', [CustomAuthController::class, 'explore'])->name('explore'); 
Route::get('users', [CustomAuthController::class, 'allusers'])->name('allusers'); 
Route::get('chat/{event_id?}', [CustomAuthController::class, 'chat'])->name('auth.chat');
Route::get('eventadd', [CustomAuthController::class, 'eventadd'])->name('eventadd');
Route::get('/etkinlikkatil/{id}', [CustomAuthController::class, 'etkinlikkatil'])->name('etkinlikkatil');
Route::get('/eventonay/{id}', [CustomAuthController::class, 'eventonay'])->name('eventonay');
Route::post('eventaddpost', [CustomAuthController::class, 'eventaddpost'])->name('eventaddpost');
Route::get('/user/add', [CustomAuthController::class, 'usercreate'])->name('user.add');
Route::post('/user/store', [CustomAuthController::class, 'userstore'])->name('user.store');
Route::get('/etkinliksil/{id}', [CustomAuthController::class, 'etkinliksil'])->name('etkinliksil'); 
Route::get('/usersil/{id}', [CustomAuthController::class, 'usersil'])->name('usersil'); 
Route::post('sendmessage', [CustomAuthController::class, 'sendmessage'])->name('chat.send'); 
Route::get('/profile/{id}', [CustomAuthController::class, 'profile'])->name('profile.show');
Route::post('/profileupdate/{id}', [CustomAuthController::class, 'profileupdate'])->name('profile.update');
Route::get('/etkinlikdetay/{id}', [CustomAuthController::class, 'etkinlikdetay'])->name('etkinlikdetay'); 
Route::get('/userdetay/{id}', [CustomAuthController::class, 'userdetay'])->name('userdetay');
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('register', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');


Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
