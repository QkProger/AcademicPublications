<?php

use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\AuthorshipController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MusicController;
use App\Http\Controllers\Admin\PublicationController;
use App\Http\Controllers\Admin\PublicationTopicController;
use App\Http\Controllers\Admin\ResearchTopicController;
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

    Route::put('/user/changeLangCode/{id}', [UserController::class, 'changeLangCode'])->name('users.changeLangCode');

    Route::resource('authors', AuthorController::class)->except(['show'])->names('authors');
    Route::resource('journals', JournalController::class)->except(['show'])->names('journals');
    Route::resource('publications', PublicationController::class)->except(['show'])->names('publications');

});
