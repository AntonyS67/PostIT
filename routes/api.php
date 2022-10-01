<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',[UserController::class,'login'])->name('api.login');
Route::post('register',[UserController::class,'register'])->name('api.register');
Route::post('group',[GroupController::class,'store'])->name('api.group.store');

Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('group')->group(function () {
        Route::get('/',[GroupController::class,'index'])->name('api.group.index');
        Route::get('/{group}/join',[UserController::class,'joinToGroup'])->name('api.user.join');
    });
    Route::prefix('note')->group(function () {
        Route::post('/group/{group}',[NoteController::class,'index'])->name('api.note.index');
        Route::post('/',[NoteController::class,'store'])->name('api.note.store');
    });
});

