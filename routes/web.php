<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DanaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class,'index'])->name('utama');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/profile', [UserController::class,'index'])->name('user')->middleware('auth');
Route::post('/profile', [UserController::class,'changepwd'])->name('changePassword');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/datawarga', [WargaController::class, 'index'])->name('datawarga')->middleware('auth');




Route::get('/datawarga/detail/{id}', [WargaController::class, 'detailwarga'])->name('warga-detail')->middleware('auth');
Route::get('/datawarga/tambah', [WargaController::class, 'tambah' ])->middleware('auth');
Route::post('/datawarga/tambah_warga', [WargaController::class, 'store' ])->name('warga-tambah');
Route::get('/datawarga/edit_warga/{id}', [WargaController::class, 'edit' ])->name('warga-edit');
Route::put('/datawarga/update_warga/{id}', [WargaController::class, 'update' ])->name('warga-update');
Route::get('/datawarga/delete_warga/{id}', [WargaController::class, 'delete' ])->name('warga-delete');
Route::get('/datawarga/tambah_anggota', [WargaController::class, 'tambahanggota' ])->name('anggota-tambah');

Route::get('selectProv', [WargaController::class, 'selectProv' ])->name('selectProv');
Route::get('selectKota/{id}', [WargaController::class, 'selectKota' ]);
Route::get('selectKecamatan/{id}', [WargaController::class, 'selectKecamatan' ]);
Route::get('selectKelurahan/{id}', [WargaController::class, 'selectKelurahan' ]);

Route::group( ['middleware'=>'auth'], function() {
    Route::get('iuran',[IuranController::class,'index'])->name('iuran');
    Route::get('iuran/tambah',[IuranController::class,'create'])->name('tambah');
    Route::post('iuran/tambah',[IuranController::class,'store'])->name('tambah-data');
    Route::get('selectDana',[IuranController::class,'getDana'])->name('get-Dana');
    Route::get('getDanaNominal/{id}',[IuranController::class,'getDanaNominal']);
    Route::get('iuran/lihat/{id}',[IuranController::class,'show'])->name('lihat-data');

    // Route::post('iuran/lihat/{id}',[IuranController::class,'payment_post']);


    Route::resource('iuran/dana', DanaController::class, ['except' => [
        'create', 'update','show'
        ]]);
    });





