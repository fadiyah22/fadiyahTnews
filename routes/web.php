<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
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

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'revalidate'], function()
{
    // Routes yang mau di revalidate masukan di sini

    Auth::routes();
    Route::get('/home',[HomeController::class,'index'])->name('home');
    Route::get('/berita', [BeritaController::class,'index']);
    Route::get('/kategori', [KategoriController::class,'index']);
    
    //route untuk proses input kategori    
    Route::get('kategori/create', [KategoriController::class, 'create']);

    //route ke class store method POST untuk proses menyimpan data dari form
    Route::post('kategori/create', [KategoriController::class, 'store']);

    //route untuk hapus
    Route::get('kategori/{id}',[KategoriController::class,'destroy']);

    //route untuk form edit
    Route::get('kategori/edit/{id}',[KategoriController::class,'edit']);

    //route untuk simpan hasil edit
    Route::put('kategori/{id}',[KategoriController::class,'update']);

    //Route untuk proses cari yang menuju function search
    Route::get('/kategori', [KategoriController::class, 'search'])->name('search');

});

//route untuk proses input berita
Route::get('berita/create', [BeritaController::class, 'create']);

//route ke class store method POST untuk proses menyimpan data dari form
Route::post('berita/create', [BeritaController::class, 'store']);

//route untuk hapus
Route::get('berita/{id}',[BeritaController::class,'destroy']);

//Route untuk proses cari yang menuju function search
Route::get('/berita', [BeritaController::class, 'search'])->name('search');

//route untuk form edit
Route::get('berita/edit/{id}',[BeritaController::class,'edit']);

 //route untuk simpan hasil edit
 Route::put('berita/{id}',[BeritaController::class,'update']);
 
