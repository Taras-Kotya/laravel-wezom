<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsController;
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


Route::get('/', [Controller::class, 'index'])->name('index');
Route::get('/pi', [Controller::class, 'pi'])->name('pi');
Route::get('/deluser', [Controller::class, 'deluser'])->name('deluser');
Route::get('/all_users', [Controller::class, 'all_users'])->name('deluser');

Route::get('/add_user', [Controller::class, 'add_user'])->name('add_user');
Route::post('/add_user', [Controller::class, 'add_user_post'])->name('add_user');
Route::get('/edit_user/{id}', [Controller::class, 'edit_user']);
Route::post('/save_user/{id}', [Controller::class, 'save_user']);

/*
Route::get('/all_news', [NewsController::class, 'all_news']);
Route::get('/add_news', [NewsController::class, 'add_news']);
Route::post('/add_news', [NewsController::class, 'add_news_post']);
Route::get('/red_news/{id}', [NewsController::class, 'edit_news']);
Route::post('/save_news/{id}', [NewsController::class, 'save_news']);
*/
Route::resource('news', NewsController::class);
//////////////////////////////////////////////

Route::get('/login', [Controller::class, 'login']);
Route::get('/logout', [Controller::class, 'logout']);
Route::post('/login', [Controller::class, 'login_post']);
