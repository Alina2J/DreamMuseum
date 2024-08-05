<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;

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


Route::controller(PageController::class)->group(function () {

    Route::get('/', 'index')->name('main-page');

    Route::get('/post/{id}', 'post')->name('single-post');

    Route::get('/category/{id}','index')->name('category-search');

    Route::middleware([CheckIsAdmin::class])->group(function() {
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/edit-profile',  'edit')->middleware(['auth', 'verified'])->name('edit-profile');

        Route::get('/favourites', 'favourites')->middleware('auth')->name('favourites-page');

        Route::get('/add-model', 'addModel')->middleware(['auth', 'verified'])->name('add-model');
    });

    Route::get('/profile-user/{id}', 'profileUser')->name('profile-user');

    Route::get('/support/{id}', 'support')->middleware(['auth', 'verified'])->name('chat-page');

    Route::get('/registration',  'reg')->middleware('guest')->name('reg-page');

    Route::get('/authorization', 'auth')->name('auth-page');

    Route::get('/forgot-password',  'password')->middleware('guest')->name('password-page');

    Route::get('/reset-password',  'reset')->middleware('guest')->name('password.reset');

    Route::get('/edit-post/{id}',  'editPost')->middleware('auth')->name('post.edit');
});

Route::controller(PostController::class)->group(function () {

    Route::put('/edit-post/{id}',  'editPost')->middleware('auth')->name('post.update');

    Route::delete('delete/{id}',  'delete')->middleware('auth')->name('delete-post');

    Route::delete('post/delete/{id}',  'deleteComment')->middleware('auth')->name('delete-comment');
    Route::post('post/comment/{id}',  'comment')->middleware('auth')->name('comments');

    Route::get('/search',  'search')->name('search');

    Route::delete('delete/{id}',  'delete')->middleware('auth')->name('delete-post');

    Route::delete('post/delete/{id}', 'deleteComment')->middleware('auth')->name('delete-comment');

    Route::get('/search', 'search')->name('search');

    Route::post('/favourites/{id}',  'favourites')->middleware('auth')->name('favourites');

    Route::post('/add-model',  'addModel')->middleware(['auth', 'verified'])->name('model.store');
    Route::get('/load-model/{id}',  'loadModel')->name('load-model');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/edit-profile',  'edit')->middleware(['auth', 'verified'])->name('edit');

    Route::post('/registration',  'registration')->middleware('guest')->name('reg');

    Route::post('/authorization',  'authorization')->middleware('guest')->name('auth');
    Route::get('/logout',  'logout')->middleware('auth')->name('logout');

    Route::post('/forgot-password',  'password')->middleware('guest')->name('password');

    Route::post('/reset-password',  'reset')->middleware('guest')->name('password.update');

    Route::get('/email/verify', 'notice')->middleware('auth')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}',  'verify')->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification',  'send')->middleware('auth')->name('verification.send');
});



Route::controller(ChatController::class)->group(function () {
    Route::get('/messages/{id}', 'messages')->middleware(['auth', 'verified'])->name('messages');
    Route::post('/chats/{id}/send',  'send')->middleware(['auth', 'verified'])->name('chats.send');
});

