<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\UserController;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        $counts = [
            'users' => User::count(),
            'buku' => Buku::count(),
            'kategori' => Kategori::count()
        ];
        return view('dashboard', compact('counts'));
    })->name('dashboard');

    Route::group(['middleware' => 'onlyadmin'], function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/resetpassword', [UserController::class, 'resetPassword'])->name('users.resetpassword');
        Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');


        Route::prefix('perpustakaan')->group(function () {
            Route::get('/', [PerpustakaanController::class, 'index'])->name('perpustakaan');
            Route::post('/', [PerpustakaanController::class, 'store'])->name('perpustakaan.store');
            Route::post('/destroy/{id}', [PerpustakaanController::class, 'destroy'])->name('perpustakaan.destroy');
            Route::post('/update/{id}', [PerpustakaanController::class, 'update'])->name('perpustakaan.update');
        });

        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori');
            Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
            Route::post('/destroy/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
            Route::post('/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        });

        Route::prefix('buku')->group(function () {
            Route::get('/', [BukuController::class, 'index'])->name('buku');
            Route::post('/', [BukuController::class, 'store'])->name('buku.store');
            Route::post('/destroy/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
            Route::post('/update/{id}', [BukuController::class, 'update'])->name('buku.update');
        });
    });

    Route::get('/userprofile', [UserController::class, 'userProfile'])->name('userprofile');
    Route::post('/userprofile', [UserController::class, 'changeProfile'])->name('userprofile');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'public'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeUser'])->name('register.store');
});
