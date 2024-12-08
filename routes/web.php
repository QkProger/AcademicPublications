<?php

use App\Http\Controllers\Admin\MeetingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\MainController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FullTestController;
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

// Route::get('/', function () {
//     return Inertia::render('Admin/home');
// })->name('index');


Route::middleware('auth')->group(function () {
});


Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/login', 'auth.login')->name('adminLoginShow');
    Route::post('/login', [AdminAuthController::class, 'adminLoginForm'])->name('adminLoginForm');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('registerPost');
});
// Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
Route::get('/user', [AdminAuthController::class, 'getUser'])->name('user');

// Route::post('/saveTrack', [MainController::class, 'saveTrack'])->name('saveTrack');
// Route::post('/deleteMyTrack', [MainController::class, 'deleteMyTrack'])->name('deleteMyTrack');
// Route::post('/saveAlbum', [MainController::class, 'saveAlbum'])->name('saveAlbum');
// Route::post('/deleteMyAlbum', [MainController::class, 'deleteMyAlbum'])->name('deleteMyAlbum');


Route::middleware('checkUserRole:admin,user')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('main');
    Route::post('/saveTrack', [MainController::class, 'saveTrack'])->name('saveTrack');
    Route::post('/deleteMyTrack', [MainController::class, 'deleteMyTrack'])->name('deleteMyTrack');
    Route::post('/saveAlbum', [MainController::class, 'saveAlbum'])->name('saveAlbum');
    Route::post('/deleteMyAlbum', [MainController::class, 'deleteMyAlbum'])->name('deleteMyAlbum');

});