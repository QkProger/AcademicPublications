<?php

use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MusicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Admin/home');
})->name('index');

Route::middleware('checkUserRole:admin')->group(function () {
    Route::resource('roles', RoleController::class)->except(['show'])->names('roles');
    Route::post('/logs/changeLogStatus', [LogController::class, 'changeLogStatus'])->name('log.changeLogStatus');
});

Route::middleware('checkUserRole:admin,moderator')->group(function () {
    Route::resource('user', UserController::class)->except(['show'])->names('users');
    Route::resource('logs', LogController::class)->only(['index'])->names('logs');
    Route::resource('musics', MusicController::class)->except(['show'])->names('musics');
    Route::resource('albums', AlbumController::class)->except(['show'])->names('albums');

    Route::put('/user/changeLangCode/{id}', [UserController::class, 'changeLangCode'])->name('users.changeLangCode');

});
