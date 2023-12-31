<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChattingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(ChattingController::class)->middleware('auth')->group(function () {

    Route::get('/chat', 'index')->name('chat');
    Route::get('/messages', 'fetchMessages')->name('messages');
    Route::post('/send-message', 'sendMessage')->name('send-message');
    Route::get('/user-list', 'fetchUsers')->name('user-list');
});
