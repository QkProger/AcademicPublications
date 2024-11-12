<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConverterController;
use App\Http\Controllers\Admin\GraduateController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SolutionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Test\TestLanguageController;
use App\Http\Controllers\Admin\Test\TestSubjectController;
use App\Http\Controllers\Admin\Test\TestQuestionController;
use App\Http\Controllers\Admin\Test\FullTestController;
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
    Route::resource('graduate', GraduateController::class)->only(['index', 'edit', 'update'])->names('graduates');
    Route::resource('logs', LogController::class)->only(['index'])->names('logs');

    Route::put('/user/changeLangCode/{id}', [UserController::class, 'changeLangCode'])->name('users.changeLangCode');

});
