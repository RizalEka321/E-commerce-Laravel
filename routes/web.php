<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin', [DashboardController::class, "index"])->name('admin.dashboard');
Route::get('/admin/katalog', [KatalogController::class, "index"])->name('admin.katalog');
Route::get('/admin/user-manajemen', [UserController::class, "index"])->name('admin.user-manajemen');
