<?php

use App\Http\Controllers\Controller;
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

Route::get('/add_user', [Controller::class, 'add_user'])->name('add_user');
Route::post('/add_user', [Controller::class, 'add_user_post'])->name('add_user');
Route::get('/edit/{id}', [Controller::class, 'edit'])->name('edit');
Route::post('/save_user/{id}', [Controller::class, 'save_user'])->name('edit');
