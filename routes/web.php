<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReagensiaController;
use App\Http\Controllers\UserManagementController;
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

// Login
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'v_register'])->name('register');
Route::post('/registration', [LoginController::class, 'register'])->name('registration');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('checkRole:admin,operator');

// Inventaris reagensia
Route::get('/reagensia', [ReagensiaController::class, 'index'])->name('reagensia')->middleware('auth');
Route::post('/reagensia/tambahreagensia', [ReagensiaController::class, 'tambahreagensia'])->name('tambahreagensia');
Route::get('/reagensia/export', [ReagensiaController::class, 'exportexcel']);
Route::post('/reagensia/import', [ReagensiaController::class, 'importexcel'])->name('import.excel');
Route::get('/api/reagensia/{namaReagensia}', [ReagensiaController::class, 'getAPIReagensia'])->name('getAPIReagensia');
Route::post('/reagensia/ubahreagensia/{id}', [ReagensiaController::class, 'ubahreagensia'])->name('ubahreagensia');
Route::delete('/reagensia/hapusreagensia/{id}', [ReagensiaController::class, 'hapusreagensia']);

// user management
Route::get('user-management', [UserManagementController::class, 'index'])->name('usermanagement')->middleware(['checkRole:admin']);
Route::post('/user-management/ubahpassword/{id}', [UserManagementController::class, 'ubahpassword'])->name('ubahpassword');
Route::put('/user-management/ubahrole/{id}', [UserManagementController::class, 'editRole'])->name('ubahRole');