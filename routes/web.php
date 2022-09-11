<?php

use App\Http\Controllers\EmployesController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/view/{id}', [App\Http\Controllers\HomeController::class, 'view'])->name('home.view');
Route::get('/home/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('home.edit');

Route::resource('/employes', EmployesController::class)->except(['index', 'create', 'show', 'edit']);
