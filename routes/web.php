<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\JournalController;

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
    return view('index');
})->name('index')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('guest')->group(function(){
    Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::name('journals.')->group(function(){
    Route::get('/journal',[JournalController::class, 'index'])->name('index');
    Route::get('/journal/update/{id}',[JournalController::class, 'updatepage'])->name('update.page');
    Route::post('/journal/create',[JournalController::class, 'store'])->name('store');
    Route::put('journal/update-action/{id}',[JournalController::class, 'update'])->name('update');
    Route::delete('journal/delete/{id}',[JournalController::class, 'destroy'])->name('destroy');
});
Route::name('chats.')->group(function(){
    Route::get('/create-persona',[ChatsController::class,'CreatePersonaPage'])->name('create.persona');
    Route::post('/create-persona',[ChatsController::class,'CreatePersona'])->name('create.persona.action');
});
