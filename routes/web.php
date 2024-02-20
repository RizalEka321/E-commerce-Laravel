<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProyekController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pembeli\PageController;

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

Route::get('/login', [AuthController::class, "login"])->name('login');
Route::get('/register', [AuthController::class, "register"])->name('register');


// Dashboard
Route::get('/admin', [DashboardController::class, "index"])->name('admin.dashboard');
// Admin Katalog
Route::get('/admin/katalog', [KatalogController::class, "index"])->name('admin.katalog');
Route::get('/admin/katalog/list', [KatalogController::class, "get_katalog"])->name('admin.get-katalog');
Route::post('/admin/katalog/create', [KatalogController::class, "store"])->name('admin.katalog.create');
Route::post('/admin/katalog/edit', [KatalogController::class, "edit"])->name('admin.katalog.edit');
Route::post('/admin/katalog/update', [KatalogController::class, "update"])->name('admin.katalog.update');
Route::post('/admin/katalog/delete', [KatalogController::class, "destroy"])->name('admin.katalog.delete');
// Admin Pesanan
Route::get('/admin/pesanan', [PesananController::class, "index"])->name('admin.pesanan');
Route::get('/admin/pesanan/list', [PesananController::class, "get_pesanan"])->name('admin.get-pesanan');
Route::post('/admin/pesanan/edit', [PesananController::class, "edit"])->name('admin.pesanan.edit');
Route::post('/admin/pesanan/update', [PesananController::class, "update"])->name('admin.pesanan.update');
Route::post('/admin/pesanan/delete', [PesananController::class, "destroy"])->name('admin.pesanan.delete');
Route::post('/admin/pesanan/update-status', [PesananController::class, "update_status"])->name('admin.pesanan.update-status');
// Admin Proyek
Route::get('/admin/proyek', [ProyekController::class, "index"])->name('admin.proyek');
Route::get('/admin/proyek/list', [ProyekController::class, "get_proyek"])->name('admin.get-proyek');
Route::post('/admin/proyek/create', [ProyekController::class, "store"])->name('admin.proyek.create');
Route::post('/admin/proyek/edit', [ProyekController::class, "edit"])->name('admin.proyek.edit');
Route::post('/admin/proyek/update', [ProyekController::class, "update"])->name('admin.proyek.update');
Route::post('/admin/proyek/delete', [ProyekController::class, "destroy"])->name('admin.proyek.delete');
// Admin User Manajemen
Route::get('/admin/user-manajemen', [UserController::class, "index"])->name('admin.user-manajemen');

// Pembeli
Route::get('/pembeli', [PageController::class, "page_home"])->name('pembeli.dashboard');
