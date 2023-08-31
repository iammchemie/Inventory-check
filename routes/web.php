<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'v_register'])->name('register');
Route::post('/registration', [LoginController::class, 'register'])->name('registration');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('checkRole:admin,operator');

Route::get('/reagensia', [DashboardController::class, 'reagensia'])->name('reagensia')->middleware('auth');
Route::post('/reagensia/tambahreagensia', [DashboardController::class, 'tambahreagensia'])->name('tambahreagensia');
Route::get('/reagensia/export', [DashboardController::class, 'exportexcel']);
Route::get('/api/reagensia/{namaReagensia}', [DashboardController::class, 'getAPIReagensia'])->name('getAPIReagensia');
Route::delete('/reagensia/hapusreagensia/{id}', [DashboardController::class, 'hapusreagensia']);


Route::get('user-management', [DashboardController::class, 'usermanagement'])->name('usermanagement')->middleware(['checkRole:admin']);
Route::post('/user-management/ubahpassword/{id}', [DashboardController::class, 'ubahpassword'])->name('ubahpassword');
Route::put('/user-management/ubahrole/{id}', [DashboardController::class, 'editRole'])->name('ubahRole');


// Route::post('/pengelolaandatatamu/tambahtamu', [DashboardController::class, 'createTamu']);
// Route::delete('/pengelolaandatatamu/hapustamu/{id}', [DashboardController::class, 'hapusTamu']);
// Route::put('/pengelolaandatatamu/ubahtamu/{id}', [DashboardController::class, 'editTamu']);