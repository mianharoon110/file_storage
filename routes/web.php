<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;

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


Route::post('login',[UserController::class, 'login'])->name('auth.login');
Route::post('register',[UserController::class, 'register'])->name('auth.register');
Route::get('logout',[UserController::class, 'logout'])->name('auth.logout');


Route::group(['middleware'=>['AuthCheck']], function(){

    Route::get('/',[UserController::class, 'viewLoginForm'])->name('auth.view.login');
    Route::get('register',[UserController::class, 'viewRegisterForm'])->name('auth.view.register');

    Route::get('dashboard',[FileController::class, 'getFiles'])->name('dashboard');
    Route::post('upload', [FileController::class, 'upload'])->name('upload');
    Route::post('rename',[FileController::class, 'rename'])->name('rename');
    Route::get('download/{id}',[FileController::class,'download'])->name('download');
    Route::post('delete',[FileController::class,'delete'])->name('delete');


});
